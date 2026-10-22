<?php
/**
 * Compact Marison admin menu organization.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Admin;

defined( 'ABSPATH' ) || exit;

final class Menus {
	public static function register(): void {
		add_menu_page(
			'Operasional Marison',
			'Operasional',
			'edit_posts',
			'marison-operations',
			[ self::class, 'render_operations_page' ],
			'dashicons-businessperson',
			26
		);

		add_submenu_page(
			'marison-operations',
			'Branch Offices',
			'Branch Offices',
			'edit_marison_branches',
			'edit.php?post_type=marison_branch'
		);
		add_submenu_page(
			'marison-operations',
			'Marketing',
			'Marketing',
			'edit_marison_marketing_records',
			'edit.php?post_type=marison_marketing'
		);

		add_submenu_page(
			'edit.php?post_type=marison_project',
			'Lokasi',
			'Lokasi',
			'manage_options',
			'edit-tags.php?taxonomy=marison_location&post_type=marison_project'
		);
		add_submenu_page(
			'edit.php?post_type=marison_project',
			'Facilities',
			'Facilities',
			'manage_options',
			'edit-tags.php?taxonomy=marison_facility&post_type=marison_project'
		);
	}

	public static function render_operations_page(): void {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( esc_html__( 'Anda tidak memiliki izin untuk membuka halaman ini.', 'marison-core' ) );
		}

		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Operasional Marison', 'marison-core' ); ?></h1>
			<p><?php echo esc_html__( 'Kelola Branch Office dan Marketing Person / Team dari menu ini. Assignment Marketing bersifat internal.', 'marison-core' ); ?></p>
		</div>
		<?php
	}
}
