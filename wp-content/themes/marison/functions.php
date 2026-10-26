<?php
/**
 * Marison theme foundation hooks.
 *
 * @package Marison
 */

defined( 'ABSPATH' ) || exit;

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
	}
);

add_action(
	'init',
	static function (): void {
		register_block_type( 'marison/homepage-featured-projects', [ 'render_callback' => 'marison_render_homepage_featured_projects' ] );
		register_block_type( 'marison/homepage-locations', [ 'render_callback' => 'marison_render_homepage_locations' ] );
		register_block_type( 'marison/homepage-articles', [ 'render_callback' => 'marison_render_homepage_articles' ] );
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
		$status_class = sanitize_html_class( 'marison-status--project-' . $project['status'] );
		$image = $project['image'] ? sprintf( '<img class="marison-image--card" src="%s" alt="%s" loading="lazy" />', esc_url( $project['image'] ), esc_attr( $project['title'] ) ) : '';
		$output .= '<article class="marison-card marison-project-card">' . $image . '<div class="marison-card__content"><p><span class="marison-status ' . esc_attr( $status_class ) . '">' . esc_html( $project['status_label'] ) . '</span></p><h3>' . esc_html( $project['title'] ) . '</h3><p>' . esc_html( $project['location'] ) . '</p><p><a href="' . esc_url( $project['url'] ) . '">' . esc_html__( 'Lihat detail Project', 'marison' ) . '</a></p></div></article>';
	}
	return $output . '</div></div></section>';
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
