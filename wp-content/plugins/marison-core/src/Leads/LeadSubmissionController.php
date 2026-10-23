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
		if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
			wp_die( esc_html__( 'Metode request tidak valid.', 'marison-core' ) );
		}
		$nonce = sanitize_text_field( wp_unslash( $_POST['marison_lead_nonce'] ?? '' ) );
		if ( ! wp_verify_nonce( $nonce, 'marison_submit_lead' ) ) {
			wp_die( esc_html__( 'Security check gagal.', 'marison-core' ) );
		}

		$result = LeadSubmission::submit( wp_unslash( $_POST ), $_SERVER );
		$redirect = wp_get_referer() ?: home_url( '/' );
		$redirect = add_query_arg( 'marison_lead_result', rawurlencode( $result['code'] ), $redirect );
		wp_safe_redirect( $redirect );
		exit;
	}
}
