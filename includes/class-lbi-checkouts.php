<?php

/**
 * LittleBot Checkouts
 *
 * A controller class that handles gateway checkout actions.
 * PayPal & 3rd party offsite processors are not handled here.
 *
 * @class     LBI_Checkouts
 * @version   1.0.1
 * @category  Checkout
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LBI_Checkouts extends LBI_Controller
{
    /**
     * GET param
     */
    const CHECKOUT_ACTION = 'lbi_payment_action';

    /**
     * The active payment gateway
     * @var string
     */
    public $gateway = false;

    /**
     * The action the user executing
     * @var string
     */
    public $action;


    /**
     * The payment form
     * @var string
     */

    public $payment_form;

    /**
     * Controller of active gateway
     * @var object
     */
    static $checkout_controller;

    /**
     * Kick it off
     */
    public function __construct(){
        $this->action = $_GET[ self::CHECKOUT_ACTION ];
        $this->get_gateway();
        $this->process_action();
    }

    /**
     * Init the class
     * @return void
     */
    static function init(){
        add_action( 'wp', array( __CLASS__, 'checkout' ) );
    }

    /**
     * Called on WP hook if we're performing a checkout action
     * @return void
     */
    public static function checkout(){
        // Bail if we're not doing anything...
        if ( ! isset( $_GET[ self::CHECKOUT_ACTION ] ) || get_post_type() != 'lb_invoice' ) return;
        // Otherwise, we're checking out. Self instantiate.
        self::get_instance();
    }

    /**
     * Gets an instance of the class
     * @return object
     */
    public static function get_instance() {
        if ( ! ( self::$checkout_controller && is_a( self::$checkout_controller, __CLASS__ ) ) ) {
            self::$checkout_controller = new self();
        }
        return self::$checkout_controller;
    }

    /**
     * Gets the active & sets the $gateway var
     * @return void
     */
    public function get_gateway(){

        $active_gateway = LBI()->gateways->selected;

        switch ( $active_gateway ) {
            case 'Littlebot_Stripe':
                $gateway = new LBS_Controller;
                break;

        }

        $this->gateway = $gateway;
    }

    /**
     * Process the user action
     * @return void
     */
    public function process_action(){
        // Calls gateway controller
        $this->gateway->process_action( $this->action );
    }

}

LBI_Checkouts::init();