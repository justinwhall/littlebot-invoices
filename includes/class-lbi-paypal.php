<?php

/**
 * LittleBot Checkouts
 *
 * A controller class that handles checkout actions
 *
 * @class     LBI_Checkouts
 * @version   1.0.1
 * @category  Checkout
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Paypal extends LBI_Controller
{

	/**
	 * Init the class
	 * @return void
	 */
	public static function init(){
		add_action( 'littlebot_payment_form', array( __CLASS__, 'maybe_get_paypal_standard_form' ) );
		add_action( 'parse_request', array( __CLASS__, 'paypal_ipn_endpoint' ) );
	}

	public static function maybe_get_paypal_standard_form(){
		global $post;

		$args = array();
		$args['environment'] = littlebot_get_option( 'paypal_environment', 'lbi_payments');
		$args['paypal_email'] = littlebot_get_option( 'paypal_email', 'lbi_payments');
		$args['currency_code'] = littlebot_get_option( 'currency_code', 'lbi_general');
		$args['item_name'] = $post->post_name;

		if ( 'test' == $args['environment'] ) {
			$args['endpoint'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		} else{
			$args['endpoint'] = 'https://www.paypal.com/cgi-bin/webscr';
		}

		if ( littlebot_get_option( 'enable_paypal_standard', 'lbi_payments') == 'on' ) {
			LBI_Controller::load_view( 'html-paypal-form', $args );
		}
	}

	public static function paypal_ipn_endpoint(){

		// check nonce
		if ( ! isset($_GET['paypal_checkout']) || ! wp_verify_nonce($_GET['paypal_checkout'], 'ipn_val'))
			return;

		if($_SERVER["REQUEST_URI"] == '/littlebot-paypal-endpoint?paypal_checkout=' . $_GET['paypal_checkout'] && isset( $_POST )) {

			// use PaypalIPN;
			$ipn = new PaypalIPN();

			// Use the sandbox endpoint during testing.
			if ( 'test' == littlebot_get_option( 'paypal_environment', 'lbi_payments') ) {
				$ipn->useSandbox();
			}
			$verified = $ipn->verifyIPN();

			if ($verified) {
				 // * Process IPN
				 // * A list of variables is available here:
				 // * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
			   LBI_Admin_Post::update_status( $_POST['custom'], 'lb-paid');
			}

		}
	}

}

LBI_Paypal::init();