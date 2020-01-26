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
	public $post_type_name;

	static $error = false;

	static $message = '';

	static $data = false;

	/**
	 * kick it off
	 * @return void
	 */
	public static function init(){
		add_action( 'transition_post_status', array( __CLASS__, 'check_for_approved_estimate' ), 10, 3 );
		add_action( 'wp_ajax_nopriv_update_status', array( __CLASS__, 'update_status' ), 11 );
		add_action( 'wp_ajax_update_status', array( __CLASS__, 'update_status' ), 20 );
	}

	public static function update_status( $ID = false, $status = false ){


		if ( isset( $_POST ) && array_key_exists( 'ajax', $_POST ) )  {
			$status = sanitize_text_field( $_POST['status'] );
			$ID = (int)sanitize_text_field( $_POST['ID'] );
		}
		
		$post = array(
		  'ID'           => $ID,
		  'post_status'   => $status
		);

		$update = wp_update_post( $post );

		if ( !$update ) {
			self::$error = true;
			self::$message = "I'm sorry, there was a problem updating this document.";
		} else{
			self::$data['new_status'] = $status;
		}

		$response = LBI()->response->build( self::$error, self::$message, self::$data);

		if ( isset( $_POST ) && array_key_exists( 'ajax', $_POST ) )  {
	    	wp_send_json( $response );
			wp_die();
		}

		return $response;

	}

	/**
	 * fires on post status transition. Creates a invoice from an estimate if change from pending -> approved
	 * @param  string $new_status the new status
	 * @param  string $old_status the old status
	 * @param  object $post       the current post (estimate)
	 * @return void             
	 */
	public static function check_for_approved_estimate( $new_status, $old_status, $post ) {
	
		// we're only looking for estimates here...
		if ( $post->post_type != 'lb_estimate' ) return;

		// create invoice
		if ( $old_status !== $new_status && $new_status == 'lb-approved' ) {
			
			$invoice = array(
			  'post_title'    => $post->post_title,
			  'post_content'  => '',
			  'post_status'   => 'lb-draft',
			  'post_type'     => 'lb_invoice'
			);

			$invoice_id = wp_insert_post( $invoice );

			update_post_meta( $invoice_id, '_client', get_post_meta( $post->ID, '_client', true ) );
			update_post_meta( $invoice_id, '_due_date', strtotime("+1 month") );
			update_post_meta( $invoice_id, '_line_items', get_post_meta( $post->ID, '_line_items', true ) );
			update_post_meta( $invoice_id, '_subtotal', get_post_meta( $post->ID, '_subtotal', true ) );
			update_post_meta( $invoice_id, '_total', get_post_meta( $post->ID, '_total', true ) );

			// Link these two documents
			self::link_docs( $post->ID, $invoice_id );

			// send notification
			do_action('send_estimate_approved_notification', $post );
		}

	}

	public static function link_docs( $estimate_id, $invoice_id) {
		update_post_meta( $estimate_id, '_linked_doc', $invoice_id );
		update_post_meta( $invoice_id, '_linked_doc', $estimate_id );
	} 

	/**
	 * security & privlege check before saving posts meta
	 * @param  string $nonce_name   save nonce
	 * @param  sttring $nonce_action nonce action
	 * @param  object $post_id      post being saved
	 * @return boolean               save to save true/false... 
	 */
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

	public static function get_formatted_number( $amount ) {

	    $thou_sep 	= LBI_Settings::littlebot_get_option( 'thousand_sep', 'lbi_general');
	    $dec_sep 	= LBI_Settings::littlebot_get_option( 'decimal_sep', 'lbi_general');;
	    $decimals 	= LBI_Settings::littlebot_get_option( 'decimal_num', 'lbi_general');

	    $formatted 	= number_format( (float)$amount, (int)$decimals, $dec_sep, $thou_sep );

	    return apply_filters( 'little_get_formatted_number', $formatted );
	}

	static function get_formatted_currency( $amount ) {

		$symbol 	= LBI_Settings::littlebot_get_option( 'currency_symbol', 'lbi_general');
		$position 	= LBI_Settings::littlebot_get_option( 'currency_position', 'lbi_general');
		$amount 	= self::get_formatted_number( $amount );

		switch ($position) {
			case 'left':
				$formatted = $symbol . $amount;
				break;
			case 'right':
				$formatted = $amount . $symbol;
				break;
			case 'left_space':
				$formatted = $symbol . ' ' . $amount;
				break;
			case 'right_space':
				$formatted = $amount . ' ' . $symbol;
				break;

			default:
				$formatted = $symbol . $amount;
				break;
		}

		return apply_filters( 'littlebot_formatted_currency', $formatted );

	}

}