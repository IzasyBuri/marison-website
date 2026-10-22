<?php
/**
 * Plugin Name: Marison Core
 * Description: Foundation bootstrap for Marison-specific WordPress business logic.
 * Version: 0.1.0
 * Requires at least: 6.6
 * Requires PHP: 8.1
 * Author: Marison Group
 * Text Domain: marison-core
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/src/Plugin.php';

\Marison\Core\Plugin::boot();

register_activation_hook( __FILE__, [ '\Marison\Core\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ '\Marison\Core\Plugin', 'deactivate' ] );
