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
		        	    'name'    => 'currency',
		        	    'label'   => __( 'Currency', $plugin_name ),
		        	    'desc'    => __( '', $plugin_name ),
		        	    'type'    => 'select',
		        	    'options' => array(
								'AED' => 'AED', 
								'AFN' => 'AFN', 
								'ALL' => 'ALL', 
								'AMD' => 'AMD', 
								'ANG' => 'ANG', 
								'AOA' => 'AOA', 
								'ARS' => 'ARS', 
								'AUD' => 'AUD', 
								'AWG' => 'AWG', 
								'AZN' => 'AZN', 
								'BAM' => 'BAM', 
								'BBD' => 'BBD', 
								'BDT' => 'BDT', 
								'BGN' => 'BGN', 
								'BHD' => 'BHD', 
								'BIF' => 'BIF', 
								'BMD' => 'BMD', 
								'BND' => 'BND', 
								'BOB' => 'BOB', 
								'BRL' => 'BRL', 
								'BSD' => 'BSD', 
								'BTN' => 'BTN', 
								'BWP' => 'BWP', 
								'BYR' => 'BYR', 
								'BZD' => 'BZD', 
								'CAD' => 'CAD', 
								'CDF' => 'CDF', 
								'CHF' => 'CHF', 
								'CLF' => 'CLF', 
								'CLP' => 'CLP', 
								'CNY' => 'CNY', 
								'COP' => 'COP', 
								'CRC' => 'CRC', 
								'CUP' => 'CUP',
								'CVE' => 'CVE',
								'CZK' => 'CZK',
								'DJF' => 'DJF',
								'DKK' => 'DKK',
								'DOP' => 'DOP',
								'DZD' => 'DZD',
								'EGP' => 'EGP',
								'ETB' => 'ETB',
								'EUR' => 'EUR',
								'FJD' => 'FJD',
								'FKP' => 'FKP',
								'GBP' => 'GBP',
								'GEL' => 'GEL',
								'GHS' => 'GHS',
								'GIP' => 'GIP',
								'GMD' => 'GMD',
								'GNF' => 'GNF',
								'GTQ' => 'GTQ',
								'GYD' => 'GYD',
								'HKD' => 'HKD',
								'HNL' => 'HNL',
								'HRK' => 'HRK',
								'HTG' => 'HTG',
								'HUF' => 'HUF',
								'IDR' => 'IDR',
								'ILS' => 'ILS',
								'INR' => 'INR',
								'IQD' => 'IQD',
								'IRR' => 'IRR',
								'ISK' => 'ISK',
								'JEP' => 'JEP',
								'JMD' => 'JMD',
								'JOD' => 'JOD', 
								'JPY' => 'JPY', 
								'KES' => 'KES', 
								'KGS' => 'KGS', 
								'KHR' => 'KHR', 
								'KMF' => 'KMF', 
								'KPW' => 'KPW', 
								'KRW' => 'KRW', 
								'KWD' => 'KWD', 
								'KYD' => 'KYD', 
								'KZT' => 'KZT', 
								'LAK' => 'LAK', 
								'LBP' => 'LBP', 
								'LKR' => 'LKR', 
								'LRD' => 'LRD', 
								'LSL' => 'LSL', 
								'LTL' => 'LTL', 
								'LVL' => 'LVL', 
								'LYD' => 'LYD', 
								'MAD' => 'MAD', 
								'MDL' => 'MDL', 
								'MGA' => 'MGA', 
								'MKD' => 'MKD', 
								'MMK' => 'MMK', 
								'MNT' => 'MNT', 
								'MOP' => 'MOP', 
								'MRO' => 'MRO', 
								'MUR' => 'MUR', 
								'MVR' => 'MVR', 
								'MWK' => 'MWK', 
								'MXN' => 'MXN', 
								'MYR' => 'MYR', 
								'MZN' => 'MZN', 
								'NAD' => 'NAD', 
								'NGN' => 'NGN', 
								'NIO' => 'NIO', 
								'NOK' => 'NOK', 
								'NPR' => 'NPR', 
								'NZD' => 'NZD', 
								'OMR' => 'OMR', 
								'PAB' => 'PAB', 
								'PEN' => 'PEN', 
								'PGK' => 'PGK', 
								'PHP' => 'PHP', 
								'PKR' => 'PKR', 
								'PLN' => 'PLN', 
								'PYG' => 'PYG', 
								'QAR' => 'QAR', 
								'RON' => 'RON', 
								'RSD' => 'RSD', 
								'RUB' => 'RUB', 
								'RWF' => 'RWF', 
								'SAR' => 'SAR', 
								'SBD' => 'SBD', 
								'SCR' => 'SCR', 
								'SDG' => 'SDG', 
								'SEK' => 'SEK', 
								'SGD' => 'SGD', 
								'SHP' => 'SHP', 
								'SLL' => 'SLL', 
								'SOS' => 'SOS', 
								'SRD' => 'SRD', 
								'STD' => 'STD', 
								'SVC' => 'SVC', 
								'SYP' => 'SYP', 
								'SZL' => 'SZL', 
								'THB' => 'THB', 
								'TJS' => 'TJS', 
								'TMT' => 'TMT', 
								'TND' => 'TND', 
								'TOP' => 'TOP', 
								'TRY' => 'TRY', 
								'TTD' => 'TTD', 
								'TWD' => 'TWD', 
								'TZS' => 'TZS', 
								'UAH' => 'UAH', 
								'UGX' => 'UGX', 
								'USD' => 'USD', 
								'UYU' => 'UYU', 
								'UZS' => 'UZS', 
								'VEF' => 'VEF', 
								'VND' => 'VND', 
								'VUV' => 'VUV', 
								'WST' => 'WST', 
								'XAF' => 'XAF', 
								'XCD' => 'XCD', 
								'XDR' => 'XDR', 
								'XOF' => 'XOF', 
								'XPF' => 'XPF', 
								'YER' => 'YER', 
								'ZAR' => 'ZAR', 
								'ZMK' => 'ZMK', 
								'ZWL' => 'ZWL' 
						)
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
