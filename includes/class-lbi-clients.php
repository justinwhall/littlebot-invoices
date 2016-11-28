<?php
/**
 *
 * Clients Object
 *
 * @class     LBI_Clients
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Clients Class. 
 */
class LBI_Clients {

    static $username_int = 1;

    public function exists( $email ){

    }

    static function generate_username( $first_name, $last_name ){

        $username = $first_name . $last_name . self::$username_int;

        if ( username_exists( $username ) ) {
            self::$username_int++;
            return self::generate_username( $first_name, $last_name );
        } else{
            return $username;
        }
    }

    public function get_all(){
        
        $args = array( 
            'meta_key'     => 'lb_client',
            'meta_value'   => 1  
        );
        $clients = get_users( $args );
        
        return $clients;
    }


}