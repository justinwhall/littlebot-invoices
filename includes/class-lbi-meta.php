<?php
/**
 * Post Types
 *
 * Registers post types, taxonomies & post statuses.
 *
 * @class     LB_Post_Types
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LB_Post_Types Class.
 */
class Littlebot_Invoices_Meta {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
	}

	/**
	 * Registers all meta
	 *
	 * @return void
	 */
	public static function register_meta() {
		$meta_keys = [
			'line_items',
			'total',
		];

		foreach ( $meta_keys as $meta ) {
			self::register_meta_helper( $meta );
		}
	}

	/**
	 * Helper to register meta
	 *
	 * @param string $meta_name The name of the meta key.
	 * @return void
	 */
	public static function register_meta_helper( $meta_name ) {
		register_meta(
			'post',
			$meta_name,
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'lb_invoice',
			]
		);
		register_meta(
			'post',
			$meta_name,
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'lb_estimate',
			]
		);
	}
}

Littlebot_Invoices_Meta::init();
