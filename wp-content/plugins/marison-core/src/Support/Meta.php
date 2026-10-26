<?php
/**
 * Registered Marison post metadata.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Support;

defined( 'ABSPATH' ) || exit;

final class Meta {
	public const PROJECT_STATUS = '_marison_project_status';
	public const PROJECT_PRIMARY_BRANCH = '_marison_project_primary_branch';
	public const PROJECT_MARKETING = '_marison_project_marketing';
	public const PROJECT_PROGRESS = '_marison_project_progress_percentage';
	public const PROJECT_PROGRESS_DESCRIPTION = '_marison_project_progress_description';
	public const PROJECT_ADDRESS = '_marison_project_address';
	public const PROJECT_AVAILABILITY_MODE = '_marison_project_availability_mode';
	public const PROJECT_MANUAL_AVAILABLE = '_marison_project_manual_available';
	public const PROJECT_MANUAL_BOOKED = '_marison_project_manual_booked';
	public const PROJECT_MANUAL_SOLD = '_marison_project_manual_sold';
	public const HOUSE_TYPE_PROJECT = '_marison_house_type_project';
	public const HOUSE_TYPE_BUILDING_AREA = '_marison_house_type_building_area';
	public const HOUSE_TYPE_LAND_AREA = '_marison_house_type_land_area';
	public const HOUSE_TYPE_BEDROOMS = '_marison_house_type_bedrooms';
	public const HOUSE_TYPE_BATHROOMS = '_marison_house_type_bathrooms';
	public const HOUSE_TYPE_FLOORS = '_marison_house_type_floors';
	public const BRANCH_WHATSAPP = '_marison_branch_whatsapp';
	public const BRANCH_TELEPHONE = '_marison_branch_telephone';
	public const ARTICLE_PROJECTS = '_marison_article_projects';

	public static function register(): void {
		self::register_meta( 'marison_project', self::PROJECT_STATUS, 'string', [ Validation::class, 'sanitize_project_status' ] );
		self::register_meta( 'marison_project', self::PROJECT_PRIMARY_BRANCH, 'integer', [ Validation::class, 'sanitize_branch_id' ] );
		self::register_meta( 'marison_project', self::PROJECT_MARKETING, 'array', [ Validation::class, 'sanitize_marketing_ids' ], [] );
		self::register_meta( 'marison_project', self::PROJECT_PROGRESS, 'integer', [ Validation::class, 'sanitize_percentage' ] );
		self::register_meta( 'marison_project', self::PROJECT_PROGRESS_DESCRIPTION, 'string', 'sanitize_textarea_field' );
		self::register_meta( 'marison_project', self::PROJECT_ADDRESS, 'string', 'sanitize_textarea_field' );
		self::register_meta( 'marison_project', self::PROJECT_AVAILABILITY_MODE, 'string', [ Validation::class, 'sanitize_availability_mode' ] );
		self::register_meta( 'marison_project', self::PROJECT_MANUAL_AVAILABLE, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_project', self::PROJECT_MANUAL_BOOKED, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_project', self::PROJECT_MANUAL_SOLD, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );

		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_PROJECT, 'integer', [ Validation::class, 'sanitize_project_id' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BUILDING_AREA, 'number', [ Validation::class, 'sanitize_non_negative_number' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_LAND_AREA, 'number', [ Validation::class, 'sanitize_non_negative_number' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BEDROOMS, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BATHROOMS, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_FLOORS, 'integer', [ Validation::class, 'sanitize_positive_integer' ] );

		self::register_meta( 'marison_branch', self::BRANCH_WHATSAPP, 'string', [ Validation::class, 'sanitize_contact_number' ] );
		self::register_meta( 'marison_branch', self::BRANCH_TELEPHONE, 'string', [ Validation::class, 'sanitize_contact_number' ] );
		self::register_meta( 'post', self::ARTICLE_PROJECTS, 'array', [ Validation::class, 'sanitize_article_project_ids' ], [] );

		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_state', 'string', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_state' ] );
		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_annual_rate', 'string', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_rate' ] );
		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_tenure_months', 'array', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_tenures' ], [] );
		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_default_dp_percent', 'string', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_default_dp' ] );
		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_effective_date', 'string', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_effective_date' ] );
		self::register_meta( 'marison_kpr_scheme', '_marison_kpr_disclaimer', 'string', [ \Marison\Core\KPR\SchemeRules::class, 'sanitize_disclaimer' ] );
	}

	private static function register_meta( string $post_type, string $key, string $type, callable $sanitize, $default = null ): void {
		$args = [
			'type' => $type,
			'single' => true,
			'show_in_rest' => false,
			'auth_callback' => [ self::class, 'authorize' ],
			'sanitize_callback' => $sanitize,
		];

		if ( null !== $default ) {
			$args['default'] = $default;
		}

		register_post_meta( $post_type, $key, $args );
	}

	public static function authorize( bool $allowed, string $meta_key, int $post_id, int $user_id ): bool {
		return user_can( $user_id, 'edit_post', $post_id );
	}

	public static function manual_key( string $status ): string {
		return [
			'available' => self::PROJECT_MANUAL_AVAILABLE,
			'booked' => self::PROJECT_MANUAL_BOOKED,
			'sold' => self::PROJECT_MANUAL_SOLD,
		][ $status ] ?? '';
	}
}
