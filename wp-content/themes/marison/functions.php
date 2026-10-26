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
	static function (): void {
		register_block_type( 'marison/homepage-featured-projects', [ 'render_callback' => 'marison_render_homepage_featured_projects' ] );
		register_block_type( 'marison/homepage-locations', [ 'render_callback' => 'marison_render_homepage_locations' ] );
		register_block_type( 'marison/homepage-articles', [ 'render_callback' => 'marison_render_homepage_articles' ] );
		register_block_type( 'marison/housing-directory', [ 'render_callback' => 'marison_render_housing_directory' ] );
		register_block_type( 'marison/project-detail', [ 'render_callback' => 'marison_render_project_detail' ] );
		register_block_type( 'marison/navigation-link', [ 'render_callback' => 'marison_render_navigation_link', 'attributes' => [ 'label_key' => [ 'type' => 'string' ], 'path' => [ 'type' => 'string' ], 'variant' => [ 'type' => 'string' ] ] ] );
	}
);

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

function marison_render_navigation_link( array $attributes ): string {
	$keys = [
		'housing' => [ 'id' => 'Perumahan', 'en' => 'Housing' ],
		'kpr' => [ 'id' => 'KPR', 'en' => 'KPR' ],
		'articles' => [ 'id' => 'Artikel', 'en' => 'Articles' ],
		'about' => [ 'id' => 'Tentang Kami', 'en' => 'About' ],
		'careers' => [ 'id' => 'Karier', 'en' => 'Careers' ],
		'search' => [ 'id' => 'Cari Rumah', 'en' => 'Find a Home' ],
		'contact' => [ 'id' => 'Kontak', 'en' => 'Contact' ],
	];
	$key = sanitize_key( $attributes['label_key'] ?? '' );
	$language = class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id';
	$label = $keys[ $key ][ 'en' === $language ? 'en' : 'id' ] ?? sanitize_text_field( $attributes['label_key'] ?? '' );
	$path = sanitize_text_field( $attributes['path'] ?? '/' );
	$url = class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::localized_url( $path ) : home_url( $path );
	$variant = 'button' === ( $attributes['variant'] ?? '' ) ? ' class="wp-block-button__link wp-element-button"' : '';
	return '<a href="' . esc_url( $url ) . '"' . $variant . '>' . esc_html( $label ) . '</a>';
}
