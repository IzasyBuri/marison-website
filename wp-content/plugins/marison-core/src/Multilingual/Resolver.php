<?php
/**
 * Canonical/translation lookup boundary.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Multilingual;

defined( 'ABSPATH' ) || exit;

final class Resolver {
	public static function current_language(): string { return Polylang::current_language(); }

	public static function canonical_post_id( int $post_id ): int {
		if ( ! Polylang::available() ) { return absint( $post_id ); }
		$canonical = pll_get_post( absint( $post_id ), Polylang::default_language() );
		return absint( $canonical ?: $post_id );
	}

	public static function translated_post_id( int $post_id, string $language ): int {
		if ( ! Polylang::available() ) { return 0; }
		return absint( pll_get_post( self::canonical_post_id( $post_id ), sanitize_key( $language ) ) );
	}

	public static function translated_term_id( int $term_id, string $taxonomy, string $language ): int {
		if ( ! Polylang::available() || ! function_exists( 'pll_get_term' ) ) { return 0; }
		return absint( pll_get_term( absint( $term_id ), sanitize_key( $language ) ) );
	}

	public static function localized_url( string $path ): string {
		$path = trim( $path, '/' );
		$canonical_url = $path ? home_url( '/' . $path . '/' ) : home_url( '/' );
		if ( ! Polylang::available() || Polylang::current_language() === Polylang::default_language() ) {
			return $canonical_url;
		}

		$page = $path ? get_page_by_path( $path, OBJECT, 'page' ) : null;
		if ( $page ) {
			$translated_id = self::translated_post_id( $page->ID, Polylang::current_language() );
			if ( $translated_id ) {
				return (string) get_permalink( $translated_id );
			}
		}

		return $canonical_url;
	}

	public static function translation_state( int $post_id, string $language ): array {
		$canonical = self::canonical_post_id( $post_id );
		if ( ! Polylang::available() ) { return [ 'state' => 'UNAVAILABLE', 'canonical_id' => $canonical, 'post_id' => $post_id, 'language' => $language ]; }
		$language = sanitize_key( $language );
		if ( $language === Polylang::default_language() ) { return [ 'state' => 'CANONICAL', 'canonical_id' => $canonical, 'post_id' => $canonical, 'language' => $language ]; }
		$translated = self::translated_post_id( $canonical, $language );
		return $translated ? [ 'state' => 'TRANSLATED', 'canonical_id' => $canonical, 'post_id' => $translated, 'language' => $language ] : [ 'state' => 'MISSING', 'canonical_id' => $canonical, 'post_id' => 0, 'language' => $language ];
	}
}
