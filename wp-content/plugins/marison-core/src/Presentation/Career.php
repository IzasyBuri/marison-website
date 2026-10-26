<?php
/**
 * Public Career Vacancy read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Multilingual\Polylang;
use Marison\Core\Multilingual\Resolver;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class Career {
	public static function guard_public_detail(): void {
		if ( ! is_singular( 'marison_career' ) || self::detail_state( get_queried_object_id() ) ) {
			return;
		}

		global $wp_query;
		if ( $wp_query instanceof \WP_Query ) {
			$wp_query->set_404();
		}
		status_header( 404 );
		nocache_headers();
	}

	public static function open_vacancies(): array {
		$args = [
			'post_type' => 'marison_career',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => [ 'date' => 'DESC', 'ID' => 'DESC' ],
			'order' => 'DESC',
			'suppress_filters' => false,
			'no_found_rows' => true,
			'meta_query' => [
				[
					'key' => Meta::CAREER_STATUS,
					'value' => 'open',
					'compare' => '=',
				],
			],
		];
		if ( Polylang::available() ) {
			$args['lang'] = Polylang::default_language();
		}

		$language = Resolver::current_language();
		$items = [];
		foreach ( get_posts( $args ) as $canonical ) {
			$canonical_id = Resolver::canonical_post_id( (int) $canonical->ID );
			if ( $canonical_id !== (int) $canonical->ID || ! self::is_published_career( $canonical_id ) ) {
				continue;
			}
			if ( Polylang::available() && function_exists( 'pll_get_post_language' ) && Polylang::default_language() !== pll_get_post_language( $canonical_id, 'slug' ) ) {
				continue;
			}
			if ( 'open' !== get_post_meta( $canonical_id, Meta::CAREER_STATUS, true ) ) {
				continue;
			}

			$translation = Resolver::translation_state( $canonical_id, $language );
			if ( Polylang::available() && Polylang::default_language() !== $language && 'TRANSLATED' !== $translation['state'] ) {
				continue;
			}
			$presentation = self::presentation_post( $canonical_id, $translation );
			if ( ! $presentation ) {
				continue;
			}
			$items[] = [
				'title' => get_the_title( $presentation ),
				'url' => (string) get_permalink( $presentation ),
				'excerpt' => self::excerpt( $presentation ),
				'status' => 'open',
				'status_label' => self::status_label( 'open', $language ),
			];
		}

		return $items;
	}

	public static function detail_state( int $post_id = 0 ): array {
		$post_id = absint( $post_id ?: get_queried_object_id() );
		$queried = get_post( $post_id );
		if ( ! $queried || 'marison_career' !== $queried->post_type || 'publish' !== $queried->post_status ) {
			return [];
		}

		$canonical_id = Resolver::canonical_post_id( $post_id );
		$canonical = get_post( $canonical_id );
		if ( ! self::is_published_career( $canonical_id ) || ! $canonical ) {
			return [];
		}

		$language = self::post_language( $post_id );
		$translation = Resolver::translation_state( $canonical_id, $language );
		$presentation = self::presentation_post( $canonical_id, $translation, $post_id );
		if ( ! $presentation ) {
			return [];
		}

		$status = Validation::sanitize_career_status( get_post_meta( $canonical_id, Meta::CAREER_STATUS, true ) );
		if ( ! in_array( $status, Validation::CAREER_STATUSES, true ) ) {
			return [];
		}

		if ( Polylang::available() && Polylang::default_language() !== $language && ( $canonical_id === $post_id || 'TRANSLATED' !== ( $translation['state'] ?? '' ) || (int) ( $translation['post_id'] ?? 0 ) !== $post_id ) ) {
			return [];
		}

		$instructions = self::language_instructions( $presentation, $language, $translation );
		return [
			'url' => (string) get_permalink( $presentation ),
			'careers_url' => self::localized_careers_url( $language ),
			'language' => $language,
			'status' => $status,
			'status_label' => self::status_label( $status, $language ),
			'application' => self::application( $status, $canonical_id, $instructions, $language ),
		];
	}

	private static function application( string $status, int $canonical_id, string $instructions, string $language ): array {
		if ( 'closed' === $status ) {
			return [ 'kind' => 'closed', 'label' => '', 'url' => '', 'instructions' => '', 'leaves_site' => false ];
		}

		$url = Validation::sanitize_career_external_url( get_post_meta( $canonical_id, Meta::CAREER_EXTERNAL_URL, true ) );
		if ( $url ) {
			return [
				'kind' => 'external',
				'label' => 'Apply externally',
				'url' => $url,
				'instructions' => '',
				'leaves_site' => true,
			];
		}

		$email = Validation::sanitize_career_email( get_post_meta( $canonical_id, Meta::CAREER_RECRUITMENT_EMAIL, true ) );
		if ( $email ) {
			return [
				'kind' => 'email',
				'label' => 'Email recruitment',
				'url' => 'mailto:' . $email,
				'instructions' => '',
				'leaves_site' => false,
			];
		}

		if ( '' !== trim( $instructions ) ) {
			return [
				'kind' => 'instructions',
				'label' => '',
				'url' => '',
				'instructions' => $instructions,
				'leaves_site' => false,
			];
		}

		return [ 'kind' => 'none', 'label' => '', 'url' => '', 'instructions' => '', 'leaves_site' => false ];
	}

	private static function presentation_post( int $canonical_id, array $translation, int $queried_id = 0 ): ?\WP_Post {
		$presentation_id = $queried_id && $queried_id !== $canonical_id ? $queried_id : (int) ( $translation['post_id'] ?? 0 );
		$presentation = $presentation_id ? get_post( $presentation_id ) : get_post( $canonical_id );
		return $presentation instanceof \WP_Post && 'marison_career' === $presentation->post_type && 'publish' === $presentation->post_status ? $presentation : null;
	}

	private static function language_instructions( \WP_Post $presentation, string $language, array $translation ): string {
		if ( ! Polylang::available() || Polylang::default_language() === $language || 'TRANSLATED' === ( $translation['state'] ?? '' ) ) {
			return sanitize_textarea_field( (string) get_post_meta( $presentation->ID, Meta::CAREER_APPLICATION_INSTRUCTIONS, true ) );
		}

		return '';
	}

	private static function post_language( int $post_id ): string {
		if ( Polylang::available() && function_exists( 'pll_get_post_language' ) ) {
			$language = pll_get_post_language( $post_id, 'slug' );
			if ( $language ) {
				return sanitize_key( $language );
			}
		}

		return Resolver::current_language();
	}

	private static function is_published_career( int $post_id ): bool {
		$post = get_post( $post_id );
		return $post instanceof \WP_Post && 'marison_career' === $post->post_type && 'publish' === $post->post_status;
	}

	private static function excerpt( \WP_Post $post ): string {
		return wp_trim_words( wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ), 28 );
	}

	private static function status_label( string $status, string $language ): string {
		$labels = [
			'open' => [ 'id' => 'Open', 'en' => 'Open' ],
			'closed' => [ 'id' => 'Closed', 'en' => 'Closed' ],
		];
		return $labels[ $status ][ 'en' === $language ? 'en' : 'id' ] ?? '';
	}

	private static function localized_careers_url( string $language ): string {
		if ( ! Polylang::available() || Polylang::default_language() === $language ) {
			return Resolver::localized_url( 'karier' );
		}

		$page = get_page_by_path( 'karier', OBJECT, 'page' );
		$translated_id = $page ? Resolver::translated_post_id( (int) $page->ID, $language ) : 0;
		return $translated_id ? (string) get_permalink( $translated_id ) : Resolver::localized_url( 'karier' );
	}
}
