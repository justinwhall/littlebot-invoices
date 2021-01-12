<?php
/**
 * LittleBot activation and deactivation actions
 *
 * @author      Justin W Hall
 * @category    Class
 * @package     LittleBot Invoices/Utility
 * @version     0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Activate_Deactivate Class.
 */
class LBI_Activate_Deactivate {

	/**
	 * Runs on plugin active.
	 *
	 * @return void
	 */
	public static function on_activate() {

		update_option( 'littlebot_invoices_version', LBI_VERSION, 'no' );

		// If we already have options, don't create defaults.
		if ( get_option( 'lbi_general' ) ) {
			return;
		}

		// set general defaults.
		$general_options = array(
			'currency_symbol'   => '$',
			'currency_code'     => 'USD',
			'currency_position' => 'left',
			'thousand_sep'      => ',',
			'decimal_sep'       => '.',
			'decimal_num'       => 2,
		);

		// set business defaults.
		$business_options = array(
			'business_name'  => get_bloginfo( 'name' ),
			'business_email' => get_bloginfo( 'admin_email' ),
		);

		$estimate_options = array(
			'terms' => 'Payment is due within 30 days from date of invoice. Late payments are subject to fees of 3% per month.',
			'notes' => '',
		);

		$invoice_options = array(
			'terms'    => 'Payment is due within 30 days from date of invoice. Late payments are subject to fees of 3% per month.',
			'notes'    => '',
			'hide_pdf' => false,
		);

		$payment_options = array(
			'paypal_environment' => 'test',
		);

		$email_options = array(
			'html_emails'             => 'on',
			'estimate_new_subject'    => 'New estimate | %title%',
			'estimate_new_body'       => "Hello %client_first_name% %client_last_name%,\rYou have a new estimate available %title% ( %estimate_number% ) which can be viewed here %link%.",
			'invoice_new_subject'     => 'New invoice | %title%',
			'invoice_new_body'        => "Hello %client_first_name% %client_last_name%,\rYou have a new invoice available %title% ( %invoice_number% ) which can be viewed here %link%.",
			'invoice_overdue_subject' => 'Invoice overdue | %title%',
			'invoice_overdue_body'    => "Hello %client_first_name% %client_last_name%,\rYou have an overdue %title% ( %invoice_number% ) which can be viewed here %link%.",
		);

		update_option( 'lbi_general', $general_options );
		update_option( 'lbi_business', $business_options );
		update_option( 'lbi_estimates', $estimate_options );
		update_option( 'lbi_invoices', $invoice_options );
		update_option( 'lbi_emails', $email_options );
		update_option( 'lbi_payments', $payment_options );

		// Cron to check for overdue invoices.
		if ( ! wp_next_scheduled( 'littleBotInvoices_cron' ) ) {
			wp_schedule_event( time(), 'every_fifteen_minutes', 'littleBotInvoices_cron' );
		}

		LB_Post_Types::register_post_types();
		flush_rewrite_rules();

	}

	/**
	 * Runs on deactiviation.
	 *
	 * @return void
	 */
	public static function on_deactivate() {
		wp_clear_scheduled_hook( 'littleBotInvoices_cron' );
	}

}

/**
 * Add cron job to check overdue invoices
 *
 * @param array $schedules array of already scheduled tasks.
 * @return array
 */
function cron_every_fifteen( $schedules ) {

	$schedules['every_fifteen_minutes'] = array(
		'interval' => 900,
		'display'  => __( 'Every 15 Minutes', 'littlebot-invoices' ),
	);

	return $schedules;
}
add_filter( 'cron_schedules', 'cron_every_fifteen' );

/**
 * Converst posts to 3.0.
 *
 * @return void
 */
function update_lb_meta() {

	$args = [
		'fields'         => 'ids',
		'posts_per_page' => -1,
		'post_type'      => [ 'lb_invoice', 'lb_estimate' ],
		'cache_results'  => false,
	];

	$query = new WP_Query( $args );

	$dict = [
		'item_title'   => 'itemTitle',
		'item_desc'    => 'itemDesc',
		'item_qty'     => 'itemQty',
		'item_rate'    => 'itemRate',
		'item_percent' => 'itemPercent',
		'item_amount'  => 'itemAmount',
	];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$new_settings = [];
			// $meta         = get_post_meta( get_the_ID(), '_line_items', true );
			$meta         = get_metadata( 'post', get_the_ID() );

			if ( is_array( $meta ) ) {
				foreach ( $meta as $line_item ) {
					$new_line_item = [];

					foreach ( $line_item as $key => $val ) {
						$new_line_item[ $dict[ $key ] ] = $val;
					}

					$new_settings[] = $new_line_item;
				}
				// update_post_meta( get_the_ID(), '_line_items', $new_settings );
			}
		}
	}
	die;
	wp_reset_postdata();
}
// add_action( 'init', 'update_lb_meta' );
