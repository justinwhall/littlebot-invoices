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
        if ( littlebot_get_option( 'enable_paypal_standard', 'lbi_payments') ) {
            LBI_Controller::load_view('html-paypal-form', array());
        }
    }

    public static function paypal_ipn_endpoint(){
        if($_SERVER["REQUEST_URI"] == '/littlebot-paypal-endpoint' && isset( $_POST )) {
            
            // use PaypalIPN;
            $ipn = new PaypalIPN();
            
            // Use the sandbox endpoint during testing.
            $ipn->useSandbox();
            $verified = $ipn->verifyIPN();
            
            if ($verified) {
                
                 // * Process IPN
                 // * A list of variables is available here:
                 // * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
                LBI_Admin_Post::update_status( false, $_POST['invoice'], 'lb-paid');
            }
            exit();
        }
    }

}

LBI_Paypal::init();