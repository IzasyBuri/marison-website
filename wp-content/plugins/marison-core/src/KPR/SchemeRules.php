<?php
/**
 * KPR Scheme validation and normalization.
 *
 * @package MarisonCore
 */

namespace Marison\Core\KPR;

defined( 'ABSPATH' ) || exit;

final class SchemeRules {
	public const STATES = [ 'active', 'inactive' ];

	public static function states(): array { return self::STATES; }

	public static function sanitize_state( $value ): string {
		$value = sanitize_key( (string) $value );
		return in_array( $value, self::STATES, true ) ? $value : '';
	}

	public static function sanitize_rate( $value ) {
		$value = trim( str_replace( ',', '.', (string) $value ) );
		if ( '' === $value || ! is_numeric( $value ) || (float) $value < 0 || (float) $value > 100 ) {
			return new \WP_Error( 'marison_kpr_rate_invalid', 'Bunga tahunan harus berupa angka antara 0 dan 100 persen.' );
		}
		return number_format( (float) $value, 2, '.', '' );
	}

	public static function sanitize_tenures( $value ) {
		$values = is_array( $value ) ? $value : [ $value ];
		$months = [];
		foreach ( $values as $item ) {
			$item = trim( (string) $item );
			if ( '' === $item ) { continue; }
			if ( ! preg_match( '/^\d+$/', $item ) || (int) $item <= 0 ) {
				return new \WP_Error( 'marison_kpr_tenure_invalid', 'Tenure harus berupa bulan positif.' );
			}
			$months[] = (int) $item;
		}
		$months = array_values( array_unique( $months ) );
		sort( $months, SORT_NUMERIC );
		return $months;
	}

	public static function sanitize_default_dp( $value ) {
		$value = trim( str_replace( ',', '.', (string) $value ) );
		if ( '' === $value || ! is_numeric( $value ) || (float) $value < 0 || (float) $value > 100 ) {
			return new \WP_Error( 'marison_kpr_dp_invalid', 'Default DP harus berupa angka antara 0 dan 100 persen.' );
		}
		return number_format( (float) $value, 2, '.', '' );
	}

	public static function sanitize_effective_date( $value ): string {
		$value = sanitize_text_field( (string) $value );
		$date  = \DateTimeImmutable::createFromFormat( '!Y-m-d', $value, new \DateTimeZone( 'UTC' ) );
		return $date && $date->format( 'Y-m-d' ) === $value ? $value : '';
	}

	public static function sanitize_disclaimer( $value ): string {
		$value = sanitize_textarea_field( (string) $value );
		return function_exists( 'mb_substr' ) ? mb_substr( $value, 0, 2000 ) : substr( $value, 0, 2000 );
	}

	public static function validate_scheme( int $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post || 'marison_kpr_scheme' !== $post->post_type || 'trash' === $post->post_status ) {
			return new \WP_Error( 'marison_kpr_scheme_invalid', 'KPR Scheme tidak valid.' );
		}
		$state = self::sanitize_state( get_post_meta( $post_id, '_marison_kpr_state', true ) );
		$rate = self::sanitize_rate( get_post_meta( $post_id, '_marison_kpr_annual_rate', true ) );
		$tenures = self::sanitize_tenures( get_post_meta( $post_id, '_marison_kpr_tenure_months', true ) );
		$dp = self::sanitize_default_dp( get_post_meta( $post_id, '_marison_kpr_default_dp_percent', true ) );
		if ( '' === $state || is_wp_error( $rate ) || is_wp_error( $tenures ) || ! $tenures || is_wp_error( $dp ) ) {
			return new \WP_Error( 'marison_kpr_scheme_incomplete', 'KPR Scheme belum memiliki konfigurasi lengkap.' );
		}
		return true;
	}
}
