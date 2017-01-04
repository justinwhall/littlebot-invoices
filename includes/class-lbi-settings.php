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

		static $options = array(
			'lbi_general',
			'lbi_business',
			'lbi_estimates',
			'lbi_invoices',
			'lbi_emails'
		);


		public function __construct() {

			$this->plugin_name = LBI()->plugin_name;
			$this->settings_api = new WeDevs_Settings_API;

			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );

		}

		static function littlebot_get_option( $option_key, $option_id, $single = true){
			$options = get_option( $option_id, $single);
			return $options[$option_key];
		}

		public function admin_init() {
		    //set the settings
		    $this->settings_api->set_sections( $this->get_settings_sections() );
		    $this->settings_api->set_fields( $this->get_settings_fields() );
		    //initialize settings
		    $this->settings_api->admin_init();

		    // var_dump( get_option( 'lbi_business', false ) );die;
		}

		public function admin_menu() {
		    add_menu_page( 'LittleBot Invoices', 'LittleBot Invoices', 'delete_posts', 'littlebot_invoices', array($this, 'plugin_page'), 'dashicons-littlebot-icon' );
		}

		public function get_settings_sections() {
		    $sections = array(
		        array(
		            'id'    => 'lbi_general',
		            'title' => __( 'General Settings', 'littlebot_invoices' )
		        ),
		        array(
		            'id'    => 'lbi_business',
		            'title' => __( 'Business', 'littlebot_invoices' )
		        ),
		        array(
		            'id'    => 'lbi_estimates',
		            'title' => __( 'Estimates', 'littlebot_invoices' )
		        ),
		        array(
		            'id'    => 'lbi_invoices',
		            'title' => __( 'Invoices', 'littlebot_invoices' )
		        ),		        
		        array(
		            'id'    => 'lbi_emails',
		            'title' => __( 'Emails', 'littlebot_invoices' )
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
		        'lbi_general' => array(
		        	array(
		        	    'name'              => 'currency_symbol',
		        	    'label'             => __( 'Currency Symbol', $plugin_name ),
		        	    'desc'              => __( 'USD is <code>$</code>', $plugin_name ),
		        	    'type'              => 'text',
		        	    'default'           => '$',
		        	    'sanitize_callback' => 'sanitize_text_field'
		        	),
		        	array(
		        	    'name'    => 'currency_position',
		        	    'label'   => __( 'Currency Position', $plugin_name ),
		        	    'desc'    => __( '', $plugin_name ),
		        	    'type'    => 'select',
		        	    'options' => array(
								'left' => 'Left ($99.99)', 
								'right' => 'Right (99.99$)', 
								'left_space' => 'Left with space ($ 99.99)', 
								'right_space' => 'Right with space (99.99 $)'
						)
		        	),
		        	array(
		        	    'name'              => 'thousand_sep',
		        	    'label'             => __( 'Thousand Separator', $plugin_name ),
		        	    'desc'              => __( 'The character that\'s used to separate displayed prices ex: <code>100,000</code>', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'text',
		        	    'default'           => ',',
		        	    'sanitize_callback' => 'sanitize_text_field'
		        	),
		        	array(
		        	    'name'              => 'decimal_sep',
		        	    'label'             => __( 'Decimal Separator', $plugin_name ),
		        	    'desc'              => __( 'The decimal that\'s used to separate displayed prices ex: <code>1000.00</code>', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'text',
		        	    'default'           => '.',
		        	    'sanitize_callback' => 'sanitize_text_field'
		        	),
		        	array(
		        	    'name'              => 'decimal_num',
		        	    'label'             => __( 'Number of Decimals', $plugin_name ),
		        	    'desc'              => __( 'The number of decimals to use when displaying prices ex: 2 = <code>100.00</code>', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'text',
		        	    'default'           => 2,
		        	    'sanitize_callback' => 'sanitize_text_field'
		        	)
	            ),
		        'lbi_business' => array(
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
		            array(
		                'name'              => 'business_email',
		                'label'             => __( 'Business Email', $plugin_name ),
		                'desc'              => __( 'This email will send notification to your clients', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'text',
		                'default'           => '',
		                'sanitize_callback' => 'sanitize_text_field'
		            )

	            ),
		        'lbi_estimates' => array(
		        	array(
		        	    'name'              => 'terms',
		        	    'label'             => __( 'Terms &amp; Conditions', $plugin_name ),
		        	    'desc'              => __( '', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'wysiwyg',
		        	    'default'           => ''
		        	),
		        	array(
		        	    'name'              => 'notes',
		        	    'label'             => __( 'Notes', $plugin_name ),
		        	    'desc'              => __( '', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'wysiwyg',
		        	    'default'           => ''
		        	)
	            ),
		        'lbi_invoices' => array(
		        	array(
		        	    'name'              => 'terms',
		        	    'label'             => __( 'Terms &amp; Conditions', $plugin_name ),
		        	    'desc'              => __( '', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'wysiwyg',
		        	    'default'           => ''
		        	),
		        	array(
		        	    'name'              => 'notes',
		        	    'label'             => __( 'Notes', $plugin_name ),
		        	    'desc'              => __( '', $plugin_name ),
		        	    'placeholder'       => __( '', $plugin_name ),
		        	    'type'              => 'wysiwyg',
		        	    'default'           => ''
		        	)
	            ),
		        'lbi_emails' => array(
		            array(
		                'name'              => 'html_emails',
		                'label'             => __( 'Send HTML emails', $plugin_name ),
		                'desc'              => __( 'Check to send HTML emails. Otherwise, emails are sent as plain text.', $plugin_name ),
		                'type'              => 'checkbox'
		            ),
		            array(
		                'name'        => 'token_html',
		                'label'		  => __('Token Key'),
		                'desc'        => '',
		                'type'        => 'token_html'
		            ),
		            array(
		                'name'              => 'estimate_new_subject',
		                'label'             => __( 'New Estimate Subject', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'text',
		                'default'           => '',
		                'sanitize_callback' => 'sanitize_text_field'
		            ),
		            array(
		                'name'              => 'estimate_new_body',
		                'label'             => __( 'New Estimate Body', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'wysiwyg',
		                'default'           => ''
		            ),
		            array(
		                'name'              => 'invoice_new_subject',
		                'label'             => __( 'New Invoice Subject', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'text',
		                'default'           => '',
		                'sanitize_callback' => 'sanitize_text_field'
		            ),
		            array(
		                'name'              => 'invoice_new_body',
		                'label'             => __( 'New Invoice Body', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'wysiwyg',
		                'default'           => ''
		            ),
		            array(
		                'name'              => 'invoice_overdue_subject',
		                'label'             => __( 'Invoice Overdue Subject', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'text',
		                'default'           => '',
		                'sanitize_callback' => 'sanitize_text_field'
		            ),
		            array(
		                'name'              => 'invoice_overdue_body',
		                'label'             => __( 'Invoice Overdue Body', $plugin_name ),
		                'desc'              => __( '', $plugin_name ),
		                'placeholder'       => __( '', $plugin_name ),
		                'type'              => 'wysiwyg',
		                'default'           => ''
		            )
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
