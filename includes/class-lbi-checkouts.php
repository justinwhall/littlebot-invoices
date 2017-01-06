<?php 

/**
 * LittleBot Estimates
 *
 * A class that handles replacing email tokens with proper values.
 *
 * @class     LBI_Tokens
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LBI_Checkouts extends LBI_Controller
{
    const CHECKOUT_ACTION = 'lbi_payment_action'
    
    public $gateway;

    static $checkout_controller;

    public function __construct(){
        $this->get_gateway();
        $this->process_action();
    }

    static function init(){
        self::register_query_var( 'lbi_payment_action', array( __CLASS__, 'checkout' ) );
    }

    public function checkout(){
        self::get_instance();
    }

    public static function get_instance() {
        if ( ! ( self::$checkout_controller && is_a( self::$checkout_controller, __CLASS__ ) ) ) {
            self::$checkout_controller = new self();
        }
        var_dump( self::$checkout_controller );
        return self::$checkout_controller;
    }

    public function get_gateway(){
        $active_gateway = LBI_Settings::littlebot_get_option( 'payment_gateways', 'lbi_payments');
        $this->gateway = $active_gateway;
    }

    public function process_action(){

    }


}

LBI_Checkouts::init();