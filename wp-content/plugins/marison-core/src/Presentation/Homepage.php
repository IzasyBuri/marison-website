<?php
/**
 * Public Homepage read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;
use Marison\Core\Multilingual\Polylang;

final class Homepage {
	public static function featured_projects( int $limit = 6 ): array {
		$args = [ 'post_type' => 'marison_project', 'post_status' => 'publish', 'posts_per_page' => min( 6, max( 1, $limit ) ), 'orderby' => 'date', 'order' => 'DESC' ];
		if ( Polylang::available() ) { $args['lang'] = Polylang::current_language(); }
		$projects = get_posts( $args );
		$items = [];
		foreach ( $projects as $project ) {
			if ( Validation::project_errors( $project->ID ) ) { continue; }
			$location = wp_get_post_terms( $project->ID, 'marison_location', [ 'fields' => 'all' ] );
			$items[] = [
				'id' => $project->ID,
				'title' => get_the_title( $project ),
				'url' => get_permalink( $project ),
				'image' => get_the_post_thumbnail_url( $project, 'large' ) ?: '',
				'status' => get_post_meta( $project->ID, Meta::PROJECT_STATUS, true ),
				'status_label' => self::status_label( get_post_meta( $project->ID, Meta::PROJECT_STATUS, true ) ),
				'location' => $location && ! is_wp_error( $location ) ? $location[0]->name : '',
			];
		}
		return $items;
	}

	public static function locations( int $limit = 6 ): array {
		$terms = get_terms( [ 'taxonomy' => 'marison_location', 'hide_empty' => false, 'number' => 100, 'orderby' => 'name', 'order' => 'ASC' ] );
		if ( is_wp_error( $terms ) ) { return []; }
		$items = [];
		foreach ( $terms as $term ) {
			if ( Validation::location_depth( (int) $term->term_id ) !== 3 ) { continue; }
			$project_ids = get_posts( [ 'post_type' => 'marison_project', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids', 'tax_query' => [ [ 'taxonomy' => 'marison_location', 'field' => 'term_id', 'terms' => [ $term->term_id ] ] ] ] );
			$project_ids = array_values( array_filter( $project_ids, static fn( $id ) => ! Validation::project_errors( (int) $id ) ) );
			if ( ! $project_ids ) { continue; }
			$items[] = [ 'id' => (int) $term->term_id, 'name' => $term->name, 'count' => count( $project_ids ) ];
			if ( count( $items ) >= min( 6, max( 1, $limit ) ) ) { break; }
		}
		return $items;
	}

	public static function articles( int $limit = 3 ): array {
		$args = [ 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => min( 3, max( 1, $limit ) ), 'orderby' => 'date', 'order' => 'DESC' ];
		if ( Polylang::available() ) { $args['lang'] = Polylang::current_language(); }
		$posts = get_posts( $args );
		return array_map( static function ( \WP_Post $post ): array {
			return [ 'id' => $post->ID, 'title' => get_the_title( $post ), 'url' => get_permalink( $post ), 'excerpt' => wp_trim_words( wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ), 24 ), 'image' => get_the_post_thumbnail_url( $post, 'medium_large' ) ?: '' ];
		}, $posts );
	}

	private static function status_label( string $status ): string {
		return [ 'upcoming' => 'Akan Datang', 'ongoing' => 'Sedang Berjalan', 'completed' => 'Selesai' ][ $status ] ?? '';
	}
}
