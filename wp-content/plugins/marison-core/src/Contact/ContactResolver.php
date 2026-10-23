<?php
/**
 * Project and corporate contact resolution.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Contact;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Settings\CorporateSettings;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class ContactResolver {
	public static function for_project( int $project_id ): array {
		$project = get_post( absint( $project_id ) );
		if ( ! $project || 'marison_project' !== $project->post_type || 'publish' !== $project->post_status ) {
			return self::unavailable( 'invalid_project' );
		}

		$branch_id = (int) get_post_meta( $project_id, Meta::PROJECT_PRIMARY_BRANCH, true );
		$branch   = get_post( $branch_id );
		if ( $branch && 'marison_branch' === $branch->post_type && 'publish' === $branch->post_status ) {
			$whatsapp = WhatsApp::build( (string) get_post_meta( $branch_id, Meta::BRANCH_WHATSAPP, true ), $project->post_title );
			if ( ! is_wp_error( $whatsapp ) ) {
				return array_merge( $whatsapp, [ 'project_id' => $project_id, 'branch_id' => $branch_id, 'state' => 'active' ] );
			}

			$telephone = self::telephone( get_post_meta( $branch_id, Meta::BRANCH_TELEPHONE, true ) );
			if ( $telephone ) {
				return array_merge( $telephone, [ 'project_id' => $project_id, 'branch_id' => $branch_id, 'state' => 'active' ] );
			}
		}

		return array_merge( self::corporate_fallback(), [ 'project_id' => $project_id, 'branch_id' => $branch_id ?: null ] );
	}

	public static function for_general(): array {
		return self::corporate_fallback();
	}

	private static function corporate_fallback(): array {
		$telephone = self::telephone( CorporateSettings::get( CorporateSettings::TELEPHONE ) );
		if ( $telephone ) {
			return array_merge( $telephone, [ 'channel' => 'corporate_fallback', 'source' => 'corporate_settings', 'state' => 'fallback' ] );
		}

		$email = sanitize_email( CorporateSettings::get( CorporateSettings::EMAIL ) );
		if ( $email ) {
			return [ 'channel' => 'corporate_fallback', 'kind' => 'email', 'value' => $email, 'url' => 'mailto:' . rawurlencode( $email ), 'source' => 'corporate_settings', 'state' => 'fallback' ];
		}

		return self::unavailable( 'contact_unavailable' );
	}

	private static function telephone( $value ): ?array {
		$value = Validation::sanitize_contact_number( $value );
		if ( ! Validation::is_valid_contact_number( $value ) ) {
			return null;
		}
		return [ 'channel' => 'telephone', 'kind' => 'telephone', 'value' => $value, 'url' => 'tel:' . preg_replace( '/[^\d+]/', '', $value ) ];
	}

	private static function unavailable( string $state ): array {
		return [ 'channel' => 'unavailable', 'value' => '', 'url' => '', 'source' => 'none', 'state' => $state ];
	}
}
