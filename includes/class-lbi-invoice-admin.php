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

	/**
	 * Renders invoice & estimate details.
	 */
	public function render_details_metabox( $post ) {
	    // Add nonce for security and authentication.
	    wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
	    require_once LBI_PLUGIN_DIR . 'views/admin-invoice-details.php';
	}
	
}
