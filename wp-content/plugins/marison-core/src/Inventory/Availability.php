<?php
/**
 * Project availability source service.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Inventory;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class Availability {
	public static function get_for_project( int $project_id ): array {
		$unavailable = [
			'mode' => 'unavailable',
			'available' => null,
			'booked' => null,
			'sold' => null,
			'total' => null,
			'source' => 'none',
			'state' => 'unavailable_project',
		];
		$project = get_post( absint( $project_id ) );
		if ( ! $project || 'marison_project' !== $project->post_type || 'publish' !== $project->post_status ) {
			return $unavailable;
		}

		$mode = sanitize_key( (string) get_post_meta( $project_id, Meta::PROJECT_AVAILABILITY_MODE, true ) );
		if ( ! in_array( $mode, Validation::AVAILABILITY_MODES, true ) ) {
			$unavailable['state'] = 'mode_not_configured';
			return $unavailable;
		}

		if ( 'manual' === $mode ) {
			$counts = self::manual_counts( $project_id );
			if ( null === $counts ) {
				return [
					'mode' => 'manual',
					'available' => null,
					'booked' => null,
					'sold' => null,
					'total' => null,
					'source' => 'manual',
					'state' => 'manual_incomplete',
				];
			}

			return self::result( 'manual', $counts, 'manual', 'active' );
		}

		return self::result( 'units', UnitRepository::count_by_status( $project_id ), 'units', 'active' );
	}

	private static function manual_counts( int $project_id ): ?array {
		$counts = [];
		foreach ( [ 'available', 'booked', 'sold' ] as $status ) {
			$value = get_post_meta( $project_id, Meta::manual_key( $status ), true );
			if ( '' === (string) $value || ! preg_match( '/^\d+$/', (string) $value ) ) {
				return null;
			}
			$counts[ $status ] = (int) $value;
		}

		return $counts;
	}

	private static function result( string $mode, array $counts, string $source, string $state ): array {
		return [
			'mode' => $mode,
			'available' => (int) ( $counts['available'] ?? 0 ),
			'booked' => (int) ( $counts['booked'] ?? 0 ),
			'sold' => (int) ( $counts['sold'] ?? 0 ),
			'total' => (int) ( $counts['available'] ?? 0 ) + (int) ( $counts['booked'] ?? 0 ) + (int) ( $counts['sold'] ?? 0 ),
			'source' => $source,
			'state' => $state,
		];
	}
}
