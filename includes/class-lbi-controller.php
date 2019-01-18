<?php

/**
 * LittleBot Invoices Controller
 *
 *
 * @class     LBI_Controller
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LBI_Controller
{

    private static $query_vars = array();

    /**
     * Kick it off
     */
    static function init(){

    }

    /**
     * Register a query var and a callback method
     * @param  string $var      query variable
     * @param  string $callback callback for query variable
     * @return null
     */
    protected static function register_query_var( $var, $callback = '' ) {
        self::add_register_query_var_hooks();
        self::$query_vars[ $var ] = $callback;
    }

    /**
     * Register query var hooks with WordPress.
     */
    private static function add_register_query_var_hooks() {
        static $registered = false; // only do this once
        if ( ! $registered ) {
            add_filter( 'query_vars', array( __CLASS__, 'filter_query_vars' ) );
            add_action( 'parse_request', array( __CLASS__, 'handle_callbacks' ), 10, 1 );
            $registered = true;
        }
    }

    /**
     * Add query vars into the filtered query_vars filter
     * @param  array  $vars
     * @return array  $vars
     */
    public static function filter_query_vars( array $vars ) {
        $vars = array_merge( $vars, array_keys( self::$query_vars ) );
        return $vars;
    }

    /**
     * Handle callbacks for registered query vars
     * @param  WP     $wp
     * @return null
     */
    public static function handle_callbacks( WP $wp ) {

        foreach ( self::$query_vars as $var => $callback ) {

            if ( isset( $wp->query_vars[ $var ] ) && $wp->query_vars[ $var ] && $callback && is_callable( $callback ) ) {
                // var_dump( $callback ); die;
                call_user_func( $callback, $wp );
            }
        }
    }

    public static function print_messages(){

        if ( ! isset( $_REQUEST['lbi_messages'] )) return;

        $messages = $_REQUEST['lbi_messages'];

        $args = array(
            'status' => $messages['status'],
            'message' => $messages['message'],
         );

        self::load_view('html-messages', $args );
    }

    /**
     * Display the template for the given view
     *
     * @static
     * @param string  $view
     * @param bool    $allow_theme_override
     * @return void
     */
    public static function load_view( $view, $args = array(), $allow_theme_override = true, $plugin_root = LBI_PLUGIN_DIR ) {
        // whether or not .php was added
        if ( substr( $view, -4 ) != '.php' ) {
            $view .= '.php';
        }
        // TODO: Allow override
        $file = apply_filters( 'lbi_views_path', $plugin_root . 'views/' . $view );
        if ( ! empty( $args ) ) { extract( $args ); }
        include $file;
    }


}

return new LBI_Controller;