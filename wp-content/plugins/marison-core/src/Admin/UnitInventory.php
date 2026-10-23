<?php
/**
 * Server-rendered Unit Inventory administration.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Admin;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Inventory\UnitRepository;
use Marison\Core\Inventory\UnitRules;

final class UnitInventory {
	private const PAGE = 'marison-unit-inventory';
	private const NONCE_ACTION = 'marison_unit_inventory_action';
	private const NONCE_NAME = 'marison_unit_inventory_nonce';
	private const PER_PAGE = 25;

	public static function register(): void {
		add_submenu_page( 'edit.php?post_type=marison_project', 'Unit Inventory', 'Unit Inventory', 'manage_marison_inventory', self::PAGE, [ self::class, 'render' ] );
	}

	public static function handle_save(): void {
		self::guard_request();
		$id = absint( $_POST['unit_id'] ?? 0 );
		$data = [
			'project_id' => absint( $_POST['project_id'] ?? 0 ),
			'house_type_id' => absint( $_POST['house_type_id'] ?? 0 ),
			'unit_identifier' => sanitize_text_field( wp_unslash( $_POST['unit_identifier'] ?? '' ) ),
			'status' => sanitize_key( wp_unslash( $_POST['status'] ?? '' ) ),
		];
		$result = $id ? UnitRepository::update( $id, $data ) : UnitRepository::create( $data );
		$message = is_wp_error( $result ) ? $result->get_error_message() : ( $id ? 'Unit berhasil diperbarui.' : 'Unit berhasil ditambahkan.' );
		self::redirect( $message, is_wp_error( $result ) ? 'error' : 'success' );
	}

	public static function handle_delete(): void {
		self::guard_request();
		$result = UnitRepository::delete( absint( $_POST['unit_id'] ?? 0 ) );
		self::redirect( is_wp_error( $result ) ? $result->get_error_message() : 'Unit berhasil dihapus.', is_wp_error( $result ) ? 'error' : 'success' );
	}

	public static function handle_bulk_status(): void {
		self::guard_request();
		$result = UnitRepository::bulk_update_status( (array) ( $_POST['unit_ids'] ?? [] ), sanitize_key( wp_unslash( $_POST['bulk_status'] ?? '' ) ) );
		$message = is_wp_error( $result ) ? $result->get_error_message() : sprintf( '%d Unit berhasil diperbarui.', (int) $result );
		self::redirect( $message, is_wp_error( $result ) ? 'error' : 'success' );
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_marison_inventory' ) ) {
			wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengelola Unit Inventory.', 'marison-core' ) );
		}

		$action = sanitize_key( $_GET['action'] ?? '' );
		if ( 'edit' === $action || 'new' === $action ) {
			self::render_form( 'edit' === $action ? UnitRepository::get( absint( $_GET['id'] ?? 0 ) ) : null );
			return;
		}

		$filters = self::filters();
		$rows = UnitRepository::list( $filters, $filters['page'], self::PER_PAGE );
		$total = UnitRepository::count( $filters );
		$projects = self::posts( 'marison_project' );
		$house_types = self::posts( 'marison_house_type' );
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline">Unit Inventory</h1>
			<a href="<?php echo esc_url( self::url( [ 'action' => 'new' ] ) ); ?>" class="page-title-action">Tambah Unit</a>
			<?php self::notice(); ?>
			<hr class="wp-header-end" />
			<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
				<input type="hidden" name="page" value="<?php echo esc_attr( self::PAGE ); ?>" />
				<p class="search-box"><label class="screen-reader-text" for="marison-unit-search">Cari Unit</label><input id="marison-unit-search" type="search" name="search" value="<?php echo esc_attr( $filters['search'] ); ?>" placeholder="Identifier Unit" /><?php submit_button( 'Cari Unit', 'secondary', '', false ); ?></p>
				<div class="tablenav top"><div class="alignleft actions">
					<?php self::select( 'project_id', 'Semua Project', $filters['project_id'], $projects ); ?>
					<?php self::select( 'house_type_id', 'Semua House Type', $filters['house_type_id'], $house_types ); ?>
					<select name="status"><option value="">Semua Status</option><?php foreach ( self::status_labels() as $value => $label ) : ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $filters['status'], $value ); ?>><?php echo esc_html( $label ); ?></option><?php endforeach; ?></select>
					<?php submit_button( 'Filter', 'secondary', '', false ); ?>
				</div></div>
			</form>

			<form id="marison-unit-bulk-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="marison_bulk_unit_status" /><?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>
				<div class="tablenav top"><div class="alignleft actions bulkactions"><label class="screen-reader-text" for="marison-bulk-status">Ubah status menjadi</label><select id="marison-bulk-status" name="bulk_status"><option value="">Bulk actions</option><?php foreach ( self::status_labels() as $value => $label ) : ?><option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option><?php endforeach; ?></select><?php submit_button( 'Terapkan', 'action', '', false ); ?></div></div>
			</form>
				<div style="overflow-x:auto;"><table class="widefat striped"><thead><tr><td class="manage-column column-cb check-column"><input type="checkbox" onclick="document.querySelectorAll('#marison-unit-bulk-form input[name=\"unit_ids[]\"]').forEach(function(input){input.checked=this.checked;}, this);" /></td><th>Unit</th><th>Project</th><th>House Type</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead><tbody>
				<?php if ( $rows ) : foreach ( $rows as $row ) : ?>
					<tr><th class="check-column"><input form="marison-unit-bulk-form" type="checkbox" name="unit_ids[]" value="<?php echo esc_attr( $row['id'] ); ?>" /></th><td><strong><a href="<?php echo esc_url( self::url( [ 'action' => 'edit', 'id' => $row['id'] ] ) ); ?>"><?php echo esc_html( $row['unit_identifier'] ); ?></a></strong></td><td><?php echo esc_html( $row['project_title'] ?: 'Project #' . $row['project_id'] ); ?></td><td><?php echo esc_html( $row['house_type_title'] ?: ( $row['house_type_id'] ? 'House Type #' . $row['house_type_id'] : '—' ) ); ?></td><td><?php echo esc_html( self::status_labels()[ $row['status'] ] ?? $row['status'] ); ?></td><td><?php echo esc_html( $row['updated_at'] ); ?> UTC</td><td><a href="<?php echo esc_url( self::url( [ 'action' => 'edit', 'id' => $row['id'] ] ) ); ?>">Edit</a> · <form style="display:inline" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><input type="hidden" name="action" value="marison_delete_unit" /><input type="hidden" name="unit_id" value="<?php echo esc_attr( $row['id'] ); ?>" /><?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?><button type="submit" class="button-link delete">Hapus</button></form></td></tr>
				<?php endforeach; else : ?><tr><td colspan="7">Belum ada Unit yang sesuai filter.</td></tr><?php endif; ?>
				</tbody></table></div>
			<?php self::pagination( $total, $filters['page'] ); ?>
		</div>
		<?php
	}

	private static function render_form( ?array $unit ): void {
		$unit = $unit ?: [ 'id' => 0, 'project_id' => 0, 'house_type_id' => 0, 'unit_identifier' => '', 'status' => '' ];
		?>
		<div class="wrap"><h1><?php echo esc_html( $unit['id'] ? 'Edit Unit' : 'Tambah Unit' ); ?></h1><?php self::notice(); ?><p>Unit memakai identifier unik dalam Project. Status wajib dipilih secara sengaja; sistem tidak mengasumsikan Tersedia.</p><form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><input type="hidden" name="action" value="marison_save_unit" /><input type="hidden" name="unit_id" value="<?php echo esc_attr( $unit['id'] ); ?>" /><?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?><table class="form-table" role="presentation"><tbody><tr><th><label for="marison-unit-project">Project</label></th><td><?php self::select( 'project_id', 'Pilih Project', $unit['project_id'], self::posts( 'marison_project' ), 'marison-unit-project' ); ?></td></tr><tr><th><label for="marison-unit-house-type">House Type</label></th><td><?php self::house_type_select( $unit['house_type_id'] ); ?><p class="description">House Type menampilkan Project pemilik; validasi server-side tetap berlaku.</p></td></tr><tr><th><label for="marison-unit-identifier">Unit identifier</label></th><td><input class="regular-text" id="marison-unit-identifier" name="unit_identifier" type="text" value="<?php echo esc_attr( $unit['unit_identifier'] ); ?>" required /></td></tr><tr><th><label for="marison-unit-status">Status</label></th><td><select id="marison-unit-status" name="status" required><option value="">Pilih status</option><?php foreach ( self::status_labels() as $value => $label ) : ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $unit['status'], $value ); ?>><?php echo esc_html( $label ); ?></option><?php endforeach; ?></select></td></tr></tbody></table><?php submit_button( $unit['id'] ? 'Simpan Perubahan' : 'Tambah Unit' ); ?></form></div>
		<?php
	}

	private static function filters(): array {
		$status = sanitize_key( $_GET['status'] ?? '' );
		return [ 'project_id' => absint( $_GET['project_id'] ?? 0 ), 'house_type_id' => absint( $_GET['house_type_id'] ?? 0 ), 'status' => in_array( $status, UnitRules::statuses(), true ) ? $status : '', 'search' => sanitize_text_field( wp_unslash( $_GET['search'] ?? '' ) ), 'page' => max( 1, absint( $_GET['paged'] ?? 1 ) ) ];
	}

	private static function posts( string $post_type ): array { return get_posts( [ 'post_type' => $post_type, 'post_status' => [ 'publish', 'future', 'draft', 'pending', 'private' ], 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ] ); }

	private static function select( string $name, string $placeholder, int $selected_id, array $posts, string $id = '' ): void {
		printf( '<select name="%s"%s><option value="">%s</option>', esc_attr( $name ), $id ? ' id="' . esc_attr( $id ) . '"' : '', esc_html( $placeholder ) );
		foreach ( $posts as $post ) { printf( '<option value="%d" %s>%s</option>', (int) $post->ID, selected( $selected_id, $post->ID, false ), esc_html( $post->post_title ) ); }
		echo '</select>';
	}

	private static function house_type_select( int $selected_id ): void {
		echo '<select id="marison-unit-house-type" name="house_type_id"><option value="">Tanpa House Type</option>';
		foreach ( self::posts( 'marison_house_type' ) as $house_type ) {
			$project_id = (int) get_post_meta( $house_type->ID, '_marison_house_type_project', true );
			$project    = $project_id ? get_post( $project_id ) : null;
			$label      = $house_type->post_title . ( $project && 'marison_project' === $project->post_type ? ' — ' . $project->post_title : ' — Project tidak valid' );
			printf( '<option value="%d" %s>%s</option>', (int) $house_type->ID, selected( $selected_id, $house_type->ID, false ), esc_html( $label ) );
		}
		echo '</select>';
	}

	private static function status_labels(): array { return [ 'available' => 'Tersedia', 'booked' => 'Terbooking', 'sold' => 'Terjual' ]; }

	private static function pagination( int $total, int $page ): void {
		$pages = (int) ceil( $total / self::PER_PAGE );
		if ( $pages <= 1 ) { return; }
		echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post( paginate_links( [ 'base' => add_query_arg( 'paged', '%#%', self::url() ), 'format' => '', 'current' => $page, 'total' => $pages, 'type' => 'plain' ] ) ) . '</div></div>';
	}

	private static function guard_request(): void {
		if ( ! current_user_can( 'manage_marison_inventory' ) ) { wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengelola Unit Inventory.', 'marison-core' ) ); }
		if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) { wp_die( esc_html__( 'Metode request tidak valid.', 'marison-core' ) ); }
		check_admin_referer( self::NONCE_ACTION, self::NONCE_NAME );
	}

	private static function redirect( string $message, string $type ): void { wp_safe_redirect( add_query_arg( [ 'page' => self::PAGE, 'marison_notice' => rawurlencode( $message ), 'marison_notice_type' => $type ], admin_url( 'admin.php' ) ) ); exit; }

	private static function notice(): void {
		if ( empty( $_GET['marison_notice'] ) ) { return; }
		$type = 'error' === sanitize_key( $_GET['marison_notice_type'] ?? '' ) ? 'error' : 'success';
		printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( $type ), esc_html( rawurldecode( wp_unslash( $_GET['marison_notice'] ) ) ) );
	}

	private static function url( array $args = [] ): string { return add_query_arg( array_merge( [ 'page' => self::PAGE ], $args ), admin_url( 'admin.php' ) ); }
}
