<?php
/**
 * Plugin Name: LittleBot Invoices
 * Plugin URI: https://justinwhall.com
 * Description: Easily create and send estimates andinvoices for you business.
 * Author: Justin W Hall
 * Author URI: https://justinwhall.com
 * Version: 1.0.0
 * Text Domain: little-bot-invoices
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: languages
 *
 * @package LittleBot Invoices
 * @category Core
 * @author Justin W. Hall
 * @version 0.9
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

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
	public static $plugin_name = 'littlebot-invoices';

	public static $invoice_statuses = array();

	public static $estimate_statuses = array();

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
			define( 'LBI_VERSION', '1.0.0' );
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
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-assets.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-page-templates.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-types.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-details.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-post-line-items.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-clients.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-client.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-estimate.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-response.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-settings-api.php';
		require_once LBI_PLUGIN_DIR . 'includes/class-lbi-settings.php';
		require_once LBI_PLUGIN_DIR . 'includes/lbi-template-tags.php';


		LBI_Page_Templates::init();
		LBI_Client::init();
		LBI_Admin_Post::init();

	}

}

endif; // End if class_exists check.


register_activation_hook( __FILE__, array( 'LBI_Activate_Deactivate', 'on_activate' ) );


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
