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
		add_action( 'single_template', array( __CLASS__, 'load_post_templates' ) );
	}

	public function load_post_templates( $single_template ){

		$object = get_queried_object();

		$single_template = LBI_PLUGIN_DIR . '/templates/template-estimate.php';

		return $single_template;
		

		// $template_location = locate_template("single-{$object->post_type}-{$object->post_name}.php");
		// var_dump( $template_location );
		// if( file_exists( $single_postType_postName_template ) )
		// {
		// 	return $single_postType_postName_template;
		// } else {
		// 	return $single_template;
		// }


	}

} // end class
