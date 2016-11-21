<?php
/**
 *
 * Mangages the invoice & estimate details metabox
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
            __( 'Invoice Details', 'little-bot-invoices' ),
            array( $this, 'render_metabox' ),
            'lb_invoice',
            'side',
            'default'
        );
 
    }
 
    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
        require_once LBI_PLUGIN_DIR . 'views/admin-invoice-details.php';
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
 
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        // If we make this far sanatize & update
        if ( isset( $_POST['lb_invoice_number'] ) ) {
           update_post_meta( $post_id, 'lb_invoice_number', sanitize_text_field( $_POST['lb_invoice_number'] ) );
        }

        if ( isset( $_POST['lb_po_number'] ) ) {
           update_post_meta( $post_id, 'lb_po_number', sanitize_text_field( $_POST['lb_po_number'] ) );
        }

        if ( isset( $_POST['lb_tax_rate'] ) ) {
           update_post_meta( $post_id, 'lb_tax_rate', sanitize_text_field( $_POST['lb_tax_rate'] ) );
        }

    }
}
 
new LBI_Invoice_Details();