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
 * @package   endpoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LittleBot REST endpoints.
 */
class Littlebot_Rest_Endpoints extends WP_REST_Controller {


	/**
	 * Valid invoice statuses
	 *
	 * @var array
	 */
	private $invoice_statuses;

	/**
	 * Valid estiamte statuses
	 *
	 * @var array
	 */
	private $estimate_statuses;

	/**
	 * Valid LittleBot Post Types
	 *
	 * @var array
	 */
	private $post_types = array(
		'lb_invoice',
		'lb_estimate',
	);

	/**
	 * Get things going
	 *
	 * @since 0.9
	 */
	public function __construct() {
		$this->invoice_statuses  = array_keys( LBI()->invoice_statuses );
		$this->estimate_statuses = array_keys( LBI()->estimate_statuses );
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {

		$version   = '1';
		$namespace = 'littlebot/v' . $version;

		register_rest_route(
			$namespace,
			'/totals',
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_totals' ),
			)
		);

		register_rest_route(
			$namespace,
			'/clients',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'clients' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => array(
					'status'    => array(
						'default'           => 'lb-paid',
						'validate_callback' => array( $this, 'validate_status' ),
					),
					'post_type' => array(
						'default'           => 'lb_invoice',
						'validate_callback' => array( $this, 'validate_post_type' ),
					),
					'client_id' => array(
						'default'           => 0,
						'validate_callback' => function( $params ) {
							return is_numeric( $params );
						},
					),
				),

			)
		);

		register_rest_route(
			$namespace,
			'/total',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_total_for_period' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => array(
					'before' => array(
						'required' => false,
						'type'     => 'string',
						'format'   => 'date-time',
					),
					'after' => array(
						'required' => false,
						'type'     => 'string',
						'format'   => 'date-time',
					),
					'status'    => array(
						'validate_callback' => array( $this, 'validate_status' ),
					),
					'post_type' => array(
						'validate_callback' => array( $this, 'validate_post_type' ),
					),
					'client_id' => array(
						'default'           => 0,
						'validate_callback' => function( $params ) {
							return is_numeric( $params );
						},
					),
				),
			)
		);
	}

	/**
	 * Gets all LittleBot Clients
	 *
	 * @param object $request the current request object.
	 * @return array
	 */
	public function clients( $request ) {
		$params    = $request->get_params();
		$post_type = $params['post_type'];
		$status    = $params['status'];

		/**
		 * Get out clients.
		 */
		$clients     = new LBI_Clients();
		$all_clients = $clients->get_all();

		/**
		 * Add total billed to the clients.
		 */
		foreach ( $all_clients as $client ) {
			$lbi_reports        = new LBI_REPORTS();
			$total              = $lbi_reports->get_total_for_period( array( $status ), $client->ID, $post_type );
			$client->total_paid = (float) $total;
		}

		return new WP_REST_Response( $all_clients, 200 );
	}

	/**
	 * Validates invoice statuses passed as REST params.
	 *
	 * @param string $params url params passed.
	 * @return boolean
	 */
	public function validate_post_type( $params ) {
		return in_array( $params, $this->post_types, true );
	}

	/**
	 * Validates invoice statuses passed as REST params.
	 *
	 * @param string $params url parameters.
	 * @param string $request request object.
	 * @return boolean
	 */
	public function validate_status( $params, $request ) {
		$params         = $request->get_params();
		$post_type      = $params['post_type'];
		$statuses       = explode( ',', $params['status'] );
		$valid_statuses = $post_type === 'lb_invoice' ? $this->invoice_statuses : $this->estimate_statuses;

		foreach ( $statuses as $status ) {
			if ( ! in_array( $status, $valid_statuses, true ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Get the SUM of all invoices or estimates for a period.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_total_for_period( $request ) {
		global $wpdb;

		$params    = $request->get_params();
		$client_id = $params['client_id'];
		$post_type = $params['post_type'];
		$after     = $params['after'];
		$before    = $params['before'];
		$statuses  = explode( ',', $params['status'] );

		$lbi_reports = new LBI_REPORTS();
		$total       = $lbi_reports->get_total_for_period( $statuses, $client_id, $post_type, $after, $before );

		return new WP_REST_Response( (float) $total, 200 );
	}

	/**
	 * Get totals for each document status
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_totals( $request ) {

		/**
		 * Get all LB statuses.
		 */
		$all_status  = array_keys( LBI()->invoice_statuses );
		$status_dict = [];

		/**
		 * Add a default array to keep track of values for each post_status.
		 */
		foreach ( $all_status as $status ) {
			$status_dict[ $status ] = array(
				'count'  => 0,
				'total'  => 0,
				'status' => $status,
			);
		}

		/**
		 * Query for posts
		 */
		$args = array(
			'post_type'      => 'lb_invoice',
			'date_query'     => array(
				array(
					'after' => 'January 1st, 2020',
				),
			),
			'posts_per_page' => -1,
		);

		$query = new WP_Query( $args );

		foreach ( $query->posts as $key => $invoice ) {
			$total  = get_post_meta( $invoice->ID, '_total', true );
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
		return true;
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed           $item WordPress representation of the item.
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
	$controller = new Littlebot_Rest_Endpoints();
	$controller->register_routes();
}

add_action( 'rest_api_init', 'register_cat_list_controller' );
