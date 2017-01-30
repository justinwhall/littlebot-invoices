<?php
/**
 *
 * Client Object
 *
 * @class     LBI_Client
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Client Class.
 */
class LBI_Client {

	static $user_data = array();

	static $error = false;

	static $message = '';

	static $data = false;

	static $username_int = 1;
 
    public static function init() {
    	// Ajax add client from estimates/invoices
    	add_action( 'wp_ajax_create_client', array( __CLASS__, 'create' ), 10 );
    	// Add meta fields
    	add_action( 'show_user_profile', array( __CLASS__, 'add_meta_fields' ) );
    	add_action( 'edit_user_profile', array( __CLASS__, 'add_meta_fields' ) );
    	// Save meta fields
    	add_action( 'personal_options_update', array( __CLASS__, 'update_meta' ), 10, 1 );
    	add_action( 'edit_user_profile_update', array( __CLASS__, 'update_meta' ), 10, 1 );
    }

    public function create(){

    	check_ajax_referer('lb-invoices', 'nonce');

    	// Make sure email isn't being used already
    	if ( email_exists( $_POST['email'] ) ){
    		self::$error = true;
    		self::$message = 'Email already exists. Please choose a different one.';
    		self::$data = false;
    	} else{
	    	// Generate unique username
	    	$username = LBI()->clients->generate_username( $_POST['first_name'], $_POST['last_name'], $_POST['company_name'], $_POST['email'] );
    	}

    	// Insert user
    	$userdata['user_login'] = $username;
    	$userdata['user_pass'] = wp_generate_password();
    	$userdata['first_name'] = $_POST['first_name'];
    	$userdata['last_name'] = $_POST['last_name'];
    	$userdata['user_email'] = $_POST['email'];
    	$userdata['user_url'] = $_POST['website'];
    	$userdata['role'] = 'subscriber';
    	$user_id = wp_insert_user( $userdata );

    	if ( !is_array( $user_id ) ) {
    		self::update_meta( $user_id);
    		self::$data['user_id'] = $user_id;
    		self::$data['company_name'] = $_POST['company_name'];
    		self::$data['first_name'] = $_POST['first_name'];
            self::$data['last_name'] = $_POST['last_name'];
    		self::$data['email'] = $_POST['email'];
    	}

    	// send response object
    	$response = LBI()->response->build( self::$error, self::$message, self::$data );
    	wp_send_json( $response );
    	
    }

    /**
     * gets a single client - get_user_meta wrapper
     * @param  integer $user_id a user's id
     * @return object   client object w/ custom meta
     */
    public function read( $user_id = 0 ){

        $client     = get_user_by( 'id', $user_id );
        $saved_meta = get_user_meta( $user_id );
        $lbi_meta   = LBI()->clients->meta;

        if ( $saved_meta ) {
            
            foreach ( $lbi_meta as $key => $value ) {
                if ( array_key_exists( $value, $saved_meta ) ) {
                    $client->data->$value = $saved_meta[$value][0];
                } else {
                    $client->data->$value = false;
                }
            }

        } else{
            $client = false;
        }

        return $client;
    }

    public function update( $user_id = 0 ){

    }

    /**
     * update a clients custom metadata
     * @param  integer $user_id  a user's ID
     * @return void 
     */
    public static function update_meta( $user_id ){
   	
    	update_user_meta( $user_id, 'company_name', $_POST['company_name'] );
    	update_user_meta( $user_id, 'phone_number', $_POST['phone_number'] );
    	update_user_meta( $user_id, 'street_address', $_POST['street_address'] );
    	update_user_meta( $user_id, 'city', $_POST['city'] );
    	update_user_meta( $user_id, 'state', $_POST['state'] );
    	update_user_meta( $user_id, 'zip', $_POST['zip'] );
    	update_user_meta( $user_id, 'country', $_POST['country'] );
    	update_user_meta( $user_id, 'client_notes', $_POST['client_notes'] );
    	update_user_meta( $user_id, 'lb_client', $_POST['lb_client'][0] );
    }

    public static function add_meta_fields( $user ){
    	require_once LBI_PLUGIN_DIR . 'views/html-user-meta.php';
    }

    /**
     * Get the client details.
     *
     * @since   0.9
     */
    public static function get_client_details( $user_id = 0 ) {

        $client = get_userdata( $user_id );

        if ( ! $client ) {
            return false;
        }

        $client_details = array(
            'id'             => (int)$client->data->ID,
            'first_name'     => isset( $client->first_name ) ? $client->first_name : '',
            'last_name'      => isset( $client->last_name ) ? $client->last_name : '',
            'email'          => isset( $client->data->user_email ) ? $client->data->user_email :  $client->user_email,
            'company_name'   => get_user_meta( $client->data->ID, 'company_name', true ),
            'street_address' => get_user_meta( $client->data->ID, 'street_address', true ),
            'city'           => get_user_meta( $client->data->ID, 'city', true ),
            'state'          => get_user_meta( $client->data->ID, 'state', true ),
            'zip'            => get_user_meta( $client->data->ID, 'zip', true ),
            'country'        => get_user_meta( $client->data->ID, 'country', true ),
            'lb_client'      => get_user_meta( $client->data->ID, 'lb_client', true ),
        );

        return apply_filters( 'littlebot_client_details', $client_details );

    }

}