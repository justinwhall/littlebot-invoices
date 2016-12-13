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
	public function init(){
		add_action( 'wp_ajax_send_estimate', array( __CLASS__, 'send_estimate' ), 10 );
	}

	static function send_estimate(){

		check_ajax_referer('lb-invoices', 'nonce');
		$post_id = $_POST['post_ID'];
		// holds associative array of tokens and their replacement
		$tokens = new LBI_Tokens( $post_id );
		$client_obj = new LBI_Client;
		$client = $client_obj->read( get_post_meta( $post_id, '_client', true ) );

		$email_options = get_option( 'lbi_emails', true );
		$biz_options = get_option( 'lbi_business', true );

		$subject = $tokens->replace_tokens( $email_options['estimate_new_subject'] );
		$message = $tokens->replace_tokens( $email_options['estimate_new_body'] );

		$emails = LBI()->emails;
		$emails->__set( 'from_name', $biz_options['business_name'] );
		$emails->__set( 'from_address', $biz_options['business_email'] );
		$headers = $emails->get_headers();
		$emails->__set( 'headers', $headers );
		$emails->send( $client->user_email, $subject, $message );
		wp_die();
	}
	
}

// new LBI_Notifications;
