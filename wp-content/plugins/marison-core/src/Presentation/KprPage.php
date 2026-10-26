<?php
/**
 * Public KPR Page read model.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Presentation;

defined( 'ABSPATH' ) || exit;

use Marison\Core\KPR\PublicDefault;
use Marison\Core\Multilingual\Polylang;

final class KprPage {
	public static function register_strings(): void {
		if ( ! is_admin() || ! function_exists( 'pll_register_string' ) ) {
			return;
		}

		$default = PublicDefault::get();
		if ( 'AVAILABLE' !== $default['state'] ) {
			return;
		}

		$scheme_id = (int) $default['scheme_id'];
		$title     = (string) get_the_title( $scheme_id );
		$disclaimer = (string) get_post_meta( $scheme_id, '_marison_kpr_disclaimer', true );
		$identity  = 'marison_kpr_scheme_' . $scheme_id . '_';

		if ( '' !== $title ) {
			pll_register_string( $identity . 'title', $title, 'Marison KPR', false );
		}
		if ( '' !== $disclaimer ) {
			pll_register_string( $identity . 'disclaimer', $disclaimer, 'Marison KPR', true );
		}
	}

	public static function view(): array {
		$default = PublicDefault::get();
		$base    = [
			'state'             => (string) $default['state'],
			'available'         => 'AVAILABLE' === $default['state'],
			'calculator_state'  => 'AVAILABLE' === $default['state'] ? 'NOT_IMPLEMENTED' : 'UNAVAILABLE',
			'scheme'            => null,
			'editorial'         => [
				'title'      => self::editorial_value( '', 'title', false ),
				'disclaimer' => self::editorial_value( '', 'disclaimer', true ),
			],
		];

		if ( 'AVAILABLE' !== $default['state'] ) {
			return $base;
		}

		$scheme_id  = (int) $default['scheme_id'];
		$title      = (string) get_the_title( $scheme_id );
		$disclaimer = (string) get_post_meta( $scheme_id, '_marison_kpr_disclaimer', true );
		$tenures    = array_values( array_filter( array_map( 'absint', (array) get_post_meta( $scheme_id, '_marison_kpr_tenure_months', true ) ) ) );

		$base['scheme'] = [
			'annual_rate_percent_points' => (string) get_post_meta( $scheme_id, '_marison_kpr_annual_rate', true ),
			'tenure_options'             => array_map( [ self::class, 'tenure_option' ], $tenures ),
			'default_dp_percent'         => (string) get_post_meta( $scheme_id, '_marison_kpr_default_dp_percent', true ),
			'effective_date'             => (string) get_post_meta( $scheme_id, '_marison_kpr_effective_date', true ),
		];
		$base['editorial'] = [
			'title'      => self::editorial_value( $title, 'title', false ),
			'disclaimer' => self::editorial_value( $disclaimer, 'disclaimer', true ),
		];

		return $base;
	}

	private static function tenure_option( int $months ): array {
		return [
			'months' => $months,
			'years'  => 0 === $months % 12 ? (int) ( $months / 12 ) : null,
		];
	}

	private static function editorial_value( string $source, string $key, bool $multiline ): array {
		if ( '' === $source ) {
			return [ 'state' => 'NOT_CONFIGURED', 'text' => '', 'source_language' => Polylang::default_language(), 'fallback' => false ];
		}

		if ( ! Polylang::available() || Polylang::current_language() === Polylang::default_language() || ! function_exists( 'pll_translate_string' ) ) {
			return [ 'state' => 'CANONICAL', 'text' => $source, 'source_language' => Polylang::default_language(), 'fallback' => false ];
		}

		$translated = (string) pll_translate_string( $source, Polylang::current_language() );
		if ( '' !== $translated && $translated !== $source ) {
			return [ 'state' => 'TRANSLATED', 'text' => $translated, 'source_language' => Polylang::default_language(), 'fallback' => false ];
		}

		return [
			'state'          => 'MISSING_TRANSLATION',
			'text'           => $source,
			'source_language' => Polylang::default_language(),
			'fallback'       => true,
			'multiline'      => $multiline,
		];
	}
}
