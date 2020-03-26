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

class Slug_Custom_Route extends WP_REST_Controller {
 
  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {

    $version = '1';
    $namespace = 'littlebot/v' . $version;

    register_rest_route( $namespace, '/(?P<id>[\d]+)', array(
      array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => array( $this, 'get_item' ),
        'permission_callback' => array( $this, 'get_item_permissions_check' ),
        'args'                => array(
            'id'
        ),
      ),
    ) );

    register_rest_route( $namespace, '/totals', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => array( $this, 'get_totals' ),
    ) );
  }
 
  /**
   * Get a collection of items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_totals( $request ) {

    /**
     * Get all LB statuses.
     */
    $all_status = array_keys( LBI()->invoice_statuses );
    $status_dict = [];

    /**
     * Add a default array to keep track of values for each post_status.
     */
    foreach ($all_status as $status) {
        $status_dict[$status] = ['count' => 0, 'total' => 0, 'status' => $status];
    }

    /**
     * query for posts
     */
    $args = array(
        'post_type' => 'lb_invoice',
        'date_query' => array(
            array(
                'after' => 'January 1st, 2020',
            ),
        ),
        'posts_per_page' => -1,
    );

    $query = new WP_Query( $args );

    foreach ( $query->posts as $key => $invoice ) {
        $total = get_post_meta( $invoice->ID, '_total', true );
        $status = $invoice->post_status;

        // Increment the count of the post type found.
        $status_dict[ $status ]['count'] = $status_dict[ $status ]['count'] + 1;
        // Increment total for the post_status.
        $status_dict[ $status ]['total'] = $status_dict[ $status ]['total'] + $total;

    }

    return new WP_REST_Response( $status_dict, 200 );
  }

  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_items_permissions_check( $request ) {
    //return true; <--use to make readable by all
    return true;
    return current_user_can( 'edit_something' );
  }

  /**
   * Prepare the item for the REST response
   *
   * @param mixed $item WordPress representation of the item.
   * @param WP_REST_Request $request Request object.
   * @return mixed
   */
  public function prepare_item_for_response( $item, $request ) {
    return array();
  }
 
  /**
   * Get the query params for collections
   *
   * @return array
   */
  public function get_collection_params() {
    return array(
      'page'     => array(
        'description'       => 'Current page of the collection.',
        'type'              => 'integer',
        'default'           => 1,
        'sanitize_callback' => 'absint',
      ),
      'per_page' => array(
        'description'       => 'Maximum number of items to be returned in result set.',
        'type'              => 'integer',
        'default'           => 10,
        'sanitize_callback' => 'absint',
      ),
      'search'   => array(
        'description'       => 'Limit results to those matching a string.',
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
      ),
    );
  }
}

/**
 * Function to register our new routes from the controller.
 */
function register_cat_list_controller() {
	$controller = new Slug_Custom_Route();
	$controller->register_routes();
}

add_action( 'rest_api_init', 'register_cat_list_controller' );