<?php
/**
 * Marison reusable reference taxonomies.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Reference;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Admin\MetaBoxes;

final class Taxonomies {
	public static function register(): void {
		register_taxonomy(
			'marison_location',
			[ 'marison_project', 'marison_branch' ],
			[
				'labels' => [
					'name' => 'Lokasi',
					'singular_name' => 'Lokasi',
					'menu_name' => 'Lokasi',
					'all_items' => 'Semua Lokasi',
					'parent_item' => 'Parent Location',
					'parent_item_colon' => 'Parent Location (Country → Province → City / Regency):',
					'new_item_name' => 'Nama Lokasi Baru',
					'add_new_item' => 'Tambah Lokasi',
					'edit_item' => 'Edit Lokasi',
					'update_item' => 'Perbarui Lokasi',
					'search_items' => 'Cari Lokasi',
					'not_found' => 'Lokasi belum tersedia.',
				],
				'hierarchical' => true,
				'public' => false,
				'publicly_queryable' => false,
				'show_ui' => true,
				'show_in_menu' => false,
				'show_in_rest' => false,
				'show_admin_column' => true,
				'rewrite' => false,
				'meta_box_cb' => [ MetaBoxes::class, 'render_location_metabox' ],
				'capabilities' => [
					'manage_terms' => 'manage_options',
					'edit_terms' => 'manage_options',
					'delete_terms' => 'manage_options',
					'assign_terms' => 'edit_posts',
				],
			]
		);

		register_taxonomy(
			'marison_facility',
			[ 'marison_project' ],
			[
				'labels' => [
					'name' => 'Facilities',
					'singular_name' => 'Facility',
					'menu_name' => 'Facilities',
					'all_items' => 'Semua Facilities',
					'new_item_name' => 'Nama Facility Baru',
					'add_new_item' => 'Tambah Facility',
					'edit_item' => 'Edit Facility',
					'update_item' => 'Perbarui Facility',
					'search_items' => 'Cari Facility',
					'not_found' => 'Facility belum tersedia.',
				],
				'hierarchical' => true,
				'public' => false,
				'publicly_queryable' => false,
				'show_ui' => true,
				'show_in_menu' => false,
				'show_in_rest' => false,
				'show_admin_column' => true,
				'rewrite' => false,
				'capabilities' => [
					'manage_terms' => 'manage_options',
					'edit_terms' => 'manage_options',
					'delete_terms' => 'manage_options',
					'assign_terms' => 'edit_posts',
				],
			]
		);
	}

	public static function validate_insert( $term, $taxonomy, $args = [] ) {
		if ( 'marison_location' !== $taxonomy || is_wp_error( $term ) ) {
			return $term;
		}

		$parent = is_array( $args ) && isset( $args['parent'] ) ? absint( $args['parent'] ) : 0;
		if ( $parent && ! self::is_allowed_parent( $parent ) ) {
			return new \WP_Error(
				'marison_location_depth',
				'Lokasi hanya boleh memiliki tiga tingkat: Country → Province → City / Regency.'
			);
		}

		return $term;
	}

	public static function validate_parent( $parent, $term_id, $taxonomy ) {
		if ( 'marison_location' !== $taxonomy || ! $parent ) {
			return absint( $parent );
		}

		if ( self::is_allowed_parent( $parent, $term_id ) ) {
			return absint( $parent );
		}

		$current = get_term( absint( $term_id ), 'marison_location' );
		return $current && ! is_wp_error( $current ) ? (int) $current->parent : 0;
	}

	private static function is_allowed_parent( int $parent, int $term_id = 0 ): bool {
		if ( $parent === $term_id || ! term_exists( $parent, 'marison_location' ) ) {
			return false;
		}

		$parent_ancestors = get_ancestors( $parent, 'marison_location', 'taxonomy' );
		if ( $term_id && in_array( $term_id, $parent_ancestors, true ) ) {
			return false;
		}

		$depth = count( $parent_ancestors ) + 2;
		$descendant_depth = 0;
		if ( $term_id ) {
			$terms = get_terms(
				[
					'taxonomy' => 'marison_location',
					'hide_empty' => false,
					'fields' => 'ids',
				]
			);
			foreach ( $terms as $candidate_id ) {
				$ancestors = get_ancestors( $candidate_id, 'marison_location', 'taxonomy' );
				$position = array_search( $term_id, $ancestors, true );
				if ( false !== $position ) {
					$descendant_depth = max( $descendant_depth, (int) $position + 1 );
				}
			}
		}

		return $depth + $descendant_depth <= 3;
	}
}

add_filter( 'pre_insert_term', [ Taxonomies::class, 'validate_insert' ], 10, 3 );
add_filter( 'wp_update_term_parent', [ Taxonomies::class, 'validate_parent' ], 10, 3 );
