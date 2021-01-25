<?php
/**
 * Defines page templates and page template paths for LBI custom post types
 * and allows for template overriding.
 *
 * @package LBI_Page_Templates
 * @version 0.9
 * @since 	0.9
 */
class LBI_Page_Templates {

	/**
	 * kick it off
	 * @return void
	 */
	public static function init(){
		// proper template path for estimates & Invoices
		add_action( 'single_template', array( __CLASS__, 'load_post_templates' ) );
		// remove all the theme CSS & JS for these pages
		add_action( 'wp_print_styles', array( __CLASS__, 'remove_non_littlebot_styles' ) );
	}

	/**
	 * Define page template and directory for lb_estimate & lb_invoice post types.
	 *
	 * @param  string $single_template default path to template.
	 * @return string  new path to template.
	 */
	public static function load_post_templates( $single_template ) {

		$post   = get_queried_object();
		$status = get_post_meta( $post->ID, 'status', true );

		// If it's a draft, show the draft template.
		if ( $status === 'lb-draft' & ! is_user_logged_in() ) {
			$single_template = LBI_PLUGIN_DIR . '/templates/template-doc-draft.php';
		} elseif ( $post->post_type === 'lb_estimate' ) {
			$single_template = LBI_PLUGIN_DIR . '/templates/template-estimate.php';
		} elseif ( $post->post_type === 'lb_invoice' ) {
			$single_template = LBI_PLUGIN_DIR . '/templates/template-invoice.php';
		}

		return $single_template;
	}

	/**
	 * Strip out styles that are not LittleBot styles so estimates and invoices look nice
	 *
	 * @return void
	 */
	public static function remove_non_littlebot_styles(){
		global $wp_styles, $post;

		// Only on the public side. Bail if not actually a page.
		if ( is_admin() || ! isset( $post ) ) return;

		// And on littleBot post types.
		if ( $post->post_type == 'lb_estimate' || $post->post_type == 'lb_invoice' ) {
			$wp_styles->queue = array(
				'admin-bar',
				'little-bot-public-styles'
			);
		}

	}

}
