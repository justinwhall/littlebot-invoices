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
     * user meta keys
     * @var array
     */
    public $meta = array(
        'company_name',
        'phone_number',
        'street_address',
        'first_name',
        'last_name',
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
    static function generate_username( $first_name, $last_name, $company_name, $email ){

        // Try company name first
        $username = trim( $company_name );

        // Try first name, last name
        if ( !strlen( $username ) ) {
            $username = trim( $first_name ) . trim( $last_name );
        }

        // Ok, no company name, first or last name. We'll make one from their email which is required
        if ( !strlen( $username ) ) {
            $username = preg_replace( '/@.*/', '', $email );
        }

        // Lastly append number so there are no dupes
        $username .= self::$username_int;

        if ( username_exists( $username ) ) {
            self::$username_int++;
            return self::generate_username( $first_name, $last_name, $company_name );
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