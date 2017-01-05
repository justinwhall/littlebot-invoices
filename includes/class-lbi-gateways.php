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

    /**
     * Kick it off
     * @param int $post_id the post ID
     */
    public function __construct(){
        $this->get_all();
        add_action( 'plugins_loaded', array( $this, 'get_all' ), 10, 1 );
    }

    public function get_all(){
        // check for active extensions
        $gateways = array( 
            'Littlebot_Stripe',
            'Littlebot_Paypal',
            'Littlebot_Authorize_Net'
        );

        foreach ( $gateways as $gateway ) {
            if ( class_exists( $gateway ) ) {
                $this->active[] = $gateway;
            }
        }
        
    }


}