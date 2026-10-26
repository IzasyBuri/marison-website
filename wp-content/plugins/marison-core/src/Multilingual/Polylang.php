<?php
/**
 * Polylang Free integration boundary.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Multilingual;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Meta;

final class Polylang {
	public static function register(): void {
		add_filter( 'pll_get_post_types', [ self::class, 'post_types' ], 10, 2 );
		add_filter( 'pll_get_taxonomies', [ self::class, 'taxonomies' ], 10, 2 );
		add_filter( 'pll_copy_post_metas', [ self::class, 'copy_post_metas' ], 10, 5 );
	}

	public static function available(): bool { return function_exists( 'pll_current_language' ) && function_exists( 'pll_get_post' ); }

	public static function current_language(): string { return self::available() ? (string) ( pll_current_language() ?: self::default_language() ) : 'id'; }

	public static function default_language(): string { return self::available() ? (string) ( pll_default_language() ?: 'id' ) : 'id'; }

	public static function post_types( array $post_types, bool $is_settings = false ): array {
		if ( $is_settings ) { return $post_types; }
		foreach ( [ 'marison_project', 'marison_house_type' ] as $post_type ) {
			if ( post_type_exists( $post_type ) ) { $post_types[ $post_type ] = $post_type; }
		}
		if ( post_type_exists( 'marison_career' ) ) { $post_types['marison_career'] = 'marison_career'; }
		return $post_types;
	}

	public static function taxonomies( array $taxonomies, bool $is_settings = false ): array {
		if ( ! $is_settings && taxonomy_exists( 'marison_facility' ) ) { $taxonomies['marison_facility'] = 'marison_facility'; }
		return $taxonomies;
	}

	public static function copy_post_metas( array $metas, bool $sync = false, int $from = 0, int $to = 0, string $lang = '' ): array {
		$from_type = get_post_type( $from );
		$to_type = get_post_type( $to );
		if ( $from_type !== $to_type ) { return $metas; }
		$shared = [];
		if ( 'marison_project' === $from_type ) {
			$shared = [ Meta::PROJECT_STATUS, Meta::PROJECT_PRIMARY_BRANCH, Meta::PROJECT_MARKETING, Meta::PROJECT_PROGRESS, Meta::PROJECT_AVAILABILITY_MODE, Meta::PROJECT_MANUAL_AVAILABLE, Meta::PROJECT_MANUAL_BOOKED, Meta::PROJECT_MANUAL_SOLD, Meta::PROJECT_ADDRESS ];
		} elseif ( 'marison_house_type' === $from_type ) {
			$shared = [ Meta::HOUSE_TYPE_PROJECT, Meta::HOUSE_TYPE_BUILDING_AREA, Meta::HOUSE_TYPE_LAND_AREA, Meta::HOUSE_TYPE_BEDROOMS, Meta::HOUSE_TYPE_BATHROOMS, Meta::HOUSE_TYPE_FLOORS, '_thumbnail_id' ];
		} elseif ( 'post' === $from_type ) {
			$shared = [ Meta::ARTICLE_PROJECTS ];
		} elseif ( 'marison_career' === $from_type ) {
			$shared = [ Meta::CAREER_STATUS, Meta::CAREER_RECRUITMENT_EMAIL, Meta::CAREER_EXTERNAL_URL ];
		}
		return array_values( array_unique( array_merge( $metas, $shared ) ) );
	}
}
