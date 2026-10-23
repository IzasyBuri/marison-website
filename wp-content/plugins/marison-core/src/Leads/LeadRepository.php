<?php
/**
 * Private Lead data access.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Leads;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Inventory\Schema;

final class LeadRepository {
	public static function create( array $data ) {
		$validated = isset( $data['consent_at'], $data['consent_version'] ) ? $data : LeadRules::validate_submission( $data );
		if ( is_wp_error( $validated ) ) {
			return $validated;
		}

		global $wpdb;
		$now = gmdate( 'Y-m-d H:i:s' );
		$inserted = $wpdb->insert(
			Schema::lead_table_name(),
			[
				'name' => $validated['name'],
				'contact' => $validated['contact'],
				'inquiry_type' => $validated['inquiry_type'],
				'project_id' => $validated['project_id'],
				'message' => $validated['message'],
				'consent_at' => $validated['consent_at'],
				'consent_version' => $validated['consent_version'],
				'created_at' => $now,
				'updated_at' => $now,
			],
			[ '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s' ]
		);
		return false === $inserted ? new \WP_Error( 'marison_lead_create_failed', 'Lead tidak dapat disimpan.' ) : (int) $wpdb->insert_id;
	}

	public static function get( int $id ): ?array {
		global $wpdb;

		$row = $wpdb->get_row( $wpdb->prepare( 'SELECT id, name, contact, inquiry_type, project_id, message, consent_at, consent_version, created_at, updated_at FROM ' . Schema::lead_table_name() . ' WHERE id = %d LIMIT 1', absint( $id ) ), ARRAY_A );
		return $row ?: null;
	}

	public static function list( array $filters = [], int $page = 1, int $per_page = 25 ): array {
		$page = max( 1, $page );
		$per_page = min( 100, max( 1, $per_page ) );
		$where = self::where( $filters );
		global $wpdb;
		$sql = 'SELECT l.id, l.name, l.contact, l.inquiry_type, l.project_id, l.created_at, project_post.post_title AS project_title FROM ' . Schema::lead_table_name() . ' l LEFT JOIN ' . $wpdb->posts . ' project_post ON project_post.ID = l.project_id ' . $where['sql'] . ' ORDER BY l.created_at DESC, l.id DESC LIMIT %d OFFSET %d';
		return $wpdb->get_results( $wpdb->prepare( $sql, array_merge( $where['args'], [ $per_page, ( $page - 1 ) * $per_page ] ) ), ARRAY_A );
	}

	public static function count( array $filters = [] ): int {
		global $wpdb;
		$where = self::where( $filters );
		$sql = 'SELECT COUNT(*) FROM ' . Schema::lead_table_name() . ' l ' . $where['sql'];
		return (int) $wpdb->get_var( $where['args'] ? $wpdb->prepare( $sql, $where['args'] ) : $sql );
	}

	public static function delete( int $id ) {
		global $wpdb;

		if ( ! self::get( $id ) ) {
			return new \WP_Error( 'marison_lead_not_found', 'Lead tidak ditemukan.' );
		}
		return false === $wpdb->delete( Schema::lead_table_name(), [ 'id' => absint( $id ) ], [ '%d' ] )
			? new \WP_Error( 'marison_lead_delete_failed', 'Lead tidak dapat dihapus.' )
			: true;
	}

	public static function delete_by_contact( string $contact ): int {
		global $wpdb;

		return (int) $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . Schema::lead_table_name() . ' WHERE contact = %s', $contact ) );
	}

	public static function find_by_contact( string $contact ): array {
		global $wpdb;

		return $wpdb->get_results( $wpdb->prepare( 'SELECT id, name, contact, created_at FROM ' . Schema::lead_table_name() . ' WHERE contact = %s ORDER BY id ASC', $contact ), ARRAY_A );
	}

	public static function find_created_before( string $utc_datetime, int $limit = 100 ): array {
		global $wpdb;

		return $wpdb->get_results( $wpdb->prepare( 'SELECT id FROM ' . Schema::lead_table_name() . ' WHERE created_at < %s ORDER BY created_at ASC, id ASC LIMIT %d', $utc_datetime, min( 100, max( 1, $limit ) ) ), ARRAY_A );
	}

	private static function where( array $filters ): array {
		global $wpdb;
		$clauses = [ '1=1' ];
		$args = [];
		if ( ! empty( $filters['project_id'] ) ) { $clauses[] = 'l.project_id = %d'; $args[] = absint( $filters['project_id'] ); }
		if ( ! empty( $filters['inquiry_type'] ) && in_array( $filters['inquiry_type'], LeadRules::INQUIRY_TYPES, true ) ) { $clauses[] = 'l.inquiry_type = %s'; $args[] = $filters['inquiry_type']; }
		if ( '' !== (string) ( $filters['search'] ?? '' ) ) { $clauses[] = '(l.name LIKE %s OR l.contact LIKE %s)'; $search = '%' . $wpdb->esc_like( sanitize_text_field( $filters['search'] ) ) . '%'; $args[] = $search; $args[] = $search; }
		return [ 'sql' => 'WHERE ' . implode( ' AND ', $clauses ), 'args' => $args ];
	}
}
