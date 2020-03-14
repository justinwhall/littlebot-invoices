<?php 

/**
 * LittleBot Gateways
 *
 * A class that handles Gateway functions
 *
 * @class     LBI_Tokens
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LBI_Gateways 
{

    public $active = array();

    public $selected = false;

    static $supported_gateways = array( 
        'Littlebot_Stripe' => 'LB_STRIPE_VERSION',
    );

    /**
     * Kick it off
     * @param int $post_id the post ID
     */
    public function __construct(){
        // $this->get_all();
        add_action( 'plugins_loaded', array( $this, 'get_all' ), 10, 1 );
        add_action( 'plugins_loaded', array( $this, 'get_selected_gateway' ), 10, 1 );
    }

    public function get_all(){
        // check for installed and active extensions

        foreach ( self::$supported_gateways as $gateway ) {
            if ( defined( $gateway ) ) {
                $this->active[] = $gateway;
            }
        }
        
    }

    public function get_selected_gateway(){
        // check if there is setting val for any LittleBot gateway extensions
        $selected_gateway = LBI_Settings::littlebot_get_option( 'payment_gateway', 'lbi_payments');

        if ( defined( self::$supported_gateways[ $selected_gateway ] ) ) {
            $this->selected = $selected_gateway;
        }
    }

}