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

class LBI_Tokens
{

	/**
	 * the post ID
	 * @var int
	 */
	public $post_id;

	/**
	 * Key value pair of Token => value to replace
	 * @var array
	 */
	public $token_values;

	/**
	 * Kick it off
	 * @param int $post_id the post ID
	 */
	public function __construct( $post_id ){
		$this->post_id = $post_id;
		$this->get_token_values();
	}

	/**
	 * Builds the token array with client object data
	 * @return array token array used to build email content
	 */
	public function get_token_values(){

		$client_obj = new LBI_Client;
		$client = $client_obj->read( get_post_meta( $this->post_id, '_client', true ) );

		$permalink = get_permalink( $this->post_id );

		// Replace the link differently depending on what kind of email we are sending
		if ( 'on' == LBI()->emails->options['html_emails'] ) {
			$link = '<a href="' . $permalink . '">' . $permalink . '</a>';
		} else{
			$link = $permalink;
		}

		$tokens = array(
			'%title%'             => get_the_title( $this->post_id ),
			'%estimate_number%'   => littlebot_get_estimate_number( $this->post_id ),
			'%invoice_number%'    => littlebot_get_invoice_number( $this->post_id ),
			'%link%'              => $link,
			'%client_first_name%' => false,
			'%client_last_name%'  => false,
			'%company_name%' => false,
			'%issued%' => get_the_date('l, F j, Y', $this->post_id ),
			'%po_numer%' => get_post_meta( $this->post_id, '_po_number', true )
		);
    
		if ( $client ) {
			$tokens['%client_first_name%'] = $client->first_name;
			$tokens['%client_last_name%']  = $client->last_name;
			$tokens['%company_name%'] = $client->company_name;
		}

		if ( get_post_type() == 'lb_estimate' ) {
			$tokens['%valid_until%'] = date_i18n( 'l, F j, Y', get_post_meta( $this->post_id, '_valid_until', true ), false );
		} else{
			$tokens['%due_date%'] = date_i18n( 'l, F j, Y', get_post_meta( $this->post_id, '_due_date', true ), false );
		}

		$this->token_values = $tokens;
	}

	/**
	 * Actually replaces email tokens with data
	 * @param  string $string A string with tokens
	 * @return string         A string with tokens replaced
	 */
	public function replace_tokens( $string ){

		foreach ( $this->token_values as $key => $value ) {
			$string = str_replace( $key, $value, $string );
		}

		return $string;
	}


}
