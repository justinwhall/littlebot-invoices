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
class LBI_Log_Metabox extends LBI_Admin_Post {
 
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
    }
 
    /**
     * Adds the meta box.
     */
    public function add_details() {
        add_meta_box(
            'lbi-log',
            __( 'Log', 'littlebot-invoices' ),
            array( $this, 'render_log_metabox' ),
            array( 'lb_invoice', 'lb_estimate' ),
            'side',
            'default'
        );
 
    }

    /**
     * Renders invoice & estimate details.
     */
    public function render_log_metabox( $post ) {
        $log = get_post_meta( $post->ID, '_lbi_log', true );

        if ( !$log ) return;

        foreach ( $log as $timestamp => $event ) {
            echo '<div class="single-log">';
            echo '<div class="event">' . $event['event'] . '</div>';
            echo '<div class="message">' . $event['message'] . '</div>';
            echo '<div class="log-date">'. date_i18n( 'F j, Y | H:i:s', $timestamp ) . '</div>';
            if ( $event['user'] ) {
                echo '<div class="by"> By '. $event['user']. '</div>';
            }
            echo '</div>';
            echo '<div class="lbi-arrow"><span class="dashicons dashicons-arrow-down-alt2"></span></div>';
        }
    }
 
}
 
new LBI_Log_Metabox();