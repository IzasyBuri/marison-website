<?php
/**
 * WhatsApp URL and context message builder.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Contact;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Support\Validation;

final class WhatsApp {
	public static function build( string $number, string $project_name = '' ) {
		$number = Validation::sanitize_contact_number( $number );
		if ( ! Validation::is_valid_contact_number( $number ) ) {
			return new \WP_Error( 'marison_whatsapp_invalid', 'Nomor WhatsApp tidak valid.' );
		}

		$digits = preg_replace( '/\D+/', '', $number );
		if ( str_starts_with( $number, '00' ) ) {
			$digits = substr( $digits, 2 );
		}
		if ( str_starts_with( $number, '0' ) && ! str_starts_with( $number, '00' ) ) {
			return new \WP_Error( 'marison_whatsapp_country_code_required', 'Nomor WhatsApp membutuhkan format internasional.' );
		}
		if ( strlen( $digits ) < 7 ) {
			return new \WP_Error( 'marison_whatsapp_invalid', 'Nomor WhatsApp tidak valid.' );
		}

		$message = $project_name
			? 'Halo Marison, saya ingin mengetahui informasi lebih lanjut mengenai ' . $project_name . '.'
			: 'Halo Marison, saya ingin mengetahui informasi lebih lanjut.';
		return [
			'channel' => 'whatsapp',
			'value' => $number,
			'url' => 'https://wa.me/' . $digits . '?text=' . rawurlencode( $message ),
			'message' => $message,
		];
	}
}
