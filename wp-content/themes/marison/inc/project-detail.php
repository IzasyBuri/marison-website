<?php
/**
 * Project Detail dynamic presentation.
 *
 * @package Marison
 */

defined( 'ABSPATH' ) || exit;

function marison_project_detail_read_model(): ?string {
	$class = '\\Marison\\Core\\Presentation\\ProjectDetail';
	return class_exists( $class ) ? $class : null;
}

function marison_project_detail_is_english(): bool {
	global $marison_project_detail_language;
	$language = $marison_project_detail_language ?? ( class_exists( '\\Marison\\Core\\Multilingual\\Resolver' ) ? \Marison\Core\Multilingual\Resolver::current_language() : 'id' );
	return 'en' === $language;
}

function marison_project_detail_label( string $key ): string {
	$labels = [
		'back' => [ 'id' => 'Kembali ke Perumahan', 'en' => 'Back to Housing' ],
		'status' => [ 'id' => 'Status Project', 'en' => 'Project status' ],
		'overview' => [ 'id' => 'Tentang Project', 'en' => 'About the Project' ],
		'house_types' => [ 'id' => 'Tipe Rumah', 'en' => 'House Types' ],
		'house_types_intro' => [ 'id' => 'Pilihan tipe rumah yang dikonfigurasi untuk Project ini.', 'en' => 'House types configured for this Project.' ],
		'house_type_missing' => [ 'id' => 'Detail tipe rumah belum tersedia.', 'en' => 'House type details are not available yet.' ],
		'house_type_detail' => [ 'id' => 'Lihat detail', 'en' => 'View details' ],
		'building_area' => [ 'id' => 'Luas bangunan', 'en' => 'Building area' ],
		'land_area' => [ 'id' => 'Luas tanah', 'en' => 'Land area' ],
		'bedrooms' => [ 'id' => 'Kamar tidur', 'en' => 'Bedrooms' ],
		'bathrooms' => [ 'id' => 'Kamar mandi', 'en' => 'Bathrooms' ],
		'floors' => [ 'id' => 'Lantai', 'en' => 'Floors' ],
		'availability' => [ 'id' => 'Ketersediaan Unit', 'en' => 'Unit Availability' ],
		'availability_units' => [ 'id' => 'Data berasal dari Unit individual.', 'en' => 'Data comes from individual Units.' ],
		'availability_manual' => [ 'id' => 'Ringkasan manual — perlu konfirmasi melalui Branch.', 'en' => 'Manual summary — confirmation through the Branch is recommended.' ],
		'availability_unavailable' => [ 'id' => 'Detail availability belum tersedia.', 'en' => 'Availability details are not available yet.' ],
		'availability_incomplete' => [ 'id' => 'Ringkasan manual belum lengkap. Hubungi Branch untuk konfirmasi.', 'en' => 'The manual summary is incomplete. Contact the Branch for confirmation.' ],
		'confirm' => [ 'id' => 'Status dapat memerlukan konfirmasi melalui Branch.', 'en' => 'Status may require confirmation through the Branch.' ],
		'unit_list' => [ 'id' => 'Unit yang tercatat', 'en' => 'Recorded Units' ],
		'facilities' => [ 'id' => 'Fasilitas', 'en' => 'Facilities' ],
		'progress' => [ 'id' => 'Progress Project', 'en' => 'Project progress' ],
		'location' => [ 'id' => 'Lokasi Project', 'en' => 'Project location' ],
		'province' => [ 'id' => 'Province', 'en' => 'Province' ],
		'city' => [ 'id' => 'City / Regency', 'en' => 'City / Regency' ],
		'related' => [ 'id' => 'Artikel terkait', 'en' => 'Related articles' ],
		'related_translation_missing' => [ 'id' => 'Menampilkan artikel Indonesia.', 'en' => 'Indonesian article shown.' ],
		'kpr' => [ 'id' => 'Pelajari KPR', 'en' => 'Learn about KPR' ],
		'kpr_available' => [ 'id' => 'Simulasi KPR tersedia di halaman KPR.', 'en' => 'KPR simulation support is available on the KPR page.' ],
		'kpr_unavailable' => [ 'id' => 'Edukasi KPR tetap tersedia; simulasi belum aktif.', 'en' => 'KPR education is available; simulation is not active yet.' ],
		'contact' => [ 'id' => 'Hubungi Branch untuk Project ini', 'en' => 'Contact the Branch for this Project' ],
		'contact_context' => [ 'id' => 'Jalur resmi Marison untuk pertanyaan mengenai Project ini.', 'en' => 'Marison’s official contact path for questions about this Project.' ],
		'contact_unavailable' => [ 'id' => 'Kontak Project belum tersedia saat ini.', 'en' => 'Project contact is not available at this time.' ],
		'contact_unavailable_help' => [ 'id' => 'Kami belum dapat mengonfirmasi jalur Branch untuk Project ini.', 'en' => 'We cannot confirm a Branch contact path for this Project yet.' ],
		'translation_missing' => [ 'id' => 'Menampilkan presentasi Indonesia.', 'en' => 'Indonesian presentation shown.' ],
		'whatsapp' => [ 'id' => 'Chat WhatsApp', 'en' => 'Chat on WhatsApp' ],
		'telephone' => [ 'id' => 'Telepon Project', 'en' => 'Call the Project' ],
		'fallback' => [ 'id' => 'Hubungi Marison', 'en' => 'Contact Marison' ],
		'email' => [ 'id' => 'Email Marison', 'en' => 'Email Marison' ],
		'availability_action' => [ 'id' => 'Lihat Ketersediaan', 'en' => 'See availability' ],
		'next' => [ 'id' => 'Berikutnya', 'en' => 'Next' ],
		'previous' => [ 'id' => 'Sebelumnya', 'en' => 'Previous' ],
		'unit_pagination' => [ 'id' => 'Navigasi Unit Project', 'en' => 'Project Unit navigation' ],
	];
	$language = marison_project_detail_is_english() ? 'en' : 'id';
	return $labels[ $key ][ $language ] ?? '';
}

function marison_project_detail_media( int $image_id, string $class, string $alt, string $loading = 'lazy' ): string {
	if ( ! $image_id ) {
		return '<div class="marison-project-detail__image marison-image--fallback ' . esc_attr( $class ) . '" role="img" aria-label="' . esc_attr( $alt ) . '"><span aria-hidden="true">Marison</span></div>';
	}

	return wp_get_attachment_image( $image_id, 'large', false, [ 'class' => $class, 'alt' => $alt, 'loading' => $loading ] );
}

function marison_project_detail_contact_action( array $contact, bool $primary = false ): string {
	$channel = sanitize_key( (string) ( $contact['channel'] ?? 'unavailable' ) );
	$url = (string) ( $contact['url'] ?? '' );
	if ( ! $url || 'unavailable' === $channel ) {
		return '';
	}

	$key = 'whatsapp' === $channel ? 'whatsapp' : ( 'telephone' === $channel ? 'telephone' : ( 'email' === $channel ? 'email' : 'fallback' ) );
	$label = marison_project_detail_label( $key );
	$class = $primary ? ' marison-button--primary' : ' marison-button--secondary';
	$external = 'whatsapp' === $channel ? ' target="_blank" rel="noopener"' : '';
	return '<a class="marison-button' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '"' . $external . '>' . esc_html( $label ) . '</a>';
}

function marison_project_detail_status_markup( string $status, string $label ): string {
	$class = sanitize_html_class( 'marison-status--project-' . $status );
	return '<span class="marison-status ' . esc_attr( $class ) . '">' . esc_html( $label ) . '</span>';
}

function marison_project_detail_value( $value, string $suffix = '' ): string {
	return null === $value ? '' : esc_html( number_format_i18n( (float) $value ) . $suffix );
}

function marison_project_detail_render_house_type( array $house_type ): string {
	$meta = [];
	$fields = [
		'building_area' => [ 'label' => marison_project_detail_label( 'building_area' ), 'suffix' => ' m²' ],
		'land_area' => [ 'label' => marison_project_detail_label( 'land_area' ), 'suffix' => ' m²' ],
		'bedrooms' => [ 'label' => marison_project_detail_label( 'bedrooms' ), 'suffix' => '' ],
		'bathrooms' => [ 'label' => marison_project_detail_label( 'bathrooms' ), 'suffix' => '' ],
		'floors' => [ 'label' => marison_project_detail_label( 'floors' ), 'suffix' => '' ],
	];
	foreach ( $fields as $key => $field ) {
		if ( null !== ( $house_type[ $key ] ?? null ) ) {
			$meta[] = '<div><dt>' . esc_html( $field['label'] ) . '</dt><dd>' . marison_project_detail_value( $house_type[ $key ], $field['suffix'] ) . '</dd></div>';
		}
	}
	$description = (string) ( $house_type['description_html'] ?? '' );
	$translation_note = 'MISSING' === ( $house_type['translation_state'] ?? '' ) ? '<p class="marison-project-detail__translation-note">' . esc_html( marison_project_detail_label( 'house_type_missing' ) ) . '</p>' : '';
	$output = '<details class="marison-project-detail__house-type"><summary><span class="marison-project-detail__house-type-summary"><span class="marison-project-detail__house-type-title">' . esc_html( $house_type['title'] ?? '' ) . '</span><span class="marison-project-detail__house-type-link">' . esc_html( marison_project_detail_label( 'house_type_detail' ) ) . '</span></span>';
	if ( ! empty( $house_type['image_id'] ) ) {
		$output .= marison_project_detail_media( (int) $house_type['image_id'], 'marison-project-detail__house-type-image', (string) ( $house_type['title'] ?? '' ) );
	}
	$output .= '<dl class="marison-project-detail__specs">' . implode( '', $meta ) . '</dl></summary>';
	$output .= '<div class="marison-project-detail__house-type-details">' . $translation_note . ( $description ? $description : '' ) . '</div></details>';
	return $output;
}

function marison_project_detail_render_availability( array $data ): string {
	$availability = $data['availability'] ?? [];
	$state = (string) ( $availability['state'] ?? 'unavailable' );
	$mode = (string) ( $availability['mode'] ?? 'unavailable' );
	$output = '<section id="availability" class="marison-project-detail__section marison-project-detail__availability marison-surface--sage" aria-labelledby="marison-project-detail-availability-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'availability' ) ) . '</p><h2 id="marison-project-detail-availability-heading">' . esc_html( marison_project_detail_label( 'availability' ) ) . '</h2>';
	if ( 'manual_incomplete' === $state ) {
		return $output . '<p class="marison-project-detail__notice" role="status">' . esc_html( marison_project_detail_label( 'availability_incomplete' ) ) . '</p></div></section>';
	}
	if ( 'active' !== $state ) {
		return $output . '<p class="marison-project-detail__notice" role="status">' . esc_html( marison_project_detail_label( 'availability_unavailable' ) ) . '</p></div></section>';
	}
	$source_label = 'units' === $mode ? marison_project_detail_label( 'availability_units' ) : marison_project_detail_label( 'availability_manual' );
	$output .= '<p class="marison-project-detail__source-note">' . esc_html( $source_label ) . '</p><dl class="marison-project-detail__availability-summary">';
	foreach ( [ 'available', 'booked', 'sold' ] as $status ) {
		$output .= '<div class="marison-project-detail__availability-item"><dt><span class="marison-status marison-status--unit-' . esc_attr( $status ) . '">' . esc_html( $data['availability'][ $status ] ?? 0 ) . '</span></dt><dd>' . esc_html( marison_project_detail_unit_label( $status ) ) . '</dd></div>';
	}
	$output .= '</dl><p class="marison-project-detail__supporting-note">' . esc_html( marison_project_detail_label( 'confirm' ) ) . '</p>';
	$units = $data['units'] ?? [];
	if ( 'units' === $mode && $units ) {
		$output .= '<div class="marison-project-detail__unit-list"><h3>' . esc_html( marison_project_detail_label( 'unit_list' ) ) . '</h3><ul>';
		foreach ( $units as $unit ) {
			$output .= '<li><span><strong>' . esc_html( $unit['identifier'] ) . '</strong>' . ( $unit['house_type_name'] ? ' <span class="marison-project-detail__unit-type">' . esc_html( $unit['house_type_name'] ) . '</span>' : '' ) . '</span><span class="marison-status marison-status--unit-' . esc_attr( $unit['status'] ) . '">' . esc_html( $unit['status_label'] ) . '</span></li>';
		}
		$output .= '</ul></div>';
	}
	if ( 'units' === $mode && ! empty( $data['unit_pages'] ) && $data['unit_pages'] > 1 ) {
		$output .= '<nav class="marison-project-detail__unit-pagination" aria-label="' . esc_attr( marison_project_detail_label( 'unit_pagination' ) ) . '"><ul>';
		for ( $page = 1; $page <= (int) $data['unit_pages']; $page++ ) {
			$url = add_query_arg( 'unit_page', $page, (string) $data['url'] );
			$current = $page === (int) $data['unit_page'] ? ' aria-current="page"' : '';
			$output .= '<li><a href="' . esc_url( $url ) . '"' . $current . '>' . esc_html( $page ) . '</a></li>';
		}
		$output .= '</ul></nav>';
	}
	return $output . '</div></section>';
}

function marison_project_detail_unit_label( string $status ): string {
	$class = marison_project_detail_read_model();
	return $class ? $class::unit_status_label( $status, marison_project_detail_is_english() ? 'en' : 'id' ) : $status;
}

function marison_render_project_detail(): string {
	$class = marison_project_detail_read_model();
	$data = $class ? $class::view( get_queried_object_id() ) : [];
	if ( ! $data ) {
		return '';
	}
	global $marison_project_detail_language;
	$marison_project_detail_language = $data['language'] ?? 'id';

	$title = (string) ( $data['title'] ?? '' );
	$contact = (array) ( $data['contact'] ?? [] );
	$contact_action = marison_project_detail_contact_action( $contact, true );
	$availability_action = '<a class="marison-button marison-button--secondary" href="#availability">' . esc_html( marison_project_detail_label( 'availability_action' ) ) . '</a>';
	$output = '<div class="marison-project-detail" data-project-detail data-contact-channel="' . esc_attr( $contact['channel'] ?? 'unavailable' ) . '">';
	$output .= '<nav class="marison-project-detail__breadcrumbs" aria-label="Breadcrumb"><ol>';
	foreach ( (array) ( $data['breadcrumbs'] ?? [] ) as $crumb ) {
		$output .= '<li>' . ( $crumb['url'] ? '<a href="' . esc_url( $crumb['url'] ) . '">' . esc_html( $crumb['label'] ) . '</a>' : '<span aria-current="page">' . esc_html( $crumb['label'] ) . '</span>' ) . '</li>';
	}
	$output .= '</ol></nav>';
	$output .= '<section class="marison-project-detail__hero" data-project-hero aria-labelledby="marison-project-detail-title"><div class="marison-project-detail__hero-media">' . marison_project_detail_media( (int) ( $data['featured_image_id'] ?? 0 ), 'marison-project-detail__hero-image', $title, 'eager' ) . '</div><div class="marison-project-detail__hero-content">' . marison_project_detail_status_markup( (string) $data['status'], (string) $data['status_label'] ) . '<h1 id="marison-project-detail-title">' . esc_html( $title ) . '</h1><p class="marison-project-detail__location">' . esc_html( $data['location']['city'] ?? '' ) . '</p><p class="marison-project-detail__summary">' . esc_html( $data['summary'] ?? '' ) . '</p><div class="marison-project-detail__actions">' . $contact_action . $availability_action . '</div>';
	if ( 'MISSING' === ( $data['translation_state'] ?? '' ) ) {
		$output .= '<p class="marison-project-detail__translation-note">' . esc_html( marison_project_detail_label( 'translation_missing' ) ) . '</p>';
	}
	$output .= '</div></section>';
	$output .= '<section class="marison-project-detail__quick-summary" aria-label="' . esc_attr( marison_project_detail_label( 'status' ) ) . '"><dl><div><dt>' . esc_html( marison_project_detail_label( 'status' ) ) . '</dt><dd>' . marison_project_detail_status_markup( (string) $data['status'], (string) $data['status_label'] ) . '</dd></div><div><dt>' . esc_html( marison_project_detail_label( 'city' ) ) . '</dt><dd>' . esc_html( $data['location']['city'] ?? '' ) . '</dd></div><div><dt>' . esc_html( marison_project_detail_label( 'availability' ) ) . '</dt><dd>' . esc_html( 'units' === ( $data['availability']['mode'] ?? '' ) ? marison_project_detail_label( 'availability_units' ) : ( 'manual' === ( $data['availability']['mode'] ?? '' ) ? marison_project_detail_label( 'availability_manual' ) : marison_project_detail_label( 'availability_unavailable' ) ) ) . '</dd></div></dl></section>';
	if ( ! empty( $data['content_html'] ) ) {
		$output .= '<section class="marison-project-detail__section marison-project-detail__overview" aria-labelledby="marison-project-detail-overview-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'overview' ) ) . '</p><h2 id="marison-project-detail-overview-heading">' . esc_html( marison_project_detail_label( 'overview' ) ) . '</h2><div class="marison-project-detail__content">' . $data['content_html'] . '</div></div></section>';
	}
	$house_types = (array) ( $data['house_types'] ?? [] );
	$output .= '<section class="marison-project-detail__section marison-project-detail__house-types" aria-labelledby="marison-project-detail-house-types-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'house_types' ) ) . '</p><h2 id="marison-project-detail-house-types-heading">' . esc_html( marison_project_detail_label( 'house_types' ) ) . '</h2><p>' . esc_html( marison_project_detail_label( 'house_types_intro' ) ) . '</p>';
	if ( $house_types ) {
		$output .= '<div class="marison-project-detail__house-type-grid">';
		foreach ( $house_types as $house_type ) {
			$output .= marison_project_detail_render_house_type( $house_type );
		}
		$output .= '</div>';
	} else {
		$output .= '<p class="marison-project-detail__notice">' . esc_html( marison_project_detail_label( 'house_type_missing' ) ) . '</p>';
	}
	$output .= '</div></section>' . marison_project_detail_render_availability( $data );
	if ( ! empty( $data['facilities'] ) ) {
		$output .= '<section class="marison-project-detail__section" aria-labelledby="marison-project-detail-facilities-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'facilities' ) ) . '</p><h2 id="marison-project-detail-facilities-heading">' . esc_html( marison_project_detail_label( 'facilities' ) ) . '</h2><ul class="marison-project-detail__facility-list">';
		foreach ( $data['facilities'] as $facility ) {
			$output .= '<li>' . esc_html( $facility['name'] ) . '</li>';
		}
		$output .= '</ul></div></section>';
	}
	if ( null !== ( $data['progress']['percentage'] ?? null ) ) {
		$output .= '<section class="marison-project-detail__section" aria-labelledby="marison-project-detail-progress-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'progress' ) ) . '</p><h2 id="marison-project-detail-progress-heading">' . esc_html( marison_project_detail_label( 'progress' ) ) . '</h2><div class="marison-project-detail__progress-row"><progress max="100" value="' . esc_attr( $data['progress']['percentage'] ) . '">' . esc_html( $data['progress']['percentage'] ) . '%</progress><strong>' . esc_html( $data['progress']['percentage'] . '%' ) . '</strong></div>' . ( $data['progress']['description'] ? '<p>' . esc_html( $data['progress']['description'] ) . '</p>' : '' ) . '</div></section>';
	}
	$location = $data['location'] ?? [];
	$output .= '<section class="marison-project-detail__section marison-project-detail__location-section" aria-labelledby="marison-project-detail-location-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'location' ) ) . '</p><h2 id="marison-project-detail-location-heading">' . esc_html( marison_project_detail_label( 'location' ) ) . '</h2><div class="marison-project-detail__location-grid"><div><p><strong>' . esc_html( $location['city'] ?? '' ) . '</strong>' . ( ! empty( $location['province'] ) ? '<br />' . esc_html( $location['province'] ) : '' ) . '</p>' . ( ! empty( $data['address'] ) ? '<p>' . nl2br( esc_html( $data['address'] ) ) . '</p>' : '' ) . '</div><div class="marison-project-detail__map-placeholder" role="img" aria-label="' . esc_attr( marison_project_detail_label( 'location' ) ) . '"><span>' . esc_html( marison_project_detail_label( 'location' ) ) . '</span></div></div></div></section>';
	if ( ! empty( $data['related_articles'] ) ) {
		$output .= '<section class="marison-project-detail__section" aria-labelledby="marison-project-detail-related-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'related' ) ) . '</p><h2 id="marison-project-detail-related-heading">' . esc_html( marison_project_detail_label( 'related' ) ) . '</h2><div class="marison-project-detail__article-grid">';
		foreach ( $data['related_articles'] as $article ) {
			$output .= '<article class="marison-card marison-project-detail__article-card">' . ( ! empty( $article['image_id'] ) ? marison_project_detail_media( (int) $article['image_id'], 'marison-image--editorial', (string) $article['title'] ) : '' ) . '<div class="marison-card__content"><h3><a href="' . esc_url( $article['url'] ) . '">' . esc_html( $article['title'] ) . '</a></h3><p>' . esc_html( $article['excerpt'] ) . '</p>' . ( 'MISSING' === ( $article['translation_state'] ?? '' ) ? '<p class="marison-project-detail__translation-note">' . esc_html( marison_project_detail_label( 'related_translation_missing' ) ) . '</p>' : '' ) . '</div></article>';
		}
		$output .= '</div></div></section>';
	}
	$output .= '<section class="marison-project-detail__section marison-project-detail__kpr" aria-labelledby="marison-project-detail-kpr-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">KPR</p><h2 id="marison-project-detail-kpr-heading">' . esc_html( marison_project_detail_label( 'kpr' ) ) . '</h2><p>' . esc_html( $data['kpr']['available'] ? marison_project_detail_label( 'kpr_available' ) : marison_project_detail_label( 'kpr_unavailable' ) ) . '</p><a class="marison-button marison-button--secondary" href="' . esc_url( $data['kpr']['url'] ) . '">' . esc_html( marison_project_detail_label( 'kpr' ) ) . '</a></div></section>';
	$output .= '<section id="project-contact" class="marison-project-detail__section marison-project-detail__contact" data-project-contact aria-labelledby="marison-project-detail-contact-heading"><div class="marison-project-detail__section-inner"><p class="marison-project-detail__eyebrow">' . esc_html( marison_project_detail_label( 'contact' ) ) . '</p><h2 id="marison-project-detail-contact-heading">' . esc_html( marison_project_detail_label( 'contact' ) ) . '</h2><p>' . esc_html( marison_project_detail_label( 'contact_context' ) ) . '</p><p><strong>' . esc_html( $contact['branch_name'] ?? '' ) . '</strong></p><div class="marison-project-detail__actions">' . $contact_action . '</div>';
	if ( ! empty( $contact['value'] ) && 'unavailable' !== ( $contact['channel'] ?? '' ) ) {
		$output .= '<p class="marison-project-detail__contact-value">' . esc_html( $contact['value'] ) . '</p>';
	}
	if ( 'fallback' === ( $contact['state'] ?? '' ) ) {
		$output .= '<p class="marison-project-detail__source-note">' . esc_html( marison_project_detail_label( 'fallback' ) ) . '</p>';
	}
	if ( 'unavailable' === ( $contact['channel'] ?? 'unavailable' ) ) {
		$output .= '<div class="marison-project-detail__notice" role="status"><p>' . esc_html( marison_project_detail_label( 'contact_unavailable' ) ) . '</p><p>' . esc_html( marison_project_detail_label( 'contact_unavailable_help' ) ) . '</p></div>';
	}
	$output .= '</div></section>';
	if ( $contact_action ) {
		$output .= '<div class="marison-project-detail__sticky" data-project-sticky hidden><div>' . marison_project_detail_contact_action( $contact, true ) . $availability_action . '</div></div>';
	} else {
		$output .= '<div class="marison-project-detail__sticky" data-project-sticky hidden><div>' . $availability_action . '</div></div>';
	}
	return $output . '</div>';
}
