<?php
/**
 * Unit inventory data access.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Inventory;

defined( 'ABSPATH' ) || exit;

final class UnitRepository {
	public static function get( int $id ): ?array {
		global $wpdb;

		$id   = absint( $id );
		$row  = $wpdb->get_row( $wpdb->prepare( 'SELECT id, project_id, house_type_id, unit_identifier, status, created_at, updated_at FROM ' . Schema::table_name() . ' WHERE id = %d LIMIT 1', $id ), ARRAY_A );
		return $row ?: null;
	}

	public static function list( array $filters, int $page = 1, int $per_page = 25 ): array {
		$page     = max( 1, $page );
		$per_page = min( 100, max( 1, $per_page ) );
		$offset   = ( $page - 1 ) * $per_page;
		$where    = self::where( $filters );
		global $wpdb;

		$sql = 'SELECT u.id, u.project_id, u.house_type_id, u.unit_identifier, u.status, u.created_at, u.updated_at, project_post.post_title AS project_title, house_type_post.post_title AS house_type_title FROM ' . Schema::table_name() . ' u LEFT JOIN ' . $wpdb->posts . ' project_post ON project_post.ID = u.project_id LEFT JOIN ' . $wpdb->posts . ' house_type_post ON house_type_post.ID = u.house_type_id ' . $where['sql'] . ' ORDER BY u.updated_at DESC, u.id DESC LIMIT %d OFFSET %d';
		$args = array_merge( $where['args'], [ $per_page, $offset ] );
		return $wpdb->get_results( $wpdb->prepare( $sql, $args ), ARRAY_A );
	}

	public static function count( array $filters = [] ): int {
		global $wpdb;

		$where = self::where( $filters );
		$sql   = 'SELECT COUNT(*) FROM ' . Schema::table_name() . ' u ' . $where['sql'];
		return (int) $wpdb->get_var( $where['args'] ? $wpdb->prepare( $sql, $where['args'] ) : $sql );
	}

	public static function create( array $data ) {
		global $wpdb;

		$validated = self::validated_data( $data );
		if ( is_wp_error( $validated ) ) {
			return $validated;
		}
		if ( self::identifier_exists( $validated['project_id'], $validated['unit_identifier'] ) ) {
			return new \WP_Error( 'marison_unit_duplicate_identifier', 'Unit identifier sudah digunakan pada Project ini.' );
		}

		$now    = gmdate( 'Y-m-d H:i:s' );
		$insert = $wpdb->insert(
			Schema::table_name(),
			[
				'project_id' => $validated['project_id'],
				'house_type_id' => $validated['house_type_id'] ?: null,
				'unit_identifier' => $validated['unit_identifier'],
				'status' => $validated['status'],
				'created_at' => $now,
				'updated_at' => $now,
			],
			[ '%d', '%d', '%s', '%s', '%s', '%s' ]
		);
		if ( false === $insert ) {
			return new \WP_Error( 'marison_unit_create_failed', 'Unit tidak dapat disimpan.' );
		}

		return (int) $wpdb->insert_id;
	}

	public static function update( int $id, array $data ) {
		$existing = self::get( $id );
		if ( ! $existing ) {
			return new \WP_Error( 'marison_unit_not_found', 'Unit tidak ditemukan.' );
		}

		$validated = self::validated_data( array_merge( $existing, $data ) );
		if ( is_wp_error( $validated ) ) {
			return $validated;
		}
		if ( self::identifier_exists( $validated['project_id'], $validated['unit_identifier'], $id ) ) {
			return new \WP_Error( 'marison_unit_duplicate_identifier', 'Unit identifier sudah digunakan pada Project ini.' );
		}

		global $wpdb;
		$updated = $wpdb->update(
			Schema::table_name(),
			[
				'project_id' => $validated['project_id'],
				'house_type_id' => $validated['house_type_id'] ?: null,
				'unit_identifier' => $validated['unit_identifier'],
				'status' => $validated['status'],
				'updated_at' => gmdate( 'Y-m-d H:i:s' ),
			],
			[ 'id' => absint( $id ) ],
			[ '%d', '%d', '%s', '%s', '%s' ],
			[ '%d' ]
		);
		return false === $updated ? new \WP_Error( 'marison_unit_update_failed', 'Unit tidak dapat diperbarui.' ) : true;
	}

	public static function delete( int $id ) {
		if ( ! self::get( $id ) ) {
			return new \WP_Error( 'marison_unit_not_found', 'Unit tidak ditemukan.' );
		}

		global $wpdb;
		return false === $wpdb->delete( Schema::table_name(), [ 'id' => absint( $id ) ], [ '%d' ] )
			? new \WP_Error( 'marison_unit_delete_failed', 'Unit tidak dapat dihapus.' )
			: true;
	}

	public static function bulk_update_status( array $ids, $status ) {
		$status = UnitRules::validate_status( $status );
		if ( is_wp_error( $status ) ) {
			return $status;
		}
		$ids = array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
		if ( ! $ids || count( $ids ) > 100 ) {
			return new \WP_Error( 'marison_unit_bulk_limit', 'Pilih antara 1 sampai 100 Unit.' );
		}

		global $wpdb;
		$placeholders = implode( ', ', array_fill( 0, count( $ids ), '%d' ) );
		$existing     = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . Schema::table_name() . ' WHERE id IN (' . $placeholders . ')', $ids ) );
		if ( $existing !== count( $ids ) ) {
			return new \WP_Error( 'marison_unit_bulk_not_found', 'Satu atau lebih Unit yang dipilih tidak ditemukan.' );
		}

		$sql          = 'UPDATE ' . Schema::table_name() . ' SET status = %s, updated_at = %s WHERE id IN (' . $placeholders . ')';
		$args         = array_merge( [ $status, gmdate( 'Y-m-d H:i:s' ) ], $ids );
		$result       = $wpdb->query( $wpdb->prepare( $sql, $args ) );
		return false === $result ? new \WP_Error( 'marison_unit_bulk_failed', 'Status Unit tidak dapat diperbarui.' ) : (int) $result;
	}

	public static function count_by_status( int $project_id ): array {
		global $wpdb;

		$rows = $wpdb->get_results( $wpdb->prepare( 'SELECT status, COUNT(*) AS total FROM ' . Schema::table_name() . ' WHERE project_id = %d GROUP BY status', absint( $project_id ) ), ARRAY_A );
		$counts = array_fill_keys( UnitRules::statuses(), 0 );
		foreach ( $rows as $row ) {
			if ( isset( $counts[ $row['status'] ] ) ) {
				$counts[ $row['status'] ] = (int) $row['total'];
			}
		}
		return $counts;
	}

	public static function count_by_project( int $project_id ): int {
		return self::count( [ 'project_id' => absint( $project_id ) ] );
	}

	public static function count_by_house_type( int $house_type_id ): int {
		return self::count( [ 'house_type_id' => absint( $house_type_id ) ] );
	}

	public static function identifier_exists( int $project_id, string $identifier, int $exclude_id = 0 ): bool {
		global $wpdb;

		$sql  = 'SELECT id FROM ' . Schema::table_name() . ' WHERE project_id = %d AND unit_identifier = %s';
		$args = [ absint( $project_id ), $identifier ];
		if ( $exclude_id ) {
			$sql   .= ' AND id != %d';
			$args[] = absint( $exclude_id );
		}
		return (bool) $wpdb->get_var( $wpdb->prepare( $sql . ' LIMIT 1', $args ) );
	}

	private static function validated_data( array $data ) {
		$project_id    = absint( $data['project_id'] ?? 0 );
		$house_type_id = absint( $data['house_type_id'] ?? 0 );
		$identifier    = UnitRules::validate_identifier( $data['unit_identifier'] ?? '' );
		$status        = UnitRules::validate_status( $data['status'] ?? '' );
		$relationship  = UnitRules::validate_relationships( $project_id, $house_type_id );
		foreach ( [ $identifier, $status, $relationship ] as $result ) {
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}

		return [
			'project_id' => $project_id,
			'house_type_id' => $house_type_id,
			'unit_identifier' => $identifier,
			'status' => $status,
		];
	}

	private static function where( array $filters ): array {
		global $wpdb;

		$where = [ '1=1' ];
		$args  = [];
		if ( ! empty( $filters['project_id'] ) ) {
			$where[] = 'u.project_id = %d';
			$args[]  = absint( $filters['project_id'] );
		}
		if ( ! empty( $filters['house_type_id'] ) ) {
			$where[] = 'u.house_type_id = %d';
			$args[]  = absint( $filters['house_type_id'] );
		}
		if ( ! empty( $filters['status'] ) && in_array( $filters['status'], UnitRules::statuses(), true ) ) {
			$where[] = 'u.status = %s';
			$args[]  = $filters['status'];
		}
		if ( '' !== (string) ( $filters['search'] ?? '' ) ) {
			$where[] = 'u.unit_identifier LIKE %s';
			$args[]  = '%' . $wpdb->esc_like( sanitize_text_field( $filters['search'] ) ) . '%';
		}

		return [ 'sql' => 'WHERE ' . implode( ' AND ', $where ), 'args' => $args ];
	}
}
