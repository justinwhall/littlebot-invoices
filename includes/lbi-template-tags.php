<?php
/**
 * Template functions
 *
 *
 * @author   Justin W Hall
 * @package  LittleBot Invoices/Template
 * @version  0.9
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) { exit; }

if ( ! function_exists( 'littlebot_get_estimate_number' ) ) :

	function littlebot_get_estimate_number( $id = 0 ) {
		$number = LBI_Estimate::get_number( get_the_ID() );
		return apply_filters( 'littlebot_get_estimate_number', $number, $client );
	}

endif;