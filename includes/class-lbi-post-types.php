<?php
/**
 * Post Types
 *
 * Registers post types, taxonomies & post statuses.
 *
 * @class     LB_Post_Types
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LB_Post_Types Class.
 */
class LB_Post_Types {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		// add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_status' ), 9 );
		// add_action( 'post_submitbox_misc_actions', array( __CLASS__, 'add_post_status' ), 9 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'remove_publish_metabox' ) );
	}

	public function remove_publish_metabox() {
		remove_meta_box( 'submitdiv', array('lb_invoice', 'lb_estimate'), 'side' );
	}

	/**
	 * Register core post types.
	 */
	public static function register_post_types() {

		if ( post_type_exists('lb-invoice') ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Invoices', 'post type general name', 'little-bot-invoices' ),
			'singular_name'      => _x( 'Invoice', 'post type singular name', 'little-bot-invoices' ),
			'menu_name'          => _x( 'Invoices', 'admin menu', 'little-bot-invoices' ),
			'name_admin_bar'     => _x( 'Invoice', 'add new on admin bar', 'little-bot-invoices' ),
			'add_new'            => _x( 'Add New', 'invoice', 'little-bot-invoices' ),
			'add_new_item'       => __( 'Add New invoice', 'little-bot-invoices' ),
			'new_item'           => __( 'New Invoice', 'little-bot-invoices' ),
			'edit_item'          => __( 'Edit Invoice', 'little-bot-invoices' ),
			'view_item'          => __( 'View Invoice', 'little-bot-invoices' ),
			'all_items'          => __( 'All Invoices', 'little-bot-invoices' ),
			'search_items'       => __( 'Search Invoices', 'little-bot-invoices' ),
			'parent_item_colon'  => __( 'Parent Invoices:', 'little-bot-invoices' ),
			'not_found'          => __( 'No invoices found.', 'little-bot-invoices' ),
			'not_found_in_trash' => __( 'No invoices found in Trash.', 'little-bot-invoices' )
		);

		$args = array(
			'labels'             => $labels,
            'description'        => __( 'Little Bot Invoices.', 'little-bot-invoices' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'littlebot-invoice' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title')
		);

		register_post_type( 'lb_invoice', $args );		

		$labels = array(
			'name'               => _x( 'Estimates', 'post type general name', 'little-bot-invoices' ),
			'singular_name'      => _x( 'Estimate', 'post type singular name', 'little-bot-invoices' ),
			'menu_name'          => _x( 'Estimates', 'admin menu', 'little-bot-invoices' ),
			'name_admin_bar'     => _x( 'Estimate', 'add new on admin bar', 'little-bot-invoices' ),
			'add_new'            => _x( 'Add New', 'Estimate', 'little-bot-invoices' ),
			'add_new_item'       => __( 'Add New Estimate', 'little-bot-invoices' ),
			'new_item'           => __( 'New Estimate', 'little-bot-invoices' ),
			'edit_item'          => __( 'Edit Estimate', 'little-bot-invoices' ),
			'view_item'          => __( 'View Estimate', 'little-bot-invoices' ),
			'all_items'          => __( 'All Estimates', 'little-bot-invoices' ),
			'search_items'       => __( 'Search Estimates', 'little-bot-invoices' ),
			'parent_item_colon'  => __( 'Parent Estimates:', 'little-bot-invoices' ),
			'not_found'          => __( 'No invoices found.', 'little-bot-invoices' ),
			'not_found_in_trash' => __( 'No invoices found in Trash.', 'little-bot-invoices' )
		);

		$args = array(
			'labels'             => $labels,
            'description'        => __( 'Little Bot Estimates.', 'little-bot-invoices' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'littlebot-estimate' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title')
		);

		register_post_type( 'lb_estimate', $args );
	}

	/**
	 * Register our custom post statuses, used for order status.
	 */
	public static function register_post_status() {
		$invoice_statuses = array(
			'lb-draft' => array(
				'label'                     => __( 'Draft', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Unpaid <span class="count">(%s)</span>', 'Unpaid <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-unpaid' => array(
				'label'                     => __( 'Unpaid', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Unpaid <span class="count">(%s)</span>', 'Unpaid <span class="count">(%s)</span>', 'little-bot-invoices' )
			),			
			'lb-paid' => array(
				'label'                     => __( 'Paid', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Paid <span class="count">(%s)</span>', 'Paid <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-overdue' => array(
				'label'                     => __( 'Overdue', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Overdue <span class="count">(%s)</span>', 'Overdue <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-voided' => array(
				'label'                     => __( 'Voided', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Voided <span class="count">(%s)</span>', 'Voided <span class="count">(%s)</span>', 'little-bot-invoices' )
			)
		);

		foreach ( $invoice_statuses as $status => $values ) {
			register_post_status( $status, $values );
			// add our custom statuses to the singleton
			LBI()->invoice_statuses[$status] = $values;
		}

		$estimate_statuses = array(
			'lb-draft' => array(
				'label'                     => __( 'Draft', 'Estimate status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Draft <span class="count">(%s)</span>', 'Draft <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-pending' => array(
				'label'                     => __( 'Pending', 'Estimate status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-approved' => array(
				'label'                     => __( 'Approved', 'Estimate status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Approved <span class="count">(%s)</span>', 'Approved <span class="count">(%s)</span>', 'little-bot-invoices' )
			),
			'lb-declined' => array(
				'label'                     => __( 'Declined', 'Invoice status', 'little-bot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>', 'little-bot-invoices' )
			)
		);

		foreach ( $estimate_statuses as $status => $values ) {
			register_post_status( $status, $values );
			// add our custom statuses to the singleton
			LBI()->estimate_statuses[$status] = $values;
		}

	}

}

LB_Post_Types::init();
