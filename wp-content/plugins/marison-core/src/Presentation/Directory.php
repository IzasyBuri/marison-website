<?php
/**
 * Public Housing Directory read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Multilingual\Polylang;
use Marison\Core\Multilingual\Resolver;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class Directory {
	public const PAGE_SIZE = 9;
	public const LOCATION_TAXONOMY = 'marison_location';

	public static function normalize_filters( array $request ): array {
		$location_raw = $request['location_term_id'] ?? '';
		$province_raw = $request['province_term_id'] ?? '';
		$status_raw = $request['project_status'] ?? '';
		$page_raw = $request['paged'] ?? 1;
		$location = self::positive_integer( $location_raw );
		$province = self::positive_integer( $province_raw );
		$status = sanitize_key( self::scalar_value( $status_raw ) );
		$page = self::positive_integer( $page_raw );
		$invalid = [];

		if ( self::has_input( $location_raw ) && ! $location ) {
			$invalid[] = 'location';
		}
		if ( self::has_input( $province_raw ) && ! $province ) {
			$invalid[] = 'province';
		}
		if ( self::has_input( $status_raw ) && ! in_array( $status, Validation::PROJECT_STATUSES, true ) ) {
			$invalid[] = 'status';
			$status = '';
		}
		if ( ! $page ) {
			$page = 1;
		}

		return [
			'location_term_id' => $location,
			'province_term_id' => $province,
			'project_status' => $status,
			'paged' => min( 100000, $page ),
			'invalid' => $invalid,
		];
	}

	public static function view( array $request = [] ): array {
		$request = $request ?: self::request();
		$filters = self::normalize_filters( $request );
		$filters = self::validate_location_filters( $filters );
		$canonical_ids = self::valid_canonical_project_ids();
		$invalid = ! empty( $filters['invalid'] );
		$query = null;

		if ( ! $invalid ) {
			$args = [
				'post_type' => 'marison_project',
				'post_status' => 'publish',
				'posts_per_page' => self::PAGE_SIZE,
				'paged' => $filters['paged'],
				'post__in' => $canonical_ids ?: [ 0 ],
				'orderby' => 'date ID',
				'order' => 'DESC',
				'no_found_rows' => false,
			];
			if ( Polylang::available() ) {
				$args['lang'] = Polylang::default_language();
			}

			if ( $filters['location_term_id'] ) {
				$args['tax_query'][] = [
					'taxonomy' => self::LOCATION_TAXONOMY,
					'field' => 'term_id',
					'terms' => [ $filters['location_term_id'] ],
					'include_children' => false,
				];
			}
			if ( $filters['province_term_id'] ) {
				$args['tax_query'][] = [
					'taxonomy' => self::LOCATION_TAXONOMY,
					'field' => 'term_id',
					'terms' => [ $filters['province_term_id'] ],
					'include_children' => true,
				];
			}
			if ( $filters['project_status'] ) {
				$args['meta_query'][] = [
					'key' => Meta::PROJECT_STATUS,
					'value' => $filters['project_status'],
					'compare' => '=',
				];
			}

			$query = new \WP_Query( $args );
		}

		$items = [];
		if ( $query ) {
			foreach ( $query->posts as $project ) {
				$items[] = self::project_item( $project );
			}
		}

		$has_filters = self::has_filter_selection( $request );
		$base_url = Resolver::localized_url( 'perumahan' );

		return [
			'filters' => $filters,
			'has_filters' => $has_filters,
			'is_invalid' => $invalid,
			'projects' => $items,
			'options' => [
				'cities' => self::location_options( $canonical_ids, 3 ),
				'provinces' => self::location_options( $canonical_ids, 2 ),
			],
			'total' => $query ? (int) $query->found_posts : 0,
			'available_total' => count( $canonical_ids ),
			'page' => $filters['paged'],
			'pages' => $query ? (int) $query->max_num_pages : 0,
			'page_size' => self::PAGE_SIZE,
			'base_url' => $base_url,
			'reset_url' => $base_url,
			'pagination' => self::pagination( $filters, $query ? (int) $query->max_num_pages : 0, $base_url ),
		];
	}

	public static function is_directory_page(): bool {
		if ( ! function_exists( 'is_page' ) || ! is_page() ) {
			return false;
		}

		$page = get_queried_object();
		$canonical = get_page_by_path( 'perumahan', OBJECT, 'page' );
		return $page instanceof \WP_Post && $canonical instanceof \WP_Post && Resolver::canonical_post_id( $page->ID ) === Resolver::canonical_post_id( $canonical->ID );
	}

	public static function filter_robots( array $robots ): array {
		if ( self::is_directory_page() && self::has_request_filters( self::request() ) ) {
			$robots['noindex'] = true;
			unset( $robots['nofollow'] );
			$robots['follow'] = true;
		}

		return $robots;
	}

	private static function request(): array {
		return [
			'location_term_id' => isset( $_GET['location_term_id'] ) ? wp_unslash( $_GET['location_term_id'] ) : '',
			'province_term_id' => isset( $_GET['province_term_id'] ) ? wp_unslash( $_GET['province_term_id'] ) : '',
			'project_status' => isset( $_GET['project_status'] ) ? wp_unslash( $_GET['project_status'] ) : '',
			'paged' => isset( $_GET['paged'] ) ? wp_unslash( $_GET['paged'] ) : 1,
		];
	}

	private static function positive_integer( $value ): int {
		$value = self::scalar_value( $value );
		return preg_match( '/^[1-9]\d*$/', $value ) ? (int) $value : 0;
	}

	private static function scalar_value( $value ): string {
		return is_scalar( $value ) ? trim( (string) $value ) : '';
	}

	private static function has_input( $value ): bool {
		return ! is_scalar( $value ) || '' !== self::scalar_value( $value );
	}

	private static function validate_location_filters( array $filters ): array {
		if ( $filters['location_term_id'] ) {
			$term = get_term( $filters['location_term_id'], self::LOCATION_TAXONOMY );
			if ( ! $term || is_wp_error( $term ) || 3 !== Validation::location_depth( $filters['location_term_id'] ) ) {
				$filters['invalid'][] = 'location';
				$filters['location_term_id'] = 0;
			}
		}
		if ( $filters['province_term_id'] ) {
			$term = get_term( $filters['province_term_id'], self::LOCATION_TAXONOMY );
			if ( ! $term || is_wp_error( $term ) || 2 !== Validation::location_depth( $filters['province_term_id'] ) ) {
				$filters['invalid'][] = 'province';
				$filters['province_term_id'] = 0;
			}
		}
		if ( $filters['location_term_id'] && $filters['province_term_id'] ) {
			$location = get_term( $filters['location_term_id'], self::LOCATION_TAXONOMY );
			if ( ! $location || (int) $location->parent !== $filters['province_term_id'] ) {
				$filters['invalid'][] = 'relationship';
			}
		}

		$filters['invalid'] = array_values( array_unique( $filters['invalid'] ) );
		return $filters;
	}

	private static function valid_canonical_project_ids(): array {
		$args = [
			'post_type' => 'marison_project',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'orderby' => 'date ID',
			'order' => 'DESC',
		];
		if ( Polylang::available() ) {
			$args['lang'] = Polylang::default_language();
		}

		$ids = get_posts( $args );
		$ids = array_values( array_unique( array_filter( array_map( static fn( $id ): int => Resolver::canonical_post_id( absint( $id ) ), $ids ) ) ) );
		return array_values( array_filter( $ids, static fn( int $id ): bool => 'publish' === get_post_status( $id ) && ! Validation::project_errors( $id ) ) );
	}

	private static function location_options( array $project_ids, int $depth ): array {
		if ( ! $project_ids ) {
			return [];
		}
		$terms = get_terms( [
			'taxonomy' => self::LOCATION_TAXONOMY,
			'object_ids' => $project_ids,
			'hide_empty' => true,
			'number' => 0,
			'orderby' => 'name',
			'order' => 'ASC',
		] );
		if ( is_wp_error( $terms ) ) {
			return [];
		}

		$options = [];
		foreach ( $terms as $term ) {
			if ( $depth === Validation::location_depth( (int) $term->term_id ) ) {
				$options[] = [ 'id' => (int) $term->term_id, 'name' => $term->name ];
			}
		}
		return $options;
	}

	private static function project_item( \WP_Post $project ): array {
		$canonical_id = (int) $project->ID;
		$language = Resolver::current_language();
		$translation = Resolver::translation_state( $canonical_id, $language );
		$presentation_id = $translation['post_id'] ?: $canonical_id;
		$location = wp_get_post_terms( $canonical_id, self::LOCATION_TAXONOMY, [ 'fields' => 'all' ] );
		$city = '';
		if ( ! is_wp_error( $location ) ) {
			foreach ( $location as $term ) {
				if ( 3 === Validation::location_depth( (int) $term->term_id ) ) {
					$city = $term->name;
					break;
				}
			}
		}
		$status = (string) get_post_meta( $canonical_id, Meta::PROJECT_STATUS, true );

		return [
			'id' => $canonical_id,
			'presentation_id' => $presentation_id,
			'title' => get_the_title( $presentation_id ),
			'url' => get_permalink( $presentation_id ),
			'image' => get_the_post_thumbnail_url( $presentation_id, 'large' ) ?: get_the_post_thumbnail_url( $canonical_id, 'large' ) ?: '',
			'status' => $status,
			'status_label' => self::status_label( $status, $language ),
			'location' => $city,
			'translation_state' => $translation['state'],
		];
	}

	private static function status_label( string $status, string $language ): string {
		$labels = [
			'upcoming' => [ 'id' => 'Akan Datang', 'en' => 'Upcoming' ],
			'ongoing' => [ 'id' => 'Sedang Berjalan', 'en' => 'Ongoing' ],
			'completed' => [ 'id' => 'Selesai', 'en' => 'Completed' ],
		];
		return $labels[ $status ][ 'en' === $language ? 'en' : 'id' ] ?? '';
	}

	private static function has_request_filters( array $request ): bool {
		return self::has_filter_selection( $request )
			|| ( isset( $request['paged'] ) && (int) $request['paged'] > 1 );
	}

	private static function has_filter_selection( array $request ): bool {
		return self::has_input( $request['location_term_id'] ?? '' )
			|| self::has_input( $request['province_term_id'] ?? '' )
			|| self::has_input( $request['project_status'] ?? '' );
	}

	private static function pagination( array $filters, int $pages, string $base_url ): array {
		if ( $pages <= 1 ) {
			return [];
		}

		$links = [];
		for ( $page = 1; $page <= $pages; $page++ ) {
			$query = self::query_args( $filters );
			if ( 1 === $page ) {
				unset( $query['paged'] );
			} else {
				$query['paged'] = $page;
			}
			$links[] = [ 'page' => $page, 'url' => add_query_arg( $query, $base_url ), 'current' => $page === $filters['paged'] ];
		}
		return $links;
	}

	private static function query_args( array $filters ): array {
		$args = [];
		foreach ( [ 'location_term_id', 'province_term_id', 'project_status' ] as $key ) {
			if ( ! empty( $filters[ $key ] ) ) {
				$args[ $key ] = $filters[ $key ];
			}
		}
		return $args;
	}
}
