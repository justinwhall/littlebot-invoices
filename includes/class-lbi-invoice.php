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

	public function get_number( $id ){
		$meta = get_post_meta( $id, '_invoice_number', true );
		$number = strlen( $meta ) ? $meta : $id;
		return $number;
	}

	public function get_status( $id ){
		$status = get_post_status( $id, '_invoice_number', true );
		return $status;
	}
	
}

new LBI_Invoice();
