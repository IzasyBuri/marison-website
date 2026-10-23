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
	}

	private static function all(): array {
		$capabilities = [ 'manage_marison_inventory' ];
		$types = [
			'marison_project' => 'marison_projects',
			'marison_house_type' => 'marison_house_types',
			'marison_branch' => 'marison_branches',
			'marison_marketing' => 'marison_marketing_records',
		];
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
		foreach ( $types as $singular => $plural ) {
			$capabilities[] = 'edit_' . $plural;
			$capabilities[] = 'read_' . $plural;
			$capabilities[] = 'delete_' . $plural;
			foreach ( $actions as $action ) {
				$capabilities[] = 'edit' === $action || 'read' === $action || 'delete' === $action
					? $action . '_' . $singular
					: $action . '_' . $plural;
			}
		}

		return array_unique( $capabilities );
	}
}
