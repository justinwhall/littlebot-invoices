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


if ( ! function_exists( 'littlebot_print_logo') ) :

	function littlebot_print_logo() {
		$logo_src = littlebot_get_option( 'logo', 'lbi_business');
		if ( strlen( trim( $logo_src ) ) ) {
			$img = '<img src="' . $logo_src .'" id="lb-logo" />';
			echo apply_filters( 'littlebot_print_logo', $img );
		}
	}

endif;

if ( ! function_exists( 'littlebot_get_option') ) :

	function littlebot_get_option( $option_key, $option_id, $single = true ) {
		$option = LBI_Settings::littlebot_get_option( $option_key, $option_id, $single = true);
		return apply_filters( 'littlebot_get_option', $option );
	}

endif;

if ( ! function_exists( 'littlebot_get_selected_gateway' ) ) :

	function littlebot_get_selected_gateway() {
		$active_gateway = LBI()->gateways->selected;
		return apply_filters( 'littlebot_get_selected_gateway', $active_gateway );
	}

endif;

if ( ! function_exists( 'littlebot_notes' ) ) :

	function littlebot_notes( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		if ( !strlen( get_post_meta( $post_id, '_notes', true ) ) ) return;

		$html = '<div class="lb-notes">';
		$html .= '<div><strong>' . __('Notes', 'littlebot-invoices') . ':</strong></div>';
		$html .= get_post_meta( $post_id, '_notes', true );
		$html .= '</div>';
		echo apply_filters( 'littlebot_notes', $html );
	}

endif;

if ( ! function_exists( 'littlebot_print_messages' ) ) :

	function littlebot_print_messages() {
		lbi_controller::print_messages();
	}

endif;

if ( ! function_exists( 'littlebot_terms' ) ) :

	function littlebot_terms( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		if ( !strlen( get_post_meta( $post_id, '_terms', true ) ) ) return;

		$html = '<div class="lb-terms">';
		$html .= '<div><strong>Terms:</strong></div>';
		$html .= get_post_meta( $post_id, '_terms', true );
		$html .= '</div>';
		echo apply_filters( 'littlebot_terms', $html );
	}

endif;

// gets invoice due date
if ( ! function_exists( 'littlebot_get_client' ) ) :

	function littlebot_get_client( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$client = new LBI_Client();
		$client = $client->read( get_post_meta( $post_id, '_client', true ) );
		return apply_filters( 'littlebot_get_client', $client );
	}

endif;

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

// gets invoice due date
if ( ! function_exists( 'littlebot_getsubtotal' ) ) :

	function littlebot_get_subtotal( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$meta = get_post_meta( $post_id, '', true );
		$total = isset( $meta['_subtotal'] ) ? LBI_Admin_Post::get_formatted_currency( $meta['_subtotal'][0] ) : 0;
		return apply_filters( 'littlebot_get_sub_total', $total );
	}

endif;

// get formatted tax total
if ( ! function_exists( 'littlebot_get_tax_total' ) ) :

	function littlebot_get_tax_total( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$sub = get_post_meta( $post_id, '_subtotal', true );
		$tax_rate = intval( get_post_meta( $post_id, '_tax_rate', true ) ) / 100;
		$tax = intVal( $sub ) * $tax_rate;
		$tax_formatted = ( $tax ) ? LBI_Admin_Post::get_formatted_currency( $tax ) : false;
		return apply_filters( 'littlebot_get_tax_total', $tax_formatted );
	}

endif;

// gets invoice total
if ( ! function_exists( 'littlebot_get_total' ) ) :

	function littlebot_get_total( $post_id = 0 ) {
		$post_id = ( ! $post_id ) ? get_the_ID() : $post_id;
		$meta = get_post_meta( $post_id, '', true );
		$total = isset( $meta['_total'] ) ? LBI_Admin_Post::get_formatted_currency( $meta['_total'][0] ) : 0;
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

// gets invoice valid until date
if ( ! function_exists( 'littlebot_get_estimate_valid_until' ) ) :

	function littlebot_get_estimate_valid_until( $id = 0 ) {
		if ( !$id ) {
			$id = get_the_ID();
		}
		$valid_until = LBI_Estimate::get_valid_until( $id );
		return apply_filters( 'littlebot_get_estimate_valid_until', $valid_until );
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
			        	<?php if (isset($options['address'])){ echo wpautop( $options['address'] ); }?>
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


if ( ! function_exists( 'littlebot_print_doc_js' ) ) :

	function littlebot_print_doc_js() {
		global $post;

		$business_name = littlebot_get_option( 'business_name', 'lbi_business' );

		$inline_js = [
			'postId'        => get_the_ID(),
			'docTitle'      => get_the_title(),
			'ajaxUrl'       => admin_url('admin-ajax.php'),
			'nonce'         => wp_create_nonce('lb-invoices'),
			'invoiceNumber' => get_post_meta( $post->ID , '_invoice_number', true ),
			'businessName'  => $business_name,
		];
		
		$inline_js_filtered = apply_filters('littlebot_print_doc_js', $inline_js );

		?>

			<script>
				var littlebotConfig = <?php echo json_encode( $inline_js_filtered ) ?>;
			</script>

		<?php
	}

endif;

// filters
add_action( 'lbi_payment_buttons', 'lbi_render_payment_buttons', 10, 1 );

function lbi_render_payment_buttons(){
	if ( empty( LBI()->gateways->active ) ) {
		echo '<span class="pending-payment">' . __( 'Pending Payment', 'littebot-invoices' ) . '</span>';
	} else{
		echo '<span class="pay">' . __( 'Pay Invoice', 'littebot-invoices' ) . '</span>';
	}
}
