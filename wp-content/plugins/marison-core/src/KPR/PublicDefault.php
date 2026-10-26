<?php
/**
 * KPR Public Default Scheme pointer and resolver.
 *
 * @package MarisonCore
 */

namespace Marison\Core\KPR;

defined( 'ABSPATH' ) || exit;

final class PublicDefault {
	private const OPTION = 'marison_kpr_public_default_id';

	public static function option_name(): string { return self::OPTION; }

	public static function get(): array {
		$scheme_id = absint( get_option( self::OPTION, 0 ) );
		if ( ! $scheme_id ) { return [ 'state' => 'NO_DEFAULT', 'scheme_id' => 0, 'scheme' => null ]; }
		$scheme = get_post( $scheme_id );
		if ( ! $scheme || 'marison_kpr_scheme' !== $scheme->post_type || 'trash' === $scheme->post_status ) {
			return [ 'state' => 'INVALID_DEFAULT', 'scheme_id' => $scheme_id, 'scheme' => null ];
		}
		if ( 'inactive' === get_post_meta( $scheme_id, '_marison_kpr_state', true ) ) {
			return [ 'state' => 'INACTIVE_DEFAULT', 'scheme_id' => $scheme_id, 'scheme' => $scheme ];
		}
		$eligible = self::eligible( $scheme_id );
		return is_wp_error( $eligible ) ? [ 'state' => 'INVALID_DEFAULT', 'scheme_id' => $scheme_id, 'scheme' => $scheme, 'error' => $eligible->get_error_message() ] : [ 'state' => 'AVAILABLE', 'scheme_id' => $scheme_id, 'scheme' => $scheme ];
	}

	public static function eligible( int $scheme_id ) {
		$scheme = get_post( $scheme_id );
		if ( ! $scheme || 'marison_kpr_scheme' !== $scheme->post_type || 'trash' === $scheme->post_status ) { return new \WP_Error( 'marison_kpr_scheme_invalid', 'KPR Scheme tidak valid.' ); }
		if ( 'publish' !== $scheme->post_status ) { return new \WP_Error( 'marison_kpr_scheme_unpublished', 'KPR Scheme harus berstatus Published.' ); }
		if ( 'active' !== get_post_meta( $scheme_id, '_marison_kpr_state', true ) ) { return new \WP_Error( 'marison_kpr_scheme_inactive', 'KPR Scheme harus Aktif.' ); }
		return SchemeRules::validate_scheme( $scheme_id );
	}

	public static function set( int $scheme_id ) {
		$eligible = self::eligible( $scheme_id );
		if ( is_wp_error( $eligible ) ) { return $eligible; }
		update_option( self::OPTION, absint( $scheme_id ), false );
		return true;
	}

	public static function clear(): bool { return delete_option( self::OPTION ); }

	public static function handle_state_change( $meta_id, int $post_id, string $meta_key, $meta_value ): void {
		if ( '_marison_kpr_state' === $meta_key && absint( get_option( self::OPTION, 0 ) ) === $post_id && 'active' !== $meta_value ) { self::clear(); }
	}

	public static function handle_delete( int $post_id, \WP_Post $post ): void {
		if ( 'marison_kpr_scheme' === $post->post_type && absint( get_option( self::OPTION, 0 ) ) === $post_id ) { self::clear(); }
	}
}
