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

	public static function remove_publish_metabox() {
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
			'name'               => _x( 'Invoices', 'post type general name', 'littlebot-invoices' ),
			'singular_name'      => _x( 'Invoice', 'post type singular name', 'littlebot-invoices' ),
			'menu_name'          => _x( 'Invoices', 'admin menu', 'littlebot-invoices' ),
			'name_admin_bar'     => _x( 'Invoice', 'add new on admin bar', 'littlebot-invoices' ),
			'add_new'            => _x( 'Add New', 'invoice', 'littlebot-invoices' ),
			'add_new_item'       => __( 'Add New invoice', 'littlebot-invoices' ),
			'new_item'           => __( 'New Invoice', 'littlebot-invoices' ),
			'edit_item'          => __( 'Edit Invoice', 'littlebot-invoices' ),
			'view_item'          => __( 'View Invoice', 'littlebot-invoices' ),
			'all_items'          => __( 'All Invoices', 'littlebot-invoices' ),
			'search_items'       => __( 'Search Invoices', 'littlebot-invoices' ),
			'parent_item_colon'  => __( 'Parent Invoices:', 'littlebot-invoices' ),
			'not_found'          => __( 'No invoices found.', 'littlebot-invoices' ),
			'not_found_in_trash' => __( 'No invoices found in Trash.', 'littlebot-invoices' )
		);

		$args = array(
			'labels'             => $labels,
            'description'        => __( 'Little Bot Invoices.', 'littlebot-invoices' ),
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
			'menu_icon'			 => 'dashicons-littlebot-icon',
			'supports'           => array( 'title')
		);

		register_post_type( 'lb_invoice', $args );

		$labels = array(
			'name'               => _x( 'Estimates', 'post type general name', 'littlebot-invoices' ),
			'singular_name'      => _x( 'Estimate', 'post type singular name', 'littlebot-invoices' ),
			'menu_name'          => _x( 'Estimates', 'admin menu', 'littlebot-invoices' ),
			'name_admin_bar'     => _x( 'Estimate', 'add new on admin bar', 'littlebot-invoices' ),
			'add_new'            => _x( 'Add New', 'Estimate', 'littlebot-invoices' ),
			'add_new_item'       => __( 'Add New Estimate', 'littlebot-invoices' ),
			'new_item'           => __( 'New Estimate', 'littlebot-invoices' ),
			'edit_item'          => __( 'Edit Estimate', 'littlebot-invoices' ),
			'view_item'          => __( 'View Estimate', 'littlebot-invoices' ),
			'all_items'          => __( 'All Estimates', 'littlebot-invoices' ),
			'search_items'       => __( 'Search Estimates', 'littlebot-invoices' ),
			'parent_item_colon'  => __( 'Parent Estimates:', 'littlebot-invoices' ),
			'not_found'          => __( 'No invoices found.', 'littlebot-invoices' ),
			'not_found_in_trash' => __( 'No invoices found in Trash.', 'littlebot-invoices' )
		);

		$args = array(
			'labels'             => $labels,
            'description'        => __( 'LittleBot Estimates.', 'littlebot-invoices' ),
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
			'menu_icon'			 => 'dashicons-littlebot-icon',
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
				'label'                     => __( 'Draft', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Unpaid <span class="count">(%s)</span>', 'Unpaid <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-unpaid' => array(
				'label'                     => __( 'Unpaid', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Unpaid <span class="count">(%s)</span>', 'Unpaid <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-paid' => array(
				'label'                     => __( 'Paid', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Paid <span class="count">(%s)</span>', 'Paid <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-overdue' => array(
				'label'                     => __( 'Overdue', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Overdue <span class="count">(%s)</span>', 'Overdue <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-voided' => array(
				'label'                     => __( 'Voided', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Voided <span class="count">(%s)</span>', 'Voided <span class="count">(%s)</span>', 'littlebot-invoices' )
			)
		);

		foreach ( $invoice_statuses as $status => $values ) {
			register_post_status( $status, $values );
			// add our custom statuses to the singleton
			LBI()->invoice_statuses[$status] = $values;
		}

		$estimate_statuses = array(
			'lb-draft' => array(
				'label'                     => __( 'Draft', 'Estimate status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Draft <span class="count">(%s)</span>', 'Draft <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-pending' => array(
				'label'                     => __( 'Pending', 'Estimate status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-approved' => array(
				'label'                     => __( 'Approved', 'Estimate status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Approved <span class="count">(%s)</span>', 'Approved <span class="count">(%s)</span>', 'littlebot-invoices' )
			),
			'lb-declined' => array(
				'label'                     => __( 'Declined', 'Invoice status', 'littlebot-invoices' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>', 'littlebot-invoices' )
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
