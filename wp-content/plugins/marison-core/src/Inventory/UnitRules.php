<?php
/**
 * Unit inventory value and relationship rules.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Inventory;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Meta;

final class UnitRules {
	public static function statuses(): array {
		return [ 'available', 'booked', 'sold' ];
	}

	public static function sanitize_identifier( $value ): string {
		$value = trim( sanitize_text_field( (string) $value ) );
		return function_exists( 'mb_substr' ) ? mb_substr( $value, 0, 191 ) : substr( $value, 0, 191 );
	}

	public static function validate_identifier( $value ) {
		$identifier = self::sanitize_identifier( $value );
		return '' !== $identifier
			? $identifier
			: new \WP_Error( 'marison_unit_identifier_required', 'Unit identifier wajib diisi.' );
	}

	public static function validate_status( $value ) {
		$status = sanitize_key( (string) $value );
		return in_array( $status, self::statuses(), true )
			? $status
			: new \WP_Error( 'marison_unit_status_invalid', 'Status Unit tidak valid.' );
	}

	public static function validate_relationships( int $project_id, int $house_type_id = 0 ) {
		$project = get_post( $project_id );
		if ( ! $project || 'marison_project' !== $project->post_type || 'trash' === $project->post_status ) {
			return new \WP_Error( 'marison_unit_project_invalid', 'Project Unit tidak valid.' );
		}

		if ( ! $house_type_id ) {
			return true;
		}

		$house_type = get_post( $house_type_id );
		$owner_id   = (int) get_post_meta( $house_type_id, Meta::HOUSE_TYPE_PROJECT, true );
		if ( ! $house_type || 'marison_house_type' !== $house_type->post_type || 'trash' === $house_type->post_status ) {
			return new \WP_Error( 'marison_unit_house_type_invalid', 'House Type Unit tidak valid.' );
		}
		if ( $owner_id !== $project_id ) {
			return new \WP_Error( 'marison_unit_house_type_mismatch', 'House Type harus berasal dari Project yang sama.' );
		}

		return true;
	}
}
