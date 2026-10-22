<?php
/**
 * Marison Core bootstrap.
 *
 * This file intentionally contains no business entities, database schema,
 * public REST routes, or activation-time data changes.
 *
 * @package MarisonCore
 */

namespace Marison\Core;

defined( 'ABSPATH' ) || exit;

final class Plugin {
	private static ?self $instance = null;

	/**
	 * Boot the plugin once per request.
	 *
	 * @return self
	 */
	public static function boot(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {}
}
