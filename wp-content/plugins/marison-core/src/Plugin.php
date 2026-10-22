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

require_once __DIR__ . '/Admin/Menus.php';
require_once __DIR__ . '/Admin/MetaBoxes.php';
require_once __DIR__ . '/Content/ContentTypes.php';
require_once __DIR__ . '/Reference/Taxonomies.php';
require_once __DIR__ . '/Support/Capabilities.php';
require_once __DIR__ . '/Support/Meta.php';
require_once __DIR__ . '/Support/Validation.php';

use Marison\Core\Admin\Menus;
use Marison\Core\Admin\MetaBoxes;
use Marison\Core\Content\ContentTypes;
use Marison\Core\Reference\Taxonomies;
use Marison\Core\Support\Capabilities;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;

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

	public static function activate(): void {
		ContentTypes::register();
		Taxonomies::register();
		Capabilities::ensure_admin_capabilities( true );
		flush_rewrite_rules();
	}

	public static function deactivate(): void {
		flush_rewrite_rules();
	}

	private function __construct() {
		add_action( 'init', [ ContentTypes::class, 'register' ], 5 );
		add_action( 'init', [ Taxonomies::class, 'register' ], 5 );
		add_action( 'init', [ Meta::class, 'register' ], 20 );
		add_action( 'init', [ Capabilities::class, 'ensure_admin_capabilities' ], 0 );
		add_action( 'admin_init', [ Capabilities::class, 'ensure_admin_capabilities' ] );
		add_action( 'admin_menu', [ Menus::class, 'register' ] );
		add_action( 'add_meta_boxes', [ MetaBoxes::class, 'register' ] );
		add_action( 'save_post', [ MetaBoxes::class, 'save' ], 20, 3 );
		add_action( 'transition_post_status', [ Validation::class, 'handle_trash_relationships' ], 10, 3 );
		add_action( 'added_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'updated_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'deleted_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'set_object_terms', [ Validation::class, 'handle_term_relationship_change' ], 10, 6 );
		add_action( 'deleted_term_relationships', [ Validation::class, 'handle_deleted_term_relationships' ], 10, 3 );
		add_action( 'edited_term_taxonomy', [ Validation::class, 'handle_edited_term_taxonomy' ], 10, 3 );
		add_action( 'admin_notices', [ MetaBoxes::class, 'render_notices' ] );
	}
}
