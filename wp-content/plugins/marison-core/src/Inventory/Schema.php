<?php
/**
 * Unit inventory schema lifecycle.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Inventory;

defined( 'ABSPATH' ) || exit;

final class Schema {
	private const VERSION_OPTION = 'marison_core_schema_version';
	private const CURRENT_VERSION = 2;

	public static function table_name(): string {
		global $wpdb;

		return $wpdb->prefix . 'marison_units';
	}

	public static function lead_table_name(): string {
		global $wpdb;

		return $wpdb->prefix . 'marison_leads';
	}

	public static function current_version(): int {
		return self::CURRENT_VERSION;
	}

	public static function maybe_upgrade(): bool {
		$installed_version = (int) get_option( self::VERSION_OPTION, 0 );
		if ( $installed_version >= self::CURRENT_VERSION && self::schema_ready() && self::lead_schema_ready() ) {
			return true;
		}

		return self::migrate();
	}

	public static function migrate(): bool {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = self::table_name();
		self::repair_malformed_indexes();
		self::repair_lead_malformed_indexes();
		$unit_sql        = "CREATE TABLE {$table_name} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			project_id bigint(20) unsigned NOT NULL,
			house_type_id bigint(20) unsigned NULL DEFAULT NULL,
			unit_identifier varchar(191) NOT NULL,
			status varchar(20) NOT NULL,
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY project_unit_identifier (project_id,unit_identifier),
			KEY project_id (project_id),
			KEY project_status (project_id,status),
			KEY house_type_id (house_type_id),
			KEY status (status)
		) {$charset_collate};";
		$lead_table_name = self::lead_table_name();
		$lead_sql        = "CREATE TABLE {$lead_table_name} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(191) NOT NULL,
			contact varchar(191) NOT NULL,
			inquiry_type varchar(20) NOT NULL,
			project_id bigint(20) unsigned NULL DEFAULT NULL,
			message text NULL,
			consent_at datetime NOT NULL,
			consent_version varchar(50) NOT NULL,
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY created_at (created_at),
			KEY project_id (project_id),
			KEY inquiry_type (inquiry_type)
		) {$charset_collate};";

		dbDelta( $unit_sql );
		dbDelta( $lead_sql );
		if ( ! self::schema_ready() ) {
			self::repair_malformed_indexes();
			dbDelta( $unit_sql );
		}
		if ( ! self::lead_schema_ready() ) {
			self::repair_lead_malformed_indexes();
			dbDelta( $lead_sql );
		}
		if ( ! self::schema_ready() || ! self::lead_schema_ready() ) {
			error_log( 'Marison Core schema migration failed: Unit or Lead table is not ready.' );
			return false;
		}

		update_option( self::VERSION_OPTION, self::CURRENT_VERSION, false );
		return true;
	}

	private static function table_exists(): bool {
		global $wpdb;

		$table_name = self::table_name();
		return $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name;
	}

	private static function schema_ready(): bool {
		global $wpdb;

		if ( ! self::table_exists() ) {
			return false;
		}

		$columns = array_map( 'strval', (array) $wpdb->get_col( 'DESCRIBE ' . self::table_name(), 0 ) );
		$required_columns = [ 'id', 'project_id', 'house_type_id', 'unit_identifier', 'status', 'created_at', 'updated_at' ];
		if ( count( array_diff( $required_columns, $columns ) ) > 0 ) {
			return false;
		}

		$indexes = [];
		foreach ( (array) $wpdb->get_results( 'SHOW INDEX FROM ' . self::table_name(), ARRAY_A ) as $index ) {
			$indexes[ $index['Key_name'] ][ (int) $index['Seq_in_index'] ] = $index['Column_name'];
		}
		$expected = [
			'PRIMARY' => [ 'id' ],
			'project_unit_identifier' => [ 'project_id', 'unit_identifier' ],
			'project_id' => [ 'project_id' ],
			'project_status' => [ 'project_id', 'status' ],
			'house_type_id' => [ 'house_type_id' ],
			'status' => [ 'status' ],
		];
		foreach ( $expected as $name => $columns_for_index ) {
			$actual = isset( $indexes[ $name ] ) ? array_values( $indexes[ $name ] ) : [];
			if ( $actual !== $columns_for_index ) {
				return false;
			}
		}

		return true;
	}

	private static function repair_malformed_indexes(): void {
		global $wpdb;

		if ( ! self::table_exists() ) {
			return;
		}

		$indexes = [];
		foreach ( (array) $wpdb->get_results( 'SHOW INDEX FROM ' . self::table_name(), ARRAY_A ) as $index ) {
			$indexes[ $index['Key_name'] ][ (int) $index['Seq_in_index'] ] = $index['Column_name'];
		}
		$expected = [
			'project_unit_identifier' => [ 'project_id', 'unit_identifier' ],
			'project_id' => [ 'project_id' ],
			'project_status' => [ 'project_id', 'status' ],
			'house_type_id' => [ 'house_type_id' ],
			'status' => [ 'status' ],
		];
		foreach ( $expected as $name => $columns_for_index ) {
			$actual = isset( $indexes[ $name ] ) ? array_values( $indexes[ $name ] ) : [];
			if ( $actual && $actual !== $columns_for_index ) {
				$wpdb->query( 'ALTER TABLE ' . self::table_name() . ' DROP INDEX `' . esc_sql( $name ) . '`' );
			}
		}
	}

	private static function lead_table_exists(): bool {
		global $wpdb;

		$table_name = self::lead_table_name();
		return $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name;
	}

	private static function lead_schema_ready(): bool {
		global $wpdb;

		if ( ! self::lead_table_exists() ) {
			return false;
		}

		$columns = array_map( 'strval', (array) $wpdb->get_col( 'DESCRIBE ' . self::lead_table_name(), 0 ) );
		$required_columns = [ 'id', 'name', 'contact', 'inquiry_type', 'project_id', 'message', 'consent_at', 'consent_version', 'created_at', 'updated_at' ];
		if ( count( array_diff( $required_columns, $columns ) ) > 0 ) {
			return false;
		}

		$indexes = [];
		foreach ( (array) $wpdb->get_results( 'SHOW INDEX FROM ' . self::lead_table_name(), ARRAY_A ) as $index ) {
			$indexes[ $index['Key_name'] ][ (int) $index['Seq_in_index'] ] = $index['Column_name'];
		}
		$expected = [
			'PRIMARY' => [ 'id' ],
			'created_at' => [ 'created_at' ],
			'project_id' => [ 'project_id' ],
			'inquiry_type' => [ 'inquiry_type' ],
		];
		foreach ( $expected as $name => $columns_for_index ) {
			$actual = isset( $indexes[ $name ] ) ? array_values( $indexes[ $name ] ) : [];
			if ( $actual !== $columns_for_index ) {
				return false;
			}
		}

		return true;
	}

	private static function repair_lead_malformed_indexes(): void {
		global $wpdb;

		if ( ! self::lead_table_exists() ) {
			return;
		}

		$indexes = [];
		foreach ( (array) $wpdb->get_results( 'SHOW INDEX FROM ' . self::lead_table_name(), ARRAY_A ) as $index ) {
			$indexes[ $index['Key_name'] ][ (int) $index['Seq_in_index'] ] = $index['Column_name'];
		}
		$expected = [
			'created_at' => [ 'created_at' ],
			'project_id' => [ 'project_id' ],
			'inquiry_type' => [ 'inquiry_type' ],
		];
		foreach ( $expected as $name => $columns_for_index ) {
			$actual = isset( $indexes[ $name ] ) ? array_values( $indexes[ $name ] ) : [];
			if ( $actual && $actual !== $columns_for_index ) {
				$wpdb->query( 'ALTER TABLE ' . self::lead_table_name() . ' DROP INDEX `' . esc_sql( $name ) . '`' );
			}
		}
	}
}
