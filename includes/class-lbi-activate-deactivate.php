<?php
/**
 * LittleBot activation and deactivation actions
 *
 * @author      Justin W Hall
 * @category    Class
 * @package     LittleBot Invoices/Utility
 * @version     0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Activate_Deactivate Class.
 */
class LBI_Activate_Deactivate {

	static public function on_activate(){
		
		// set business defaults 
		$general_options = array( 
			'currency' => 'USD',
			'currency_position' => 'left',
			'thousand_sep' => ',',
			'decimal_sep' => '.',
			'decimal_num' => 2
		);

		// set business defaults
		$business_options = array( 
			'business_name' => get_bloginfo( 'name' ), 
			'address' => ''
		);
		
		update_option( 'lbi_general', $general_options );
		update_option( 'lbi_business', $business_options );
	}


}

