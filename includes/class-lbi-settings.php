<?php
/**
 * LittleBot settings pages
 *
 * @author      Justin W Hall
 * @category    Settings
 * @package     LittleBot Invoices/Settings
 * @version     0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LBI_Settings Class.
 */
class LBI_Settings {


		/**
		 * Holds WeDevs_Settings_API class.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      object    $settings_api   
		 */
		private $settings_api;

		private $plugin_name;


		public function __construct() {

			$this->plugin_name = LBI()->plugin_name;
			$this->settings_api = new WeDevs_Settings_API;

			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );

		}


		public function admin_init() {
		    //set the settings
		    $this->settings_api->set_sections( $this->get_settings_sections() );
		    $this->settings_api->set_fields( $this->get_settings_fields() );
		    //initialize settings
		    $this->settings_api->admin_init();
		}

		public function admin_menu() {
		    add_menu_page( 'LittleBot Invoices', 'LittleBot Invoices', 'delete_posts', 'littlebot_invoices', array($this, 'plugin_page') );
		}

		public function get_settings_sections() {
		    $sections = array(
		        array(
		            'id'    => 'littlebot_invoices_general',
		            'title' => __( 'General Settings', 'littlebot_invoices' )
		        ),
		        array(
		            'id'    => 'littlebot_invoices_business',
		            'title' => __( 'Business', 'littlebot_invoices' )
		        )
		    );
		    return $sections;
		}
		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		public function get_settings_fields() {
		    $settings_fields = array(
		        'littlebot_invoices_general' => array(
		        	array(
		        	    'name'    => 'sp_environment',
		        	    'label'   => __( 'Environment', $plugin_name ),
		        	    'desc'    => __( 'Live or test modes?', $plugin_name ),
		        	    'type'    => 'radio',
		        	    'options' => array(
		        	        'live' => 'Live',
		        	        'test'  => 'Test'
		        	    )
		        	),
	            ),
		        'littlebot_invoices_business' => array(
		            array(
		                'name'              => 'business_name',
		                'label'             => __( 'Business Name', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'text',
		                'default'           => get_bloginfo( 'name' ),
		                'sanitize_callback' => 'sanitize_text_field'
		            ),
		            array(
		                'name'              => 'address',
		                'label'             => __( 'Address', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'textarea'
		            ),


	            )



		    );
		    return $settings_fields;
		}
		
		public function plugin_page() {
		    echo '<div class="wrap">';
		    $this->settings_api->show_navigation();
		    $this->settings_api->show_forms();
		    echo '</div>';
		}
		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		public function get_pages() {
		    $pages = get_pages();
		    $pages_options = array();
		    if ( $pages ) {
		        foreach ($pages as $page) {
		            $pages_options[$page->ID] = $page->post_title;
		        }
		    }
		    return $pages_options;
		}

}

return new LBI_Settings;
