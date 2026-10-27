<?php
/**
 * Internal POST boundary for future Lead forms.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Leads;

defined( 'ABSPATH' ) || exit;

final class LeadSubmissionController {
	public static function handle(): void {
		self::process( false );
	}

	public static function handle_general(): void {
		self::process( true );
	}

	private static function process( bool $general ): void {
		if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
			wp_die( esc_html__( 'Metode request tidak valid.', 'marison-core' ) );
		}
		$raw_nonce = $_POST['marison_lead_nonce'] ?? '';
		$nonce     = is_scalar( $raw_nonce ) ? sanitize_text_field( wp_unslash( $raw_nonce ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'marison_submit_lead' ) ) {
			if ( $general ) {
				$redirect = add_query_arg( 'marison_lead_result', 'error', self::general_redirect( self::requested_contact_language() ) );
				wp_safe_redirect( $redirect );
				exit;
			}
			wp_die( esc_html__( 'Security check gagal.', 'marison-core' ) );
		}

		$input = $general ? self::general_input() : wp_unslash( $_POST );
		$result = $general ? LeadSubmission::submit_general( $input, $_SERVER ) : LeadSubmission::submit( $input, $_SERVER );
		$code = $general ? ( $result['success'] ? 'success' : 'error' ) : $result['code'];
		$redirect = $general ? self::general_redirect( self::requested_contact_language() ) : ( wp_get_referer() ?: home_url( '/' ) );
		$redirect = add_query_arg( 'marison_lead_result', $code, $redirect );
		wp_safe_redirect( $redirect );
		exit;
	}

	private static function general_input(): array {
		$input = [];
		foreach ( [ 'name', 'contact', 'message', 'website' ] as $key ) {
			$value          = $_POST[ $key ] ?? '';
			$input[ $key ] = is_scalar( $value ) ? wp_unslash( $value ) : '';
		}
		$consent         = $_POST['consent'] ?? false;
		$input['consent'] = is_scalar( $consent ) ? wp_unslash( $consent ) : false;

		return $input;
	}

	private static function requested_contact_language(): string {
		$value = $_POST['marison_contact_language'] ?? '';
		return is_scalar( $value ) ? sanitize_key( wp_unslash( $value ) ) : '';
	}

	private static function general_redirect( string $requested_language = '' ): string {
		$fallback = home_url( '/kontak/' );
		$allowed  = [ $fallback ];
		$page     = get_page_by_path( 'kontak', OBJECT, 'page' );
		$page_ids = $page ? [ $page->ID ] : [];
		$translations = [];

		if ( function_exists( 'pll_get_post_translations' ) && $page ) {
			$translations = (array) pll_get_post_translations( $page->ID );
			$page_ids     = array_merge( $page_ids, array_values( array_map( 'absint', $translations ) ) );
		}
		foreach ( array_unique( array_filter( $page_ids ) ) as $page_id ) {
			$url = get_permalink( $page_id );
			if ( $url ) {
				$allowed[] = $url;
			}
		}
		if ( $page && $requested_language && isset( $translations[ $requested_language ] ) ) {
			$localized = get_permalink( absint( $translations[ $requested_language ] ) );
			if ( $localized ) {
				$fallback = $localized;
			}
		}

		$referer = wp_get_referer();
		if ( ! $referer || ! wp_validate_redirect( $referer, '' ) ) {
			return $fallback;
		}

		$referer = remove_query_arg( 'marison_lead_result', $referer );
		foreach ( array_unique( $allowed ) as $url ) {
			if ( untrailingslashit( $referer ) === untrailingslashit( $url ) ) {
				return $url;
			}
		}

		return $fallback;
	}
}
