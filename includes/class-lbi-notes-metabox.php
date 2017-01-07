<?php
/**
 *
 * Manages the invoice & estimate notes metabox
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
class LBI_Notes_Metabox extends LBI_Admin_Post {
 
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
        add_action( 'add_meta_boxes', array( $this, 'add_notes'  )        );
        add_action( 'save_post',      array( $this, 'save_notes' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_notes() {
        add_meta_box(
            'lbi-notes',
            __( 'Notes', 'littlebot-invoices' ),
            array( $this, 'render_notes_metabox' ),
            array( 'lb_invoice', 'lb_estimate' ),
            'normal',
            'default'
        );
 
    }

    /**
     * Renders invoice & estimate details.
     */
    public function render_notes_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'nonce_action', 'lbi_notes_nonce' );
        $option_id = ( $post->post_type = 'lb_invoice' ) ? 'lbi_invoices' : 'lbi_estimates';
        $options = get_option( $option_id );
        $content = ( get_post_meta( $post->ID, '_notes', true ) ) ? get_post_meta( $post->ID, '_notes', true ) : $options['notes'];
        wp_editor( $content, '_lbi_notes', $settings = array('editor_height' => 200) );
    }

    public function save_notes( $post_id, $post ){
        
        $nonce_name   = isset( $_POST['lbi_notes_nonce'] ) ? $_POST['lbi_notes_nonce'] : '';
        $nonce_action = 'nonce_action';
        $save = $this->validate_save_action( $nonce_name, $nonce_action, $post_id);

        if ( !$save ) return;

        update_post_meta( $post_id, '_notes', sanitize_text_field( $_POST['_lbi_notes'] ) );
    }
 
}
 
new LBI_Notes_Metabox();