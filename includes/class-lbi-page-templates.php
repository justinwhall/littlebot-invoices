<?php
/**
 * Defines page tempaltes and page template paths for LBI custom post types
 * and allows for template overiding.
 *
 * @package LBI_Page_Templates
 * @version 0.9
 * @since 	0.9
 */
class LBI_Page_Templates {

	public function init(){
		// proper template path for estimates & Invoices
		add_action( 'single_template', array( __CLASS__, 'load_post_templates' ) );
		// remove all the theme CSS & JS for these pages
		add_action( 'wp_print_styles', array( __CLASS__, 'remove_non_littlebot_styles' ) );
	}

	public function load_post_templates( $single_template ){

		$object = get_queried_object();

		if ( $object->post_type == 'lb_estimate' ) {
			$single_template = LBI_PLUGIN_DIR . '/templates/template-estimate.php';
		} else if ( $object->post_type == 'lb_invoice' ){
			$single_template = LBI_PLUGIN_DIR . '/templates/template-invoice.php';			
		}

		return $single_template;
	
	}

	public function remove_non_littlebot_styles(){
		global $wp_styles, $post;
		
		// Only on the public side
		if ( is_admin() ) return;

		// And on littleBot post types.
		if ( $post->post_type == 'lb_estimate' || $post->post_type == 'lb_invoice' ) {
			$wp_styles->queue = array(
				'admin-bar',
				'little-bot-public-styles',
			);
		}

	}

} 
