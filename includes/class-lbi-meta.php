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
			[
				'key'  => 'client',
				'type' => 'integer',
			],
			[
				'key'  => 'due_date',
				'type' => 'string',
			],
			[
				'key'  => 'invoice_number',
				'type' => 'integer',
			],
			[
				'key'  => 'po_number',
				'type' => 'integer',
			],
			[
				'key'  => 'line_items',
				'type' => 'string',
			],
			[
				'key'  => 'sub_total',
				'type' => 'integer',
			],
			[
				'key'  => 'total',
				'type' => 'integer',
			],
			[
				'key'  => 'tax_rate',
				'type' => 'integer',
			],
		];

		foreach ( $meta_keys as $meta ) {
			self::register_meta_helper( $meta );
		}

		register_meta(
			'user',
			'company_name',
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'user',
				'type'           => 'string',
				'auth_callback'  => function() {
					return true;
				},
			]
		);

		register_meta(
			'user',
			'lb_client',
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'user',
				'type'           => 'boolean',
				'auth_callback'  => function() {
					return true;
				},
			]
		);

		register_meta(
			'post',
			'_line_items',
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'lb_invoice',
				'type'           => 'array',
				'auth_callback'  => function() {
					return true;
				},
				'show_in_rest'   => [
					'schema' => [
						'items' => [
							'type'       => 'object',
							'properties' => [
								'item_title'   => [
									'type' => 'string',
								],
								'item_desc'    => [
									'type' => 'string',
								],
								'item_qty'     => [
									'type' => 'integer',
								],
								'item_rate'    => [
									'type' => 'integer',
								],
								'item_percent' => [
									'type' => 'integer',
								],
								'item_amount'  => [
									'type' => 'interger',
								],
							],
						],
					],
				],
			]
		);
	}

	/**
	 * Helper to register meta
	 *
	 * @param string $meta The name of the meta key.
	 * @return void
	 */
	public static function register_meta_helper( $meta ) {
		register_meta(
			'post',
			$meta['key'],
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'lb_invoice',
				'type'           => $meta['type'],
				'auth_callback'  => function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
		register_meta(
			'post',
			$meta['key'],
			[
				'show_in_rest'   => true,
				'single'         => true,
				'object_subtype' => 'lb_estimate',
				'type'           => $meta['type'],
			]
		);
	}
}

Littlebot_Invoices_Meta::init();
