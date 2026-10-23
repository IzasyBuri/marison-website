<?php
/**
 * Lightweight Lead abuse controls.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Leads;

defined( 'ABSPATH' ) || exit;

final class AbuseProtection {
	private const LIMIT = 5;
	private const WINDOW = 600;

	public static function check( array $input, array $server = [] ) {
		if ( '' !== trim( sanitize_text_field( (string) ( $input['website'] ?? '' ) ) ) ) {
			return new \WP_Error( 'marison_lead_honeypot', 'Submission tidak dapat diproses.' );
		}

		if ( isset( $input['started_at'] ) && is_numeric( $input['started_at'] ) && time() - (int) $input['started_at'] < 2 ) {
			return new \WP_Error( 'marison_lead_too_fast', 'Submission tidak dapat diproses.' );
		}

		$count = (int) get_transient( self::key( $server ) );
		return $count >= self::LIMIT ? new \WP_Error( 'marison_lead_rate_limited', 'Terlalu banyak submission. Coba lagi nanti.' ) : true;
	}

	public static function record( array $server = [] ): void {
		$key = self::key( $server );
		$count = (int) get_transient( $key );
		set_transient( $key, $count + 1, self::WINDOW );
	}

	private static function key( array $server ): string {
		$fingerprint = (string) ( $server['REMOTE_ADDR'] ?? 'unknown' ) . '|' . (string) ( $server['HTTP_USER_AGENT'] ?? '' );
		return 'marison_lead_rate_' . hash_hmac( 'sha256', $fingerprint, wp_salt( 'auth' ) );
	}
}
