<?php
/**
 * Restricted corporate contact settings.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Settings;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Validation;

final class CorporateSettings {
	public const TELEPHONE = 'marison_corporate_telephone';
	public const EMAIL = 'marison_corporate_email';

	public static function register(): void {
		register_setting( 'marison_core_corporate_contacts', self::TELEPHONE, [ 'sanitize_callback' => [ self::class, 'sanitize_telephone' ], 'default' => '' ] );
		register_setting( 'marison_core_corporate_contacts', self::EMAIL, [ 'sanitize_callback' => 'sanitize_email', 'default' => '' ] );
		add_settings_section( 'marison_corporate_contact_section', 'Corporate Contact Fallback', [ self::class, 'render_section' ], 'marison-corporate-contacts' );
		add_settings_field( self::TELEPHONE, 'Telepon korporat', [ self::class, 'render_telephone' ], 'marison-corporate-contacts', 'marison_corporate_contact_section' );
		add_settings_field( self::EMAIL, 'Email korporat', [ self::class, 'render_email' ], 'marison-corporate-contacts', 'marison_corporate_contact_section' );
	}

	public static function add_menu(): void {
		add_submenu_page( 'marison-operations', 'Kontak Korporat', 'Kontak Korporat', 'manage_marison_settings', 'marison-corporate-contacts', [ self::class, 'render_page' ] );
	}

	public static function get( string $key ): string {
		return (string) get_option( $key, '' );
	}

	public static function sanitize_telephone( $value ): string {
		return Validation::sanitize_contact_number( $value );
	}

	public static function render_page(): void {
		if ( ! current_user_can( 'manage_marison_settings' ) ) {
			wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengelola kontak korporat.', 'marison-core' ) );
		}
		?>
		<div class="wrap">
			<h1>Kontak Korporat</h1>
			<p>Nilai ini adalah fallback eksplisit saja. Jangan mengisi nomor atau email fiktif.</p>
			<form method="post" action="options.php">
				<?php settings_fields( 'marison_core_corporate_contacts' ); do_settings_sections( 'marison-corporate-contacts' ); submit_button( 'Simpan Kontak' ); ?>
			</form>
		</div>
		<?php
	}

	public static function render_section(): void {
		echo '<p>Project tetap diarahkan ke Branch terlebih dahulu. Fallback ini hanya digunakan bila kontak Branch tidak tersedia.</p>';
	}

	public static function render_telephone(): void {
		printf( '<input class="regular-text" type="text" name="%s" value="%s" />', esc_attr( self::TELEPHONE ), esc_attr( self::get( self::TELEPHONE ) ) );
	}

	public static function render_email(): void {
		printf( '<input class="regular-text" type="email" name="%s" value="%s" />', esc_attr( self::EMAIL ), esc_attr( self::get( self::EMAIL ) ) );
	}
}
