<?php
/**
 * Emails
 *
 * @author      Justin W Hall
 * @category    Assets
 * @package     LittleBot Invoices/Emails
 * @version     0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EDD_Emails Class
 *
 * @since 0.9
 */
class LBI_Emails {

	/**
	 * Holds the from address
	 *
	 * @since 0.9
	 */
	private $from_address;

	/**
	 * Holds the from name
	 *
	 * @since 0.9
	 */
	private $from_name;

	/**
	 * Holds the email content type
	 *
	 * @since 0.9
	 */
	private $content_type;

	/**
	 * Holds the email headers
	 *
	 * @since 0.9
	 */
	private $headers;

	/**
	 * Whether to send email in HTML
	 *
	 * @since 0.9
	 */
	private $html = true;

	/**
	 * The email template to use
	 *
	 * @since 0.9
	 */
	private $template;

	/**
	 * The header text for the email
	 *
	 * @since  0.9
	 */
	private $heading = '';

	/**
	 * Get things going
	 *
	 * @since 0.9
	 */
	public function __construct() {

		if ( 'none' === $this->get_template() ) {
			$this->html = false;
		}

		add_action( 'lbi_email_send_before', array( $this, 'send_before' ) );
		add_action( 'lbi_email_send_after', array( $this, 'send_after' ) );

	}

	/**
	 * Set a property
	 *
	 * @since 0.9
	 */
	public function __set( $key, $value ) {
		$this->$key = $value;
	}

	/**
	 * Get a property
	 *
	 * @since 2.6.9
	 */
	public function __get( $key ) {
		return $this->$key;
	}

	/**
	 * Get the email from name
	 *
	 * @since 0.9
	 */
	public function get_from_name() {
		if ( ! $this->from_name ) {
			$this->from_name = 'Test Name';
		}

		return wp_specialchars_decode( $this->from_name );
	}

	/**
	 * Get the email from address
	 *
	 * @since 0.9
	 */
	public function get_from_address() {

		if ( ! $this->from_address ) {
			$this->from_address = 'test@email.com';
		}

		return $this->from_address;
	}

	/**
	 * Get the email content type
	 *
	 * @since 0.9
	 */
	public function get_content_type() {

		return 'text/plain';
	}

	/**
	 * Get the email headers
	 *
	 * @since 0.9
	 */
	public function get_headers() {
		
		if ( ! $this->headers ) {
			$this->headers  = "From: {$this->get_from_name()} <{$this->get_from_address()}>\r\n";
			$this->headers .= "Reply-To: {$this->get_from_address()}\r\n";
			$this->headers .= "Content-Type: {$this->get_content_type()}; charset=utf-8\r\n";
		}

		return $this->headers;
	}

	/**
	 * Retrieve email templates
	 *
	 * @since 0.9
	 */
	public function get_templates() {
		$templates = array(
			'default' => __( 'Default Template', 'littlebot-invoices' ),
			'none'    => __( 'No template, plain text only', 'littlebot-invoices' )
		);

		return apply_filters( 'edd_email_templates', $templates );
	}

	/**
	 * Get the enabled email template
	 *
	 * @since 0.9
	 *
	 * @return string|null
	 */
	public function get_template() {

	}

	/**
	 * Get the header text for the email
	 *
	 * @since 0.9
	 */
	public function get_heading() {
		return apply_filters( 'edd_email_heading', $this->heading );
	}

	/**
	 * Build the final email
	 *
	 * @since 0.9
	 * @param string $message
	 *
	 * @return string
	 */
	public function build_email( $message ) {

		// TODO: build HTML email.

		return  $message;
	}

	/**
	 * Send the email
	 * @param  string  $to               The To address to send to.
	 * @param  string  $subject          The subject line of the email to send.
	 * @param  string  $message          The body of the email to send.
	 * @param  string|array $attachments Attachments to the email in a format supported by wp_mail()
	 * @since 0.9
	 */
	public function send( $to, $subject, $message, $attachments = '' ) {


		if ( ! did_action( 'init' ) && ! did_action( 'admin_init' ) ) {
			_doing_it_wrong( __FUNCTION__, __( 'You cannot send email with LBI_Emails until init/admin_init has been reached', 'littlebot-invoices' ), null );
			return false;
		}

		/**
		 * Hooks before the email is sent
		 *
		 * @since 0.9
		 */
		do_action( 'lbi_email_send_before', $this );

		$message = $this->build_email( $message );

		$sent  = wp_mail( $to, $subject, $message, $this->get_headers(), $attachments );


		/**
		 * Hooks after the email is sent
		 *
		 * @since 0.9
		 */
		do_action( 'lbi_email_send_after', $this );

		return $sent;

	}

	/**
	 * Add filters / actions before the email is sent
	 *
	 * @since 0.9
	 */
	public function send_before() {
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}

	/**
	 * Remove filters / actions after the email is sent
	 *
	 * @since 0.9
	 */
	public function send_after() {
		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		// Reset heading to an empty string
		$this->heading = '';
	}

	/**
	 * Converts text to formatted HTML. This is primarily for turning line breaks into <p> and <br/> tags.
	 *
	 * @since 0.9
	 */
	public function text_to_html( $message ) {

		// if ( 'text/html' == $this->content_type || true === $this->html ) {
		// 	$message = apply_filters( 'edd_email_template_wpautop', true ) ? wpautop( $message ) : $message;
		// }

		return $message;
	}

}

