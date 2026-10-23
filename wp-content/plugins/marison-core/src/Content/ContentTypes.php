<?php
/**
 * Marison managed content type registration.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Content;

defined( 'ABSPATH' ) || exit;

final class ContentTypes {
	public static function register(): void {
		register_post_type(
			'marison_project',
			[
				'labels' => [
					'name' => 'Perumahan',
					'singular_name' => 'Project',
					'menu_name' => 'Perumahan',
					'name_admin_bar' => 'Project',
					'add_new' => 'Tambah Project',
					'add_new_item' => 'Tambah Project',
					'edit_item' => 'Edit Project',
					'new_item' => 'Project Baru',
					'view_item' => 'Lihat Project',
					'search_items' => 'Cari Project',
					'not_found' => 'Project belum tersedia.',
					'not_found_in_trash' => 'Tidak ada Project di tempat sampah.',
				],
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_rest' => false,
				'show_in_nav_menus' => false,
				'has_archive' => false,
				'rewrite' => [
					'slug' => 'perumahan',
					'with_front' => false,
				],
				'query_var' => true,
				'supports' => [ 'title', 'editor', 'thumbnail', 'revisions' ],
				'capability_type' => [ 'marison_project', 'marison_projects' ],
				'map_meta_cap' => true,
				'menu_icon' => 'dashicons-admin-home',
			]
		);

		register_post_type(
			'marison_house_type',
			[
				'labels' => [
					'name' => 'House Types',
					'singular_name' => 'House Type',
					'menu_name' => 'House Types',
					'add_new_item' => 'Tambah House Type',
					'edit_item' => 'Edit House Type',
					'new_item' => 'House Type Baru',
					'search_items' => 'Cari House Type',
					'not_found' => 'House Type belum tersedia.',
				],
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => 'edit.php?post_type=marison_project',
				'show_in_rest' => false,
				'show_in_nav_menus' => false,
				'rewrite' => false,
				'has_archive' => false,
				'supports' => [ 'title', 'editor', 'thumbnail', 'revisions' ],
				'capability_type' => [ 'marison_house_type', 'marison_house_types' ],
				'map_meta_cap' => true,
			]
		);

		register_post_type(
			'marison_branch',
			[
				'labels' => [
					'name' => 'Branch Offices',
					'singular_name' => 'Branch Office',
					'menu_name' => 'Branch Offices',
					'add_new_item' => 'Tambah Branch Office',
					'edit_item' => 'Edit Branch Office',
					'new_item' => 'Branch Office Baru',
					'search_items' => 'Cari Branch Office',
					'not_found' => 'Branch Office belum tersedia.',
				],
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'show_in_rest' => false,
				'show_in_nav_menus' => false,
				'rewrite' => false,
				'has_archive' => false,
				'supports' => [ 'title', 'editor', 'revisions' ],
				'capability_type' => [ 'marison_branch', 'marison_branches' ],
				'map_meta_cap' => true,
			]
		);

		register_post_type(
			'marison_marketing',
			[
				'labels' => [
					'name' => 'Marketing',
					'singular_name' => 'Marketing Person / Team',
					'menu_name' => 'Marketing',
					'add_new_item' => 'Tambah Marketing Person / Team',
					'edit_item' => 'Edit Marketing Person / Team',
					'new_item' => 'Marketing Person / Team Baru',
					'search_items' => 'Cari Marketing Person / Team',
					'not_found' => 'Marketing Person / Team belum tersedia.',
				],
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'show_in_rest' => false,
				'show_in_nav_menus' => false,
				'rewrite' => false,
				'has_archive' => false,
				'supports' => [ 'title', 'revisions' ],
				'capability_type' => [ 'marison_marketing', 'marison_marketing_records' ],
				'map_meta_cap' => true,
			]
		);

		register_post_type(
			'marison_kpr_scheme',
			[
				'labels' => [
					'name' => 'KPR Schemes',
					'singular_name' => 'KPR Scheme',
					'menu_name' => 'KPR Schemes',
					'add_new_item' => 'Tambah KPR Scheme',
					'edit_item' => 'Edit KPR Scheme',
					'new_item' => 'KPR Scheme Baru',
					'search_items' => 'Cari KPR Scheme',
					'not_found' => 'KPR Scheme belum tersedia.',
				],
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'show_in_rest' => false,
				'show_in_nav_menus' => false,
				'rewrite' => false,
				'has_archive' => false,
				'supports' => [ 'title', 'revisions' ],
				'capability_type' => [ 'marison_kpr_scheme', 'marison_kpr_schemes' ],
				'map_meta_cap' => true,
			]
		);
	}
}
