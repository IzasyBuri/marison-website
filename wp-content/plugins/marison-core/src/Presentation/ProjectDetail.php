<?php
/**
 * Public Project Detail read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Contact\ContactResolver;
use Marison\Core\Inventory\Availability;
use Marison\Core\Inventory\UnitRepository;
use Marison\Core\Inventory\UnitRules;
use Marison\Core\KPR\PublicDefault;
use Marison\Core\Multilingual\Polylang;
use Marison\Core\Multilingual\Resolver;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class ProjectDetail {
	public const UNIT_PAGE_SIZE = 12;
	public const LOCATION_TAXONOMY = 'marison_location';
	public const FACILITY_TAXONOMY = 'marison_facility';

	public static function view( int $post_id = 0, array $request = [] ): array {
		$post_id = absint( $post_id ?: get_queried_object_id() );
		$canonical_id = Resolver::canonical_post_id( $post_id );
		$canonical = get_post( $canonical_id );
		if ( ! $canonical || 'marison_project' !== $canonical->post_type || 'publish' !== $canonical->post_status ) {
			return [];
		}

		$language = Resolver::current_language();
		if ( Polylang::available() && $post_id !== $canonical_id && function_exists( 'pll_get_post_language' ) ) {
			$queried_language = pll_get_post_language( $post_id, 'slug' );
			if ( $queried_language ) {
				$language = sanitize_key( $queried_language );
			}
		}
		$translation = Resolver::translation_state( $canonical_id, $language );
		$presentation_id = $translation['post_id'] ?: $canonical_id;
		$presentation = get_post( $presentation_id );
		if ( ! $presentation || 'marison_project' !== $presentation->post_type || 'publish' !== $presentation->post_status ) {
			$presentation = $canonical;
			$presentation_id = $canonical_id;
		}

		$request = $request ?: self::request();
		$unit_page = self::positive_integer( $request['unit_page'] ?? 1 );
		$availability = Availability::get_for_project( $canonical_id );
		$house_types = self::house_types( $canonical_id, $language );
		$units = self::units( $canonical_id, $availability, $unit_page, $house_types, $language );
		$contact = ContactResolver::for_project( $canonical_id );
		$branch_id = absint( $contact['branch_id'] ?? 0 );

		return [
			'canonical_id' => $canonical_id,
			'presentation_id' => $presentation_id,
			'translation_state' => $translation['state'],
			'language' => $language,
			'title' => get_the_title( $presentation ),
			'url' => get_permalink( $presentation ),
			'summary' => self::summary( $presentation ),
			'content_html' => self::content( $presentation ),
			'featured_image_id' => (int) ( get_post_thumbnail_id( $presentation_id ) ?: get_post_thumbnail_id( $canonical_id ) ),
			'status' => (string) get_post_meta( $canonical_id, Meta::PROJECT_STATUS, true ),
			'status_label' => self::status_label( (string) get_post_meta( $canonical_id, Meta::PROJECT_STATUS, true ), $language ),
			'location' => self::location( $canonical_id ),
			'address' => (string) get_post_meta( $canonical_id, Meta::PROJECT_ADDRESS, true ),
			'house_types' => $house_types,
			'availability' => $availability,
			'units' => $units['items'],
			'unit_page' => $units['page'],
			'unit_pages' => $units['pages'],
			'unit_page_size' => self::UNIT_PAGE_SIZE,
			'facilities' => self::facilities( $canonical_id, $language ),
			'progress' => self::progress( $canonical_id, $presentation_id ),
			'related_articles' => self::related_articles( $canonical_id, $language ),
			'kpr' => self::kpr(),
			'contact' => array_merge(
				$contact,
				[
					'branch_name' => self::branch_name( $branch_id ),
				]
			),
			'breadcrumbs' => [
				[ 'label' => self::label( 'home', $language ), 'url' => home_url( '/' ) ],
				[ 'label' => self::label( 'housing', $language ), 'url' => Resolver::localized_url( 'perumahan' ) ],
				[ 'label' => get_the_title( $presentation ), 'url' => '' ],
			],
		];
	}

	public static function status_label( string $status, string $language = '' ): string {
		$language = $language ?: Resolver::current_language();
		$labels = [
			'upcoming' => [ 'id' => 'Akan Datang', 'en' => 'Upcoming' ],
			'ongoing' => [ 'id' => 'Sedang Berjalan', 'en' => 'Ongoing' ],
			'completed' => [ 'id' => 'Selesai', 'en' => 'Completed' ],
		];
		return $labels[ $status ][ 'en' === $language ? 'en' : 'id' ] ?? '';
	}

	public static function unit_status_label( string $status, string $language = '' ): string {
		$language = $language ?: Resolver::current_language();
		$labels = [
			'available' => [ 'id' => 'Tersedia', 'en' => 'Available' ],
			'booked' => [ 'id' => 'Terbooking', 'en' => 'Booked' ],
			'sold' => [ 'id' => 'Terjual', 'en' => 'Sold' ],
		];
		return $labels[ $status ][ 'en' === $language ? 'en' : 'id' ] ?? '';
	}

	private static function request(): array {
		return [
			'unit_page' => isset( $_GET['unit_page'] ) ? wp_unslash( $_GET['unit_page'] ) : 1,
		];
	}

	private static function positive_integer( $value ): int {
		$value = is_scalar( $value ) ? trim( (string) $value ) : '';
		return preg_match( '/^[1-9]\d*$/', $value ) ? min( 100000, (int) $value ) : 1;
	}

	private static function summary( \WP_Post $post ): string {
		$text = $post->post_excerpt ?: $post->post_content;
		return wp_trim_words( wp_strip_all_tags( $text ), 34 );
	}

	private static function content( \WP_Post $post ): string {
		return '' !== trim( (string) $post->post_content ) ? apply_filters( 'the_content', $post->post_content ) : '';
	}

	private static function location( int $project_id ): array {
		$location = wp_get_post_terms( $project_id, self::LOCATION_TAXONOMY, [ 'fields' => 'all' ] );
		$result = [ 'city' => '', 'province' => '' ];
		if ( is_wp_error( $location ) ) {
			return $result;
		}

		foreach ( $location as $term ) {
			$depth = Validation::location_depth( (int) $term->term_id );
			if ( 3 === $depth ) {
				$result['city'] = $term->name;
			}
			if ( 2 === $depth ) {
				$result['province'] = $term->name;
			}
			if ( 3 === $depth && $term->parent ) {
				$province = get_term( (int) $term->parent, self::LOCATION_TAXONOMY );
				if ( $province && ! is_wp_error( $province ) ) {
					$result['province'] = $province->name;
				}
			}
		}

		return $result;
	}

	private static function house_types( int $project_id, string $language ): array {
		$posts = get_posts(
			[
				'post_type' => 'marison_house_type',
				'post_status' => 'publish',
				'posts_per_page' => 100,
				'orderby' => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
				'meta_key' => Meta::HOUSE_TYPE_PROJECT,
				'meta_value' => $project_id,
			]
		);
		if ( Polylang::available() ) {
			$posts = get_posts(
				[
					'post_type' => 'marison_house_type',
					'post_status' => 'publish',
					'posts_per_page' => 100,
					'orderby' => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
					'meta_key' => Meta::HOUSE_TYPE_PROJECT,
					'meta_value' => $project_id,
					'lang' => Polylang::default_language(),
					'suppress_filters' => false,
				]
			);
		}
		$posts = array_values( array_filter( $posts, [ self::class, 'is_canonical_language_post' ] ) );
		$items = [];
		foreach ( $posts as $post ) {
			$items[ $post->ID ] = self::house_type( $post, $project_id, $language );
		}
		return array_values( $items );
	}

	private static function house_type( \WP_Post $canonical, int $project_id, string $language ): array {
		$translation = Resolver::translation_state( $canonical->ID, $language );
		$presentation_id = $translation['post_id'] ?: $canonical->ID;
		$presentation = get_post( $presentation_id );
		if ( ! $presentation || 'marison_house_type' !== $presentation->post_type || 'publish' !== $presentation->post_status ) {
			$presentation = $canonical;
			$presentation_id = $canonical->ID;
		}

		$owner_id = (int) get_post_meta( $canonical->ID, Meta::HOUSE_TYPE_PROJECT, true );
		return [
			'id' => (int) $canonical->ID,
			'presentation_id' => (int) $presentation_id,
			'title' => get_the_title( $presentation ),
			'description_html' => self::content( $presentation ),
			'image_id' => (int) ( get_post_thumbnail_id( $presentation_id ) ?: get_post_thumbnail_id( $canonical->ID ) ),
			'building_area' => self::meta_number( $canonical->ID, Meta::HOUSE_TYPE_BUILDING_AREA ),
			'land_area' => self::meta_number( $canonical->ID, Meta::HOUSE_TYPE_LAND_AREA ),
			'bedrooms' => self::meta_integer( $canonical->ID, Meta::HOUSE_TYPE_BEDROOMS ),
			'bathrooms' => self::meta_integer( $canonical->ID, Meta::HOUSE_TYPE_BATHROOMS ),
			'floors' => self::meta_integer( $canonical->ID, Meta::HOUSE_TYPE_FLOORS ),
			'translation_state' => $translation['state'],
			'valid_owner' => $owner_id === $project_id,
		];
	}

	private static function units( int $project_id, array $availability, int $requested_page, array $house_types, string $language ): array {
		if ( 'units' !== ( $availability['mode'] ?? '' ) ) {
			return [ 'items' => [], 'page' => 1, 'pages' => 0 ];
		}

		$total = UnitRepository::count_by_project( $project_id );
		$pages = max( 1, (int) ceil( $total / self::UNIT_PAGE_SIZE ) );
		$page = min( $requested_page, $pages );
		$by_id = [];
		foreach ( $house_types as $house_type ) {
			$by_id[ $house_type['id'] ] = $house_type;
		}
		$items = [];
		foreach ( UnitRepository::list( [ 'project_id' => $project_id ], $page, self::UNIT_PAGE_SIZE ) as $unit ) {
			$house_type = null;
			$house_type_id = absint( $unit['house_type_id'] ?? 0 );
			if ( $house_type_id && isset( $by_id[ $house_type_id ] ) && $by_id[ $house_type_id ]['valid_owner'] ) {
				$house_type = $by_id[ $house_type_id ];
			}
			$status = sanitize_key( (string) ( $unit['status'] ?? '' ) );
			if ( ! in_array( $status, UnitRules::statuses(), true ) ) {
				continue;
			}
			$items[] = [
				'identifier' => (string) $unit['unit_identifier'],
				'status' => $status,
				'status_label' => self::unit_status_label( $status, $language ),
				'house_type_name' => $house_type['title'] ?? '',
			];
		}

		return [ 'items' => $items, 'page' => $page, 'pages' => $total ? $pages : 0 ];
	}

	private static function facilities( int $project_id, string $language ): array {
		$terms = wp_get_post_terms( $project_id, self::FACILITY_TAXONOMY, [ 'fields' => 'all' ] );
		if ( is_wp_error( $terms ) ) {
			return [];
		}
		$items = [];
		foreach ( $terms as $term ) {
			$translated_id = Resolver::translated_term_id( (int) $term->term_id, self::FACILITY_TAXONOMY, $language );
			$display = $translated_id ? get_term( $translated_id, self::FACILITY_TAXONOMY ) : null;
			$display = $display && ! is_wp_error( $display ) ? $display : $term;
			$items[] = [ 'name' => $display->name, 'translation_state' => $display->term_id === $term->term_id ? 'CANONICAL' : 'TRANSLATED' ];
		}
		return $items;
	}

	private static function progress( int $canonical_id, int $presentation_id ): array {
		$value = get_post_meta( $canonical_id, Meta::PROJECT_PROGRESS, true );
		$percentage = '' === (string) $value ? null : (int) $value;
		$description = (string) get_post_meta( $presentation_id, Meta::PROJECT_PROGRESS_DESCRIPTION, true );
		if ( '' === trim( $description ) && $presentation_id !== $canonical_id ) {
			$description = (string) get_post_meta( $canonical_id, Meta::PROJECT_PROGRESS_DESCRIPTION, true );
		}
		return [
			'percentage' => null !== $percentage && $percentage >= 0 && $percentage <= 100 ? $percentage : null,
			'description' => $description,
		];
	}

	private static function related_articles( int $project_id, string $language ): array {
		$posts = get_posts(
			[
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 6,
				'orderby' => 'date',
				'order' => 'DESC',
				'meta_query' => [
					[
						'key' => Meta::ARTICLE_PROJECTS,
						'value' => 'i:' . $project_id . ';',
						'compare' => 'LIKE',
					],
				],
			]
		);
		if ( Polylang::available() ) {
			$posts = get_posts(
				[
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 6,
					'orderby' => 'date',
					'order' => 'DESC',
					'lang' => Polylang::default_language(),
					'suppress_filters' => false,
					'meta_query' => [
						[
							'key' => Meta::ARTICLE_PROJECTS,
							'value' => 'i:' . $project_id . ';',
							'compare' => 'LIKE',
						],
					],
				]
			);
		}
		$posts = array_values( array_filter( $posts, [ self::class, 'is_canonical_language_post' ] ) );
		$items = [];
		foreach ( $posts as $post ) {
			$translation = Resolver::translation_state( $post->ID, $language );
			$presentation_id = $translation['post_id'] ?: $post->ID;
			$presentation = get_post( $presentation_id );
			if ( ! $presentation || 'post' !== $presentation->post_type || 'publish' !== $presentation->post_status ) {
				$presentation = $post;
				$presentation_id = $post->ID;
			}
			$items[] = [
				'id' => (int) $post->ID,
				'presentation_id' => (int) $presentation_id,
				'title' => get_the_title( $presentation ),
				'url' => get_permalink( $presentation ),
				'excerpt' => wp_trim_words( wp_strip_all_tags( $presentation->post_excerpt ?: $presentation->post_content ), 24 ),
				'image_id' => (int) get_post_thumbnail_id( $presentation_id ),
				'translation_state' => $translation['state'],
			];
			if ( count( $items ) >= 3 ) {
				break;
			}
		}
		return $items;
	}

	private static function kpr(): array {
		$default = PublicDefault::get();
		return [
			'state' => $default['state'],
			'available' => 'AVAILABLE' === $default['state'],
			'url' => Resolver::localized_url( 'kpr' ),
		];
	}

	private static function is_canonical_language_post( \WP_Post $post ): bool {
		if ( ! Polylang::available() || ! function_exists( 'pll_get_post_language' ) ) {
			return true;
		}
		$language = pll_get_post_language( $post->ID, 'slug' );
		return ! $language || Polylang::default_language() === $language;
	}

	private static function branch_name( int $branch_id ): string {
		$branch = get_post( $branch_id );
		return $branch && 'marison_branch' === $branch->post_type && 'publish' === $branch->post_status ? get_the_title( $branch ) : '';
	}

	private static function meta_number( int $post_id, string $key ): ?float {
		$value = get_post_meta( $post_id, $key, true );
		return '' === (string) $value ? null : (float) $value;
	}

	private static function meta_integer( int $post_id, string $key ): ?int {
		$value = get_post_meta( $post_id, $key, true );
		return '' === (string) $value ? null : (int) $value;
	}

	private static function label( string $key, string $language ): string {
		$labels = [
			'home' => [ 'id' => 'Beranda', 'en' => 'Home' ],
			'housing' => [ 'id' => 'Perumahan', 'en' => 'Housing' ],
		];
		return $labels[ $key ][ 'en' === $language ? 'en' : 'id' ] ?? '';
	}
}
