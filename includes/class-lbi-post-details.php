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

        $this->post_type_name = 'Invoice';
    }

    /**
     * Gets the due date of an invoice if stored in the DB, otherwise generates one +30 days 
     * @param  int $post_id the post ID
     * @return string unix timestamp
     */
    public function get_due_date( $post_id ){

        $saved_date = get_post_meta( $post_id, '_lb_post_datate', true );

        if ( strlen( $saved_date ) ) {
            $due_date = $saved_date;
        } else{
            $due_date = strtotime( '+30 days', current_time('timestamp') );
        }

        return $due_date;
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
        require_once LBI_PLUGIN_DIR . 'views/html-estimate-invoice-details.php';
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
        if ( isset( $_POST['_lb_invoice_number'] ) ) {
           update_post_meta( $post_id, '_lb_invoice_number', sanitize_text_field( $_POST['_lb_invoice_number'] ) );
        }

        if ( isset( $_POST['_lb_po_number'] ) ) {
           update_post_meta( $post_id, '_lb_po_number', sanitize_text_field( $_POST['_lb_po_number'] ) );
        }

        if ( isset( $_POST['_lb_tax_rate'] ) ) {
           update_post_meta( $post_id, '_lb_tax_rate', sanitize_text_field( $_POST['_lb_tax_rate'] ) );
        }

        if ( isset( $_POST['_lb_client'] ) ) {
           update_post_meta( $post_id, '_lb_client', $_POST['_lb_client'] );
        }

    }
}
 
new LBI_Invoice_Details();