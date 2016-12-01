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

// gets an estimate number
if ( ! function_exists( 'littlebot_get_estimate_number' ) ) :

	function littlebot_get_estimate_number( $id = 0 ) {
		$number = LBI_Estimate::get_number( get_the_ID() );
		return apply_filters( 'littlebot_get_estimate_number', $number, $client );
	}

endif;

// print the to and from address
if ( ! function_exists( 'littlebot_print_to_from' ) ) :

	function littlebot_print_to_from() {
		$options = get_option( 'littlebot_invoices_business', array() );
		$client_obj = new LBI_Client;
		$client = $client_obj->read( get_post_meta( get_the_ID(), '_lb_client', true ) );
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
			    <tr>
			        <td class="label">To</td>
			        <td class="address">
			        	<div class="company"><?php echo $client->data->company_name; ?></div>
			        	<div class="name"><?php echo $client->data->first_name . ' ' . $client->data->last_name; ?></div>
			        	<div class="street"><?php echo $client->data->street_address; ?></div>
			        	<div class="city-state">
			        	<?php 
				        	$city_state_zip = $client->data->city;
				        	// should be output a comma
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
		// $post_id = get_the_ID();
		global $post;
		include LBI_PLUGIN_DIR . '/templates/template-totals.php';
	}

endif;

// print tax amount
if ( ! function_exists( 'get_tax_amount' ) ) :

	function get_tax_amount( $post_id ) {
		return get_post_meta( $post_id, '_subtotal', true ) * ( get_post_meta( $post_id, '_lb_tax_rate', true ) / 100 );
	}

endif;
