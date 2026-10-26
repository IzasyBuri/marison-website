<?php
/**
 * Capability provisioning for the initial managed content model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Support;

defined( 'ABSPATH' ) || exit;

final class Capabilities {
	public static function ensure_admin_capabilities( bool $force = false ): void {
		if ( ! $force && ! is_admin() && ! wp_doing_cron() ) {
			return;
		}

		$administrator = get_role( 'administrator' );
		if ( ! $administrator ) {
			return;
		}

		foreach ( self::all() as $capability ) {
			$administrator->add_cap( $capability );
		}

		$editor = get_role( 'editor' );
		if ( $editor ) {
			foreach ( self::career() as $capability ) {
				$editor->add_cap( $capability );
			}
		}
	}

	private static function career(): array {
		return self::type_capabilities( 'marison_career', 'marison_careers' );
	}

	private static function all(): array {
		$capabilities = [ 'manage_marison_inventory', 'manage_marison_leads', 'manage_marison_settings', 'manage_marison_kpr' ];
		$types = [
			'marison_project' => 'marison_projects',
			'marison_career' => 'marison_careers',
			'marison_house_type' => 'marison_house_types',
			'marison_branch' => 'marison_branches',
			'marison_marketing' => 'marison_marketing_records',
			'marison_kpr_scheme' => 'marison_kpr_schemes',
		];
		foreach ( $types as $singular => $plural ) {
			$capabilities = array_merge( $capabilities, self::type_capabilities( $singular, $plural ) );
		}

		return array_unique( $capabilities );
	}

	private static function type_capabilities( string $singular, string $plural ): array {
		$capabilities = [ 'edit_' . $plural, 'read_' . $plural, 'delete_' . $plural ];
		$actions = [
			'edit',
			'read',
			'delete',
			'edit_others',
			'publish',
			'read_private',
			'delete_private',
			'delete_published',
			'delete_others',
			'edit_private',
			'edit_published',
		];
		foreach ( $actions as $action ) {
			$capabilities[] = 'edit' === $action || 'read' === $action || 'delete' === $action
				? $action . '_' . $singular
				: $action . '_' . $plural;
		}

		return array_unique( $capabilities );
	}
}
