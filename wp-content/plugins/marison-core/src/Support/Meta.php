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
	public const HOUSE_TYPE_PROJECT = '_marison_house_type_project';
	public const HOUSE_TYPE_BUILDING_AREA = '_marison_house_type_building_area';
	public const HOUSE_TYPE_LAND_AREA = '_marison_house_type_land_area';
	public const HOUSE_TYPE_BEDROOMS = '_marison_house_type_bedrooms';
	public const HOUSE_TYPE_BATHROOMS = '_marison_house_type_bathrooms';
	public const HOUSE_TYPE_FLOORS = '_marison_house_type_floors';
	public const BRANCH_WHATSAPP = '_marison_branch_whatsapp';
	public const BRANCH_TELEPHONE = '_marison_branch_telephone';

	public static function register(): void {
		self::register_meta( 'marison_project', self::PROJECT_STATUS, 'string', [ Validation::class, 'sanitize_project_status' ] );
		self::register_meta( 'marison_project', self::PROJECT_PRIMARY_BRANCH, 'integer', [ Validation::class, 'sanitize_branch_id' ] );
		self::register_meta( 'marison_project', self::PROJECT_MARKETING, 'array', [ Validation::class, 'sanitize_marketing_ids' ], [] );
		self::register_meta( 'marison_project', self::PROJECT_PROGRESS, 'integer', [ Validation::class, 'sanitize_percentage' ] );
		self::register_meta( 'marison_project', self::PROJECT_PROGRESS_DESCRIPTION, 'string', 'sanitize_textarea_field' );
		self::register_meta( 'marison_project', self::PROJECT_ADDRESS, 'string', 'sanitize_textarea_field' );

		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_PROJECT, 'integer', [ Validation::class, 'sanitize_project_id' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BUILDING_AREA, 'number', [ Validation::class, 'sanitize_non_negative_number' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_LAND_AREA, 'number', [ Validation::class, 'sanitize_non_negative_number' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BEDROOMS, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_BATHROOMS, 'integer', [ Validation::class, 'sanitize_non_negative_integer' ] );
		self::register_meta( 'marison_house_type', self::HOUSE_TYPE_FLOORS, 'integer', [ Validation::class, 'sanitize_positive_integer' ] );

		self::register_meta( 'marison_branch', self::BRANCH_WHATSAPP, 'string', [ Validation::class, 'sanitize_contact_number' ] );
		self::register_meta( 'marison_branch', self::BRANCH_TELEPHONE, 'string', [ Validation::class, 'sanitize_contact_number' ] );
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
}
