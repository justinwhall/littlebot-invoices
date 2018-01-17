<?php
/**
 *
 * Manages the invoice & estimate details metabox
 *
 * @class     LBI_Invoice_Details
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Invoice_Details Classes.
 */
class LBI_Invoice_Details extends LBI_Admin_Post {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

		$this->post_type_name = 'Invoice';
	}

	/**
	 * Meta box initialization.
	 */
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_details'  )        );
		add_action( 'save_post',      array( $this, 'save_details' ), 10, 2 );
	}

	/**
	 * Adds the meta box.
	 */
	public function add_details() {
		add_meta_box(
			'lbi-inovoice-details',
			__( $this->post_type_name . ' Details', 'little-bot-invoices' ),
			array( $this, 'render_details_metabox' ),
			array( 'lb_invoice', 'lb_estimate' ),
			'side',
			'default'
		);

	}

	/**
	 * Renders invoice & estimate details.
	 */
	public function render_details_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		// details metabox
		require_once LBI_PLUGIN_DIR . 'views/html-estimate-invoice-details.php';
		// add client modal
		require_once LBI_PLUGIN_DIR . 'views/html-estimate-invoice-add-client-modal.php';
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return null
	 */
	public function save_details( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
		$nonce_action = 'custom_nonce_action';

		$save = $this->validate_save_action( $nonce_name, $nonce_action, $post_id );

		if ( ! $save ) return;

		// If we make this far sanitize & update
		if ( isset( $_POST['_invoice_number'] ) ) {
			update_post_meta( $post_id, '_invoice_number', sanitize_text_field( $_POST['_invoice_number'] ) );
		}

		if ( isset( $_POST['_estimate_number'] ) ) {
			update_post_meta( $post_id, '_estimate_number', sanitize_text_field( $_POST['_estimate_number'] ) );
		}

		if ( isset( $_POST['_po_number'] ) ) {
			update_post_meta( $post_id, '_po_number', sanitize_text_field( $_POST['_po_number'] ) );
		}

		if ( isset( $_POST['_tax_rate'] ) ) {
			$tax_rate = $_POST['_tax_rate'];
		} else {
			$tax_rate = 0;
		}
		update_post_meta( $post_id, '_tax_rate', sanitize_text_field( $tax_rate ) );

		if ( isset( $_POST['_client'] ) ) {
			update_post_meta( $post_id, '_client', $_POST['_client'] );
		}

		if ( 'lb_invoice' == get_post_type( $post_id ) ) {
			$hide_payment = ( isset( $_POST['_hide_payment_buttons'] ) ) ? $_POST['_hide_payment_buttons'] : false;
			update_post_meta( $post_id, '_hide_payment_buttons', $hide_payment );
		}

		// Valid Until & Due date
		if ( isset( $_POST['due_mm'] ) && isset( $_POST['due_j'] ) && isset( $_POST['due_y'] ) ) {
			$due_date = strtotime( $_POST['due_mm'] . '/' . $_POST['due_j'] . '/' . $_POST['due_y'] );
			$option_key = ( $post->post_type == 'lb_invoice' ) ? '_due_date' : '_valid_until';
			update_post_meta( $post_id, $option_key, $due_date );
		}

	}
}

new LBI_Invoice_Details();
