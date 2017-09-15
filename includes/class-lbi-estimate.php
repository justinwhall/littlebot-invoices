<?php

/**
 * LittleBot Estimates
 *
 * A class specific to Estimates.
 *
 * @class     LBI_Estimate
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Estimate extends LBI_Admin_Post {

	public function get_number( $id ) {
		$meta = get_post_meta( $id, '_estimate_number', true );
		$number = strlen( $meta ) ? $meta : $id;
		return $number;
	}

	public function get_status( $id ) {
		$status = get_post_status( $id, '_estimate_number', true );
		return $status;
	}

	public static function get_valid_until( $id ) {
		$saved_date = get_post_meta( $id, '_valid_until', true );

		if ( strlen( $saved_date ) ) {
			$valid_until = $saved_date;
		} else {
			$valid_until = strtotime( '+30 days', current_time( 'timestamp' ) );
		}

		return $valid_until;
	}

}

new LBI_Estimate();
