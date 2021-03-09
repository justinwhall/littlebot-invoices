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

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';

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
		add_action( 'admin_head', array( $this, 'admin_head_scripts' ) );
	}

	/**
	 * Enqueue admin styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( 'little-bot-admin-styles', LBI_PLUGIN_URL . 'assets/css/little-bot-admin.css', array(), LBI_VERSION, 'all' );
	}

	/**
	 * Enqueue public styles.
	 */
	public function public_styles() {
		wp_enqueue_style( 'little-bot-public-styles', LBI_PLUGIN_URL . 'assets/css/little-bot-public.css', array(), LBI_VERSION, 'all' );
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		$is_classic_editor = LBI_SETTINGS::littlebot_get_option( 'is_classic_editor', 'lbi_general' ) === 'on' ? true : false;

		if ( $is_classic_editor ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'little-bot-scripts', LBI_PLUGIN_URL . 'assets/js/littlebot.js', array( 'jquery', 'wp-util' ), LBI_VERSION, true );
		} else {
				$url = GUTENBERG_HOT_RELOAD_PLUGIN_URL . 'admin/dist/block.build.js';

			if ( defined( 'LB_DEV' ) && LB_DEV ) {
				$url = 'http://localhost:8080/gutenberg-hot-module-replacement/block.hot.js';

				wp_enqueue_script(
					'gutenberg-hot-module-replacement',
					$url,
					array(
						'wp-blocks',
						'wp-i18n',
						'wp-element',
					),
					'1.0.2',
					true
				);
			}
		}

		// wp_enqueue_script( 'little-report-scripts', LBI_PLUGIN_URL . 'dist/index.js', array( 'wp-api-request' ), LBI_VERSION, true );
		// wp_localize_script( 'little-bot-scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => wp_create_nonce( 'lb-invoices' ) ) );
	}


	public function admin_head_scripts() {
		global $post;
		$status     = is_object( $post ) ? $post->post_status : '';
		$is_reports = apply_filters( 'littlebot_is_reports', 1 );
		echo '<script>var isLittlebotReports = "' . $is_reports . '"; var littlebotStatus = "' . $status . '"</script>';
	}

	/**
	 * Enqueue public scripts.
	 */
	public function public_scripts() {
		global $post;

		$post_type        = get_post_type( $post );
		$allow_post_types = [ 'lb_invoice', 'lb_estimate' ];

		/**
		 * Only load on Littlebot post types.
		 */
		if ( ! in_array( $post_type, $allow_post_types ) ) {
			return;
		}

		wp_enqueue_script( 'little-bot-public-scripts', LBI_PLUGIN_URL . 'assets/js/littlebot-invoices-public.js', array( 'jquery' ), LBI_VERSION, true );
		wp_localize_script(
			'little-bot-public-scripts',
			'ajax_object',
			array(
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'lb-invoices' ),
			)
		);
	}

}

return new LBI_Assets();
