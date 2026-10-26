<?php
/**
 * Public Article read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Multilingual\Resolver;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class Article {
	/**
	 * Resolve the related Projects for an Article without exposing internal IDs.
	 *
	 * The canonical Indonesian Article owns the relationship identity. Polylang's
	 * existing shared-meta synchronization keeps translations aligned, but reading
	 * from the canonical Article also makes that boundary explicit and resilient.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function related_projects( int $post_id = 0, string $language = '' ): array {
		$post_id = absint( $post_id ?: get_queried_object_id() );
		$post = get_post( $post_id );
		if ( ! $post || 'post' !== $post->post_type ) {
			return [];
		}

		$language = $language ? sanitize_key( $language ) : Resolver::current_language();
		$relationship_source_id = Resolver::canonical_post_id( $post_id );
		$stored_ids = get_post_meta( $relationship_source_id, Meta::ARTICLE_PROJECTS, true );
		$canonical_ids = Validation::sanitize_article_project_ids( $stored_ids );
		$projects = [];

		foreach ( $canonical_ids as $canonical_id ) {
			$canonical = get_post( $canonical_id );
			if ( ! $canonical || 'marison_project' !== $canonical->post_type || 'publish' !== $canonical->post_status ) {
				continue;
			}

			$translation = Resolver::translation_state( $canonical_id, $language );
			$presentation_id = $translation['post_id'] ?: $canonical_id;
			$presentation = get_post( $presentation_id );
			if ( ! $presentation || 'marison_project' !== $presentation->post_type || 'publish' !== $presentation->post_status ) {
				$presentation = $canonical;
				$presentation_id = $canonical_id;
			}

			$projects[] = [
				'title' => get_the_title( $presentation ),
				'url' => get_permalink( $presentation ),
				'image' => get_the_post_thumbnail_url( $presentation_id, 'large' ) ?: get_the_post_thumbnail_url( $canonical_id, 'large' ) ?: '',
				'status' => (string) get_post_meta( $canonical_id, Meta::PROJECT_STATUS, true ),
				'status_label' => ProjectDetail::status_label( (string) get_post_meta( $canonical_id, Meta::PROJECT_STATUS, true ), $language ),
				'location' => self::location( $canonical_id ),
				'translation_state' => $translation['state'],
			];
		}

		return $projects;
	}

	private static function location( int $project_id ): string {
		$terms = wp_get_post_terms( $project_id, 'marison_location', [ 'fields' => 'all' ] );
		if ( is_wp_error( $terms ) || ! $terms ) {
			return '';
		}

		foreach ( $terms as $term ) {
			if ( 3 === Validation::location_depth( (int) $term->term_id ) ) {
				return (string) $term->name;
			}
		}

		return (string) $terms[0]->name;
	}
}
