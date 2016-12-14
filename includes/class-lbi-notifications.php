<?php 

/**
 * LittleBot Estimates
 *
 * A class specific to Notifications.
 *
 * @class     LBI_Notifications
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Notifications 
{
	public $tokens;

	public $client;

	public $email_options;

	public $business_options;

	public function __construct( $post_id ){
		// replaces tokens
		$this->tokens = new LBI_Tokens( $post_id );

		// Create a client to notify 
		$client = new LBI_Client;
		$this->client = $client->read( get_post_meta( $post_id, '_client', true ) );

		$this->email_options = get_option( 'lbi_emails', true );
		$this->business_options = get_option( 'lbi_business', true );

	}

	public function init(){
		add_action( 'wp_ajax_send_estimate', array( __CLASS__, 'new_estimate' ), 10 );
		add_action( 'wp_ajax_send_invoice', array( __CLASS__, 'new_invoice' ), 10 );
	}

	static function new_invoice(){

		check_ajax_referer( 'lb-invoices', 'nonce' );
		$post_id = $_POST['post_ID'];
		$notification = new LBI_Notifications( $post_id );
		
		$subject = $notification->tokens->replace_tokens( $notification->email_options['invoice_new_subject'] );
		$message = $notification->tokens->replace_tokens( $notification->email_options['invoice_new_body'] );

		$notification->send( $notification->client->user_email, $subject, $message );

		wp_die();
	}

	static function new_estimate(){

		check_ajax_referer('lb-invoices', 'nonce');
		$post_id = $_POST['post_ID'];
		$notification = new LBI_Notifications( $post_id );

		$subject = $notification->tokens->replace_tokens( $notification->email_options['estimate_new_subject'] );
		$message = $notification->tokens->replace_tokens( $notification->email_options['estimate_new_body'] );

		$notification->send( $notification->client->user_email, $subject, $message );
		wp_die();
	}

	public function send( $to_address, $subject, $message ){

		$emails = LBI()->emails;
		$emails->__set( 'from_name', $this->business_options['business_name'] );
		$emails->__set( 'from_address', $this->business_options['business_email'] );
		$headers = $emails->get_headers();
		$emails->__set( 'headers', $headers );
		$emails->send( $to_address, $subject, $message );
	}
	
}

// new LBI_Notifications;
