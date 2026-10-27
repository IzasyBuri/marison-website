<?php
/**
 * Consent-aware Lead submission service.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Leads;

defined( 'ABSPATH' ) || exit;

final class LeadSubmission {
	public static function submit_general( array $input, array $server = [] ): array {
		$input['inquiry_type'] = 'general';
		$input['project_id']    = null;

		return self::submit( $input, $server );
	}

	public static function submit( array $input, array $server = [] ): array {
		$validated = LeadRules::validate_submission( $input );
		if ( is_wp_error( $validated ) ) {
			return self::failure( $validated );
		}

		$abuse = AbuseProtection::check( $input, $server );
		if ( is_wp_error( $abuse ) ) {
			return self::failure( $abuse );
		}

		$lead_id = LeadRepository::create( $validated );
		if ( is_wp_error( $lead_id ) ) {
			return self::failure( new \WP_Error( 'marison_lead_storage_failed', 'Lead tidak dapat diproses saat ini.' ) );
		}

		AbuseProtection::record( $server );
		return [ 'success' => true, 'code' => 'success', 'lead_id' => $lead_id ];
	}

	private static function failure( \WP_Error $error ): array {
		return [ 'success' => false, 'code' => $error->get_error_code(), 'message' => $error->get_error_message() ];
	}
}
