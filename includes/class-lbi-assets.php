<?php
/**
 * Load assets
 *
 * @author      Justin W Hall
 * @category    Admin
 * @package     LittleBot Invoices/Admin
 * @version     0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'LBI_Assets' ) ) :

/**
 * WC_Admin_Assets Class.
 */
class LBI_Assets {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( 'little-bot-styles', LBI_PLUGIN_URL . 'assets/css/little-bot-admin.css', array(), LBI_VERSION, 'all');
	}


	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'little-bot-scripts', LBI_PLUGIN_URL . 'assets/js/littlebot.js', array( 'jquery' ), LBI_VERSION, true );
	}


}

endif;

return new LBI_Assets();

