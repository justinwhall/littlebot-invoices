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

	public $options;

	/**
	 * Get things going
	 *
	 * @since 0.9
	 */
	public function __construct() {

		$this->options = get_option( 'lbi_emails', true );

		if ( 'off' === $this->options['html_emails'] ) {
			$this->html = false;
		}

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

		if ( $this->html ) {
			$content_type = 'text/html';
		} else {
			$content_type = 'text/plain';
		}
	
		return $content_type;
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
	 * Get the header text for the email
	 *
	 * @since 0.9
	 */
	public function get_heading() {
		return $this->heading;
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

		if ( $this->html ) {
			$message = wpautop( $message, true );
			ob_start();
			require_once LBI_PLUGIN_DIR . 'templates/template-email.php';
			$message = ob_get_contents();
			ob_end_clean();
		}

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

		$sent = wp_mail( $to, $subject, $message, $this->get_headers(), $attachments );

		/**
		 * Hooks after the email is sent
		 *
		 * @since 0.9
		 */
		do_action( 'lbi_email_send_after', $to );

		return $sent;

	}



}
