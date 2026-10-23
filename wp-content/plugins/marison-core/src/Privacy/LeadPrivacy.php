<?php
/**
 * WordPress privacy integration for private Leads.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Privacy;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Leads\LeadRepository;

final class LeadPrivacy {
	public static function register(): void {
		add_filter( 'wp_privacy_personal_data_exporters', [ self::class, 'register_exporter' ] );
		add_filter( 'wp_privacy_personal_data_erasers', [ self::class, 'register_eraser' ] );
	}

	public static function register_exporter( array $exporters ): array {
		$exporters['marison-leads'] = [ 'exporter_friendly_name' => 'Marison Leads', 'callback' => [ self::class, 'export' ] ];
		return $exporters;
	}

	public static function register_eraser( array $erasers ): array {
		$erasers['marison-leads'] = [ 'eraser_friendly_name' => 'Marison Leads', 'callback' => [ self::class, 'erase' ] ];
		return $erasers;
	}

	public static function export( string $identifier, int $page = 1 ): array {
		$rows = LeadRepository::find_by_contact( $identifier );
		$data = [];
		foreach ( $rows as $row ) {
			$data[] = [
				'group_id' => 'marison-lead',
				'group_label' => 'Marison Leads',
				'item_id' => 'lead-' . $row['id'],
				'data' => [
					[ 'name' => 'Name', 'value' => $row['name'] ],
					[ 'name' => 'Contact', 'value' => $row['contact'] ],
					[ 'name' => 'Created', 'value' => $row['created_at'] ],
				],
			];
		}

		return [ 'data' => $data, 'done' => true ];
	}

	public static function erase( string $identifier, int $page = 1 ): array {
		$removed = LeadRepository::delete_by_contact( $identifier );
		return [ 'items_removed' => $removed, 'items_retained' => 0, 'messages' => [], 'done' => true ];
	}
}
