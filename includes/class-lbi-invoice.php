<?php 

/**
 * LittleBot Invoices
 *
 * A class specific to Invoices.
 *
 * @class     LBI_Invoice
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Invoice extends LBI_Admin_Post
{

	public function get_number( $id ) {
		$meta = get_post_meta( $id, '_invoice_number', true );
		$number = strlen( $meta ) ? $meta : $id;
		return $number;
	}

	public function get_status( $id ) {
		$status = get_post_status( $id, '_invoice_number', true );
		return $status;
	}

	/**
	 * Gets the due date of an invoice if stored in the DB, otherwise generates one +30 days 
	 * @param  int $post_id the post ID
	 * @return string unix timestamp
	 */
	static function get_due_date( $post_id ) {

	    $saved_date = get_post_meta( $post_id, '_due_date', true );

	    if ( strlen( $saved_date ) ) {
	        $due_date = $saved_date;
	    } else{
	        $due_date = strtotime( '+30 days', current_time('timestamp') );
	    }

	    return $due_date;
	}
	
}

new LBI_Invoice();
