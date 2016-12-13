<?php 

/**
 * LittleBot Estimates
 *
 * A class that handles replacing email tokens with proper values.
 *
 * @class     LBI_Tokens
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Tokens 
{

	public $post_id;

	public $token_values;

	public function __construct( $post_id ){
		$this->post_id = $post_id;
		$this->get_token_values();
	}

	public function get_token_values(){
		$client_obj = new LBI_Client;
		$client = $client_obj->read( get_post_meta( $this->post_id, '_client', true ) );

		$tokens = array(
			'%title%'             => get_the_title( $this->post_id ),
			'%estimate_number%'   => get_post_meta( $this->post_id, '_estimate_number', true ),
			'%link%'              => get_permalink( $this->post_id ),
			'%client_first_name%' => $client->first_name,
			'%client_last_name%'  => $client->last_name
		);

		$this->token_values = $tokens;
	}

	public function replace_tokens( $string ){

		foreach ( $this->token_values as $key => $value ) {
			$string = str_replace( $key, $value, $string );
		}

		return $string;
	}


}