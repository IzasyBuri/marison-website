<?php
/**
 * Restricted server-rendered Lead administration.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Admin;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Leads\LeadRepository;

final class Leads {
	private const PAGE = 'marison-leads';
	private const NONCE_ACTION = 'marison_lead_admin_action';
	private const NONCE_NAME = 'marison_lead_admin_nonce';
	private const PER_PAGE = 25;

	public static function register(): void {
		add_menu_page( 'Leads', 'Leads', 'manage_marison_leads', self::PAGE, [ self::class, 'render' ], 'dashicons-email', 27 );
	}

	public static function handle_delete(): void {
		if ( ! current_user_can( 'manage_marison_leads' ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
			wp_die( esc_html__( 'Anda tidak memiliki izin untuk menghapus Lead.', 'marison-core' ) );
		}
		check_admin_referer( self::NONCE_ACTION, self::NONCE_NAME );
		$result = LeadRepository::delete( absint( $_POST['lead_id'] ?? 0 ) );
		$message = is_wp_error( $result ) ? $result->get_error_message() : 'Lead berhasil dihapus.';
		wp_safe_redirect( add_query_arg( [ 'page' => self::PAGE, 'marison_notice' => rawurlencode( $message ), 'marison_notice_type' => is_wp_error( $result ) ? 'error' : 'success' ], admin_url( 'admin.php' ) ) );
		exit;
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_marison_leads' ) ) {
			wp_die( esc_html__( 'Anda tidak memiliki izin untuk melihat Leads.', 'marison-core' ) );
		}
		$filters = [ 'search' => sanitize_text_field( wp_unslash( $_GET['search'] ?? '' ) ), 'project_id' => absint( $_GET['project_id'] ?? 0 ) ];
		$page = max( 1, absint( $_GET['paged'] ?? 1 ) );
		$rows = LeadRepository::list( $filters, $page, self::PER_PAGE );
		$total = LeadRepository::count( $filters );
		$projects = get_posts( [ 'post_type' => 'marison_project', 'post_status' => [ 'publish', 'future', 'draft', 'pending', 'private' ], 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ] );
		?>
		<div class="wrap">
			<h1>Leads</h1>
			<?php self::notice(); ?>
			<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>"><input type="hidden" name="page" value="<?php echo esc_attr( self::PAGE ); ?>" /><p class="search-box"><label class="screen-reader-text" for="marison-lead-search">Cari Lead</label><input id="marison-lead-search" type="search" name="search" value="<?php echo esc_attr( $filters['search'] ); ?>" placeholder="Nama atau kontak" /><?php submit_button( 'Cari Lead', 'secondary', '', false ); ?></p><div class="tablenav top"><div class="alignleft actions"><select name="project_id"><option value="">Semua Project / General</option><?php foreach($projects as $project): ?><option value="<?php echo esc_attr($project->ID); ?>" <?php selected($filters['project_id'],$project->ID); ?>><?php echo esc_html($project->post_title); ?></option><?php endforeach; ?></select><?php submit_button('Filter','secondary','',false); ?></div></div></form>
			<p>Lead bersifat internal. Gunakan data ini hanya untuk routing dan tindak lanjut yang berwenang.</p>
			<div style="overflow-x:auto;"><table class="widefat striped"><thead><tr><th>Name</th><th>Contact</th><th>Project / General</th><th>Created (UTC)</th><th>Actions</th></tr></thead><tbody>
			<?php if($rows): foreach($rows as $row): ?><tr><td><?php echo esc_html($row['name']); ?></td><td><?php echo esc_html($row['contact']); ?></td><td><?php echo esc_html($row['project_title'] ?: 'General Corporate'); ?></td><td><?php echo esc_html($row['created_at']); ?></td><td><form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"><input type="hidden" name="action" value="marison_delete_lead" /><input type="hidden" name="lead_id" value="<?php echo esc_attr($row['id']); ?>" /><?php wp_nonce_field(self::NONCE_ACTION,self::NONCE_NAME); ?><button type="submit" class="button-link delete">Hapus</button></form></td></tr><?php endforeach; else: ?><tr><td colspan="5">Belum ada Lead yang sesuai filter.</td></tr><?php endif; ?>
			</tbody></table></div>
			<?php $pages=(int)ceil($total/self::PER_PAGE);if($pages>1): ?><div class="tablenav"><div class="tablenav-pages"><?php echo wp_kses_post(paginate_links(['base'=>add_query_arg('paged','%#%',self::url()),'format'=>'','current'=>$page,'total'=>$pages,'type'=>'plain'])); ?></div></div><?php endif; ?>
		</div>
		<?php
	}

	private static function url(): string { return add_query_arg( [ 'page' => self::PAGE ], admin_url( 'admin.php' ) ); }

	private static function notice(): void {
		if ( empty( $_GET['marison_notice'] ) ) { return; }
		$type = 'error' === sanitize_key( $_GET['marison_notice_type'] ?? '' ) ? 'error' : 'success';
		printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( $type ), esc_html( rawurldecode( wp_unslash( $_GET['marison_notice'] ) ) ) );
	}
}
