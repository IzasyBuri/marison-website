<?php
/**
 * Marison Core bootstrap.
 *
 * This file contains Marison business entities, schema lifecycle hooks, and
 * admin/business logic, but no public REST routes.
 *
 * @package MarisonCore
 */

namespace Marison\Core;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/Admin/Menus.php';
require_once __DIR__ . '/Admin/MetaBoxes.php';
require_once __DIR__ . '/Contact/WhatsApp.php';
require_once __DIR__ . '/Contact/ContactResolver.php';
require_once __DIR__ . '/Contact/CorporateContact.php';
require_once __DIR__ . '/Settings/CorporateSettings.php';
require_once __DIR__ . '/KPR/SchemeRules.php';
require_once __DIR__ . '/KPR/PublicDefault.php';
require_once __DIR__ . '/KPR/Calculator.php';
require_once __DIR__ . '/Multilingual/Polylang.php';
require_once __DIR__ . '/Multilingual/Resolver.php';
require_once __DIR__ . '/Presentation/Homepage.php';
require_once __DIR__ . '/Presentation/Directory.php';
require_once __DIR__ . '/Presentation/ProjectDetail.php';
require_once __DIR__ . '/Presentation/Article.php';
require_once __DIR__ . '/Presentation/KprPage.php';
require_once __DIR__ . '/Presentation/Career.php';
require_once __DIR__ . '/Admin/KPRSchemes.php';
require_once __DIR__ . '/Leads/LeadRules.php';
require_once __DIR__ . '/Leads/LeadRepository.php';
require_once __DIR__ . '/Leads/AbuseProtection.php';
require_once __DIR__ . '/Leads/LeadSubmission.php';
require_once __DIR__ . '/Leads/LeadSubmissionController.php';
require_once __DIR__ . '/Admin/Leads.php';
require_once __DIR__ . '/Privacy/LeadPrivacy.php';
require_once __DIR__ . '/Admin/UnitInventory.php';
require_once __DIR__ . '/Content/ContentTypes.php';
require_once __DIR__ . '/Inventory/Schema.php';
require_once __DIR__ . '/Inventory/Availability.php';
require_once __DIR__ . '/Inventory/UnitRules.php';
require_once __DIR__ . '/Inventory/UnitRepository.php';
require_once __DIR__ . '/Reference/Taxonomies.php';
require_once __DIR__ . '/Support/Capabilities.php';
require_once __DIR__ . '/Support/Meta.php';
require_once __DIR__ . '/Support/Validation.php';

use Marison\Core\Admin\Menus;
use Marison\Core\Admin\MetaBoxes;
use Marison\Core\Settings\CorporateSettings;
use Marison\Core\KPR\PublicDefault;
use Marison\Core\Multilingual\Polylang;
use Marison\Core\Admin\KPRSchemes;
use Marison\Core\Admin\Leads;
use Marison\Core\Privacy\LeadPrivacy;
use Marison\Core\Admin\UnitInventory;
use Marison\Core\Content\ContentTypes;
use Marison\Core\Inventory\Schema;
use Marison\Core\Reference\Taxonomies;
use Marison\Core\Support\Capabilities;
use Marison\Core\Support\Meta;
use Marison\Core\Support\Validation;
use Marison\Core\Presentation\Directory;
use Marison\Core\Presentation\KprPage;
use Marison\Core\Presentation\Career;

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
		Schema::migrate();
		Capabilities::ensure_admin_capabilities( true );
		flush_rewrite_rules();
	}

	public static function deactivate(): void {
		flush_rewrite_rules();
	}

	private function __construct() {
		Polylang::register();
		add_action( 'pll_init', [ KprPage::class, 'register_strings' ] );
		add_action( 'init', [ Schema::class, 'maybe_upgrade' ], 1 );
		add_action( 'init', [ ContentTypes::class, 'register' ], 5 );
		add_action( 'init', [ Taxonomies::class, 'register' ], 5 );
		add_action( 'init', [ Meta::class, 'register' ], 20 );
		add_filter( 'wp_robots', [ Directory::class, 'filter_robots' ] );
		add_action( 'template_redirect', [ Career::class, 'guard_public_detail' ] );
		add_action( 'init', [ Capabilities::class, 'ensure_admin_capabilities' ], 0 );
		add_action( 'admin_init', [ Capabilities::class, 'ensure_admin_capabilities' ] );
		add_action( 'admin_init', [ CorporateSettings::class, 'register' ] );
		add_action( 'admin_menu', [ Menus::class, 'register' ] );
		add_action( 'admin_menu', [ CorporateSettings::class, 'add_menu' ] );
		add_action( 'admin_menu', [ KPRSchemes::class, 'register' ] );
		add_action( 'add_meta_boxes_marison_kpr_scheme', [ KPRSchemes::class, 'register_meta_box' ] );
		add_action( 'save_post_marison_kpr_scheme', [ KPRSchemes::class, 'save' ], 20, 2 );
		add_action( 'admin_post_marison_set_kpr_default', [ KPRSchemes::class, 'handle_set_default' ] );
		add_action( 'admin_post_marison_clear_kpr_default', [ KPRSchemes::class, 'handle_clear_default' ] );
		add_action( 'admin_menu', [ Leads::class, 'register' ] );
		add_action( 'admin_post_marison_delete_lead', [ Leads::class, 'handle_delete' ] );
		add_action( 'init', [ LeadPrivacy::class, 'register' ] );
		add_action( 'admin_post_marison_submit_lead', [ \Marison\Core\Leads\LeadSubmissionController::class, 'handle' ] );
		add_action( 'admin_post_nopriv_marison_submit_lead', [ \Marison\Core\Leads\LeadSubmissionController::class, 'handle' ] );
		add_action( 'admin_post_marison_submit_general_lead', [ \Marison\Core\Leads\LeadSubmissionController::class, 'handle_general' ] );
		add_action( 'admin_post_nopriv_marison_submit_general_lead', [ \Marison\Core\Leads\LeadSubmissionController::class, 'handle_general' ] );
		add_action( 'admin_menu', [ UnitInventory::class, 'register' ] );
		add_action( 'admin_post_marison_save_unit', [ UnitInventory::class, 'handle_save' ] );
		add_action( 'admin_post_marison_delete_unit', [ UnitInventory::class, 'handle_delete' ] );
		add_action( 'admin_post_marison_bulk_unit_status', [ UnitInventory::class, 'handle_bulk_status' ] );
		add_action( 'add_meta_boxes', [ MetaBoxes::class, 'register' ] );
		add_action( 'save_post', [ MetaBoxes::class, 'save' ], 20, 3 );
		add_action( 'transition_post_status', [ Validation::class, 'handle_trash_relationships' ], 10, 3 );
		add_action( 'before_delete_post', [ Validation::class, 'prevent_delete_with_units' ], 10, 2 );
		add_action( 'before_delete_post', [ PublicDefault::class, 'handle_delete' ], 10, 2 );
		add_action( 'added_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'updated_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'updated_post_meta', [ PublicDefault::class, 'handle_state_change' ], 10, 4 );
		add_action( 'deleted_post_meta', [ Validation::class, 'handle_post_meta_change' ], 10, 4 );
		add_action( 'set_object_terms', [ Validation::class, 'handle_term_relationship_change' ], 10, 6 );
		add_action( 'deleted_term_relationships', [ Validation::class, 'handle_deleted_term_relationships' ], 10, 3 );
		add_action( 'edited_term_taxonomy', [ Validation::class, 'handle_edited_term_taxonomy' ], 10, 3 );
		add_action( 'admin_notices', [ MetaBoxes::class, 'render_notices' ] );
	}
}
