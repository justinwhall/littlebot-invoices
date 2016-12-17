<?php
/**
 * Template functions
 *
 *
 * @author   Justin W Hall
 * @package  LittleBot Invoices/Template
 * @version  0.9
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) { exit; }

// gets invoice due date
if ( ! function_exists( 'littlebot_get_option' ) ) :

	function littlebot_get_option( $option_key, $option_id, $single = true ) {
		$option = LBI_Settings::littlebot_get_option( $option_key, $option_id, $single = true  );
		return apply_filters( 'littlebot_get_option', $option );
	}

endif;

// gets invoice due date
if ( ! function_exists( 'littlebot_get_formatted_currency' ) ) :

	function littlebot_get_formatted_currency( $number) {
		$formated_number = LBI_Admin_Post::get_formatted_currency( $number );
		return apply_filters( 'littlebot_get_formatted_currency', $formated_number );
	}

endif;

// get formatted tax total
if ( ! function_exists( 'littlebot_get_tax_total' ) ) :

	function littlebot_get_tax_total( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$tax = get_post_meta( $post_id, '_subtotal', true ) * ( get_post_meta( $post_id, '_tax_rate', true ) / 100 );
		$taxFormatted = LBI_Admin_Post::get_formatted_currency( $tax );
		return apply_filters( 'littlebot_get_tax_total', $taxFormatted );
	}

endif;

// gets invoice due date
if ( ! function_exists( 'littlebot_get_total' ) ) :

	function littlebot_get_total( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$meta = get_post_meta( $post_id, '', true );
		$total = LBI_Admin_Post::get_formatted_currency( $meta['_total'][0] );
		return apply_filters( 'littlebot_get_total', $total );
	}

endif;

// gets invoice due date
if ( ! function_exists( 'littlebot_get_invoice_due_date' ) ) :

	function littlebot_get_invoice_due_date( $id = 0 ) {
		if ( !$id ) {
			$id = get_the_ID();
		}
		$due_date = LBI_Invoice::get_due_date( $id );
		return apply_filters( 'littlebot_get_invoice_due_date', $due_date );
	}

endif;

// gets an estimate number
if ( ! function_exists( 'littlebot_get_estimate_number' ) ) :

	function littlebot_get_estimate_number( $id = 0 ) {
		if ( !$id ) {
			$id = get_the_ID();
		}
		$estimate = new LBI_Estimate;
		$number = $estimate->get_number( $id );
		return apply_filters( 'littlebot_get_estimate_number', $number );
	}

endif;

// gets an invoice number
if ( ! function_exists( 'littlebot_get_invoice_number' ) ) :

	function littlebot_get_invoice_number( $id = 0 ) {
		if ( !$id ) {
			$id = get_the_ID();
		}
		$invoice = new LBI_invoice;
		$number = $invoice->get_number( $id );
		return apply_filters( 'littlebot_get_invoice_number', $number);
	}

endif;

// print the to and from address
if ( ! function_exists( 'littlebot_print_to_from' ) ) :

	function littlebot_print_to_from() {
		$options = get_option( 'lbi_business', array() );
		$client_obj = new LBI_Client;
		$client = $client_obj->read( get_post_meta( get_the_ID(), '_client', true ) );
		?>
		<table>
		    <tbody>
			    <tr>
			        <td class="label">From</td>
			        <td class="address">
			        	<div class="company"><?php echo $options['business_name']; ?></div>
			        	<?php echo wpautop( $options['address'] ); ?>
			        </td>
			    </tr>						    
	        	<?php if ( $client ): ?>
			    <tr>
			        <td class="label">To</td>
			        <td class="address">
				        	<div class="company"><?php echo $client->data->company_name; ?></div>
				        	<div class="name"><?php echo $client->data->first_name . ' ' . $client->data->last_name; ?></div>
				        	<div class="street"><?php echo $client->data->street_address; ?></div>
				        	<div class="city-state">
					        	<?php 
						        	$city_state_zip = $client->data->city;
						        	// should we output a comma
						        	if ( strlen( $city_state_zip ) ) {
						        		if ( strlen( $client->data->state ) || strlen( $client->data->zip ) ) {
						        			$city_state_zip .= ', ';
						        		}
						        	}

						        	if ( strlen( $client->data->state ) ) {
							        	$city_state_zip .= $client->data->state . ' ';
						        	}

						        	if ( strlen( $client->data->zip ) ) {
							        	$city_state_zip .= $client->data->zip;
						        	}

						        	echo $city_state_zip;
					        	?>
				        	</div>
				        </td>
				    </tr>
	        	<?php endif; ?>
		    </tbody>
		</table>
		<?php
	}

endif;

// print line items
if ( ! function_exists( 'littlebot_print_line_items' ) ) :

	function littlebot_print_line_items() {
		$line_items = get_post_meta( get_the_ID(), '_line_items', true );
		include LBI_PLUGIN_DIR . '/templates/template-line-items.php';
	}

endif;

// print totals
if ( ! function_exists( 'littlebot_print_totals' ) ) :

	function littlebot_print_totals() {
		global $post;
		include LBI_PLUGIN_DIR . '/templates/template-totals.php';
	}

endif;

// print tax amount
if ( ! function_exists( 'get_tax_amount' ) ) :

	function get_tax_amount( $post_id ) {
		return get_post_meta( $post_id, '_subtotal', true ) * ( get_post_meta( $post_id, '_tax_rate', true ) / 100 );
	}

endif;
