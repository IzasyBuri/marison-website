<?php
/**
 * Purpose-built admin fields for the initial content model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Admin;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

final class MetaBoxes {
	private const NONCE_ACTION = 'marison_core_save_content';
	private const NONCE_NAME = 'marison_core_content_nonce';

	public static function register(): void {
		add_meta_box( 'marison_project_details', 'Informasi Project', [ self::class, 'render_project_details' ], 'marison_project', 'normal', 'high' );
		add_meta_box( 'marison_project_operations', 'Relasi Operasional Project', [ self::class, 'render_project_operations' ], 'marison_project', 'side', 'high' );
		add_meta_box( 'marison_house_type_details', 'Informasi House Type', [ self::class, 'render_house_type' ], 'marison_house_type', 'normal', 'high' );
		add_meta_box( 'marison_branch_contact', 'Kontak Publik Branch', [ self::class, 'render_branch' ], 'marison_branch', 'normal', 'high' );
		add_meta_box( 'marison_article_projects', 'Project Terkait', [ self::class, 'render_article_projects' ], 'post', 'side', 'default' );
		add_meta_box( 'marison_career_details', 'Career Vacancy', [ self::class, 'render_career' ], 'marison_career', 'normal', 'high' );
	}

	public static function render_career( \WP_Post $post ): void {
		self::nonce();
		$status = get_post_meta( $post->ID, Meta::CAREER_STATUS, true );
		$instructions = get_post_meta( $post->ID, Meta::CAREER_APPLICATION_INSTRUCTIONS, true );
		$email = get_post_meta( $post->ID, Meta::CAREER_RECRUITMENT_EMAIL, true );
		$url = get_post_meta( $post->ID, Meta::CAREER_EXTERNAL_URL, true );
		?>
		<p><label for="marison_career_status"><strong>Status Vacancy</strong></label></p>
		<select class="widefat" id="marison_career_status" name="marison_career_status">
			<option value="">Pilih status sebelum publish</option>
			<option value="open" <?php selected( $status, 'open' ); ?>>Open</option>
			<option value="closed" <?php selected( $status, 'closed' ); ?>>Closed</option>
		</select>
		<p class="description">Vacancy tanpa status tidak dapat tetap published.</p>

		<p><label for="marison_career_application_instructions"><strong>Application instructions</strong></label></p>
		<textarea class="widefat" id="marison_career_application_instructions" name="marison_career_application_instructions" rows="5"><?php echo esc_textarea( $instructions ); ?></textarea>
		<p class="description">Instruksi ini spesifik untuk bahasa Vacancy saat ini.</p>

		<p><label for="marison_career_recruitment_email"><strong>Recruitment email</strong></label></p>
		<input class="widefat" id="marison_career_recruitment_email" name="marison_career_recruitment_email" type="email" value="<?php echo esc_attr( $email ); ?>" />

		<p><label for="marison_career_external_url"><strong>External application URL</strong></label></p>
		<input class="widefat" id="marison_career_external_url" name="marison_career_external_url" type="url" value="<?php echo esc_attr( $url ); ?>" />
		<p class="description">Gunakan URL http atau https. URL ini menjadi tujuan aplikasi utama.</p>
		<?php
	}

	public static function render_project_details( \WP_Post $post ): void {
		self::nonce();
		$status = get_post_meta( $post->ID, Meta::PROJECT_STATUS, true );
		$progress = get_post_meta( $post->ID, Meta::PROJECT_PROGRESS, true );
		$progress_description = get_post_meta( $post->ID, Meta::PROJECT_PROGRESS_DESCRIPTION, true );
		$address = get_post_meta( $post->ID, Meta::PROJECT_ADDRESS, true );
		$availability_mode = get_post_meta( $post->ID, Meta::PROJECT_AVAILABILITY_MODE, true );
		?>
		<p><label for="marison_project_status"><strong>Status Project</strong></label></p>
		<select class="widefat" id="marison_project_status" name="marison_project_status">
			<option value="">Pilih status sebelum publish</option>
			<option value="upcoming" <?php selected( $status, 'upcoming' ); ?>>Akan Datang</option>
			<option value="ongoing" <?php selected( $status, 'ongoing' ); ?>>Sedang Berjalan</option>
			<option value="completed" <?php selected( $status, 'completed' ); ?>>Selesai</option>
		</select>
		<p class="description">Nilai teknis disimpan stabil; label ini adalah label admin.</p>

		<p><label for="marison_project_progress"><strong>Progress saat ini (%)</strong></label></p>
		<input class="small-text" id="marison_project_progress" name="marison_project_progress" type="number" min="0" max="100" step="1" value="<?php echo esc_attr( $progress ); ?>" />

		<p><label for="marison_project_progress_description"><strong>Deskripsi progress singkat</strong></label></p>
		<textarea class="widefat" id="marison_project_progress_description" name="marison_project_progress_description" rows="3"><?php echo esc_textarea( $progress_description ); ?></textarea>

		<p><label for="marison_project_address"><strong>Alamat Project</strong></label></p>
		<textarea class="widefat" id="marison_project_address" name="marison_project_address" rows="3"><?php echo esc_textarea( $address ); ?></textarea>

		<hr />
		<p><label for="marison_project_availability_mode"><strong>Availability Source</strong></label></p>
		<select class="widefat" id="marison_project_availability_mode" name="marison_project_availability_mode">
			<option value="">Pilih sumber availability sebelum publish</option>
			<option value="manual" <?php selected( $availability_mode, 'manual' ); ?>>Manual fallback</option>
			<option value="units" <?php selected( $availability_mode, 'units' ); ?>>Unit Inventory</option>
		</select>
		<p class="description">Membuat Unit tidak otomatis mengubah mode. Manual fallback tetap tersimpan saat Unit Inventory menjadi sumber aktif.</p>
		<?php self::availability_count_field( 'marison_project_manual_available', 'Manual — Tersedia', Meta::PROJECT_MANUAL_AVAILABLE, $post->ID ); ?>
		<?php self::availability_count_field( 'marison_project_manual_booked', 'Manual — Terbooking', Meta::PROJECT_MANUAL_BOOKED, $post->ID ); ?>
		<?php self::availability_count_field( 'marison_project_manual_sold', 'Manual — Terjual', Meta::PROJECT_MANUAL_SOLD, $post->ID ); ?>
		<p class="description">Isi semua tiga angka manual dengan bilangan bulat tidak negatif saat Manual fallback digunakan. Angka ini diabaikan dalam mode Unit Inventory.</p>
		<?php
	}

	private static function availability_count_field( string $name, string $label, string $meta_key, int $post_id ): void {
		$value = get_post_meta( $post_id, $meta_key, true );
		?>
		<p><label for="<?php echo esc_attr( $name ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label></p>
		<input class="small-text" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="number" min="0" step="1" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}

	public static function render_project_operations( \WP_Post $post ): void {
		self::nonce();
		$branch_id = (int) get_post_meta( $post->ID, Meta::PROJECT_PRIMARY_BRANCH, true );
		$marketing_ids = get_post_meta( $post->ID, Meta::PROJECT_MARKETING, true );
		$marketing_ids = is_array( $marketing_ids ) ? array_map( 'absint', $marketing_ids ) : [];
		$branches = get_posts(
			[
				'post_type' => 'marison_branch',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
			]
		);
		$marketing_records = get_posts(
			[
				'post_type' => 'marison_marketing',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
			]
		);
		?>
		<p><label for="marison_project_primary_branch"><strong>Primary Branch Office</strong></label></p>
		<select class="widefat" id="marison_project_primary_branch" name="marison_project_primary_branch">
			<option value="">Pilih Branch Office</option>
			<?php foreach ( $branches as $branch ) : ?>
				<option value="<?php echo esc_attr( $branch->ID ); ?>" <?php selected( $branch_id, $branch->ID ); ?>><?php echo esc_html( $branch->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description">Project yang dipublish wajib memiliki Branch dengan Primary Public WhatsApp.</p>

		<p><strong>Marketing Person / Team</strong></p>
		<p class="description">Assignment ini internal dan tidak menjadi CTA publik.</p>
		<?php if ( $marketing_records ) : ?>
			<?php foreach ( $marketing_records as $record ) : ?>
				<label style="display:block;margin:4px 0;">
					<input type="checkbox" name="marison_project_marketing[]" value="<?php echo esc_attr( $record->ID ); ?>" <?php checked( in_array( $record->ID, $marketing_ids, true ) ); ?> />
					<?php echo esc_html( $record->post_title ); ?>
				</label>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="description">Belum ada Marketing Person / Team aktif.</p>
		<?php endif; ?>
		<?php
	}

	public static function render_house_type( \WP_Post $post ): void {
		self::nonce();
		$project_id = (int) get_post_meta( $post->ID, Meta::HOUSE_TYPE_PROJECT, true );
		$projects = get_posts(
			[
				'post_type' => 'marison_project',
				'post_status' => [ 'publish', 'draft', 'pending', 'private' ],
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
			]
		);
		?>
		<p><label for="marison_house_type_project"><strong>Project pemilik</strong></label></p>
		<select class="widefat" id="marison_house_type_project" name="marison_house_type_project">
			<option value="">Pilih Project</option>
			<?php foreach ( $projects as $project ) : ?>
				<option value="<?php echo esc_attr( $project->ID ); ?>" <?php selected( $project_id, $project->ID ); ?>><?php echo esc_html( $project->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description">House Type tidak memiliki halaman publik mandiri dan wajib memiliki satu Project sebelum publish.</p>

		<?php self::number_field( 'marison_house_type_building_area', 'Luas bangunan', Meta::HOUSE_TYPE_BUILDING_AREA, $post->ID, 'm²' ); ?>
		<?php self::number_field( 'marison_house_type_land_area', 'Luas tanah', Meta::HOUSE_TYPE_LAND_AREA, $post->ID, 'm²' ); ?>
		<?php self::number_field( 'marison_house_type_bedrooms', 'Kamar tidur', Meta::HOUSE_TYPE_BEDROOMS, $post->ID, 'jumlah' ); ?>
		<?php self::number_field( 'marison_house_type_bathrooms', 'Kamar mandi', Meta::HOUSE_TYPE_BATHROOMS, $post->ID, 'jumlah' ); ?>
		<?php self::number_field( 'marison_house_type_floors', 'Jumlah lantai', Meta::HOUSE_TYPE_FLOORS, $post->ID, 'jumlah' ); ?>
		<p class="description">Gunakan Featured Image untuk gambar utama atau floor plan pada foundation ini.</p>
		<?php
	}

	private static function number_field( string $name, string $label, string $meta_key, int $post_id, string $suffix ): void {
		$value = get_post_meta( $post_id, $meta_key, true );
		?>
		<p><label for="<?php echo esc_attr( $name ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label></p>
		<input class="small-text" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="number" min="0" step="any" value="<?php echo esc_attr( $value ); ?>" />
		<span class="description"><?php echo esc_html( $suffix ); ?></span>
		<?php
	}

	public static function render_branch( \WP_Post $post ): void {
		self::nonce();
		$whatsapp = get_post_meta( $post->ID, Meta::BRANCH_WHATSAPP, true );
		$telephone = get_post_meta( $post->ID, Meta::BRANCH_TELEPHONE, true );
		?>
		<p><label for="marison_branch_whatsapp"><strong>Primary Public WhatsApp</strong></label></p>
		<input class="widefat" id="marison_branch_whatsapp" name="marison_branch_whatsapp" type="text" value="<?php echo esc_attr( $whatsapp ); ?>" />
		<p class="description">Untuk WhatsApp, gunakan format internasional lengkap dengan kode negara, misalnya +62 812 3456 7890. Marison tidak menambahkan atau menebak kode negara; jika nomor tidak memenuhi format, routing akan memakai telepon atau fallback yang tersedia.</p>

		<p><label for="marison_branch_telephone"><strong>Telepon publik (opsional)</strong></label></p>
		<input class="widefat" id="marison_branch_telephone" name="marison_branch_telephone" type="text" value="<?php echo esc_attr( $telephone ); ?>" />
		<?php
	}

	public static function render_article_projects( \WP_Post $post ): void {
		self::nonce();
		$selected = get_post_meta( $post->ID, Meta::ARTICLE_PROJECTS, true );
		$selected = is_array( $selected ) ? array_map( 'absint', $selected ) : [];
		$args = [
			'post_type' => 'marison_project',
			'post_status' => [ 'publish', 'draft', 'pending', 'private' ],
			'posts_per_page' => 100,
			'orderby' => 'title',
			'order' => 'ASC',
		];
		if ( class_exists( '\\Marison\\Core\\Multilingual\\Polylang' ) && \Marison\Core\Multilingual\Polylang::available() ) {
			$args['lang'] = \Marison\Core\Multilingual\Polylang::default_language();
		}
		$projects = get_posts( $args );
		foreach ( $projects as $project ) {
			printf( '<label style="display:block;margin:4px 0;"><input type="checkbox" name="marison_article_projects[]" value="%d" %s /> %s</label>', (int) $project->ID, checked( in_array( $project->ID, $selected, true ), true, false ), esc_html( $project->post_title ) );
		}
		if ( ! $projects ) {
			echo '<p class="description">Belum ada Project yang dapat dipilih.</p>';
		}
	}

	public static function render_location_metabox( \WP_Post $post ): void {
		if ( 'marison_project' !== $post->post_type ) {
			wp_terms_checklist( $post->ID, [ 'taxonomy' => 'marison_location', 'checked_ontop' => false ] );
			return;
		}

		$current = wp_get_post_terms( $post->ID, 'marison_location', [ 'fields' => 'ids' ] );
		$current = ! is_wp_error( $current ) && $current ? (int) $current[0] : 0;
		$terms = get_terms( [ 'taxonomy' => 'marison_location', 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC' ] );
		self::nonce();
		?>
		<p><label for="marison_project_location"><strong>City / Regency Project</strong></label></p>
		<select class="widefat" id="marison_project_location" name="marison_project_location">
			<option value="">Pilih City / Regency</option>
			<?php foreach ( $terms as $term ) : ?>
				<?php if ( ! Validation::is_valid_location( $term->term_id ) ) { continue; } ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php selected( $current, $term->term_id ); ?>><?php echo esc_html( self::location_label( $term ) ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description">Struktur referensi: Country → Province → City / Regency. Project memilih satu City / Regency.</p>
		<?php
	}

	private static function location_label( \WP_Term $term ): string {
		$names = [ $term->name ];
		foreach ( get_ancestors( $term->term_id, 'marison_location', 'taxonomy' ) as $ancestor_id ) {
			$ancestor = get_term( $ancestor_id, 'marison_location' );
			if ( $ancestor && ! is_wp_error( $ancestor ) ) {
				$names[] = $ancestor->name;
			}
		}

		return implode( ' / ', array_reverse( $names ) );
	}

	public static function save( int $post_id, \WP_Post $post, bool $update = false ): void {
		if ( ! in_array( $post->post_type, [ 'marison_project', 'marison_house_type', 'marison_branch', 'marison_career', 'post' ], true ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}
		$can_edit = current_user_can( 'edit_post', $post_id );
		$nonce_valid = $can_edit && isset( $_POST[ self::NONCE_NAME ] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION );
		if ( $nonce_valid ) {
			switch ( $post->post_type ) {
				case 'marison_project':
					self::save_project( $post_id );
					break;
				case 'marison_house_type':
					self::save_house_type( $post_id );
					break;
				case 'marison_branch':
					self::save_branch( $post_id );
					break;
				case 'marison_career':
					self::save_career( $post_id );
					break;
				case 'post':
					self::save_article_projects( $post_id );
					break;
			}
		}
		if ( 'marison_branch' === $post->post_type ) {
			Validation::invalidate_projects_for_branch( $post_id );
		}

		self::enforce_publish_gate( $post_id, $post->post_type );
	}

	private static function save_career( int $post_id ): void {
		$raw_status = isset( $_POST['marison_career_status'] ) ? wp_unslash( $_POST['marison_career_status'] ) : '';
		$status = Validation::sanitize_career_status( $raw_status );
		self::save_or_delete( $post_id, Meta::CAREER_STATUS, $status, '' !== (string) $raw_status && '' === $status ? 'Status Career tidak valid dan tidak disimpan.' : '' );

		self::save_text( $post_id, Meta::CAREER_APPLICATION_INSTRUCTIONS, 'marison_career_application_instructions', true );
		self::save_text( $post_id, Meta::CAREER_RECRUITMENT_EMAIL, 'marison_career_recruitment_email', false, [ Validation::class, 'sanitize_career_email' ] );
		self::save_text( $post_id, Meta::CAREER_EXTERNAL_URL, 'marison_career_external_url', false, [ Validation::class, 'sanitize_career_external_url' ] );
	}

	private static function save_project( int $post_id ): void {
		$status = isset( $_POST['marison_project_status'] ) ? Validation::sanitize_project_status( wp_unslash( $_POST['marison_project_status'] ) ) : '';
		self::save_or_delete( $post_id, Meta::PROJECT_STATUS, $status, $status !== (string) ( $_POST['marison_project_status'] ?? '' ) ? 'Status Project tidak valid dan tidak disimpan.' : '' );

		$branch_id = isset( $_POST['marison_project_primary_branch'] ) ? absint( $_POST['marison_project_primary_branch'] ) : 0;
		if ( $branch_id && Validation::is_valid_post( $branch_id, 'marison_branch', true ) ) {
			update_post_meta( $post_id, Meta::PROJECT_PRIMARY_BRANCH, $branch_id );
		} else {
			delete_post_meta( $post_id, Meta::PROJECT_PRIMARY_BRANCH );
			if ( $branch_id ) { self::notice( 'Primary Branch Office tidak valid dan tidak disimpan.' ); }
		}

		$marketing_ids = isset( $_POST['marison_project_marketing'] ) ? Validation::sanitize_post_ids( wp_unslash( $_POST['marison_project_marketing'] ) ) : [];
		$marketing_ids = array_values( array_filter( $marketing_ids, static fn( $id ) => Validation::is_valid_post( $id, 'marison_marketing', true ) ) );
		update_post_meta( $post_id, Meta::PROJECT_MARKETING, $marketing_ids );

		$progress = isset( $_POST['marison_project_progress'] ) ? Validation::sanitize_percentage( wp_unslash( $_POST['marison_project_progress'] ) ) : '';
		self::save_or_delete( $post_id, Meta::PROJECT_PROGRESS, $progress, '' !== (string) ( $_POST['marison_project_progress'] ?? '' ) && '' === $progress ? 'Progress harus berupa angka 0 sampai 100.' : '' );
		self::save_text( $post_id, Meta::PROJECT_PROGRESS_DESCRIPTION, 'marison_project_progress_description', true );
		self::save_text( $post_id, Meta::PROJECT_ADDRESS, 'marison_project_address', true );

		$mode = isset( $_POST['marison_project_availability_mode'] ) ? Validation::sanitize_availability_mode( wp_unslash( $_POST['marison_project_availability_mode'] ) ) : '';
		self::save_or_delete( $post_id, Meta::PROJECT_AVAILABILITY_MODE, $mode, '' !== (string) ( $_POST['marison_project_availability_mode'] ?? '' ) && '' === $mode ? 'Availability Source tidak valid.' : '' );
		$manual_fields = [
			Meta::PROJECT_MANUAL_AVAILABLE => 'marison_project_manual_available',
			Meta::PROJECT_MANUAL_BOOKED => 'marison_project_manual_booked',
			Meta::PROJECT_MANUAL_SOLD => 'marison_project_manual_sold',
		];
		foreach ( $manual_fields as $meta_key => $input_name ) {
			$raw = isset( $_POST[ $input_name ] ) ? wp_unslash( $_POST[ $input_name ] ) : '';
			$value = Validation::sanitize_non_negative_integer( $raw );
			self::save_or_delete( $post_id, $meta_key, $value, '' !== (string) $raw && '' === $value ? 'Manual availability harus berupa bilangan bulat tidak negatif.' : '' );
		}

		$location_id = isset( $_POST['marison_project_location'] ) ? absint( $_POST['marison_project_location'] ) : 0;
		if ( $location_id && Validation::is_valid_location( $location_id ) ) {
			wp_set_post_terms( $post_id, [ $location_id ], 'marison_location', false );
		} else {
			wp_set_post_terms( $post_id, [], 'marison_location', false );
			if ( $location_id ) { self::notice( 'Lokasi Project harus berupa City / Regency yang valid.' ); }
		}
	}

	private static function save_house_type( int $post_id ): void {
		$project_id = isset( $_POST['marison_house_type_project'] ) ? absint( $_POST['marison_house_type_project'] ) : 0;
		if ( $project_id && Validation::is_valid_post( $project_id, 'marison_project' ) ) {
			update_post_meta( $post_id, Meta::HOUSE_TYPE_PROJECT, $project_id );
		} else {
			delete_post_meta( $post_id, Meta::HOUSE_TYPE_PROJECT );
			if ( $project_id ) { self::notice( 'Project pemilik House Type tidak valid.' ); }
		}

		$fields = [
			'Meta::HOUSE_TYPE_BUILDING_AREA' => [ Meta::HOUSE_TYPE_BUILDING_AREA, 'marison_house_type_building_area', [ Validation::class, 'sanitize_non_negative_number' ] ],
			'Meta::HOUSE_TYPE_LAND_AREA' => [ Meta::HOUSE_TYPE_LAND_AREA, 'marison_house_type_land_area', [ Validation::class, 'sanitize_non_negative_number' ] ],
			'Meta::HOUSE_TYPE_BEDROOMS' => [ Meta::HOUSE_TYPE_BEDROOMS, 'marison_house_type_bedrooms', [ Validation::class, 'sanitize_non_negative_integer' ] ],
			'Meta::HOUSE_TYPE_BATHROOMS' => [ Meta::HOUSE_TYPE_BATHROOMS, 'marison_house_type_bathrooms', [ Validation::class, 'sanitize_non_negative_integer' ] ],
			'Meta::HOUSE_TYPE_FLOORS' => [ Meta::HOUSE_TYPE_FLOORS, 'marison_house_type_floors', [ Validation::class, 'sanitize_positive_integer' ] ],
		];
		foreach ( $fields as $field ) {
			[ $meta_key, $input_name, $sanitizer ] = $field;
			$raw = isset( $_POST[ $input_name ] ) ? wp_unslash( $_POST[ $input_name ] ) : '';
			$value = call_user_func( $sanitizer, $raw );
			self::save_or_delete( $post_id, $meta_key, $value, '' !== (string) $raw && '' === (string) $value ? 'Nilai House Type tidak valid dan tidak disimpan.' : '' );
		}
	}

	private static function save_branch( int $post_id ): void {
		self::save_text( $post_id, Meta::BRANCH_WHATSAPP, 'marison_branch_whatsapp', false, [ Validation::class, 'sanitize_contact_number' ] );
		self::save_text( $post_id, Meta::BRANCH_TELEPHONE, 'marison_branch_telephone', false, [ Validation::class, 'sanitize_contact_number' ] );
	}

	private static function save_article_projects( int $post_id ): void {
		$projects = isset( $_POST['marison_article_projects'] ) ? wp_unslash( $_POST['marison_article_projects'] ) : [];
		$projects = Validation::sanitize_article_project_ids( $projects );
		if ( $projects ) {
			update_post_meta( $post_id, Meta::ARTICLE_PROJECTS, $projects );
		} else {
			delete_post_meta( $post_id, Meta::ARTICLE_PROJECTS );
		}
	}

	private static function save_text( int $post_id, string $meta_key, string $input_name, bool $textarea, ?callable $sanitizer = null ): void {
		if ( ! isset( $_POST[ $input_name ] ) ) {
			return;
		}
		$raw = wp_unslash( $_POST[ $input_name ] );
		$value = $sanitizer ? call_user_func( $sanitizer, $raw ) : ( $textarea ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw ) );
		self::save_or_delete( $post_id, $meta_key, $value, '' );
	}

	private static function save_or_delete( int $post_id, string $meta_key, $value, string $notice ): void {
		if ( '' !== $notice ) {
			self::notice( $notice );
		}
		if ( '' === $value || null === $value ) {
			delete_post_meta( $post_id, $meta_key );
			return;
		}
		update_post_meta( $post_id, $meta_key, $value );
	}

	private static function enforce_publish_gate( int $post_id, string $post_type ): void {
		static $checking = false;
		if ( $checking || 'publish' !== get_post_status( $post_id ) ) {
			return;
		}

		$errors = Validation::enforce_published_integrity( $post_id, $post_type );
		if ( ! $errors ) {
			return;
		}

		$checking = true;
		wp_update_post( [ 'ID' => $post_id, 'post_status' => 'draft' ] );
		$checking = false;
		foreach ( $errors as $error ) {
			self::notice( $error );
		}
		self::notice( 'Data disimpan sebagai Draft sampai semua persyaratan terpenuhi.' );
	}

	private static function nonce(): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
	}

	private static function notice( string $message ): void {
		$user_id = get_current_user_id();
		if ( $user_id ) {
			$notices = get_transient( 'marison_core_notices_' . $user_id );
			$notices = is_array( $notices ) ? $notices : [];
			$notices[] = $message;
			set_transient( 'marison_core_notices_' . $user_id, $notices, MINUTE_IN_SECONDS );
		}
	}

	public static function render_notices(): void {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return;
		}
		$notices = get_transient( 'marison_core_notices_' . $user_id );
		if ( ! is_array( $notices ) || ! $notices ) {
			return;
		}
		delete_transient( 'marison_core_notices_' . $user_id );
		foreach ( $notices as $notice ) {
			printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $notice ) );
		}
	}
}
