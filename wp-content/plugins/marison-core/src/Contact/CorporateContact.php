<?php
/**
 * Public corporate contact read boundary.
 *
 * @package MarisonCore
 */

namespace Marison\Core\Contact;

defined( 'ABSPATH' ) || exit;

use Marison\Core\Settings\CorporateSettings;
use Marison\Core\Support\Validation;

final class CorporateContact {
	/**
	 * Return only configured, public-safe corporate contact channels.
	 *
	 * @return array{state:string,channels:array<int,array{kind:string,value:string,url:string}>}
	 */
	public static function read(): array {
		$channels = [];

		$telephone = Validation::sanitize_contact_number( CorporateSettings::get( CorporateSettings::TELEPHONE ) );
		if ( Validation::is_valid_contact_number( $telephone ) ) {
			$channels[] = [
				'kind'  => 'telephone',
				'value' => $telephone,
				'url'   => 'tel:' . preg_replace( '/[^\d+]/', '', $telephone ),
			];
		}

		$email = sanitize_email( CorporateSettings::get( CorporateSettings::EMAIL ) );
		if ( is_email( $email ) ) {
			$channels[] = [
				'kind'  => 'email',
				'value' => $email,
				'url'   => 'mailto:' . rawurlencode( $email ),
			];
		}

		return [
			'state'    => $channels ? 'available' : 'unavailable',
			'channels' => $channels,
		];
	}
}
