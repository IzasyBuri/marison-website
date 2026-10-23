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
