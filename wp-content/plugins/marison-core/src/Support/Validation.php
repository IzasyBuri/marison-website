<?php
/**
 * Content model validation and relationship safety.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Support;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Inventory\UnitRepository;

final class Validation {
	public const PROJECT_STATUSES = [ 'upcoming', 'ongoing', 'completed' ];
	public const CAREER_STATUSES = [ 'open', 'closed' ];
	public const AVAILABILITY_MODES = [ 'manual', 'units' ];
	private static bool $enforcing_integrity = false;

	public static function sanitize_project_status( $value ): string {
		$value = sanitize_key( (string) $value );
		return in_array( $value, self::PROJECT_STATUSES, true ) ? $value : '';
	}

	public static function sanitize_career_status( $value ): string {
		$value = sanitize_key( (string) $value );
		return in_array( $value, self::CAREER_STATUSES, true ) ? $value : '';
	}

	public static function sanitize_career_email( $value ): string {
		$value = sanitize_email( (string) $value );
		return is_email( $value ) ? $value : '';
	}

	public static function sanitize_career_external_url( $value ): string {
		$raw = trim( (string) $value );
		if ( '' === $raw || preg_match( '/\s/', $raw ) ) {
			return '';
		}

		$raw_parts = wp_parse_url( $raw );
		if ( ! is_array( $raw_parts ) || empty( $raw_parts['host'] ) || empty( $raw_parts['scheme'] ) || ! in_array( strtolower( $raw_parts['scheme'] ), [ 'http', 'https' ], true ) ) {
			return '';
		}

		$value = esc_url_raw( $raw, [ 'http', 'https' ] );
		$parts = wp_parse_url( $value );
		if ( ! $value || ! is_array( $parts ) || empty( $parts['host'] ) || ! filter_var( $parts['host'], FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME ) && ! filter_var( $parts['host'], FILTER_VALIDATE_IP ) ) {
			return '';
		}

		return $value;
	}

	public static function sanitize_availability_mode( $value ): string {
		$value = sanitize_key( (string) $value );
		return in_array( $value, self::AVAILABILITY_MODES, true ) ? $value : '';
	}

	public static function sanitize_non_negative_number( $value ) {
		$value = trim( (string) $value );
		if ( '' === $value || ! preg_match( '/^\d+(?:[.,]\d+)?$/', $value ) ) {
			return '';
		}

		return (float) str_replace( ',', '.', $value );
	}

	public static function sanitize_non_negative_integer( $value ): string {
		$value = trim( (string) $value );
		return '' === $value || ! preg_match( '/^\d+$/', $value ) ? '' : (string) absint( $value );
	}

	public static function sanitize_positive_integer( $value ): string {
		$value = self::sanitize_non_negative_integer( $value );
		return '' !== $value && (int) $value > 0 ? $value : '';
	}

	public static function sanitize_percentage( $value ): string {
		$value = self::sanitize_non_negative_integer( $value );
		return '' !== $value && (int) $value <= 100 ? $value : '';
	}

	public static function sanitize_post_ids( $value ): array {
		if ( ! is_array( $value ) ) {
			$value = [ $value ];
		}

		return array_values( array_unique( array_filter( array_map( 'absint', $value ) ) ) );
	}

	public static function sanitize_project_id( $value ): int {
		$value = absint( $value );
		return self::is_valid_post( $value, 'marison_project' ) ? $value : 0;
	}

	public static function sanitize_branch_id( $value ): int {
		$value = absint( $value );
		return self::is_valid_post( $value, 'marison_branch' ) ? $value : 0;
	}

	public static function sanitize_marketing_ids( $value ): array {
		return array_values(
			array_filter(
				self::sanitize_post_ids( $value ),
				static fn( $id ) => self::is_valid_post( $id, 'marison_marketing' )
			)
		);
	}

	public static function sanitize_article_project_ids( $value ): array {
		$ids = [];
		foreach ( self::sanitize_post_ids( $value ) as $id ) {
			$id = \Marison\Core\Multilingual\Resolver::canonical_post_id( $id );
			if ( self::is_valid_post( $id, 'marison_project' ) ) {
				$ids[] = $id;
			}
		}
		return array_values( array_unique( $ids ) );
	}

	public static function sanitize_contact_number( $value ): string {
		$value = sanitize_text_field( (string) $value );
		$value = preg_replace( '/[^\d+\s().-]/u', '', $value );
		return trim( preg_replace( '/\s+/u', ' ', (string) $value ) );
	}

	public static function is_valid_contact_number( $value ): bool {
		return preg_match_all( '/\d/', (string) $value ) >= 7;
	}

	public static function is_valid_post( $post_id, string $post_type, bool $published_only = false ): bool {
		$post = get_post( absint( $post_id ) );
		if ( ! $post || $post_type !== $post->post_type || 'trash' === $post->post_status ) {
			return false;
		}

		return ! $published_only || 'publish' === $post->post_status;
	}

	public static function is_valid_location( $term_id ): bool {
		$term = get_term( absint( $term_id ), 'marison_location' );
		return $term && ! is_wp_error( $term ) && 3 === self::location_depth( $term->term_id );
	}

	public static function location_depth( int $term_id ): int {
		return count( get_ancestors( $term_id, 'marison_location', 'taxonomy' ) ) + 1;
	}

	public static function project_errors( int $post_id ): array {
		$errors = [];
		$status = get_post_meta( $post_id, Meta::PROJECT_STATUS, true );
		$branch_id = (int) get_post_meta( $post_id, Meta::PROJECT_PRIMARY_BRANCH, true );
		$location_ids = wp_get_post_terms( $post_id, 'marison_location', [ 'fields' => 'ids' ] );

		if ( ! in_array( $status, self::PROJECT_STATUSES, true ) ) {
			$errors[] = 'Project Status wajib dipilih dari Akan Datang, Sedang Berjalan, atau Selesai.';
		}
		$availability_mode = get_post_meta( $post_id, Meta::PROJECT_AVAILABILITY_MODE, true );
		if ( ! in_array( $availability_mode, self::AVAILABILITY_MODES, true ) ) {
			$errors[] = 'Availability Source wajib dipilih dari Manual atau Unit Inventory.';
		}
		if ( ! self::is_valid_post( $branch_id, 'marison_branch', true ) ) {
			$errors[] = 'Project wajib memiliki satu Primary Branch Office yang aktif.';
		} elseif ( ! self::branch_has_contact( $branch_id ) && ! self::corporate_fallback_available() ) {
			$errors[] = 'Primary Branch Office wajib memiliki WhatsApp, telepon, atau fallback korporat yang valid.';
		}
		if ( 1 !== count( $location_ids ) || ! self::is_valid_location( (int) $location_ids[0] ) ) {
			$errors[] = 'Project wajib memiliki tepat satu lokasi City / Regency yang valid.';
		}

		return $errors;
	}

	public static function career_errors( int $post_id ): array {
		$status = get_post_meta( $post_id, Meta::CAREER_STATUS, true );
		return in_array( $status, self::CAREER_STATUSES, true )
			? []
			: [ 'Career Vacancy wajib memiliki status Open atau Closed sebelum publish.' ];
	}

	public static function house_type_errors( int $post_id ): array {
		$project_id = (int) get_post_meta( $post_id, Meta::HOUSE_TYPE_PROJECT, true );
		return self::is_valid_post( $project_id, 'marison_project', true )
			? []
			: [ 'House Type wajib memiliki tepat satu Project pemilik yang valid.' ];
	}

	public static function branch_errors( int $post_id ): array {
		return ! self::branch_has_contact( $post_id ) && ! self::corporate_fallback_available()
			? [ 'Branch Office wajib memiliki Primary Public WhatsApp atau telepon publik, atau fallback korporat yang valid.' ]
			: [];
	}

	public static function branch_has_contact( int $branch_id ): bool {
		return self::is_valid_contact_number( get_post_meta( $branch_id, Meta::BRANCH_WHATSAPP, true ) )
			|| self::is_valid_contact_number( get_post_meta( $branch_id, Meta::BRANCH_TELEPHONE, true ) );
	}

	public static function corporate_fallback_available(): bool {
		$telephone = \Marison\Core\Settings\CorporateSettings::get( \Marison\Core\Settings\CorporateSettings::TELEPHONE );
		$email = sanitize_email( \Marison\Core\Settings\CorporateSettings::get( \Marison\Core\Settings\CorporateSettings::EMAIL ) );
		return self::is_valid_contact_number( $telephone ) || '' !== $email;
	}

	public static function prevent_delete_with_units( int $post_id, \WP_Post $post ): void {
		$count = 'marison_project' === $post->post_type
			? UnitRepository::count_by_project( $post_id )
			: ( 'marison_house_type' === $post->post_type ? UnitRepository::count_by_house_type( $post_id ) : 0 );
		if ( $count <= 0 ) {
			return;
		}

		$label = 'marison_project' === $post->post_type ? 'Project' : 'House Type';
		wp_die( esc_html( sprintf( '%s tidak dapat dihapus permanen karena masih direferensikan oleh %d Unit. Hapus Unit secara eksplisit terlebih dahulu.', $label, $count ) ) );
	}

	public static function enforce_published_integrity( int $post_id, string $post_type ): array {
		if ( self::$enforcing_integrity || 'publish' !== get_post_status( $post_id ) ) {
			return [];
		}

		$errors = 'marison_project' === $post_type ? self::project_errors( $post_id ) : ( 'marison_house_type' === $post_type ? self::house_type_errors( $post_id ) : ( 'marison_branch' === $post_type ? self::branch_errors( $post_id ) : ( 'marison_career' === $post_type ? self::career_errors( $post_id ) : [] ) ) );
		if ( ! $errors ) {
			return [];
		}

		self::$enforcing_integrity = true;
		wp_update_post( [ 'ID' => $post_id, 'post_status' => 'draft' ] );
		self::$enforcing_integrity = false;

		return $errors;
	}

	public static function handle_post_meta_change( $meta_id, int $post_id, string $meta_key, $meta_value ): void {
		if ( doing_action( 'save_post' ) ) {
			return;
		}

		$post_type = get_post_type( $post_id );
		if ( 'marison_branch' === $post_type && Meta::BRANCH_WHATSAPP === $meta_key ) {
			self::invalidate_projects_for_branch( $post_id );
			return;
		}

		$gated_keys = [
			'marison_project' => [ Meta::PROJECT_STATUS, Meta::PROJECT_PRIMARY_BRANCH, Meta::PROJECT_AVAILABILITY_MODE ],
			'marison_house_type' => [ Meta::HOUSE_TYPE_PROJECT ],
			'marison_career' => [ Meta::CAREER_STATUS ],
		];
		if ( isset( $gated_keys[ $post_type ] ) && in_array( $meta_key, $gated_keys[ $post_type ], true ) ) {
			self::enforce_published_integrity( $post_id, $post_type );
		}
	}

	public static function handle_term_relationship_change( int $object_id, array $terms, array $tt_ids, string $taxonomy ): void {
		if ( 'marison_location' !== $taxonomy || doing_action( 'save_post' ) || 'marison_project' !== get_post_type( $object_id ) ) {
			return;
		}

		self::enforce_published_integrity( $object_id, 'marison_project' );
	}

	public static function handle_deleted_term_relationships( int $object_id, array $tt_ids, string $taxonomy ): void {
		if ( 'marison_location' !== $taxonomy || doing_action( 'save_post' ) || 'marison_project' !== get_post_type( $object_id ) ) {
			return;
		}

		self::enforce_published_integrity( $object_id, 'marison_project' );
	}

	public static function handle_edited_term_taxonomy( int $tt_id, string $taxonomy, array $args ): void {
		if ( 'marison_location' !== $taxonomy ) {
			return;
		}

		$term = get_term_by( 'term_taxonomy_id', $tt_id, $taxonomy );
		if ( ! $term || is_wp_error( $term ) ) {
			return;
		}

		$location_term_ids = get_terms(
			[
				'taxonomy' => 'marison_location',
				'hide_empty' => false,
				'fields' => 'ids',
			]
		);
		if ( ! is_wp_error( $location_term_ids ) ) {
			clean_term_cache( array_map( 'absint', $location_term_ids ), 'marison_location' );
		}

		$project_ids = get_posts(
			[
				'post_type' => 'marison_project',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'tax_query' => [
					[
						'taxonomy' => 'marison_location',
						'field' => 'term_id',
						'terms' => [ $term->term_id ],
						'include_children' => true,
					],
				],
			]
		);

		foreach ( $project_ids as $project_id ) {
			self::enforce_published_integrity( (int) $project_id, 'marison_project' );
		}
	}

	public static function invalidate_projects_for_branch( int $branch_id ): void {
		$projects = get_posts(
			[
				'post_type' => 'marison_project',
				'post_status' => [ 'publish', 'future', 'pending', 'private' ],
				'posts_per_page' => -1,
				'fields' => 'ids',
				'meta_key' => Meta::PROJECT_PRIMARY_BRANCH,
				'meta_value' => $branch_id,
			]
		);

		if ( self::is_valid_post( $branch_id, 'marison_branch', true ) && ( self::branch_has_contact( $branch_id ) || self::corporate_fallback_available() ) ) {
			return;
		}

		foreach ( $projects as $project_id ) {
			wp_update_post( [ 'ID' => $project_id, 'post_status' => 'draft' ] );
		}
	}

	public static function handle_trash_relationships( string $new_status, string $old_status, \WP_Post $post ): void {
		if ( 'trash' !== $new_status || 'trash' === $old_status ) {
			return;
		}

		if ( 'marison_project' === $post->post_type ) {
			$house_types = get_posts(
				[
					'post_type' => 'marison_house_type',
					'post_status' => [ 'publish', 'future', 'draft', 'pending', 'private' ],
					'posts_per_page' => -1,
					'fields' => 'ids',
					'meta_key' => Meta::HOUSE_TYPE_PROJECT,
					'meta_value' => $post->ID,
				]
			);
			foreach ( $house_types as $house_type_id ) {
				wp_update_post( [ 'ID' => $house_type_id, 'post_status' => 'draft' ] );
			}
		}

		if ( 'marison_branch' === $post->post_type ) {
			$projects = get_posts(
				[
					'post_type' => 'marison_project',
					'post_status' => [ 'publish', 'future', 'draft', 'pending', 'private' ],
					'posts_per_page' => -1,
					'fields' => 'ids',
					'meta_key' => Meta::PROJECT_PRIMARY_BRANCH,
					'meta_value' => $post->ID,
				]
			);
			foreach ( $projects as $project_id ) {
				wp_update_post( [ 'ID' => $project_id, 'post_status' => 'draft' ] );
			}
		}
	}
}
