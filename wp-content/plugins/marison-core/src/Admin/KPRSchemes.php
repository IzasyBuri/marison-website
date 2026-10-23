<?php
/**
 * KPR Scheme administration.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Admin;

defined( 'ABSPATH' ) || exit;

use Marison\Core\KPR\PublicDefault;
use Marison\Core\KPR\SchemeRules;

final class KPRSchemes {
	private const PAGE = 'marison-kpr';
	private const NONCE_ACTION = 'marison_kpr_scheme_save';
	private const NONCE_NAME = 'marison_kpr_scheme_nonce';

	public static function register(): void {
		add_menu_page( 'KPR', 'KPR', 'manage_marison_kpr', self::PAGE, [ self::class, 'render' ], 'dashicons-calculator', 28 );
	}

	public static function register_meta_box(): void {
		add_meta_box( 'marison_kpr_configuration', 'Konfigurasi KPR Scheme', [ self::class, 'render_meta_box' ], 'marison_kpr_scheme', 'normal', 'high' );
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_marison_kpr' ) ) { wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengelola KPR Scheme.', 'marison-core' ) ); }
		$schemes = get_posts( [ 'post_type' => 'marison_kpr_scheme', 'post_status' => [ 'publish', 'future', 'draft', 'pending', 'private' ], 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ] );
		$default = PublicDefault::get();
		?>
		<div class="wrap"><h1 class="wp-heading-inline">KPR Schemes</h1><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=marison_kpr_scheme' ) ); ?>" class="page-title-action">Tambah KPR Scheme</a><?php self::notice(); ?><hr class="wp-header-end" /><p>Public Default dipilih secara eksplisit. Tidak ada rumus cicilan pada foundation ini.</p><p><strong>Status Public Default:</strong> <?php echo esc_html( $default['state'] ); ?></p>
		<div style="overflow-x:auto;"><table class="widefat striped"><thead><tr><th>Scheme</th><th>State</th><th>Bunga tahunan</th><th>Tenure (bulan)</th><th>DP default</th><th>Effective date</th><th>Public Default</th></tr></thead><tbody>
		<?php
	}

	public static function render_meta_box( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
		$state = get_post_meta( $post->ID, '_marison_kpr_state', true );$rate = get_post_meta( $post->ID, '_marison_kpr_annual_rate', true );$tenures = get_post_meta( $post->ID, '_marison_kpr_tenure_months', true );$dp = get_post_meta( $post->ID, '_marison_kpr_default_dp_percent', true );$date = get_post_meta( $post->ID, '_marison_kpr_effective_date', true );$disclaimer = get_post_meta( $post->ID, '_marison_kpr_disclaimer', true );
		?>
		<p><label for="marison_kpr_state"><strong>State</strong></label></p><select class="widefat" id="marison_kpr_state" name="marison_kpr_state"><option value="">Pilih state</option><option value="active" <?php selected($state,'active'); ?>>Aktif</option><option value="inactive" <?php selected($state,'inactive'); ?>>Tidak Aktif</option></select>
		<p><label for="marison_kpr_annual_rate"><strong>Bunga tahunan (%)</strong></label></p><input class="small-text" id="marison_kpr_annual_rate" name="marison_kpr_annual_rate" type="number" min="0" max="100" step="0.01" value="<?php echo esc_attr($rate); ?>" /><p class="description">Percentage points: 5.50 berarti 5.50% per tahun. Metode bunga belum ditentukan.</p>
		<p><label for="marison_kpr_tenure_months"><strong>Tenure (bulan)</strong></label></p><textarea class="widefat" id="marison_kpr_tenure_months" name="marison_kpr_tenure_months" rows="4"><?php echo esc_textarea(implode("\n",(array)$tenures)); ?></textarea><p class="description">Satu tenure per baris. Nilai akan dinormalisasi, diurutkan, dan dideduplikasi.</p>
		<p><label for="marison_kpr_default_dp_percent"><strong>Default DP (%)</strong></label></p><input class="small-text" id="marison_kpr_default_dp_percent" name="marison_kpr_default_dp_percent" type="number" min="0" max="100" step="0.01" value="<?php echo esc_attr($dp); ?>" /><p class="description">Ini adalah asumsi default, bukan aturan minimum atau kelayakan KPR.</p>
		<p><label for="marison_kpr_effective_date"><strong>Effective date</strong></label></p><input id="marison_kpr_effective_date" name="marison_kpr_effective_date" type="date" value="<?php echo esc_attr($date); ?>" /><p class="description">Tanggal bisnis YYYY-MM-DD; tidak ada expiry otomatis.</p>
		<p><label for="marison_kpr_disclaimer"><strong>Disclaimer</strong></label></p><textarea class="widefat" id="marison_kpr_disclaimer" name="marison_kpr_disclaimer" rows="4"><?php echo esc_textarea($disclaimer); ?></textarea><p class="description">Jelaskan bahwa simulasi mendatang adalah estimasi, bukan persetujuan pembiayaan.</p>
		<?php
	}

	public static function save( int $post_id, \WP_Post $post ): void {
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($post_id) || ! current_user_can('edit_post',$post_id) || ! isset($_POST[self::NONCE_NAME]) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[self::NONCE_NAME])),self::NONCE_ACTION) ) return;
		$fields=[
			'_marison_kpr_state'=>SchemeRules::sanitize_state(wp_unslash($_POST['marison_kpr_state']??'')),
			'_marison_kpr_annual_rate'=>SchemeRules::sanitize_rate(wp_unslash($_POST['marison_kpr_annual_rate']??'')),
			'_marison_kpr_tenure_months'=>SchemeRules::sanitize_tenures(preg_split('/\R/',(string)wp_unslash($_POST['marison_kpr_tenure_months']??''))),
			'_marison_kpr_default_dp_percent'=>SchemeRules::sanitize_default_dp(wp_unslash($_POST['marison_kpr_default_dp_percent']??'')),
			'_marison_kpr_effective_date'=>SchemeRules::sanitize_effective_date(wp_unslash($_POST['marison_kpr_effective_date']??'')),
			'_marison_kpr_disclaimer'=>SchemeRules::sanitize_disclaimer(wp_unslash($_POST['marison_kpr_disclaimer']??'')),
		];
		foreach($fields as $key=>$value){if(is_wp_error($value)){self::notice($value->get_error_message());continue;}if(''===$value||[]===$value)delete_post_meta($post_id,$key);else update_post_meta($post_id,$key,$value);}
	}

	public static function handle_set_default(): void { self::guard_action();$result=PublicDefault::set(absint($_POST['scheme_id']??0));self::redirect(is_wp_error($result)?$result->get_error_message():'Public Default berhasil dipilih.',is_wp_error($result)?'error':'success'); }
	public static function handle_clear_default(): void { self::guard_action();PublicDefault::clear();self::redirect('Public Default dihapus. Kalkulator menjadi unavailable sampai Scheme valid dipilih.','success'); }

	private static function guard_action(): void { if(!current_user_can('manage_marison_kpr')||'POST'!==strtoupper($_SERVER['REQUEST_METHOD']??''))wp_die(esc_html__('Request KPR tidak valid.','marison-core'));check_admin_referer(self::NONCE_ACTION,self::NONCE_NAME); }
	private static function redirect(string $message,string $type):void{wp_safe_redirect(add_query_arg(['page'=>self::PAGE,'marison_notice'=>rawurlencode($message),'marison_notice_type'=>$type],admin_url('admin.php')));exit;}
	private static function notice(?string $message = null):void{
		if ( null !== $message ) { set_transient( 'marison_kpr_notice_' . get_current_user_id(), $message, MINUTE_IN_SECONDS ); return; }
		if ( ! empty( $_GET['marison_notice'] ) ) { printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', 'error' === sanitize_key( $_GET['marison_notice_type'] ?? '' ) ? 'error' : 'success', esc_html( rawurldecode( wp_unslash( $_GET['marison_notice'] ) ) ) ); }
		$transient = get_transient( 'marison_kpr_notice_' . get_current_user_id() );
		if ( $transient ) { delete_transient( 'marison_kpr_notice_' . get_current_user_id() ); printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $transient ) ); }
	}
}
