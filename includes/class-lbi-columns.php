<?php
/**
 * LittleBot Invoices
 *
 * A class that handles post.php columns.
 *
 * @class     LBI_Columns
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Columns {

	public function __construct() {
		// Remove quick edit
		add_action( 'post_row_actions', array( $this, 'modify_row_actions' ), 15, 2 );
		// Custom columns
		add_action( 'manage_lb_invoice_posts_columns', array( $this, 'set_littlebot_columns' ), 15, 1 );
		add_action( 'manage_lb_invoice_posts_custom_column', array( $this, 'build_littlebot_columns' ), 15, 2 );
		add_action( 'manage_lb_estimate_posts_columns', array( $this, 'set_littlebot_columns' ), 15, 1 );
		add_action( 'manage_lb_estimate_posts_custom_column', array( $this, 'build_littlebot_columns' ), 15, 2 );

	}

	function modify_row_actions( $actions, $post ) {
		global $current_screen;

		if ( 'lb_invoice' != $current_screen->post_type || 'lb_estimate' != $current_screen->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
			$actions['pdf'] = '<a href="' . get_permalink( $post->ID ) . '?pdf=1" target="_blank" rel="bookmark" aria-label="View PDF">PDF</a>';
		}

		return $actions;
	}

	 public function build_littlebot_columns( $columns,  $post_id ) {

		switch ( $columns ) {
			case 'status':
				global $current_screen;
				$status_slug = get_post_status( $post_id );
				if ( $current_screen->post_type == 'lb_invoice' ) {
					echo LBI()->invoice_statuses[$status_slug]['label'];
				} else {
					echo LBI()->estimate_statuses[$status_slug]['label'];
				}

				break;

			case 'issued':

				echo '<span class="lb-cal"></span>' . get_the_date( 'M j, Y', $post_id );

				break;

			case 'client':

				$client_id = get_post_meta( $post_id, '_client', true );

				if ( $client_id == 'no_client' ) {
					echo '<em>No Client</em>';
				} else {
					$client = LBI_Client::get_client_details( $client_id );
					echo '<div class="lb-company"><a href="/wp-admin/user-edit.php?user_id=' . $client_id . '"><span class="dashicons dashicons-admin-users"></span> ' . $client['company_name'] . '</a></div>';
				}

				break;

			case 'amount':

				echo littlebot_get_total( $post_id );

				break;

		}

	 }

	 public function set_littlebot_columns( $columns ) {
		unset( $columns['date'] );
		return array_merge($columns,
			array(
				'status' => __('Status'),
				'issued' =>__( 'Issued'),
				'client' =>__( 'Client'),
				'amount' => __('Amount')
				)
			);
	 }





}

new LBI_Columns;
