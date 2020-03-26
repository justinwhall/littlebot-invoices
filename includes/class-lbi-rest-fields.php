<?php 

/**
 * LittleBot REST Endpoints
 *
 * A class that handles customer endpoints
 *
 * @class     LBI_REST_ENDPOINTS
 * @version   2.7.0
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'rest_api_init', function () {
    register_rest_field( ['lb_invoice', 'lb_estimate'], 'lb_meta', array(
        'get_callback' => function( $post_arr ) {
          $meta = new stdClass();

          $meta->total = (float) get_post_meta( $post_arr['id'], '_total', true );

          return $meta;
        },
    ) );
} );