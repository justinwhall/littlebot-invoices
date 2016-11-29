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

class LBI_Estimate extends LBI_Admin_Post
{

	public function get_number(){
		// var_dump( get_the_ID() );
	}
	
}

new LBI_Estimate();
