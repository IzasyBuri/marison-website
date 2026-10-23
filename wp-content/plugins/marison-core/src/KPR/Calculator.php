<?php
/**
 * KPR calculator validation/result boundary.
 *
 * @package MarisonCore
 */

namespace Marison\Core\KPR;

defined( 'ABSPATH' ) || exit;

final class Calculator {
	public static function validate_inputs( array $input, array $scheme ) {
		$price = (float) ( $input['property_price'] ?? 0 );
		$dp = (float) ( $input['dp_percent'] ?? -1 );
		$tenure = absint( $input['tenure_months'] ?? 0 );
		$allowed_tenures = array_map( 'absint', (array) ( $scheme['tenures'] ?? [] ) );
		if ( $price <= 0 ) { return new \WP_Error( 'marison_kpr_price_invalid', 'Harga properti harus lebih besar dari nol.' ); }
		if ( $dp < 0 || $dp > 100 ) { return new \WP_Error( 'marison_kpr_dp_invalid', 'DP harus berada antara 0 dan 100 persen.' ); }
		if ( $tenure <= 0 || ! in_array( $tenure, $allowed_tenures, true ) ) { return new \WP_Error( 'marison_kpr_tenure_invalid', 'Tenure tidak tersedia pada Scheme ini.' ); }
		return [ 'property_price' => $price, 'dp_percent' => $dp, 'tenure_months' => $tenure ];
	}

	public static function calculate( array $input ): array {
		$default = PublicDefault::get();
		if ( 'AVAILABLE' !== $default['state'] ) {
			return [ 'state' => $default['state'], 'payment' => null, 'message' => 'Kalkulator belum tersedia karena Public Default Scheme belum valid.' ];
		}
		$scheme_id = (int) $default['scheme_id'];
		$scheme = [ 'tenures' => get_post_meta( $scheme_id, '_marison_kpr_tenure_months', true ) ];
		$validated = self::validate_inputs( $input, $scheme );
		if ( is_wp_error( $validated ) ) { return [ 'state' => 'INVALID_INPUT', 'payment' => null, 'error' => $validated->get_error_code(), 'message' => $validated->get_error_message() ]; }
		return [ 'state' => 'NOT_IMPLEMENTED', 'payment' => null, 'inputs' => $validated, 'message' => 'Rumus simulasi KPR belum diimplementasikan.' ];
	}
}
