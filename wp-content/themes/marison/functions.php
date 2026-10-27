<?php
/**
 * Marison theme foundation hooks.
 *
 * @package Marison
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/inc/project-detail.php';

add_action(
	'after_setup_theme',
	static function (): void {
		add_editor_style( 'style.css' );
	}
);

add_action(
	'wp_enqueue_scripts',
	static function (): void {
		wp_enqueue_style( 'marison-foundation', get_stylesheet_uri(), [], wp_get_theme()->get( 'Version' ) );
		if ( is_singular( 'marison_project' ) ) {
			wp_enqueue_script( 'marison-project-detail', get_theme_file_uri( 'assets/project-detail.js' ), [], wp_get_theme()->get( 'Version' ), true );
		}
	}
);

add_action(
	'init',
	'marison_register_article_pattern',
	9
);

function marison_register_article_pattern(): void {
	if ( ! function_exists( 'register_block_pattern' ) || WP_Block_Patterns_Registry::get_instance()->is_registered( 'marison/article-archive-content' ) ) {
		return;
	}

	ob_start();
	include __DIR__ . '/patterns/article-archive-content.php';
	$content = ob_get_clean();
	register_block_pattern(
		'marison/article-archive-content',
		[
			'title' => 'Marison Article Archive Content',
			'description' => 'Native Article archive structure with localized introduction, Query Loop, pagination, and housing discovery CTA.',
			'categories' => [ 'marison-articles' ],
			'inserter' => false,
			'content' => $content,
		]
	);
}

add_action(
	'init',
	static function (): void {
		register_block_type( 'marison/homepage-featured-projects', [ 'render_callback' => 'marison_render_homepage_featured_projects' ] );
		register_block_type( 'marison/homepage-locations', [ 'render_callback' => 'marison_render_homepage_locations' ] );
		register_block_type( 'marison/homepage-articles', [ 'render_callback' => 'marison_render_homepage_articles' ] );
		register_block_type( 'marison/housing-directory', [ 'render_callback' => 'marison_render_housing_directory' ] );
		register_block_type( 'marison/project-detail', [ 'render_callback' => 'marison_render_project_detail' ] );
		register_block_type( 'marison/kpr-status', [ 'render_callback' => 'marison_render_kpr_status' ] );
		register_block_type( 'marison/article-archive-copy', [ 'render_callback' => 'marison_render_article_archive_copy', 'attributes' => [ 'variant' => [ 'type' => 'string', 'default' => 'intro' ] ] ] );
		register_block_type( 'marison/article-card', [ 'render_callback' => 'marison_render_article_card' ] );
		register_block_type( 'marison/article-meta', [ 'render_callback' => 'marison_render_article_meta' ] );
		register_block_type( 'marison/article-featured-image', [ 'render_callback' => 'marison_render_article_featured_image' ] );
		register_block_type( 'marison/article-related-projects', [ 'render_callback' => 'marison_render_article_related_projects' ] );
		register_block_type( 'marison/navigation-link', [ 'render_callback' => 'marison_render_navigation_link', 'attributes' => [ 'label_key' => [ 'type' => 'string' ], 'path' => [ 'type' => 'string' ], 'variant' => [ 'type' => 'string' ] ] ] );
		register_block_type( 'marison/career-list', [ 'render_callback' => 'marison_render_career_list' ] );
		register_block_type( 'marison/career-application', [ 'render_callback' => 'marison_render_career_application' ] );
		register_block_type( 'marison/corporate-contact', [ 'render_callback' => 'marison_render_corporate_contact' ] );
		register_block_type( 'marison/general-contact-form', [ 'render_callback' => 'marison_render_general_contact_form' ] );
	}
);

function marison_contact_language(): string {
	return class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id';
}

function marison_contact_label( string $key ): string {
	$labels = [
		'corporate_channels' => [ 'id' => 'Saluran kontak korporat', 'en' => 'Corporate contact channels' ],
		'telephone' => [ 'id' => 'Telepon korporat', 'en' => 'Corporate phone' ],
		'email' => [ 'id' => 'Email korporat', 'en' => 'Corporate email' ],
		'unavailable' => [ 'id' => 'Kontak korporat belum tersedia', 'en' => 'Corporate contact is not configured yet' ],
		'unavailable_detail' => [ 'id' => 'Belum ada saluran kontak korporat yang dapat ditampilkan.', 'en' => 'No corporate contact channel is configured for display yet.' ],
		'general_inquiry' => [ 'id' => 'Pertanyaan umum', 'en' => 'General inquiry' ],
		'general_inquiry_intro' => [ 'id' => 'Gunakan formulir ini untuk pertanyaan umum kepada Marison.', 'en' => 'Use this form for a general question for Marison.' ],
		'name' => [ 'id' => 'Nama', 'en' => 'Name' ],
		'contact' => [ 'id' => 'Nomor WhatsApp atau telepon', 'en' => 'WhatsApp number or telephone' ],
		'message' => [ 'id' => 'Pesan (opsional)', 'en' => 'Message (optional)' ],
		'consent' => [ 'id' => 'Saya menyetujui pemrosesan data ini untuk menanggapi pertanyaan saya.', 'en' => 'I consent to this data being processed to respond to my question.' ],
		'privacy_help' => [ 'id' => 'Baca kerangka kebijakan privasi (draf, memerlukan review legal)', 'en' => 'Read the privacy notice draft (requires legal review)' ],
		'submit' => [ 'id' => 'Kirim pertanyaan', 'en' => 'Send inquiry' ],
		'success' => [ 'id' => 'Pertanyaan Anda sudah diterima.', 'en' => 'Your inquiry has been received.' ],
		'error' => [ 'id' => 'Pertanyaan belum dapat dikirim. Periksa data Anda dan coba lagi.', 'en' => 'Your inquiry could not be sent. Check your details and try again.' ],
	];
	$language = 'en' === marison_contact_language() ? 'en' : 'id';
	return translate( $labels[ $key ][ $language ] ?? '', 'marison' );
}

function marison_public_page_url( string $path ): string {
	$path = trim( $path, '/' );
	$page = $path ? get_page_by_path( $path, OBJECT, 'page' ) : null;
	if ( ! $page && $path ) {
		$pages = get_posts(
			[
				'post_type'        => 'page',
				'post_status'      => 'any',
				'name'             => sanitize_title( $path ),
				'posts_per_page'   => 1,
				'suppress_filters' => true,
			]
		);
		$page = $pages[0] ?? null;
	}
	if ( ! $page || 'publish' !== get_post_status( $page ) ) {
		return '';
	}

	$canonical_url = get_permalink( $page );
	if ( ! class_exists( '\Marison\Core\Multilingual\Resolver' ) || \Marison\Core\Multilingual\Resolver::current_language() === \Marison\Core\Multilingual\Polylang::default_language() ) {
		return $canonical_url ? (string) $canonical_url : '';
	}

	$translated_id = \Marison\Core\Multilingual\Resolver::translated_post_id( (int) $page->ID, \Marison\Core\Multilingual\Resolver::current_language() );
	if ( $translated_id && 'publish' === get_post_status( $translated_id ) ) {
		$localized_url = \Marison\Core\Multilingual\Resolver::localized_url( $path );
		return $localized_url ?: (string) $canonical_url;
	}

	return $canonical_url ? (string) $canonical_url : '';
}

function marison_privacy_url(): string {
	return marison_public_page_url( 'kebijakan-privasi' );
}

function marison_render_corporate_contact(): string {
	$read_model = '\\Marison\\Core\\Contact\\CorporateContact';
	$view = class_exists( $read_model ) ? $read_model::read() : [ 'state' => 'unavailable', 'channels' => [] ];
	$output = '<section class="marison-contact-channels" aria-labelledby="marison-contact-channels-heading"><h2 id="marison-contact-channels-heading">' . esc_html( marison_contact_label( 'corporate_channels' ) ) . '</h2>';

	if ( 'available' !== ( $view['state'] ?? '' ) || empty( $view['channels'] ) ) {
		return $output . '<div class="marison-contact-channels__unavailable" role="status"><p class="marison-contact-channels__state">' . esc_html( marison_contact_label( 'unavailable' ) ) . '</p><p>' . esc_html( marison_contact_label( 'unavailable_detail' ) ) . '</p></div></section>';
	}

	$output .= '<ul class="marison-contact-channels__list">';
	foreach ( $view['channels'] as $channel ) {
		$kind = 'email' === ( $channel['kind'] ?? '' ) ? 'email' : 'telephone';
		$output .= '<li class="marison-contact-channel marison-contact-channel--' . esc_attr( $kind ) . '"><p class="marison-contact-channel__label">' . esc_html( marison_contact_label( $kind ) ) . '</p><a href="' . esc_url( $channel['url'] ?? '' ) . '">' . esc_html( $channel['value'] ?? '' ) . '</a></li>';
	}
	return $output . '</ul></section>';
}

function marison_render_general_contact_form(): string {
	$result_value = $_GET['marison_lead_result'] ?? '';
	$result       = is_scalar( $result_value ) ? sanitize_key( wp_unslash( $result_value ) ) : '';
	$notice = '';
	if ( 'success' === $result ) {
		$notice = '<div class="marison-contact-form__notice marison-contact-form__notice--success" role="status" aria-live="polite">' . esc_html( marison_contact_label( 'success' ) ) . '</div>';
	} elseif ( 'error' === $result ) {
		$notice = '<div class="marison-contact-form__notice marison-contact-form__notice--error" role="alert">' . esc_html( marison_contact_label( 'error' ) ) . '</div>';
	}

	$action = esc_url( admin_url( 'admin-post.php' ) );
	$nonce  = wp_nonce_field( 'marison_submit_lead', 'marison_lead_nonce', true, false );
	$output = '<section class="marison-contact-form" aria-labelledby="marison-contact-form-heading"><h2 id="marison-contact-form-heading">' . esc_html( marison_contact_label( 'general_inquiry' ) ) . '</h2><p>' . esc_html( marison_contact_label( 'general_inquiry_intro' ) ) . '</p>' . $notice;
	$output .= '<form method="post" action="' . $action . '"><input type="hidden" name="action" value="marison_submit_general_lead" /><input type="hidden" name="marison_contact_language" value="' . esc_attr( marison_contact_language() ) . '" />' . $nonce;
	$output .= '<div class="marison-form-control"><label for="marison-contact-name">' . esc_html( marison_contact_label( 'name' ) ) . '</label><input id="marison-contact-name" name="name" type="text" autocomplete="name" required /></div>';
	$output .= '<div class="marison-form-control"><label for="marison-contact-contact">' . esc_html( marison_contact_label( 'contact' ) ) . '</label><input id="marison-contact-contact" name="contact" type="text" autocomplete="on" required /></div>';
	$output .= '<div class="marison-form-control"><label for="marison-contact-message">' . esc_html( marison_contact_label( 'message' ) ) . '</label><textarea id="marison-contact-message" name="message" rows="5"></textarea></div>';
	$output .= '<div class="marison-contact-form__honeypot" aria-hidden="true"><label for="marison-contact-website">Website</label><input id="marison-contact-website" name="website" type="text" tabindex="-1" autocomplete="off" /></div>';
	$privacy_url = marison_privacy_url();
	$privacy_link = $privacy_url ? ' <a href="' . esc_url( $privacy_url ) . '">' . esc_html( marison_contact_label( 'privacy_help' ) ) . '</a>' : '';
	$output .= '<div class="marison-form-control marison-contact-form__consent"><label><input name="consent" type="checkbox" value="1" required /> <span>' . esc_html( marison_contact_label( 'consent' ) ) . $privacy_link . '</span></label></div>';
	$output .= '<button type="submit">' . esc_html( marison_contact_label( 'submit' ) ) . '</button></form></section>';

	return $output;
}

function marison_career_language(): string {
	return class_exists( '\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id';
}

function marison_career_label( string $key, string $language = '' ): string {
	$labels = [
		'heading' => [ 'id' => 'Lowongan yang tersedia', 'en' => 'Open vacancies' ],
		'empty_title' => [ 'id' => 'Belum ada lowongan yang tersedia.', 'en' => 'No open vacancies are available yet.' ],
		'empty_text' => [ 'id' => 'Silakan kembali lagi untuk melihat peluang baru bersama Marison.', 'en' => 'Please check back later for new opportunities with Marison.' ],
		'status' => [ 'id' => 'Status lowongan', 'en' => 'Vacancy status' ],
		'closed_text' => [ 'id' => 'Lamaran untuk lowongan ini sudah ditutup.', 'en' => 'Applications for this vacancy are closed.' ],
		'external' => [ 'id' => 'Lamar melalui situs eksternal (meninggalkan Marison)', 'en' => 'Apply externally (leaves Marison)' ],
		'email' => [ 'id' => 'Hubungi recruitment melalui email', 'en' => 'Email recruitment' ],
		'instructions' => [ 'id' => 'Cara melamar', 'en' => 'How to apply' ],
		'none' => [ 'id' => 'Informasi lamaran belum dikonfigurasi.', 'en' => 'Application details are not configured yet.' ],
	];
	$language = 'en' === ( $language ?: marison_career_language() ) ? 'en' : 'id';
	return $labels[ $key ][ $language ] ?? '';
}

function marison_career_view_model(): array {
	$class = '\\Marison\\Core\\Presentation\\Career';
	return class_exists( $class ) ? $class::open_vacancies() : [];
}

function marison_render_career_list(): string {
	$vacancies = marison_career_view_model();
	$heading_id = 'marison-career-list-heading';
	$output = '<section class="marison-career-list" aria-labelledby="' . esc_attr( $heading_id ) . '"><h2 id="' . esc_attr( $heading_id ) . '">' . esc_html( marison_career_label( 'heading' ) ) . '</h2>';
	if ( ! $vacancies ) {
		return $output . '<div class="marison-career-list__empty" role="status"><p class="marison-career-list__empty-title">' . esc_html( marison_career_label( 'empty_title' ) ) . '</p><p>' . esc_html( marison_career_label( 'empty_text' ) ) . '</p></div></section>';
	}

	$output .= '<div class="marison-career-list__grid">';
	foreach ( $vacancies as $vacancy ) {
		$output .= '<article class="marison-card marison-career-card"><div class="marison-card__content"><p><span class="marison-status marison-status--career-open">' . esc_html( $vacancy['status_label'] ?? '' ) . '</span></p><h3>' . esc_html( $vacancy['title'] ?? '' ) . '</h3><p>' . esc_html( $vacancy['excerpt'] ?? '' ) . '</p><p><a class="marison-button marison-button--primary" href="' . esc_url( $vacancy['url'] ?? '' ) . '">' . esc_html( 'en' === marison_career_language() ? 'View vacancy' : 'Lihat lowongan' ) . '</a></p></div></article>';
	}
	return $output . '</div></section>';
}

function marison_render_career_application(): string {
	$class = '\\Marison\\Core\\Presentation\\Career';
	$view = class_exists( $class ) ? $class::detail_state( get_queried_object_id() ) : [];
	if ( ! $view ) {
		return '';
	}

	$application = $view['application'] ?? [];
	$language = (string) ( $view['language'] ?? marison_career_language() );
	$status_class = 'closed' === ( $view['status'] ?? '' ) ? 'marison-status--career-closed' : 'marison-status--career-open';
	$output = '<section class="marison-career-application" aria-labelledby="marison-career-application-heading"><div class="marison-career-application__status"><span class="marison-status ' . esc_attr( $status_class ) . '">' . esc_html( $view['status_label'] ?? '' ) . '</span><span class="screen-reader-text">' . esc_html( marison_career_label( 'status', $language ) ) . '</span></div>';
	$output .= '<div class="marison-career-application__destination">';
	if ( 'closed' === ( $application['kind'] ?? '' ) ) {
		$output .= '<p id="marison-career-application-heading" class="marison-career-application__message">' . esc_html( marison_career_label( 'closed_text', $language ) ) . '</p>';
	} elseif ( 'external' === ( $application['kind'] ?? '' ) || 'email' === ( $application['kind'] ?? '' ) ) {
		$output .= '<p id="marison-career-application-heading"><a class="marison-button marison-button--primary" href="' . esc_url( $application['url'] ?? '' ) . '"' . ( 'external' === $application['kind'] ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>' . esc_html( 'external' === $application['kind'] ? marison_career_label( 'external', $language ) : marison_career_label( 'email', $language ) ) . '</a></p>';
	} elseif ( 'instructions' === ( $application['kind'] ?? '' ) ) {
		$output .= '<div id="marison-career-application-heading" class="marison-career-application__instructions"><h2>' . esc_html( marison_career_label( 'instructions', $language ) ) . '</h2><p>' . nl2br( esc_html( $application['instructions'] ?? '' ) ) . '</p></div>';
	} else {
		$output .= '<p id="marison-career-application-heading" class="marison-career-application__message">' . esc_html( marison_career_label( 'none', $language ) ) . '</p>';
	}
	return $output . '</div></section>';
}

add_action(
	'pre_get_posts',
	'marison_configure_article_archive_query'
);

function marison_configure_article_archive_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}

	$query->set( 'post_type', 'post' );
	$query->set( 'post_status', 'publish' );
	$query->set( 'posts_per_page', 9 );
	$query->set( 'orderby', [ 'date' => 'DESC', 'ID' => 'DESC' ] );
	$query->set( 'ignore_sticky_posts', true );
}

function marison_homepage_read_model(): ?string {
	$class = '\\Marison\\Core\\Presentation\\Homepage';
	return class_exists( $class ) ? $class : null;
}

function marison_render_homepage_featured_projects(): string {
	$read_model = marison_homepage_read_model();
	$projects = $read_model ? $read_model::featured_projects( 6 ) : [];
	if ( ! $projects ) {
		return '';
	}

	$output = '<section class="marison-home-section marison-surface--cream"><div class="wp-block-group"><div class="marison-foundation-grid">';
	foreach ( $projects as $project ) {
		$output .= marison_render_project_card( $project );
	}
	return $output . '</div></div></section>';
}

function marison_render_project_card( array $project ): string {
	$title = (string) ( $project['title'] ?? '' );
	$url = (string) ( $project['url'] ?? '#' );
	$status = sanitize_key( (string) ( $project['status'] ?? '' ) );
	$status_class = sanitize_html_class( 'marison-status--project-' . $status );
	if ( ! empty( $project['image'] ) ) {
		$image = sprintf( '<img class="marison-image--card" src="%s" alt="%s" loading="lazy" />', esc_url( $project['image'] ), esc_attr( $title ) );
	} else {
		$image = '<div class="marison-image--card marison-image--fallback" role="img" aria-label="' . esc_attr( $title ) . '"><span aria-hidden="true">Marison</span></div>';
	}
	$translation_note = 'MISSING' === ( $project['translation_state'] ?? '' )
		? '<p class="marison-project-card__translation-note">' . esc_html( marison_directory_label( 'translation_missing' ) ) . '</p>'
		: '';

	return '<article class="marison-card marison-project-card">' . $image . '<div class="marison-card__content"><p><span class="marison-status ' . esc_attr( $status_class ) . '">' . esc_html( $project['status_label'] ?? '' ) . '</span></p><h3>' . esc_html( $title ) . '</h3><p>' . esc_html( $project['location'] ?? '' ) . '</p>' . $translation_note . '<p><a href="' . esc_url( $url ) . '">' . esc_html( marison_directory_label( 'detail' ) ) . '</a></p></div></article>';
}

function marison_directory_label( string $key ): string {
	$english = class_exists( '\Marison\\Core\\Multilingual\\Resolver' ) && 'en' === \Marison\Core\Multilingual\Resolver::current_language();
	$labels = [
		'city' => [ 'id' => 'City / Regency', 'en' => 'City / Regency' ],
		'province' => [ 'id' => 'Province (opsional)', 'en' => 'Province (optional)' ],
		'status' => [ 'id' => 'Status Project (opsional)', 'en' => 'Project status (optional)' ],
		'all_cities' => [ 'id' => 'Semua City / Regency', 'en' => 'All cities / regencies' ],
		'all_provinces' => [ 'id' => 'Semua Province', 'en' => 'All provinces' ],
		'all_statuses' => [ 'id' => 'Semua status', 'en' => 'All statuses' ],
		'submit' => [ 'id' => 'Terapkan filter', 'en' => 'Apply filters' ],
		'reset' => [ 'id' => 'Lihat semua perumahan', 'en' => 'See all housing' ],
		'detail' => [ 'id' => 'Lihat detail Project', 'en' => 'View Project details' ],
		'translation_missing' => [ 'id' => 'Menampilkan presentasi Indonesia.', 'en' => 'Indonesian presentation shown.' ],
		'active' => [ 'id' => 'Filter aktif', 'en' => 'Active filters' ],
		'results' => [ 'id' => 'Daftar Project perumahan', 'en' => 'Housing Project results' ],
		'pagination' => [ 'id' => 'Navigasi halaman Project', 'en' => 'Project page navigation' ],
		'invalid' => [ 'id' => 'Pilihan filter tidak valid. Silakan coba lagi.', 'en' => 'That filter selection is not valid. Please try again.' ],
		'no_projects' => [ 'id' => 'Belum ada Project perumahan yang tersedia.', 'en' => 'No housing Projects are available yet.' ],
		'no_match' => [ 'id' => 'Belum ada Project yang cocok dengan filter ini.', 'en' => 'No Projects match these filters yet.' ],
		'next' => [ 'id' => 'Berikutnya', 'en' => 'Next' ],
		'previous' => [ 'id' => 'Sebelumnya', 'en' => 'Previous' ],
	];
	return $labels[ $key ][ $english ? 'en' : 'id' ] ?? '';
}

function marison_directory_status_label( string $status ): string {
	$english = class_exists( '\Marison\\Core\\Multilingual\\Resolver' ) && 'en' === \Marison\Core\Multilingual\Resolver::current_language();
	$labels = [
		'upcoming' => [ 'id' => 'Akan Datang', 'en' => 'Upcoming' ],
		'ongoing' => [ 'id' => 'Sedang Berjalan', 'en' => 'Ongoing' ],
		'completed' => [ 'id' => 'Selesai', 'en' => 'Completed' ],
	];
	return $labels[ $status ][ $english ? 'en' : 'id' ] ?? $status;
}

function marison_directory_view_model(): array {
	$class = '\\Marison\\Core\\Presentation\\Directory';
	return class_exists( $class ) ? $class::view() : [];
}

function marison_render_housing_directory(): string {
	$view = marison_directory_view_model();
	if ( ! $view ) {
		return '';
	}

	$filters = $view['filters'];
	$output = '<section class="marison-directory marison-surface--cream" aria-labelledby="marison-directory-results-heading">';
	$output .= '<form class="marison-directory__filters" method="get" action="' . esc_url( $view['base_url'] ) . '"><div class="marison-directory__filter-grid">';
	$output .= '<div class="marison-form-control"><label for="marison-directory-city">' . esc_html( marison_directory_label( 'city' ) ) . '</label><select id="marison-directory-city" name="location_term_id"><option value="">' . esc_html( marison_directory_label( 'all_cities' ) ) . '</option>';
	foreach ( $view['options']['cities'] as $option ) {
		$output .= '<option value="' . esc_attr( $option['id'] ) . '" ' . selected( $filters['location_term_id'], $option['id'], false ) . '>' . esc_html( $option['name'] ) . '</option>';
	}
	$output .= '</select></div><div class="marison-form-control"><label for="marison-directory-province">' . esc_html( marison_directory_label( 'province' ) ) . '</label><select id="marison-directory-province" name="province_term_id"><option value="">' . esc_html( marison_directory_label( 'all_provinces' ) ) . '</option>';
	foreach ( $view['options']['provinces'] as $option ) {
		$output .= '<option value="' . esc_attr( $option['id'] ) . '" ' . selected( $filters['province_term_id'], $option['id'], false ) . '>' . esc_html( $option['name'] ) . '</option>';
	}
	$output .= '</select></div><div class="marison-form-control"><label for="marison-directory-status">' . esc_html( marison_directory_label( 'status' ) ) . '</label><select id="marison-directory-status" name="project_status"><option value="">' . esc_html( marison_directory_label( 'all_statuses' ) ) . '</option>';
	foreach ( [ 'upcoming', 'ongoing', 'completed' ] as $status ) {
		$output .= '<option value="' . esc_attr( $status ) . '" ' . selected( $filters['project_status'], $status, false ) . '>' . esc_html( marison_directory_status_label( $status ) ) . '</option>';
	}
	$output .= '</select></div></div><div class="marison-directory__filter-actions"><button type="submit">' . esc_html( marison_directory_label( 'submit' ) ) . '</button>';
	if ( $view['has_filters'] ) {
		$output .= '<a class="marison-button marison-button--secondary" href="' . esc_url( $view['reset_url'] ) . '">' . esc_html( marison_directory_label( 'reset' ) ) . '</a>';
	}
	$output .= '</div></form>';

	if ( $view['has_filters'] ) {
		$output .= '<p class="marison-directory__active" aria-live="polite"><strong>' . esc_html( marison_directory_label( 'active' ) ) . ':</strong> ' . esc_html( marison_directory_active_context( $view ) ) . '</p>';
	}

	if ( $view['is_invalid'] ) {
		$output .= '<div class="marison-directory__empty" role="alert"><h2 id="marison-directory-results-heading">' . esc_html( marison_directory_label( 'invalid' ) ) . '</h2><p><a href="' . esc_url( $view['reset_url'] ) . '">' . esc_html( marison_directory_label( 'reset' ) ) . '</a></p></div>';
	} elseif ( ! $view['projects'] ) {
		$key = $view['available_total'] > 0 && $view['has_filters'] ? 'no_match' : 'no_projects';
		$output .= '<div class="marison-directory__empty" role="status"><h2 id="marison-directory-results-heading">' . esc_html( marison_directory_label( $key ) ) . '</h2>';
		if ( $view['has_filters'] ) {
			$output .= '<p><a href="' . esc_url( $view['reset_url'] ) . '">' . esc_html( marison_directory_label( 'reset' ) ) . '</a></p>';
		}
		$output .= '</div>';
	} else {
		$output .= '<div class="marison-directory__results"><h2 id="marison-directory-results-heading" class="screen-reader-text">' . esc_html( marison_directory_label( 'results' ) ) . '</h2><div class="marison-foundation-grid">';
		foreach ( $view['projects'] as $project ) {
			$output .= marison_render_project_card( $project );
		}
		$output .= '</div></div>';
		if ( $view['pagination'] ) {
			$output .= '<nav class="marison-pagination" aria-label="' . esc_attr( marison_directory_label( 'pagination' ) ) . '"><ul>';
			if ( $view['page'] > 1 ) {
				$previous = $view['pagination'][ $view['page'] - 2 ] ?? null;
				if ( $previous ) {
					$output .= '<li><a href="' . esc_url( $previous['url'] ) . '" aria-label="' . esc_attr( marison_directory_label( 'previous' ) ) . '">' . esc_html( marison_directory_label( 'previous' ) ) . '</a></li>';
				}
			}
			foreach ( $view['pagination'] as $link ) {
				$current = $link['current'] ? ' aria-current="page"' : '';
				$output .= '<li><a href="' . esc_url( $link['url'] ) . '"' . $current . '>' . esc_html( $link['page'] ) . '</a></li>';
			}
			if ( $view['page'] < $view['pages'] ) {
				$next = $view['pagination'][ $view['page'] ] ?? null;
				if ( $next ) {
					$output .= '<li><a href="' . esc_url( $next['url'] ) . '" aria-label="' . esc_attr( marison_directory_label( 'next' ) ) . '">' . esc_html( marison_directory_label( 'next' ) ) . '</a></li>';
				}
			}
			$output .= '</ul></nav>';
		}
	}

	return $output . '</section>';
}

function marison_directory_active_context( array $view ): string {
	$parts = [];
	foreach ( [ 'cities' => 'location_term_id', 'provinces' => 'province_term_id' ] as $options_key => $filter_key ) {
		foreach ( $view['options'][ $options_key ] as $option ) {
			if ( (int) $option['id'] === (int) $view['filters'][ $filter_key ] ) {
				$parts[] = $option['name'];
			}
		}
	}
	if ( $view['filters']['project_status'] ) {
		$parts[] = marison_directory_status_label( $view['filters']['project_status'] );
	}
	return implode( ', ', $parts ) ?: marison_directory_label( 'invalid' );
}

function marison_render_homepage_locations(): string {
	$read_model = marison_homepage_read_model();
	$locations = $read_model ? $read_model::locations( 6 ) : [];
	if ( ! $locations ) {
		return '';
	}

	$output = '<form class="marison-home-discovery" method="get" action="' . esc_url( home_url( '/perumahan/' ) ) . '"><label for="marison-home-city">' . esc_html__( 'Cari berdasarkan City / Regency', 'marison' ) . '</label><select id="marison-home-city" name="location_term_id"><option value="">' . esc_html__( 'Pilih City / Regency', 'marison' ) . '</option>';
	foreach ( $locations as $location ) { $output .= '<option value="' . esc_attr( $location['id'] ) . '">' . esc_html( $location['name'] ) . '</option>'; }
	return $output . '</select><button type="submit">' . esc_html__( 'Cari Rumah', 'marison' ) . '</button></form>';
}

function marison_render_homepage_articles(): string {
	$read_model = marison_homepage_read_model();
	$articles = $read_model ? $read_model::articles( 3 ) : [];
	if ( ! $articles ) { return ''; }

	$output = '<section class="marison-home-section"><div class="wp-block-group"><div class="marison-foundation-grid">';
	foreach ( $articles as $article ) {
		$image = $article['image'] ? sprintf( '<img class="marison-image--editorial" src="%s" alt="%s" loading="lazy" />', esc_url( $article['image'] ), esc_attr( $article['title'] ) ) : '';
		$output .= '<article class="marison-card marison-article-card">' . $image . '<div class="marison-card__content"><h3>' . esc_html( $article['title'] ) . '</h3><p>' . esc_html( $article['excerpt'] ) . '</p><p><a href="' . esc_url( $article['url'] ) . '">' . esc_html__( 'Baca artikel', 'marison' ) . '</a></p></div></article>';
	}
	return $output . '</div></div></section>';
}

function marison_article_language(): string {
	return class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id';
}

function marison_article_label( string $key ): string {
	$english = 'en' === marison_article_language();
	$labels = [
		'archive_title' => [ 'id' => 'Artikel Marison', 'en' => 'Marison Articles' ],
		'archive_intro' => [ 'id' => 'Baca wawasan tentang hunian, lingkungan, dan perjalanan memilih rumah bersama Marison.', 'en' => 'Read practical perspectives on homes, neighborhoods, and the journey of choosing a place to live with Marison.' ],
		'empty_title' => [ 'id' => 'Belum ada artikel yang tersedia.', 'en' => 'No articles are available yet.' ],
		'empty_text' => [ 'id' => 'Kami sedang menyiapkan tulisan editorial untuk membantu Anda memahami pilihan hunian.', 'en' => 'We are preparing editorial stories to help you understand your housing options.' ],
		'published' => [ 'id' => 'Diterbitkan', 'en' => 'Published' ],
		'category' => [ 'id' => 'Kategori', 'en' => 'Category' ],
		'related_projects' => [ 'id' => 'Project terkait', 'en' => 'Related Projects' ],
		'article_cta_title' => [ 'id' => 'Lanjutkan mencari hunian', 'en' => 'Continue exploring homes' ],
		'article_cta_text' => [ 'id' => 'Jelajahi Project Marison untuk menemukan pilihan hunian yang sesuai dengan kebutuhan Anda.', 'en' => 'Explore Marison Projects to find housing options that fit your needs.' ],
		'view_housing' => [ 'id' => 'Lihat semua perumahan', 'en' => 'Explore all housing' ],
	];
	return translate( $labels[ $key ][ $english ? 'en' : 'id' ] ?? '', 'marison' );
}

function marison_render_article_archive_copy( array $attributes ): string {
	$variant = sanitize_key( $attributes['variant'] ?? 'intro' );
	if ( ! in_array( $variant, [ 'intro', 'empty', 'cta' ], true ) ) {
		$variant = 'intro';
	}
	if ( 'empty' === $variant ) {
		return '<div class="marison-article-empty" role="status"><h2>' . esc_html( marison_article_label( 'empty_title' ) ) . '</h2><p>' . esc_html( marison_article_label( 'empty_text' ) ) . '</p></div>';
	}
	if ( 'cta' === ( $attributes['variant'] ?? '' ) ) {
		return '<section class="marison-article-cta marison-surface--dark"><h2>' . esc_html( marison_article_label( 'article_cta_title' ) ) . '</h2><p>' . esc_html( marison_article_label( 'article_cta_text' ) ) . '</p><p>' . marison_render_navigation_link( [ 'label_key' => 'search', 'path' => '/perumahan/', 'variant' => 'button' ] ) . '</p></section>';
	}

	return '<section class="marison-article-archive-intro"><p class="marison-article-eyebrow">' . esc_html( marison_article_label( 'archive_title' ) ) . '</p><h1>' . esc_html( marison_article_label( 'archive_title' ) ) . '</h1><p class="marison-article-archive-intro__lead">' . esc_html( marison_article_label( 'archive_intro' ) ) . '</p></section>';
}

function marison_render_article_card(): string {
	$post = get_post();
	if ( ! $post || 'post' !== $post->post_type ) {
		return '';
	}

	$title = get_the_title( $post );
	$url = get_permalink( $post );
	$image_id = get_post_thumbnail_id( $post );
	if ( $image_id ) {
		$image = wp_get_attachment_image( $image_id, 'medium_large', false, [ 'class' => 'marison-image--editorial', 'loading' => 'lazy' ] );
	} else {
		$image = '<div class="marison-image--editorial marison-image--fallback" role="img" aria-label="' . esc_attr( $title ) . '"><span aria-hidden="true">Marison</span></div>';
	}

	return '<article class="marison-card marison-article-card">' . $image . '<div class="marison-card__content"><p class="marison-article-card__date"><time datetime="' . esc_attr( get_the_date( DATE_W3C, $post ) ) . '">' . esc_html( get_the_date( '', $post ) ) . '</time></p><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 26 ) ) . '</p><p><a href="' . esc_url( $url ) . '">' . esc_html( 'en' === marison_article_language() ? 'Read article' : 'Baca artikel' ) . '</a></p></div></article>';
}

function marison_render_article_meta(): string {
	$post = get_post();
	if ( ! $post || 'post' !== $post->post_type ) {
		return '';
	}

	$parts = [ '<span><span class="screen-reader-text">' . esc_html( marison_article_label( 'published' ) ) . ': </span><time datetime="' . esc_attr( get_the_date( DATE_W3C, $post ) ) . '">' . esc_html( get_the_date( '', $post ) ) . '</time></span>' ];
	$categories = get_the_category( $post->ID );
	if ( $categories && ! is_wp_error( $categories ) ) {
		$parts[] = '<span><span class="screen-reader-text">' . esc_html( marison_article_label( 'category' ) ) . ': </span>' . esc_html( $categories[0]->name ) . '</span>';
	}

	return '<div class="marison-article-meta">' . implode( '<span aria-hidden="true">·</span>', $parts ) . '</div>';
}

function marison_render_article_featured_image(): string {
	$post = get_post();
	if ( ! $post || 'post' !== $post->post_type ) {
		return '';
	}

	$image_id = get_post_thumbnail_id( $post );
	if ( $image_id ) {
		return '<figure class="marison-article-featured-image">' . wp_get_attachment_image( $image_id, 'large', false, [ 'loading' => 'eager' ] ) . '</figure>';
	}

	return '<div class="marison-article-featured-image marison-image--fallback" role="img" aria-label="' . esc_attr( get_the_title( $post ) ) . '"><span aria-hidden="true">Marison</span></div>';
}

function marison_render_article_related_projects(): string {
	$post = get_post();
	$read_model = '\\Marison\\Core\\Presentation\\Article';
	$projects = $post && class_exists( $read_model ) ? $read_model::related_projects( $post->ID, marison_article_language() ) : [];
	if ( ! $projects ) {
		return '';
	}

	$output = '<section class="marison-article-related-projects" aria-labelledby="marison-article-related-projects-heading"><h2 id="marison-article-related-projects-heading">' . esc_html( marison_article_label( 'related_projects' ) ) . '</h2><div class="marison-foundation-grid">';
	foreach ( $projects as $project ) {
		$output .= marison_render_project_card( $project );
	}
	return $output . '</div></section>';
}

function marison_render_navigation_link( array $attributes ): string {
	$keys = [
		'housing' => [ 'id' => 'Perumahan', 'en' => 'Housing' ],
		'kpr' => [ 'id' => 'KPR', 'en' => 'KPR' ],
		'articles' => [ 'id' => 'Artikel', 'en' => 'Articles' ],
		'about' => [ 'id' => 'Tentang Kami', 'en' => 'About' ],
		'careers' => [ 'id' => 'Karier', 'en' => 'Careers' ],
		'search' => [ 'id' => 'Cari Rumah', 'en' => 'Find a Home' ],
		'contact' => [ 'id' => 'Kontak', 'en' => 'Contact' ],
		'privacy' => [ 'id' => 'Kebijakan Privasi', 'en' => 'Privacy Notice' ],
	];
	$key = sanitize_key( $attributes['label_key'] ?? '' );
	$language = class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id';
	$label = $keys[ $key ][ 'en' === $language ? 'en' : 'id' ] ?? sanitize_text_field( $attributes['label_key'] ?? '' );
	$path = sanitize_text_field( $attributes['path'] ?? '/' );
	if ( 'privacy' === $key ) {
		$url = marison_privacy_url();
		return $url ? '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>' : '';
	}
	$url = class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::localized_url( $path ) : home_url( $path );
	if ( '/karier/' === trailingslashit( $path ) && is_singular( 'marison_career' ) && class_exists( '\\Marison\\Core\\Presentation\\Career' ) ) {
		$career = \Marison\Core\Presentation\Career::detail_state( get_queried_object_id() );
		if ( $career ) {
			$language = (string) ( $career['language'] ?? $language );
			$label = 'en' === $language ? 'Careers' : 'Karier';
			$url = (string) ( $career['careers_url'] ?? $url );
		}
	}
	$variant = 'button' === ( $attributes['variant'] ?? '' ) ? ' class="wp-block-button__link wp-element-button"' : '';
	return '<a href="' . esc_url( $url ) . '"' . $variant . '>' . esc_html( $label ) . '</a>';
}

function marison_kpr_page_view(): array {
	$class = '\\Marison\\Core\\Presentation\\KprPage';
	return class_exists( $class ) ? $class::view() : [
		'state'            => 'UNAVAILABLE',
		'available'        => false,
		'calculator_state' => 'UNAVAILABLE',
		'scheme'           => null,
		'editorial'        => [
			'title'      => [ 'state' => 'NOT_CONFIGURED', 'text' => '', 'fallback' => false ],
			'disclaimer' => [ 'state' => 'NOT_CONFIGURED', 'text' => '', 'fallback' => false ],
		],
	];
}

function marison_kpr_label( string $key ): string {
	$english = class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) && 'en' === \Marison\Core\Multilingual\Resolver::current_language();
	$labels  = [
		'simulation_status'      => [ 'id' => 'Status simulasi', 'en' => 'Simulation status' ],
		'unavailable'            => [ 'id' => 'Simulasi belum tersedia', 'en' => 'Simulation is not available yet' ],
		'no_default'             => [ 'id' => 'Belum ada konfigurasi KPR publik yang dapat digunakan.', 'en' => 'No eligible public KPR configuration is available.' ],
		'invalid_default'        => [ 'id' => 'Konfigurasi KPR publik belum lengkap atau tidak valid.', 'en' => 'The public KPR configuration is incomplete or invalid.' ],
		'inactive_default'       => [ 'id' => 'Konfigurasi KPR publik sedang tidak aktif.', 'en' => 'The public KPR configuration is inactive.' ],
		'not_implemented'        => [ 'id' => 'Konfigurasi tersedia, tetapi rumus simulasi belum diimplementasikan.', 'en' => 'Configuration is available, but the simulation formula is not implemented.' ],
		'configuration'          => [ 'id' => 'Konfigurasi publik', 'en' => 'Public configuration' ],
		'scheme_title'           => [ 'id' => 'Nama konfigurasi', 'en' => 'Configuration name' ],
		'annual_rate'            => [ 'id' => 'Asumsi bunga tahunan terkonfigurasi', 'en' => 'Configured annual rate assumption' ],
		'tenures'                => [ 'id' => 'Tenure tersedia', 'en' => 'Available tenure' ],
		'default_dp'             => [ 'id' => 'Asumsi DP default', 'en' => 'Default DP assumption' ],
		'effective_date'         => [ 'id' => 'Tanggal efektif', 'en' => 'Effective date' ],
		'disclaimer'             => [ 'id' => 'Disclaimer konfigurasi', 'en' => 'Configured disclaimer' ],
		'no_disclaimer'          => [ 'id' => 'Belum ada disclaimer konfigurasi yang tersedia.', 'en' => 'No configured scheme disclaimer is available.' ],
		'missing_editorial'      => [ 'id' => 'Teks editorial Indonesia ditampilkan karena terjemahan bahasa Inggris belum dikonfigurasi.', 'en' => 'Indonesian editorial text is shown because an English translation is not configured.' ],
		'years'                  => [ 'id' => '%d tahun', 'en' => '%d years' ],
		'months'                => [ 'id' => '%d bulan', 'en' => '%d months' ],
	];
	$label = $labels[ $key ][ $english ? 'en' : 'id'] ?? '';
	return translate( $label, 'marison' );
}

function marison_render_kpr_status(): string {
	$view = marison_kpr_page_view();
	$id   = 'marison-kpr-status-heading';
	$out  = '<section class="marison-kpr-status marison-kpr-status--' . esc_attr( strtolower( sanitize_key( (string) $view['state'] ) ) ) . '" aria-labelledby="' . esc_attr( $id ) . '">';
	$out .= '<p class="marison-kpr-status__eyebrow">KPR</p><h2 id="' . esc_attr( $id ) . '">' . esc_html( marison_kpr_label( 'simulation_status' ) ) . '</h2>';

	if ( ! $view['available'] ) {
		$state_key = sanitize_key( strtolower( (string) $view['state'] ) );
		$reason    = marison_kpr_label( 'invalid_default' );
		if ( 'no_default' === $state_key ) {
			$reason = marison_kpr_label( 'no_default' );
		} elseif ( 'inactive_default' === $state_key ) {
			$reason = marison_kpr_label( 'inactive_default' );
		}
		$out .= '<p class="marison-kpr-status__state">' . esc_html( marison_kpr_label( 'unavailable' ) ) . '</p><p>' . esc_html( $reason ) . '</p></section>';
		return $out;
	}

	$out .= '<p class="marison-kpr-status__state">' . esc_html( marison_kpr_label( 'unavailable' ) ) . '</p><p>' . esc_html( marison_kpr_label( 'not_implemented' ) ) . '</p>';
	$out .= '<div class="marison-kpr-status__configuration"><h3>' . esc_html( marison_kpr_label( 'configuration' ) ) . '</h3>';
	$editorial = $view['editorial'];
	$title     = $editorial['title'];
	if ( '' !== (string) $title['text'] ) {
		$out .= '<dl><dt>' . esc_html( marison_kpr_label( 'scheme_title' ) ) . '</dt><dd>' . esc_html( $title['text'] ) . '</dd></dl>';
		if ( ! empty( $title['fallback'] ) ) {
			$out .= '<p class="marison-kpr-status__translation-note">' . esc_html( marison_kpr_label( 'missing_editorial' ) ) . '</p>';
		}
	}

	$scheme = $view['scheme'];
	$out   .= '<dl class="marison-kpr-status__facts">';
	if ( '' !== (string) $scheme['annual_rate_percent_points'] ) {
		$out .= '<div><dt>' . esc_html( marison_kpr_label( 'annual_rate' ) ) . '</dt><dd>' . esc_html( $scheme['annual_rate_percent_points'] . '%' ) . '</dd></div>';
	}
	if ( $scheme['tenure_options'] ) {
		$out .= '<div><dt>' . esc_html( marison_kpr_label( 'tenures' ) ) . '</dt><dd><ul>';
		foreach ( $scheme['tenure_options'] as $tenure ) {
			$label = null !== $tenure['years'] ? sprintf( marison_kpr_label( 'years' ), (int) $tenure['years'] ) : sprintf( marison_kpr_label( 'months' ), (int) $tenure['months'] );
			$out  .= '<li>' . esc_html( $label ) . '</li>';
		}
		$out .= '</ul></dd></div>';
	}
	if ( '' !== (string) $scheme['default_dp_percent'] ) {
		$out .= '<div><dt>' . esc_html( marison_kpr_label( 'default_dp' ) ) . '</dt><dd>' . esc_html( $scheme['default_dp_percent'] . '%' ) . '</dd></div>';
	}
	if ( '' !== (string) $scheme['effective_date'] ) {
		$out .= '<div><dt>' . esc_html( marison_kpr_label( 'effective_date' ) ) . '</dt><dd>' . esc_html( $scheme['effective_date'] ) . '</dd></div>';
	}
	$out .= '</dl></div>';

	$disclaimer = $editorial['disclaimer'];
	$out        .= '<aside class="marison-kpr-status__disclaimer"><h3>' . esc_html( marison_kpr_label( 'disclaimer' ) ) . '</h3>';
	if ( '' !== (string) $disclaimer['text'] ) {
		$out .= '<p>' . nl2br( esc_html( $disclaimer['text'] ) ) . '</p>';
		if ( ! empty( $disclaimer['fallback'] ) ) {
			$out .= '<p class="marison-kpr-status__translation-note">' . esc_html( marison_kpr_label( 'missing_editorial' ) ) . '</p>';
		}
	} else {
		$out .= '<p>' . esc_html( marison_kpr_label( 'no_disclaimer' ) ) . '</p>';
	}
	return $out . '</aside></section>';
}
