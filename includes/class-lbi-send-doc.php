<?php
/**
 * Send Estimate/Invoice to client
 *
 *
 * @class     LBI_Send_Doc
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Send_Doc Classes.
 */
class LBI_Send_Doc extends LBI_Admin_Post {
 
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
        // add_action( 'save_post',      array( $this, 'save_line_items' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_line_items() {
        add_meta_box(
            'lbi-send-doc',
            __( 'Send to Client', 'little-bot-invoices' ),
            array( $this, 'render_send_to_client' ),
            array( 'lb_invoice', 'lb_estimate' ),
            'side',
            'default'
        );
 
    }
 
    /**
     * Renders the meta box.
     */
    public function render_send_to_client( $post ) {
        $client = new LBI_Client;
        // If there is a client, well set a default email
        $client_meta = $client->read( get_post_meta( $post->ID, '_client', true ) );
        if ( $client_meta ) {
            $client_email = $client_meta->data->user_email;
        }
        require_once LBI_PLUGIN_DIR . 'views/html-admin-send-doc.php';
    }

}
 
new LBI_Send_Doc;

