<?php
/**
 * Admin Line Items
 *
 * Mangages the line items metabox
 *
 * @class     LBI_Line_Items
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Line_Items Classes.
 */
class LBI_Line_Items extends LBI_Admin_Post {
 
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
        add_action( 'add_meta_boxes', array( $this, 'add_line_items'  )        );
        add_action( 'save_post',      array( $this, 'save_line_items' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_line_items() {
        add_meta_box(
            'lbi-line-items',
            __( 'Line Items', 'little-bot-invoices' ),
            array( $this, 'render_line_items' ),
            array( 'lb_invoice', 'lb_estimate' ),
            'normal',
            'default'
        );
 
    }
 
    /**
     * Renders the meta box.
     */
    public function render_line_items( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
        require_once LBI_PLUGIN_DIR . 'views/html-admin-invoice-line-items.php';
    }
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_line_items( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

        $save = $this->validate_save_action( $nonce_name, $nonce_action, $post_id);

        if ( !$save ) return;

        $all_line_items = array();
        foreach ( $_POST['item_title'] as $i => $title ) {
            $line_item = array();

            $line_item['item_title']   = sanitize_text_field( $title );
            $line_item['item_desc']    = sanitize_text_field( $_POST['item_desc'][$i] );
            $line_item['item_qty']     = sanitize_text_field( $_POST['item_qty'][$i] );
            $line_item['item_rate']    = sanitize_text_field( $_POST['item_rate'][$i] );
            $line_item['item_percent'] = sanitize_text_field( $_POST['item_percent'][$i] );
            $line_item['item_amount']  = sanitize_text_field( $_POST['item_amount'][$i] );

            $all_line_items[] = $line_item;
        }

        update_post_meta( $post_id, '_line_items', $all_line_items );
        update_post_meta( $post_id, '_subtotal', $_POST['_subtotal'] );
        update_post_meta( $post_id, '_total', $_POST['_total'] );
    }
}
 
new LBI_Line_Items();
