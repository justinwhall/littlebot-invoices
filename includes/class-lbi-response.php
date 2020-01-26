<?php
/**
 *
 * Ajax Response Object
 *
 * @class     LBI_Response
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Response Class. 
 */
class LBI_Response {

	public $response = array();

    public function build( $error, $message, $data = '' ){
    	
    	$this->response['error']   = $error;
    	$this->response['message'] = $message;
    	$this->response['data']   = $data;

    	return $this->response;
    }

}