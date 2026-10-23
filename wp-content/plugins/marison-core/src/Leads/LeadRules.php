<?php
/**
 * Lead submission validation.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Leads;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Validation;

final class LeadRules {
	public const INQUIRY_TYPES = [ 'project', 'general' ];
	public const CONSENT_VERSION = 'v1';

	public static function validate_submission( array $input ) {
		$name = trim( sanitize_text_field( (string) ( $input['name'] ?? '' ) ) );
		if ( '' === $name || self::length( $name ) > 191 ) {
			return new \WP_Error( 'marison_lead_name_invalid', 'Nama wajib diisi dengan panjang yang wajar.' );
		}

		$contact = Validation::sanitize_contact_number( $input['contact'] ?? '' );
		if ( ! Validation::is_valid_contact_number( $contact ) ) {
			return new \WP_Error( 'marison_lead_contact_invalid', 'Nomor WhatsApp/telepon tidak valid.' );
		}

		$inquiry_type = sanitize_key( (string) ( $input['inquiry_type'] ?? 'project' ) );
		if ( ! in_array( $inquiry_type, self::INQUIRY_TYPES, true ) ) {
			return new \WP_Error( 'marison_lead_type_invalid', 'Jenis inquiry tidak valid.' );
		}

		$project_id = absint( $input['project_id'] ?? 0 );
		if ( 'project' === $inquiry_type && ! Validation::is_valid_post( $project_id, 'marison_project', true ) ) {
			return new \WP_Error( 'marison_lead_project_invalid', 'Project inquiry harus memiliki Project yang valid.' );
		}
		if ( 'general' === $inquiry_type ) {
			$project_id = 0;
		}

		$consent = $input['consent'] ?? false;
		if ( ! in_array( $consent, [ true, 1, '1', 'yes', 'on' ], true ) ) {
			return new \WP_Error( 'marison_lead_consent_required', 'Consent pemrosesan data wajib diberikan.' );
		}

		$message = sanitize_textarea_field( (string) ( $input['message'] ?? '' ) );
		if ( self::length( $message ) > 2000 ) {
			return new \WP_Error( 'marison_lead_message_too_long', 'Pesan terlalu panjang.' );
		}

		return [
			'name' => $name,
			'contact' => $contact,
			'inquiry_type' => $inquiry_type,
			'project_id' => $project_id ?: null,
			'message' => '' === $message ? null : $message,
			'consent_at' => gmdate( 'Y-m-d H:i:s' ),
			'consent_version' => self::CONSENT_VERSION,
		];
	}

	private static function length( string $value ): int {
		return function_exists( 'mb_strlen' ) ? mb_strlen( $value ) : strlen( $value );
	}
}
