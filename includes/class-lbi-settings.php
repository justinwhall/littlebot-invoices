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


		static $options = array(
			'lbi_general',
			'lbi_business',
			'lbi_estimates',
			'lbi_invoices',
			'lbi_emails',
			'lbi_payments'
		);


		public function __construct() {

			$this->settings_api = new WeDevs_Settings_API;

			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );

		}

		static function littlebot_get_option( $option_key, $option_id, $single = true ){
			$options = get_option( $option_id, $single );
			if ( is_array( $options ) && array_key_exists( $option_key, $options ) ) {
				$val = $options[$option_key];
			} else{
				$val = false;
			}
			return $val;
		}

		public function admin_init() {
			//set the settings
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );
			//initialize settings
			$this->settings_api->admin_init();

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
				),
				array(
					'id'    => 'lbi_payments',
					'title' => __( 'Payments', 'littlebot_invoices' )
				)
			);

			return apply_filters( 'lbi_settings_sections', $sections );
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
						'label'             => __( 'Currency Symbol', 'littlebot-invoices' ),
						'desc'              => __( 'USD is <code>$</code>', 'littlebot-invoices' ),
						'type'              => 'text',
						'default'           => '$',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'currency_code',
						'label'             => __( 'Currency Code', 'littlebot-invoices' ),
						'desc'              => '',
						'type'              => 'text',
						'default'           => 'USD',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'    => 'currency_position',
						'label'   => __( 'Currency Position', 'littlebot-invoices' ),
						'desc'    => '',
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
						'label'             => __( 'Thousand Separator', 'littlebot-invoices' ),
						'desc'              => __( 'The character that\'s used to separate displayed prices ex: <code>100,000</code>', 'littlebot-invoices' ),
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => ',',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'decimal_sep',
						'label'             => __( 'Decimal Separator', 'littlebot-invoices' ),
						'desc'              => __( 'The decimal that\'s used to separate displayed prices ex: <code>1000.00</code>', 'littlebot-invoices' ),
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '.',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'decimal_num',
						'label'             => __( 'Number of Decimals', 'littlebot-invoices' ),
						'desc'              => __( 'The number of decimals to use when displaying prices ex: 2 = <code>100.00</code>', 'littlebot-invoices' ),
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => 2,
						'sanitize_callback' => 'sanitize_text_field'
					)
				),
				'lbi_business' => array(
					array(
						'name'              => 'logo',
						'label'             => __( 'Business Logo', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'file'
					),
					array(
						'name'              => 'business_name',
						'label'             => __( 'Business Name', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => get_bloginfo( 'name' ),
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'address',
						'label'             => __( 'Address', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'textarea'
					),
					array(
						'name'              => 'business_email',
						'label'             => __( 'Business Email', 'littlebot-invoices' ),
						'desc'              => __( 'This email will send notification to your clients', 'littlebot-invoices' ),
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					)

				),
				'lbi_estimates' => array(
					array(
						'name'              => 'terms',
						'label'             => __( 'Terms &amp; Conditions', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					),
					array(
						'name'              => 'notes',
						'label'             => __( 'Notes', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					)
				),
				'lbi_invoices' => array(
					array(
						'name'              => 'hide_pdf',
						'label'             => __( 'Hide PDF', 'littlebot-invoices' ),
						'desc'              => __( 'Hides the PDF download button on invoices if checked.', 'littlebot-invoices' ),
						'type'              => 'checkbox'
					),
					array(
						'name'              => 'terms',
						'label'             => __( 'Terms &amp; Conditions', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					),
					array(
						'name'              => 'notes',
						'label'             => __( 'Notes', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					)
				),
				'lbi_emails' => array(
					array(
						'name'              => 'html_emails',
						'label'             => __( 'Send HTML emails', 'littlebot-invoices' ),
						'desc'              => __( 'Check to send HTML emails. Otherwise, emails are sent as plain text.', 'littlebot-invoices' ),
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
						'label'             => __( 'New Estimate Subject', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'estimate_new_body',
						'label'             => __( 'New Estimate Body', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					),
					array(
						'name'              => 'invoice_new_subject',
						'label'             => __( 'New Invoice Subject', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'invoice_new_body',
						'label'             => __( 'New Invoice Body', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					),
					array(
						'name'              => 'invoice_overdue_subject',
						'label'             => __( 'Invoice Overdue Subject', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'invoice_overdue_body',
						'label'             => __( 'Invoice Overdue Body', 'littlebot-invoices' ),
						'desc'              => '',
						'placeholder'       => '',
						'type'              => 'wysiwyg',
						'default'           => ''
					)
				),
				'lbi_payments' => array(
					array(
						'name'              => 'enable_paypal_standard',
						'label'             => __( 'Enable PayPal Standard', 'littlebot-invoices' ),
						'desc'              => __( 'Enables offsite credit card checkout by PayPal. Can be used in conjunction with payment gateways.', 'littlebot-invoices' ),
						'type'              => 'checkbox'
					),
					array(
						'name'              => 'paypal_email',
						'label'             => __( 'Paypal Email', 'littlebot-invoices' ),
						'desc'              => __( 'Email you would like money sent to', 'littlebot-invoices' ),
						'placeholder'       => '',
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
							'name'              => 'paypal_environment',
							'label'             => __( 'PayPal Environment', 'littlebot-invoices' ),
							'desc'              => __( 'Live or Test mode?', 'littlebot-invoices' ),
							'placeholder'       => '',
							'type'              => 'radio',
							'options'           => array( 'live' => 'Live', 'test' => 'Test')
					),
					array(
						'name'    => 'payment_gateway',
						'label'   => __( 'Payment Gateways', 'littlebot-invoices' ),
						'desc'    => 'Try the <a href="/wp-admin/admin.php?page=littlebot_invoices-addons">Stripe Addon</a>',
						'type'    => 'select',
						'options' => array(
								'' => '--',
						),
					),
				),

			);
			return apply_filters( 'lbi_settings_fields', $settings_fields );
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
