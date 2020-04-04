<?php
/**
 * Plugin Name: LittleBot Invoices
 * Plugin URI: https://littlebot.io
 * Description: Easily create and send estimates and invoices for your business.
 * Author: Justin W Hall
 * Author URI: https://littlebot.io

 * Version: 2.6.7
 * Text Domain: littlebot-invoices
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: languages
 *
 * @package LittleBot Invoices
 * @category Core
 * @author Justin W. Hall
 * @version 2.5.6
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Create a helper function for easy SDK access.
function li_fs() {
	global $li_fs;

	if ( ! isset( $li_fs ) ) {
		// Include Freemius SDK.
		require_once dirname(__FILE__) . '/freemius/start.php';

		$li_fs = fs_dynamic_init( array(
			'id'                  => '1366',
			'slug'                => 'littlebot-invoices',
			'type'                => 'plugin',
			'public_key'          => 'pk_f66e8f2a97d560af341c41d6ff5cb',
			'is_premium'          => false,
			'has_addons'          => true,
			'has_paid_plans'      => false,
			'menu'                => array(
				'slug'           => 'littlebot_invoices',
				'contact'        => true,
				'support'        => false,
			),
		) );
	}

	return $li_fs;
}

// Init Freemius.
li_fs();
// Signal that SDK was initiated.
do_action( 'li_fs_loaded' );


if ( ! class_exists( 'Little_Bot_Invoices' ) ) :

/**
 * Main Little_Bot_Invoices Class.
 *
 * @since 0.9
 */
final class Little_Bot_Invoices {
	/** Singleton *************************************************************/

	/**
	 * @var Little_Bot_Invoices The one true Little_Bot_Invoices
	 * @since 0.9
	 */
	private static $instance;

	/**
	 * @var Little_Bot_Invoices Plugin name
	 * @since 0.9
	 */
	public $plugin_name = 'littlebot-invoices';

	public $invoice_statuses = array();

	public $estimate_statuses = array();

	/**
	 * @var Littlebot_Stripe holds installed add ons
	 * @since 0.9
	 */
	public static $extensions = array();


	/**
	 * Main Little_Bot_Invoices Instance.
	 *
	 * Insures that only one instance of Little_Bot_Invoices exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 0.9
	 * @static
	 * @staticvar array $instance
	 * @uses Little_Bot_Invoices::setup_constants() Setup the constants needed.
	 * @uses Little_Bot_Invoices::includes() Include the required files.
	 * @uses Little_Bot_Invoices::load_textdomain() load the language files.
	 * @see LBI()
	 * @return object|Little_Bot_Invoices The one true Little_Bot_Invoices
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Little_Bot_Invoices ) ) {
			self::$instance = new Little_Bot_Invoices;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->clients = new LBI_Clients();
			self::$instance->response = new LBI_Response();
			self::$instance->emails = new LBI_Emails();
			self::$instance->gateways = new LBI_Gateways();
			self::$instance->load_plugin_textdomain();
			// self::$instance->extentions = new LBI_Extentions();
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 0.9
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'little-bot-invoices' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 0.9
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'little-bot-invoices' ), '1.0' );
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 0.9
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version.
		if ( ! defined( 'LBI_VERSION' ) ) {
			define( 'LBI_VERSION', '2.4.6' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'LBI_PLUGIN_DIR' ) ) {
			define( 'LBI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'LBI_PLUGIN_URL' ) ) {
			define( 'LBI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'LBI_PLUGIN_FILE' ) ) {
			define( 'LBI_PLUGIN_FILE', __FILE__ );
		}

	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 0.9
	 * @return void
	 */
	private function includes() {
		global $LBI_options;

		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-activate-deactivate.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-controller.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-assets.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-page-templates.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-types.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-details.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-line-items.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-send-doc.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-clients.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-client.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-columns.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-estimate.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-invoice.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-response.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-settings-api.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-settings.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-checkouts.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-emails.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-notifications.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-tokens.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-gateways.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-paypal-ipn.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-paypal.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-log.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-log-metabox.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-notes-metabox.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-terms-metabox.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-pdf.php';
		require_once LBI_PLUGIN_DIR . 'includes/lbi-template-tags.php';

		LBI_PDF::init();
		LBI_Controller::init();
		LBI_Notifications::init();
		LBI_Page_Templates::init();
		LBI_Client::init();
		LBI_Admin_Post::init();

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.2
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'littlebot-invoices',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);

	}

}

endif; // End if class_exists check.


register_activation_hook( __FILE__, array( 'LBI_Activate_Deactivate', 'on_activate' ) );
register_deactivation_hook( __FILE__, array( 'LBI_Activate_Deactivate', 'on_deactivate' ) );


/**
 * The main function that returns Little_Bot_Invoices
 *
 * @since 0.9
* @return object|Little_Bot_Invoices The one true Little_Bot_Invoices Instance.
 */
function LBI() {
	return Little_Bot_Invoices::instance();
}

LBI();
