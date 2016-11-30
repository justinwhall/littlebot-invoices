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

    /**
     * Appended to generated usernames and incremented if needed to avoid dupe usernames
     * @var integer
     */
    static $username_int = 1;

    /**
     * custom user meta keys
     * @var array
     */
    public $meta = array(
        'company_name',
        'phone_number',
        'street_address',
        'city',
        'state',
        'zip',
        'country',
        'client_notes',
        'lb_client'
    );

    /**
     * generates a clients username
     * @param  string $first_name user meta first name
     * @param  string $last_name  user meta last name
     * @return string             {first_name} + {last_name} + $this->username_int
     */
    static function generate_username( $first_name, $last_name ){

        $username = $first_name . $last_name . self::$username_int;

        if ( username_exists( $username ) ) {
            self::$username_int++;
            return self::generate_username( $first_name, $last_name );
        } else{
            return $username;
        }
    }

    /**
     * gets all clients
     * @return array all clients
     */
    public function get_all(){
        
        $args = array( 
            'meta_key'     => 'lb_client',
            'meta_value'   => 1  
        );
        $clients = get_users( $args );
        
        return $clients;
    }


}