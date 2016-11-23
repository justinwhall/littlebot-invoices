<?php 

/**
 * Admin Invoice
 *
 * A class all invoice & estimate classes are derived from.
 *
 * @class     LBI_Widgets
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Admin_Post
{
	static $post_type_name;

	public function __construct()
	{

	}

	public function validate_save_action( $nonce_name, $nonce_action, $post_id ){

		$save = true;

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
		    $save = false;
		}
		
		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
		    $save = false;
		}
		
		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
		    $save = false;
		}
		
		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
		    $save = false;
		}
		
		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
		    $save = false;
		}

		return $save;

	}
	
}
