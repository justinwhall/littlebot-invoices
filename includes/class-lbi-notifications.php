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
		// estimate approved
		add_action( 'send_estimate_approved_notification', array( __CLASS__, 'invoice_overdue' ), 10, 3 );

		// Doc status changed
		add_action( 'transition_post_status', array( __CLASS__, 'doc_status_changed' ), 15, 3 );
		add_action( 'littlebot_send_invoice_overdue_email', array( __CLASS__, 'invoice_overdue' ), 10, 1 );
	}

	public function doc_status_changed( $new_status, $old_status, $post ){
		// Overdue invoice
		if ( $new_status !== $old_status && $new_status == 'lb-overdue' ) {
			do_action( 'littlebot_send_invoice_overdue_email', $post );
		}
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

	public function estimate_approved( $post ){
		$notification = new LBI_Notifications( $post->ID );
		$notification->send( $this->business_options['business_email'] , 'Invoice Approved', 'This is the message');
	}

	public function invoice_overdue( $post ){
		$notification = new LBI_Notifications( $post->ID );
		$subject = $notification->tokens->replace_tokens( $notification->email_options['invoice_overdue_subject'] );
		$message = $notification->tokens->replace_tokens( $notification->email_options['invoice_overdue_body'] );
		$notification->send( $notification->client->user_email, $subject, $message );
	}

	public function send( $to_address, $subject, $message ){
		$emails = LBI()->emails;
		$emails->__set( 'from_name', $this->business_options['business_name'] );
		$emails->__set( 'from_address', $this->business_options['business_email'] );
		$emails->__set( 'heading', $this->tokens->token_values['%title%'] );
		$headers = $emails->get_headers();
		$emails->__set( 'headers', $headers );
		$emails->send( $to_address, $subject, $message );
	}
	
}