<?php
/**
 * Load assets
 *
 * @author      Justin W Hall
 * @category    Assets
 * @package     LittleBot Invoices/Assets
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
		add_action( 'wp_enqueue_scripts', array( $this, 'public_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue admin styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( 'little-bot-admin-styles', LBI_PLUGIN_URL . 'assets/css/little-bot-admin.css', array(), LBI_VERSION, 'all');
	}

	/**
	 * Enqueue public styles.
	 */
	public function public_styles() {
		wp_enqueue_style( 'little-bot-public-styles', LBI_PLUGIN_URL . 'assets/css/little-bot-public.css', array(), LBI_VERSION, 'all');
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'little-bot-scripts', LBI_PLUGIN_URL . 'assets/js/littlebot.js', array( 'jquery', 'wp-util' ), LBI_VERSION, true );
		wp_localize_script('little-bot-scripts', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce('lb-invoices') ) );
	}

	/**
	 * Enqueue public scripts.
	 */
	public function public_scripts() {
		global $post;

		$post_type = get_post_type($post);
		$allow_post_types = ['lb_invoice', 'lb_estimate'];

		/**
		 * Only load on Littlebot post types. 
		 */
		if ( ! in_array( $post_type, $allow_post_types ) ) {
			return;
		}

		wp_enqueue_script( 'little-bot-public-scripts', LBI_PLUGIN_URL . 'assets/js/littlebot-invoices-public.js', array( 'jquery' ), LBI_VERSION, true );
		wp_localize_script('little-bot-public-scripts', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce('lb-invoices') ) );
	}

}

endif;

return new LBI_Assets();

