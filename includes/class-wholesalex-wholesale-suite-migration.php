<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WholesaleX_Wholesale_Suite_Migration {

	/**
	 * Instance of this class
	 *
	 * @since 1.0.0
	 */
	protected static $_instance = null;
	protected $classes          = array();

	/**
	 * Background process migrate to wholesalex
	 *
	 * @var WholesaleX_Background_Migration
	 */
	protected static $background_process;

	/**
	 * Get Instance of WholesaleX Migration Tool Main Class
	 *
	 * @return WholesaleXMigrationTool|null
	 * @since 1.0.0
	 */
	public static function run() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		self::$background_process = new WholesaleX_Wholesale_Suite_Background_Migration();
		add_action( 'wholesalex_migration_tools_restapi_action', array( $this, 'process_tools_restapi' ) );

		// $this->wholesale_suit_migration();

	}

	public function split_into_chunk( $limit = 20, $total_count = 0 ) {
		$result = array();
		// Loop until the count is zero or less
		while ( $total_count > 0 ) {
			// If the count is greater than or equal to the limit
			if ( $total_count >= $limit ) {
				// Push the limit to the array
				$result[] = $limit;
				// Subtract the limit from the count
				$total_count -= $limit;
			} else {
				// Otherwise, push the remaining count to the array
				$result[] = $total_count;
				// Set the count to zero
				$total_count = 0;
			}
		}

		return $result;
	}

	public function process_tools_restapi( $post ) {
		$type = isset( $post['type'] ) ? sanitize_text_field( $post['type'] ) : '';
		switch ( $type ) {
			case 'start_ws_migration':
				$this->migration();
				break;
			case 'ws_migration_status':
				$this->get_migration_status();

			default:
				// code...
				break;
		}

	}

	public function get_migration_status() {
		wp_send_json(
			array(
				'status'          => true,
				'is_migrating'    => get_transient( 'wholesalex_wholesalex_suite_migrating' ),
				'migration_stats' => get_transient( 'wholesalex_wholesale_suite_migration_stats' ),
			)
		);
	}

	public static function migrate_to_wholesalex_roles() {
		$count                          = 0;
		$all_registered_wholesale_roles = maybe_unserialize( get_option( 'wwp_options_registered_custom_roles' ) );
		$prepare_migration_data         = array();
		foreach ( $all_registered_wholesale_roles as $id => $role ) {
			$group_data = array(
				'id'                => $id,
				'_role_title'       => $role['roleName'],
				'_shipping_methods' => array(),
				'_payment_methods'  => array(),
				'credit_limit'      => '',
			);

			$prepare_migration_data[] = $group_data;
			$count++;
		}

		foreach ( $prepare_migration_data as $role ) {
			wholesalex()->set_roles( $role['id'], $role );
			wholesalex()->log( 'Wholesale Suite Role: (' . $role['_role_title'] . ') Migrated into WnolesaleX Role', 'info' );
		}
		return $count;
	}

	public static function migrate_products_meta( $page = 1, $limit = 5 ) {
		$count                          = 0;
		$all_registered_wholesale_roles = maybe_unserialize( get_option( 'wwp_options_registered_custom_roles' ) );
		$product_ids                    = get_posts(
			array(
				'post_type'   => 'product',
				'post_status' => 'publish',
				'numberposts' => $limit,
				'page'        => $page,
				'fields'      => 'ids',
			)
		);

		foreach ( $product_ids as $product_id ) {
			$wholesale_suite_tiers = array();

			foreach ( $all_registered_wholesale_roles as $role_id => $role ) {
				$wholesale_suite_price = get_post_meta( $product_id, $role_id . '_wholesale_price', true ); // discount amount // Fixed Price-> After Discount/Percentage Wholesale Price
				if ( $wholesale_suite_price ) {
					update_post_meta( $product_id, $role_id . '_sale_price', $wholesale_suite_price );
				}
			}

			if ( 'yes' == get_post_meta( $product_id, 'wwpp_post_meta_enable_quantity_discount_rule', true ) ) {
				$quantity_discounts = get_post_meta( $product_id, 'wwpp_post_meta_quantity_discount_rule_mapping', true );
				if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
					foreach ( $quantity_discounts as $discount ) {

						$temp_tier = array(
							'id'  => uniqid(),
							'src' => 'single_product',
						);

						$role_id      = $discount['wholesale_role'];
						$min_quantity = $discount['start_qty'];
						$type         = ( 'percent-price' == $discount['price_type'] ) ? 'percentage' : 'fixed_price';
						$amount       = $discount['wholesale_price'];
						if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
							$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
						}

						$temp_tier['_discount_type']   = $type;
						$temp_tier['_min_quantity']    = $min_quantity;
						$temp_tier['_discount_amount'] = $amount;

						$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
					}
				}

				foreach ( $wholesale_suite_tiers as $key => $value ) {
					update_post_meta( $product_id, $key, $value );
				}
			}

			// Visibility Settings
			$include_role = array_values( get_post_meta( $product_id, 'wwpp_product_wholesale_visibility_filter', false ) );
			if ( $include_role && isset( $include_role[0] ) && $include_role[0] != 'all' ) {

				$exclude_roles = array_diff( array_keys( wholesalex()->get_roles() ), $include_role );

				$exclude_wholesalex_roles = array();
				foreach ( $exclude_roles as $role_id ) {
					$exclude_wholesalex_roles[] = array(
						'value' => $role_id,
						'name'  => wholesalex()->get_role_name_by_role_id( 'wholesalex_b2c_users' ),
					);
				}

				$wholesalex_settings = get_post_meta( $product_id, 'wholesalex_settings', true );
				if ( ! $wholesalex_settings || ! is_array( $wholesalex_settings ) ) {
					$wholesalex_settings = array();
				}

				$wholesalex_settings['_hide_for_b2b_role_n_user'] = 'b2b_specific';
				$wholesalex_settings['_hide_for_roles']           = $exclude_wholesalex_roles;

				update_post_meta( $product_id, 'wholesalex_settings', $wholesalex_settings );
			}

			update_post_meta( $product_id, 'wholesalex_migration', true );

			wholesalex()->log( 'Wholesale Suite Simple Product: (#' . $product_id . ') Rolewise Pricing and Tiers and Visibility Settings Migrated into WnolesaleX Rolewise Pricing and Tiers and Visibility Settings', 'info' );

			$count++;

		}

		return $count;
	}
	public static function migrate_product_variations_meta( $page = 1, $limit = 5 ) {
		$count                          = 0;
		$all_registered_wholesale_roles = maybe_unserialize( get_option( 'wwp_options_registered_custom_roles' ) );
		$product_variation              = get_posts(
			array(
				'post_type'   => 'product_variation',
				'post_status' => 'publish',
				'numberposts' => $limit,
				'page'        => $page,
				'fields'      => 'ids',
			)
		);

		foreach ( $product_variation as $product_id ) {
			$wholesale_suite_tiers = array();
			foreach ( $all_registered_wholesale_roles as $role_id => $role ) {
				$wholesale_suite_price = get_post_meta( $product_id, $role_id . '_wholesale_price', true ); // discount amount // Fixed Price-> After Discount/Percentage Wholesale Price
				if ( $wholesale_suite_price ) {
					update_post_meta( $product_id, $role_id . '_sale_price', $wholesale_suite_price );
				}
			}

			if ( 'yes' == get_post_meta( $product_id, 'wwpp_post_meta_enable_quantity_discount_rule', true ) ) {
				$quantity_discounts = get_post_meta( $product_id, 'wwpp_post_meta_quantity_discount_rule_mapping', true );
				if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
					foreach ( $quantity_discounts as $discount ) {

						$temp_tier = array(
							'id'  => uniqid(),
							'src' => 'single_product',
						);

						$role_id      = $discount['wholesale_role'];
						$min_quantity = $discount['start_qty'];
						$type         = ( 'percent-price' == $discount['price_type'] ) ? 'percentage' : 'fixed_price';
						$amount       = $discount['wholesale_price'];
						if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
							$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
						}

						$temp_tier['_discount_type']   = $type;
						$temp_tier['_min_quantity']    = $min_quantity;
						$temp_tier['_discount_amount'] = $amount;

						$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
					}
				}

				foreach ( $wholesale_suite_tiers as $key => $value ) {
					update_post_meta( $product_id, $key, $value );
				}
			}

			wholesalex()->log( 'Wholesale Suite Product Vairation: (#' . $product_id . ') Rolewise Pricing and Tiers and Visibility Settings Migrated into WnolesaleX Rolewise Pricing and Tiers and Visibility Settings', 'info' );
			$count++;
		}

		return $count;
	}

	public static function migrate_category_data( $page = 1, $limit = 5 ) {
		$count = 0;

		$offset = ( $page - 1 ) * $limit;

		$args = array(
			'taxonomy'   => array( 'product_cat' ),
			'orderby'    => 'id',
			'order'      => 'ASC',
			'hide_empty' => true,
			'fields'     => 'ids',
			'offset'     => $offset,
			'number'     => $limit,
		);

		$categories = get_terms( $args );
		foreach ( $categories as $cat_id ) {
			if ( 'yes' === get_term_meta( $cat_id, 'wwpp_enable_quantity_based_wholesale_discount', true ) ) {
				$wholesale_suite_tiers = array();
				$quantity_discounts    = get_term_meta( $cat_id, 'wwpp_quantity_based_wholesale_discount_mapping', true );
				if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
					foreach ( $quantity_discounts as $discount ) {

						$temp_tier = array(
							'id'  => uniqid(),
							'src' => 'category',
						);

						$role_id      = $discount['wholesale-role'];
						$min_quantity = $discount['start-qty'];
						$type         = 'percentage';
						$amount       = $discount['wholesale-discount'];
						if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
							$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
						}

						$temp_tier['_discount_type']   = $type;
						$temp_tier['_min_quantity']    = $min_quantity;
						$temp_tier['_discount_amount'] = $amount;

						$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
					}
				}

				foreach ( $wholesale_suite_tiers as $key => $value ) {
					update_term_meta( $cat_id, $key, $value );
					$count++;
					wholesalex()->log( 'Wholesale Suite Category Data: (#' . $cat_id . ') Rolewise Pricing and Tiers and Visibility Settings Migrated into WnolesaleX Rolewise Pricing and Tiers and Visibility Settings', 'info' );

				}
			}
		}

		return $count;

	}

	public static function migrate_registration_fields() {
		$count         = 0;
		$custom_fields = get_option( 'wwlc_option_registration_form_custom_fields', array() );

		$migration_fields = array();

		$wholesalex_fields = get_option( '__wholesalex_registration_form', self::get_wholesalex_default_form() );

		$allowed_type = array( 'text', 'url', 'number', 'email', 'password', 'date', 'file', 'tel', 'textarea', 'select', 'radio', 'checkbox' );

		global $WWLC_REGISTRATION_FIELDS;
		if ( $WWLC_REGISTRATION_FIELDS && is_array( $WWLC_REGISTRATION_FIELDS ) ) {
			$custom_fields = array_merge( $WWLC_REGISTRATION_FIELDS, $custom_fields );
		}

		foreach ( $custom_fields as $field_id => $custom_field ) {

			$field_name  = $custom_field['field_name'];
			$field_type  = $custom_field['field_type'];
			$is_required = $custom_field['required'];
			$placeholder = $custom_field['field_placeholder'];
			$is_enabled  = $custom_field['enabled'];

			if ( ! $field_type ) {
				$field_type = isset( $custom_field['type'] ) ? $custom_field['type'] : '';
			}
			if ( ! $field_name ) {
				$field_name = isset( $custom_field['label'] ) ? $custom_field['label'] : '';
			}
			if ( ! $placeholder ) {
				$placeholder = isset( $custom_field['placeholder'] ) ? $custom_field['placeholder'] : '';
			}
			if ( ! $is_enabled ) {
				$is_enabled = isset( $custom_field['active'] ) ? true : false;
			}

			if ( ! in_array( $field_type, $allowed_type ) ) {
				wholesalex()->log( sprintf( 'Wholesale Suite Migration: Field Type (%s) Does not supported in WholesaleX. Skipped For Migration. ', $field_type ), 'info' );
				continue;
			}

			// $field_type = get_post_meta( $field_id, 'b2bking_custom_field_field_type', true );
			// update_post_meta( $field_id, 'wholesalex_migrate', true );
			$temp_field = array(
				'id'                    => $field_id,
				'type'                  => $field_type,
				'title'                 => $field_name,
				'placeholder'           => $placeholder,
				'required'              => $is_required,
				'custom_field'          => true,
				'name'                  => $field_id,
				'isLabelHide'           => false,
				'help_message'          => '',
				'enableForRegistration' => $is_enabled,
				'enableForBillingForm'  => false,
				'excludeRoles'          => array(),
			);

			if ( isset( $custom_field['options'] ) ) {
				$options = array();
				foreach ( $custom_field['options'] as $option ) {
					$options[] = array(
						'name'  => $option['text'],
						'value' => $option['value'],
					);
				}
				$temp_field['option'] = $options;
			}

			$migration_fields[] = $temp_field;
		}

			$wholesalex_fields = json_decode( $wholesalex_fields, 'true' );
			$all_fields        = $wholesalex_fields + $migration_fields;

			$fields = array();
			$names  = array();

		foreach ( $wholesalex_fields as $field ) {
			$names[]  = $field['name'];
			$fields[] = $field;
		}
		foreach ( $migration_fields as $field ) {
			if ( ! in_array( $field['name'], $names ) ) {
				$names[]  = $field['name'];
				$fields[] = $field;
				wholesalex()->log( 'Wholesale Suite ' . $field['title'] . ' Migrated into wholesalex registration form field', 'info' );
			}
			$count++;
		}

		update_option( '__wholesalex_registration_form', json_encode( $fields ) );

		return $count;
	}

	public static function migrate_general_discount() {
		$count = 0;

		$discounts = get_option( 'wwpp_option_wholesale_role_general_discount_mapping', array() );

		$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

		foreach ( $discounts as $role_id => $discount ) {
			$temp_rule = array();
			$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
			$temp_rule = array(
				'id'               => uniqid(),
				'_rule_status'     => false,
				'_rule_title'      => sprintf( __( 'Discount Rule - Migrate From Wholesale Prices Settings (%s)', 'wholesalex' ), $role_name ),
				'limit'            => array(),
				'_rule_type'       => 'product_discount',
				'product_discount' =>
				array(
					'_discount_type'   => 'percentage',
					'_discount_amount' => $discount,
					'_discount_name'   => '',
				),
				'_rule_for'        => 'specific_roles',
				'specific_roles'   => array(
					array(
						'name'  => $role_name,
						'value' => $role_id,
					),
				),
				'_product_filter'  => 'all_products',
			);

			$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

			wholesalex()->log( 'Wholesale Suite General Discount migrated into wholesalex dynamic rules #' . $temp_rule['id'] );

			$count++;

		}

		$is_single_product_qb_discount = get_option( 'enable_wholesale_role_cart_quantity_based_wholesale_discount_mode_2' );
		if ( 'yes' === $is_single_product_qb_discount ) {
			$discounts = get_option( 'wwpp_option_wholesale_role_cart_qty_based_discount_mapping', array() );

			$rolewise_tiers = array();

			foreach ( $discounts as $discount ) {
				$temp_tier     = array();
				$role_id       = $discount['wholesale_role'];
				$role_name     = $discount['wholesale_name'];
				$min_quantity1 = $discount['start_qty'];
				$min_quantity2 = $discount['end_qty'];
				$amount        = $discount['percent_discount'];

				$temp_tier = array(
					'_id'              => uniqid(),
					'src'              => 'dynamic_rule',
					'_discount_type'   => 'percentage',
					'_min_quantity'    => $min_quantity1,
					'_discount_amount' => $amount,
				);
				if ( ! ( isset( $rolewise_tiers[ $role_id ] ) && is_array( $rolewise_tiers[ $role_id ] ) ) ) {
					$rolewise_tiers[ $role_id ] = array();
				}
				$rolewise_tiers[ $role_id ][] = $temp_tier;
			}

			foreach ( $rolewise_tiers as $role_id => $tier ) {
				$temp_rule = array(
					'id'              => uniqid(),
					'_rule_status'    => true,
					'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
					'limit'           => array(),
					'_rule_type'      => 'quantity_based',
					'quantity_based'  => array( 'tiers' => $tier ),
					'_rule_for'       => 'specific_roles',
					'specific_roles'  => array(
						array(
							'name'  => wholesalex()->get_role_name_by_role_id( $role_id ),
							'value' => $role_id,
						),
					),
					'_product_filter' => 'all_products',
				);

				$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

				wholesalex()->log( 'Wholesale Suite Cart Quantity Based Discounts migrated into wholesalex dynamic rules #' . $temp_rule['id'] );
				$count++;

			}

			$discounts               = get_option( 'wwpp_option_wholesale_role_cart_subtotal_price_based_discount_mapping', array() );
			$rolewise_cart_discounts = array();

			foreach ( $discounts as $discount ) {
				$role_id    = $discount['wholesale_role'];
				$cart_total = $discount['subtotal_price'];
				$type       = $discount['discount_type'];
				$amount     = $discount['discount_amount'];
				$title      = $discount['discount_title'];
				$type       = ( $type === 'percent-discount' ) ? 'percentage' : 'amount';

				if ( ! ( isset( $rolewise_cart_discounts[ $role_id ] ) && is_array( $rolewise_cart_discounts[ $role_id ] ) ) ) {
					$rolewise_cart_discounts[ $role_id ] = array();
				}
				$rolewise_cart_discounts[ $role_id ][] = array(
					'_discount_type'   => $type,
					'_discount_amount' => $amount,
					'_discount_name'   => $title,
				);

				$temp_rule = array(
					'id'              => uniqid(),
					'_rule_status'    => true,
					'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
					'limit'           => array(),
					'_rule_type'      => 'cart_discount',
					'cart_discount'   => array(
						'_discount_type'   => $type,
						'_discount_amount' => $amount,
						'_discount_name'   => $title,
					),
					'_rule_for'       => 'specific_roles',
					'specific_roles'  => array(
						array(
							'name'  => wholesalex()->get_role_name_by_role_id( $role_id ),
							'value' => $role_id,
						),
					),
					'_product_filter' => 'all_products',
					'conditions'      => array(
						'tiers' => array(
							array(
								'_id'                  => uniqid(),
								'src'                  => 'dynamic_rule',
								'_conditions_for'      => 'cart_total_value',
								'_conditions_operator' => 'greater_equal',
								'_conditions_value'    => $cart_total,
							),
						),
					),

				);

				$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

				wholesalex()->log( 'Wholesale Suite Cart Subtotal Discounts migrated into wholesalex dynamic rules #' . $temp_rule['id'] );
				$count++;

			}
		}

		update_option( '__wholesalex_dynamic_rules', $dynamic_rules );

		return $count;

	}

	public static function migrate_shipping_rule() {
		$count = 0;

		$shipping_mappings = get_option( 'wwpp_option_wholesale_role_shipping_zone_method_mapping', array() );
		$dynamic_rules     = get_option( '__wholesalex_dynamic_rules', array() );
		foreach ( $shipping_mappings as $shipping_rule ) {
			$role_id   = $shipping_rule['wholesale_role'];
			$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
			$zone      = $shipping_rule['shipping_zone'];
			$method_id = $shipping_rule['shipping_method'];

			$method = WC_Shipping_Zones::get_shipping_method( $method_id );

			$temp_rule = array(
				'id'              => uniqid(),
				'_rule_status'    => true,
				'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
				'limit'           => array(),
				'_rule_type'      => 'shipping_rule',
				'shipping_rule'   => array(
					'__shipping_zone'        => $zone,
					'_shipping_zone_methods' => array(
						array(
							'name'  => $method->get_title(),
							'value' => $method_id,
						),
					),
				),
				'_rule_for'       => 'specific_roles',
				'specific_roles'  => array(
					array(
						'name'  => $role_name,
						'value' => $role_id,
					),
				),
				'_product_filter' => 'all_products',
			);

			$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
		}

		update_option( '__wholesalex_dynamic_rules', $dynamic_rules );

		return $count;
	}

	public static function migrate_payment_rule() {

		$count = 0;

		// Tax Class Mapping'
		$gateway_mapping_rules     = get_option( 'wwpp_option_wholesale_role_payment_gateway_mapping', array() );
		$gateway_surcharge_mapping = get_option( 'wwpp_option_payment_gateway_surcharge_mapping', array() );

		$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

		foreach ( $gateway_mapping_rules as $role_id => $gateways ) {
			$role_name     = wholesalex()->get_role_name_by_role_id( $role_id );
			$gateway_array = array();
			foreach ( $gateways as $gateway ) {
				$gateway_array[] = $gateway['id'];
			}
			$role_data                     = wholesalex()->get_roles( 'by_id', $role_id );
			$role_data['_payment_methods'] = $gateway_array;
			wholesalex()->set_roles( $role_id, $role_data );
			wholesalex()->log( sprintf( 'WholesaleX Role (%s) Payment Method Update From WholesaleX Wholesale Suite Migration', $role_name ) );
		}

		foreach ( $gateway_surcharge_mapping as $surcharge ) {
			$role_id          = $surcharge['wholesale_role'];
			$payment_gateway  = $surcharge['payment_gateway'];
			$surcharge_title  = $surcharge['surcharge_title'];
			$surcharge_type   = ( 'fixed_price' === $surcharge['type'] ) ? 'amount' : 'percentage';
			$surcharge_amount = $surcharge['surcharge_amount'];
			$role_name        = wholesalex()->get_role_name_by_role_id( $role_id );

			$wc_gateways = new WC_Payment_Gateways();

			// Get an array of all available payment gateways
			$payment_gateways = $wc_gateways->get_available_payment_gateways();

			$gateway_title = isset( $payment_gateways[ $payment_gateway ] ) ? $payment_gateways[ $payment_gateway ]->get_title() : '';

			$temp_rule = array(
				'id'              => uniqid(),
				'_rule_status'    => true,
				'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Gateway Surcharge (%s)', 'wholesalex' ), $role_name ),
				'limit'           => array(),
				'_rule_type'      => 'extra_charge',
				'extra_charge'    => array(
					'_payment_gateways' => array(
						array(
							'name'  => $gateway_title,
							'value' => $payment_gateway,
						),
					),
					'_charge_type'      => $surcharge_type,
					'_charge_amount'    => $surcharge_amount,
					'_charge_name'      => $surcharge_title,

				),
				'_rule_for'       => 'specific_roles',
				'specific_roles'  => array(
					array(
						'name'  => $role_name,
						'value' => $role_id,
					),
				),
				'_product_filter' => 'all_products',
			);

			$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

			update_option( '__wholesalex_dynamic_rules', $dynamic_rules );

			wholesalex()->log( sprintf( 'WholesaleX Dynamic Rules added For Wholesale Suite Surcharge Migration' ) );

		}

		return $count;

	}

	public static function migrate_tax_rule() {
		$count = 0;

		$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

		// Tax Class Mapping'
		$tax_mapping_rules = get_option( 'wwpp_option_wholesale_role_tax_class_options_mapping', array() );
		
		foreach ( $tax_mapping_rules as $role_id => $tax_rule ) {
			$role_name      = $tax_rule['wholesale-role-name'];
			$tax_class      = $tax_rule['tax-class'];
			$tax_class_name = $tax_rule['tax-class-name'];

			$temp_rule                         = array(
				'id'              => uniqid(),
				'_rule_status'    => true,
				'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Tax Class Mapping (%s)', 'wholesalex' ), $role_name ),
				'limit'           => array(),
				'_rule_type'      => 'tax_rule',
				'tax_rule'        => array(
					'_tax_exempted' => 'no',
					'_tax_class'    => $tax_class,
				),
				'_rule_for'       => 'specific_roles',
				'specific_roles'  => array(
					array(
						'name'  => $role_name,
						'value' => $role_id,
					),
				),
				'_product_filter' => 'all_products',
			);
			$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
		}

		$tax_exemption_rules = get_option( 'wwpp_option_wholesale_role_tax_option_mapping', array() );

		foreach ( $tax_exemption_rules as $role_id => $tax_exemption_status ) {
			$is_tax_exempted = $tax_exemption_status['tax_exempted'];
			if ( 'yes' != $is_tax_exempted ) {
				continue;
			}
			$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
			// new tax rule
			$temp_rule = array(
				'id'              => uniqid(),
				'_rule_status'    => true,
				'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Tax Exemption (%s)', 'wholesalex' ), $role_name ),
				'limit'           => array(),
				'_rule_type'      => 'tax_rule',
				'tax_rule'        => array(
					'_tax_exempted' => $is_tax_exempted,
				),
				'_rule_for'       => 'specific_roles',
				'specific_roles'  => array(
					array(
						'name'  => $role_name,
						'value' => $role_id,
					),
				),
				'_product_filter' => 'all_products',
			);

			$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
		}

		update_option( '__wholesalex_dynamic_rules', $dynamic_rules );


		return $count;
	}

	public static function migrate_users_meta( $page = 1, $limit = 20 ) {
		$count = 0;

			// wwpp_tax_exemption

			$users                 = get_users(
				array(
					'fields' => 'ids',
					'number' => $limit,
					'paged'  => $page,
				)
			);
			$wholesale_suite_roles = array_keys( maybe_unserialize( get_option( 'wwp_options_registered_custom_roles', array() ) ) );
			$wc_gateways           = new WC_Payment_Gateways();

		foreach ( $users as $user_id ) {
			$user_data     = get_userdata( $user_id );
			$settings_data = array();

			if ( $user_data ) {
				$wholesale_suite_role = array_values( array_intersect( $wholesale_suite_roles, $user_data->roles ) );
				if ( isset( $wholesale_suite_role[0] ) ) {
					wholesalex()->change_role( $user_id, $wholesale_suite_role[0], get_user_meta( $user_id, '__wholesalex_role', true ) );
					update_user_meta( $user_id, '__wholesalex_status', 'active' );
				}
			}

			$tax_exemption_status = get_user_meta( $user_id, 'wwpp_tax_exemption', true );
			switch ( $tax_exemption_status ) {
				case 'yes':
				case 'no':
					$settings_data['_wholesalex_profile_override_tax_exemption'] = $tax_exemption_status;
					break;
				default:
					break;
			}
			$shipping_status = get_user_meta( $user_id, 'wwpp_override_shipping_options', true );

			switch ( $shipping_status ) {
				case 'yes':
					$settings_data['_wholesalex_profile_override_shipping_method'] = $shipping_status;
					$shipping_methods_type = get_user_meta( $user_id, 'wwpp_shipping_methods_type', true );
					if ( 'force_free_shipping' === $shipping_methods_type ) {
						$settings_data['_wholesalex_profile_shipping_method_type'] = 'force_free_shipping';
					} elseif ( 'specify_shipping_methods' === $shipping_methods_type ) {
						$settings_data['_wholesalex_profile_shipping_method_type'] = 'specific_shipping_methods';
						$shipping_methods = get_user_meta( $user_id, 'wwpp_shipping_methods', true );

						$wholesalex_shipping_methods = array();

						$settings_data['_wholesalex_profile_shipping_zone'] = get_user_meta( $user_id, 'wwpp_shipping_zone', true );

						foreach ( $shipping_methods as $method_id ) {
							$method                        = WC_Shipping_Zones::get_shipping_method( $method_id );
							$wholesalex_shipping_methods[] = array(
								'name'  => $method->get_title(),
								'value' => $method_id,
							);
						}

						$settings_data['_wholesalex_profile_shipping_zone_methods'] = $wholesalex_shipping_methods;

					}

					break;
				case 'no':
					$settings_data['_wholesalex_profile_override_shipping_method'] = $shipping_status;
					break;

				default:
					// code...
					break;
			}

			$payment_gateways_status = get_user_meta( $user_id, 'wwpp_override_payment_gateway_options', true );
			switch ( $payment_gateways_status ) {
				case 'yes':
					$settings_data['_wholesalex_profile_override_payment_gateway'] = 'yes';
					$payment_gateways        = get_user_meta( $user_id, 'wwpp_payment_gateway_options', true );
					$wholesalex_gateway_data = array();

					$available_payment_gateways = WC()->payment_gateways->payment_gateways();

					foreach ( $payment_gateways as $gateway_id ) {
						if ( isset( $available_payment_gateways[ $gateway_id ] ) ) {
							$wholesalex_gateway_data[] = array(
								'name'  => $available_payment_gateways[ $gateway_id ]->title,
								'value' => $gateway_id,
							);
						}
					}

					$settings_data['_wholesalex_profile_payment_gateways'] = $wholesalex_gateway_data;

					break;
				case 'no':
					$settings_data['_wholesalex_profile_override_payment_gateway'] = 'no';
					// code...
					break;

				default:
					// code...
					break;
			}

			$wholesalex_discount_data = array( 'tiers' => array() );

			$tier_discounts = get_user_meta( $user_id, 'wwpp_wholesale_discount_qty_discount_mapping', true );
			foreach ( $tier_discounts as $tier ) {
				$wholesalex_discount_data['tiers'][] = array(
					'_id'              => uniqid(),
					'_discount_type'   => 'percentage',
					'_discount_amount' => $tier['percent_discount'],
					'_min_quantity'    => $tier['start_qty'],
					'src'              => 'profile',
					'_product_filter'  => 'all_products',
				);
			}

			$profile_discounts = array( '_profile_discounts' => $wholesalex_discount_data );

			update_user_meta( $user_id, '__wholesalex_profile_discounts', $profile_discounts );
			update_user_meta( $user_id, '__wholesalex_profile_settings', $settings_data );
			$count++;
		}

		return $count;
	}
	public function migration() {
		set_transient( 'wholesalex_wholesale_suite_migration_stats', array() );

		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_to_wholesalex_roles',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite Roles Added to queue for migrating', 'info' );

		$products_count  = wp_count_posts( 'product' )->publish;
		$products_chunks = $this->split_into_chunk( 20, $products_count );
		$total_chunks    = count( $products_chunks );

		foreach ( $products_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_products_meta',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'Wholesale Suite Simple Products (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		$variations_count  = wp_count_posts( 'product_variation' )->publish;
		$variations_chunks = $this->split_into_chunk( 20, $variations_count );
		$total_chunks      = count( $variations_chunks );

		foreach ( $variations_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_product_variations_meta',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'Wholesale Suite Product Variations (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		$category_count       = wp_count_terms( 'product_cat' );
		$category_count_chunk = $this->split_into_chunk( 20, $category_count );
		$total_chunks         = count( $category_count_chunk );

		foreach ( $category_count_chunk as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_category_data',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);

			wholesalex()->log( 'Wholesale Suite Category Data (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_registration_fields',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite Registration Fields queue for migrating', 'info' );

		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_general_discount',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite General Discounts queue for migrating', 'info' );
		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_shipping_rule',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite Shipping Rule queue for migrating', 'info' );
		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_payment_rule',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite Payment Rule queue for migrating', 'info' );

		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_tax_rule',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'Wholesale Suite Tax Rule queue for migrating', 'info' );

		$users_count       = count_users()['total_users'];
		$users_count_chunk = $this->split_into_chunk( 20, $users_count );
		$total_chunks      = count( $users_count_chunk );

		foreach ( $users_count_chunk as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_users_meta',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);

			wholesalex()->log( 'Wholesale Suite Users (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		self::$background_process->save()->dispatch();

		wp_send_json(
			array(
				'status' => true,
				'data'   => array( 'message' => 'Migration Started.' ),
			)
		);
	}



	public function wholesale_suit_migration() {
		// Migrate Wholesale Suite Role Into WholesaleX Role
		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_role' === $_GET['migrate'] ) {

			$all_registered_wholesale_roles = maybe_unserialize( get_option( 'wwp_options_registered_custom_roles' ) );
			$prepare_migration_data         = array();
			foreach ( $all_registered_wholesale_roles as $id => $role ) {
				$group_data = array(
					'id'                => $id,
					'_role_title'       => $role['roleName'],
					'_shipping_methods' => array(),
					'_payment_methods'  => array(),
					'credit_limit'      => '',
				);

				$prepare_migration_data[] = $group_data;
			}

			foreach ( $prepare_migration_data as $role ) {
				wholesalex()->set_roles( $role['id'], $role );
			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_single_product' === $_GET['migrate'] ) {

			$all_registered_wholesale_roles = maybe_unserialize( get_option( 'wwp_options_registered_custom_roles' ) );
			// Get all products
			$product_ids = get_posts(
				array(
					'post_type'   => 'product',
					'post_status' => 'publish',
					'numberposts' => -1,
					'fields'      => 'ids',
				)
			);

			$product_variation = get_posts(
				array(
					'post_type'   => 'product_variation',
					'post_status' => 'publish',
					'numberposts' => -1,
					'fields'      => 'ids',
				)
			);

			foreach ( $product_ids as $product_id ) {
				if ( get_post_meta( $product_id, 'wholesalex_migration', true ) ) {
					continue;
				}
				$wholesale_suite_tiers = array();

				foreach ( $all_registered_wholesale_roles as $role_id => $role ) {
					$wholesale_suite_price = get_post_meta( $product_id, $role_id . '_wholesale_price', true ); // discount amount // Fixed Price-> After Discount/Percentage Wholesale Price
					// $percentage_key = $role_id.'_wholesale_percentage_discount'; // discount percentage
					if ( $wholesale_suite_price ) {
						update_post_meta( $product_id, $role_id . '_sale_price', $wholesale_suite_price );
					}
				}

				if ( 'yes' == get_post_meta( $product_id, 'wwpp_post_meta_enable_quantity_discount_rule', true ) ) {
					$quantity_discounts = get_post_meta( $product_id, 'wwpp_post_meta_quantity_discount_rule_mapping', true );
					if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
						foreach ( $quantity_discounts as $discount ) {

							$temp_tier = array(
								'id'  => uniqid(),
								'src' => 'single_product',
							);

							$role_id      = $discount['wholesale_role'];
							$min_quantity = $discount['start_qty'];
							$type         = ( 'percent-price' == $discount['price_type'] ) ? 'percentage' : 'fixed_price';
							$amount       = $discount['wholesale_price'];
							if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
								$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
							}

							$temp_tier['_discount_type']   = $type;
							$temp_tier['_min_quantity']    = $min_quantity;
							$temp_tier['_discount_amount'] = $amount;

							$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
						}
					}

					foreach ( $wholesale_suite_tiers as $key => $value ) {
						update_post_meta( $product_id, $key, $value );
					}
				}

				// Visibility Settings
				$include_role = array_values( get_post_meta( $product_id, 'wwpp_product_wholesale_visibility_filter', false ) );
				if ( $include_role && isset( $include_role[0] ) && $include_role[0] != 'all' ) {

					$exclude_roles = array_diff( array_keys( wholesalex()->get_roles() ), $include_role );

					$exclude_wholesalex_roles = array();
					foreach ( $exclude_roles as $role_id ) {
						$exclude_wholesalex_roles[] = array(
							'value' => $role_id,
							'name'  => wholesalex()->get_role_name_by_role_id( 'wholesalex_b2c_users' ),
						);
					}

					$wholesalex_settings = get_post_meta( $product_id, 'wholesalex_settings', true );
					if ( ! $wholesalex_settings || ! is_array( $wholesalex_settings ) ) {
						$wholesalex_settings = array();
					}

					$wholesalex_settings['_hide_for_b2b_role_n_user'] = 'b2b_specific';
					$wholesalex_settings['_hide_for_roles']           = $exclude_wholesalex_roles;

					update_post_meta( $product_id, 'wholesalex_settings', $wholesalex_settings );
				}

				update_post_meta( $product_id, 'wholesalex_migration', true );

				// wwpp_post_meta_quantity_discount_rule_mapping
			}
			foreach ( $product_variation as $product_id ) {
				if ( get_post_meta( $product_id, 'wholesalex_migration', true ) ) {
					continue;
				}
				foreach ( $all_registered_wholesale_roles as $role_id => $role ) {
					$wholesale_suite_price = get_post_meta( $product_id, $role_id . '_wholesale_price', true ); // discount amount // Fixed Price-> After Discount/Percentage Wholesale Price
					// $percentage_key = $role_id.'_wholesale_percentage_discount'; // discount percentage
					if ( $wholesale_suite_price ) {
						update_post_meta( $product_id, $role_id . '_sale_price', $wholesale_suite_price );
					}
				}

				if ( 'yes' == get_post_meta( $product_id, 'wwpp_post_meta_enable_quantity_discount_rule', true ) ) {
					$quantity_discounts = get_post_meta( $product_id, 'wwpp_post_meta_quantity_discount_rule_mapping', true );
					if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
						foreach ( $quantity_discounts as $discount ) {

							$temp_tier = array(
								'id'  => uniqid(),
								'src' => 'single_product',
							);

							$role_id      = $discount['wholesale_role'];
							$min_quantity = $discount['start_qty'];
							$type         = ( 'percent-price' == $discount['price_type'] ) ? 'percentage' : 'fixed_price';
							$amount       = $discount['wholesale_price'];
							if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
								$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
							}

							$temp_tier['_discount_type']   = $type;
							$temp_tier['_min_quantity']    = $min_quantity;
							$temp_tier['_discount_amount'] = $amount;

							$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
						}
					}

					foreach ( $wholesale_suite_tiers as $key => $value ) {
						update_post_meta( $product_id, $key, $value );
					}
				}

				update_post_meta( $product_id, 'wholesalex_migration', true );

			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suit_category' == $_GET['migrate'] ) {

			$args = array(
				'taxonomy'   => array( 'product_cat' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'ids',
			);

			$categories = get_terms( $args );
			foreach ( $categories as $cat_id ) {
				if ( 'yes' === get_term_meta( $cat_id, 'wwpp_enable_quantity_based_wholesale_discount', true ) ) {
					$wholesale_suite_tiers = array();
					$quantity_discounts    = get_term_meta( $cat_id, 'wwpp_quantity_based_wholesale_discount_mapping', true );
					if ( $quantity_discounts && is_array( $quantity_discounts ) ) {
						foreach ( $quantity_discounts as $discount ) {

							$temp_tier = array(
								'id'  => uniqid(),
								'src' => 'category',
							);

							$role_id      = $discount['wholesale-role'];
							$min_quantity = $discount['start-qty'];
							$type         = 'percentage';
							$amount       = $discount['wholesale-discount'];
							if ( ! is_array( $wholesale_suite_tiers[ $role_id . '_tiers' ] ) ) {
								$wholesale_suite_tiers[ $role_id . '_tiers' ] = array();
							}

							$temp_tier['_discount_type']   = $type;
							$temp_tier['_min_quantity']    = $min_quantity;
							$temp_tier['_discount_amount'] = $amount;

							$wholesale_suite_tiers[ $role_id . '_tiers' ][] = $temp_tier;
						}
					}

					foreach ( $wholesale_suite_tiers as $key => $value ) {
						update_term_meta( $cat_id, $key, $value );
					}
				}
			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_registration_field' === $_GET['migrate'] ) {
			$custom_fields = get_option( 'wwlc_option_registration_form_custom_fields', array() );

			$migration_fields = array();

			$wholesalex_fields = get_option( '__wholesalex_registration_form', $this->get_wholesalex_default_form() );

			$allowed_type = array( 'text', 'url', 'number', 'email', 'password', 'date', 'file', 'tel', 'textarea', 'select', 'radio', 'checkbox' );

			global $WWLC_REGISTRATION_FIELDS;
			if ( $WWLC_REGISTRATION_FIELDS && is_array( $WWLC_REGISTRATION_FIELDS ) ) {
				$custom_fields = array_merge( $WWLC_REGISTRATION_FIELDS, $custom_fields );
			}

			// print_r('<pre>'); print_r($WWLC_REGISTRATION_FIELDS); print_r('</pre>');

			foreach ( $custom_fields as $field_id => $custom_field ) {

				$field_name  = $custom_field['field_name'];
				$field_type  = $custom_field['field_type'];
				$is_required = $custom_field['required'];
				$placeholder = $custom_field['field_placeholder'];
				$is_enabled  = $custom_field['enabled'];

				if ( ! $field_type ) {
					$field_type = isset( $custom_field['type'] ) ? $custom_field['type'] : '';
				}
				if ( ! $field_name ) {
					$field_name = isset( $custom_field['label'] ) ? $custom_field['label'] : '';
				}
				if ( ! $placeholder ) {
					$placeholder = isset( $custom_field['placeholder'] ) ? $custom_field['placeholder'] : '';
				}
				if ( ! $is_enabled ) {
					$is_enabled = isset( $custom_field['active'] ) ? true : false;
				}

				if ( ! in_array( $field_type, $allowed_type ) ) {
					wholesalex()->log( sprintf( 'Wholesale Suite Migration: Field Type (%s) Does not supported in WholesaleX. Skipped For Migration. ', $field_type ), 'info' );
					continue;
				}

				// $field_type = get_post_meta( $field_id, 'b2bking_custom_field_field_type', true );
				// update_post_meta( $field_id, 'wholesalex_migrate', true );
				$temp_field = array(
					'id'                    => $field_id,
					'type'                  => $field_type,
					'title'                 => $field_name,
					'placeholder'           => $placeholder,
					'required'              => $is_required,
					'custom_field'          => true,
					'name'                  => $field_id,
					'isLabelHide'           => false,
					'help_message'          => '',
					'enableForRegistration' => $is_enabled,
					'enableForBillingForm'  => false,
					'excludeRoles'          => array(),
				);

				if ( isset( $custom_field['options'] ) ) {
					$options = array();
					foreach ( $custom_field['options'] as $option ) {
						$options[] = array(
							'name'  => $option['text'],
							'value' => $option['value'],
						);
					}
					$temp_field['option'] = $options;
				}

				$migration_fields[] = $temp_field;
			}

			// print_r('<pre>'); print_r($migration_fields); print_r('</pre>');

				$wholesalex_fields = json_decode( $wholesalex_fields, 'true' );
				$all_fields        = $wholesalex_fields + $migration_fields;

				// print_r('<pre>'); print_r($wholesalex_fields); print_r('</pre>');

				// print_r('<pre>'); print_r($migration_fields); print_r('</pre>');

				$fields = array();
				$names  = array();

			foreach ( $wholesalex_fields as $field ) {
				$names[]  = $field['name'];
				$fields[] = $field;
			}
			foreach ( $migration_fields as $field ) {
				if ( ! in_array( $field['name'], $names ) ) {
					$names[]  = $field['name'];
					$fields[] = $field;
				}
			}

			update_option( '__wholesalex_registration_form', json_encode( $fields ) );
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_discount_settings' === $_GET['migrate'] ) {
			if ( ! get_transient( 'wholesalex_migrate__discount' ) ) {

				$discounts = get_option( 'wwpp_option_wholesale_role_general_discount_mapping', array() );

				$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

				foreach ( $discounts as $role_id => $discount ) {
					$temp_rule = array();
					$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
					$temp_rule = array(
						'id'               => uniqid(),
						'_rule_status'     => false,
						'_rule_title'      => sprintf( __( 'Discount Rule - Migrate From Wholesale Prices Settings (%s)', 'wholesalex' ), $role_name ),
						'limit'            => array(),
						'_rule_type'       => 'product_discount',
						'product_discount' =>
						array(
							'_discount_type'   => 'percentage',
							'_discount_amount' => $discount,
							'_discount_name'   => '',
						),
						'_rule_for'        => 'specific_roles',
						'specific_roles'   => array(
							array(
								'name'  => $role_name,
								'value' => $role_id,
							),
						),
						'_product_filter'  => 'all_products',
					);

					$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

				}

				$is_single_product_qb_discount = get_option( 'enable_wholesale_role_cart_quantity_based_wholesale_discount_mode_2' );
				if ( 'yes' === $is_single_product_qb_discount ) {
					$discounts = get_option( 'wwpp_option_wholesale_role_cart_qty_based_discount_mapping', array() );

					$rolewise_tiers = array();

					foreach ( $discounts as $discount ) {
						$temp_tier     = array();
						$role_id       = $discount['wholesale_role'];
						$role_name     = $discount['wholesale_name'];
						$min_quantity1 = $discount['start_qty'];
						$min_quantity2 = $discount['end_qty'];
						$amount        = $discount['percent_discount'];

						$temp_tier = array(
							'_id'              => uniqid(),
							'src'              => 'dynamic_rule',
							'_discount_type'   => 'percentage',
							'_min_quantity'    => $min_quantity1,
							'_discount_amount' => $amount,
						);
						if ( ! ( isset( $rolewise_tiers[ $role_id ] ) && is_array( $rolewise_tiers[ $role_id ] ) ) ) {
							$rolewise_tiers[ $role_id ] = array();
						}
						$rolewise_tiers[ $role_id ][] = $temp_tier;
					}

					foreach ( $rolewise_tiers as $role_id => $tier ) {
						$temp_rule = array(
							'id'              => uniqid(),
							'_rule_status'    => true,
							'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
							'limit'           => array(),
							'_rule_type'      => 'quantity_based',
							'quantity_based'  => array( 'tiers' => $tier ),
							'_rule_for'       => 'specific_roles',
							'specific_roles'  => array(
								array(
									'name'  => wholesalex()->get_role_name_by_role_id( $role_id ),
									'value' => $role_id,
								),
							),
							'_product_filter' => 'all_products',
						);

						$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
					}

					$discounts               = get_option( 'wwpp_option_wholesale_role_cart_subtotal_price_based_discount_mapping', array() );
					$rolewise_cart_discounts = array();

					foreach ( $discounts as $discount ) {
						$role_id    = $discount['wholesale_role'];
						$cart_total = $discount['subtotal_price'];
						$type       = $discount['discount_type'];
						$amount     = $discount['discount_amount'];
						$title      = $discount['discount_title'];
						$type       = ( $type === 'percent-discount' ) ? 'percentage' : 'amount';

						if ( ! ( isset( $rolewise_cart_discounts[ $role_id ] ) && is_array( $rolewise_cart_discounts[ $role_id ] ) ) ) {
							$rolewise_cart_discounts[ $role_id ] = array();
						}
						$rolewise_cart_discounts[ $role_id ][] = array(
							'_discount_type'   => $type,
							'_discount_amount' => $amount,
							'_discount_name'   => $title,
						);

						$temp_rule = array(
							'id'              => uniqid(),
							'_rule_status'    => true,
							'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
							'limit'           => array(),
							'_rule_type'      => 'cart_discount',
							'cart_discount'   => array(
								'_discount_type'   => $type,
								'_discount_amount' => $amount,
								'_discount_name'   => $title,
							),
							'_rule_for'       => 'specific_roles',
							'specific_roles'  => array(
								array(
									'name'  => wholesalex()->get_role_name_by_role_id( $role_id ),
									'value' => $role_id,
								),
							),
							'_product_filter' => 'all_products',
							'conditions'      => array(
								'tiers' => array(
									array(
										'_id'             => uniqid(),
										'src'             => 'dynamic_rule',
										'_conditions_for' => 'cart_total_value',
										'_conditions_operator' => 'greater_equal',
										'_conditions_value' => $cart_total,
									),
								),
							),

						);

						$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

					}
				}

				update_option( '__wholesalex_dynamic_rules', $dynamic_rules );
				set_transient( 'wholesalex_migrate__discount', true );
			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_shipping_rule' === $_GET['migrate'] ) {
			if ( ! get_transient( 'wholesalex_migrate__shipping' ) ) {

				$shipping_mappings = get_option( 'wwpp_option_wholesale_role_shipping_zone_method_mapping', array() );
				$dynamic_rules     = get_option( '__wholesalex_dynamic_rules', array() );
				foreach ( $shipping_mappings as $shipping_rule ) {
					$role_id   = $shipping_rule['wholesale_role'];
					$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
					$zone      = $shipping_rule['shipping_zone'];
					$method_id = $shipping_rule['shipping_method'];

					$method = WC_Shipping_Zones::get_shipping_method( $method_id );

					$temp_rule = array(
						'id'              => uniqid(),
						'_rule_status'    => true,
						'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices General Quantity Based Discounts (%s)', 'wholesalex' ), $role_name ),
						'limit'           => array(),
						'_rule_type'      => 'shipping_rule',
						'shipping_rule'   => array(
							'__shipping_zone'        => $zone,
							'_shipping_zone_methods' => array(
								array(
									'name'  => $method->get_title(),
									'value' => $method_id,
								),
							),
						),
						'_rule_for'       => 'specific_roles',
						'specific_roles'  => array(
							array(
								'name'  => $role_name,
								'value' => $role_id,
							),
						),
						'_product_filter' => 'all_products',
					);

					$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
				}

				update_option( '__wholesalex_dynamic_rules', $dynamic_rules );
				set_transient( 'wholesalex_migrate__shipping', true );
			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_payment_gateway' === $_GET['migrate'] ) {

			if ( ! get_transient( 'wholesalex_migration__gateway_migration' ) ) {

				// Tax Class Mapping'
				$gateway_mapping_rules     = get_option( 'wwpp_option_wholesale_role_payment_gateway_mapping', array() );
				$gateway_surcharge_mapping = get_option( 'wwpp_option_payment_gateway_surcharge_mapping', array() );

				$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

				foreach ( $gateway_mapping_rules as $role_id => $gateways ) {
					$role_name     = wholesalex()->get_role_name_by_role_id( $role_id );
					$gateway_array = array();
					foreach ( $gateways as $gateway ) {
						$gateway_array[] = $gateway['id'];
					}
					$role_data                     = wholesalex()->get_roles( 'by_id', $role_id );
					$role_data['_payment_methods'] = $gateway_array;
					wholesalex()->set_roles( $role_id, $role_data );
					wholesalex()->log( sprintf( 'WholesaleX Role (%s) Payment Method Update From WholesaleX Wholesale Suite Migration', $role_name ) );
				}

				foreach ( $gateway_surcharge_mapping as $surcharge ) {
					$role_id          = $surcharge['wholesale_role'];
					$payment_gateway  = $surcharge['payment_gateway'];
					$surcharge_title  = $surcharge['surcharge_title'];
					$surcharge_type   = ( 'fixed_price' === $surcharge['type'] ) ? 'amount' : 'percentage';
					$surcharge_amount = $surcharge['surcharge_amount'];
					$role_name        = wholesalex()->get_role_name_by_role_id( $role_id );

					$wc_gateways = new WC_Payment_Gateways();

					// Get an array of all available payment gateways
					$payment_gateways = $wc_gateways->get_available_payment_gateways();

					$gateway_title = isset( $payment_gateways[ $payment_gateway ] ) ? $payment_gateways[ $payment_gateway ]->get_title() : '';

					$temp_rule = array(
						'id'              => uniqid(),
						'_rule_status'    => true,
						'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Gateway Surcharge (%s)', 'wholesalex' ), $role_name ),
						'limit'           => array(),
						'_rule_type'      => 'extra_charge',
						'extra_charge'    => array(
							'_payment_gateways' => array(
								array(
									'name'  => $gateway_title,
									'value' => $payment_gateway,
								),
							),
							'_charge_type'      => $surcharge_type,
							'_charge_amount'    => $surcharge_amount,
							'_charge_name'      => $surcharge_title,

						),
						'_rule_for'       => 'specific_roles',
						'specific_roles'  => array(
							array(
								'name'  => $role_name,
								'value' => $role_id,
							),
						),
						'_product_filter' => 'all_products',
					);

					$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;

					update_option( '__wholesalex_dynamic_rules', $dynamic_rules );

					wholesalex()->log( sprintf( 'WholesaleX Dynamic Rules added For Wholesale Suite Surcharge Migration' ) );

				}

				set_transient( 'wholesalex_migration__gateway_migration', true );

			}
		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_tax_rule' === $_GET['migrate'] ) {

			if ( ! get_transient( 'wholesalex_migration__tax_rule_migration' ) ) {

				$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

				// Tax Class Mapping'
				$tax_mapping_rules = get_option( 'wwpp_option_wholesale_role_tax_class_options_mapping', array() );
				foreach ( $tax_mapping_rules as $role_id => $tax_rule ) {
					$role_name      = $tax_rule['wholesale-role-name'];
					$tax_class      = $tax_rule['tax-class'];
					$tax_class_name = $tax_rule['tax-class-name'];

					$temp_rule                         = array(
						'id'              => uniqid(),
						'_rule_status'    => true,
						'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Tax Class Mapping (%s)', 'wholesalex' ), $role_name ),
						'limit'           => array(),
						'_rule_type'      => 'tax_rule',
						'tax_rule'        => array(
							'_tax_exempted' => 'no',
							'_tax_class'    => $tax_class,
						),
						'_rule_for'       => 'specific_roles',
						'specific_roles'  => array(
							array(
								'name'  => $role_name,
								'value' => $role_id,
							),
						),
						'_product_filter' => 'all_products',
					);
					$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
				}

				$tax_exemption_rules = get_option( 'wwpp_option_wholesale_role_tax_option_mapping', array() );

				foreach ( $tax_exemption_rules as $role_id => $tax_exemption_status ) {
					$is_tax_exempted = $tax_exemption_status['tax_exempted'];
					if ( 'yes' != $is_tax_exempted ) {
						continue;
					}
					$role_name = wholesalex()->get_role_name_by_role_id( $role_id );
					// new tax rule
					$temp_rule = array(
						'id'              => uniqid(),
						'_rule_status'    => true,
						'_rule_title'     => sprintf( __( 'Migrate From Wholesale Prices: Tax Exemption (%s)', 'wholesalex' ), $role_name ),
						'limit'           => array(),
						'_rule_type'      => 'tax_rule',
						'tax_rule'        => array(
							'_tax_exempted' => $is_tax_exempted,
						),
						'_rule_for'       => 'specific_roles',
						'specific_roles'  => array(
							array(
								'name'  => $role_name,
								'value' => $role_id,
							),
						),
						'_product_filter' => 'all_products',
					);

					$dynamic_rules[ $temp_rule['id'] ] = $temp_rule;
				}

				update_option( '__wholesalex_dynamic_rules', $dynamic_rules );
				set_transient( 'wholesalex_migration__tax_rule_migration', true );
			}

			// print_r('<pre>'); print_r($tax_mapping_rules); print_r('</pre>');
			// // print_r('<pre>'); print_r($tax_exemption_rules); print_r('</pre>');
			// die();

		}

		if ( isset( $_GET['migrate'] ) && 'wholesale_suite_users' === $_GET['migrate'] ) {

			// wwpp_tax_exemption

			$users                 = get_users( array( 'fields' => 'ids' ) );
			$wholesale_suite_roles = array_keys( maybe_unserialize( get_option( 'wwp_options_registered_custom_roles', array() ) ) );
			$wc_gateways           = new WC_Payment_Gateways();

			foreach ( $users as $user_id ) {
				$user_data     = get_userdata( $user_id );
				$settings_data = array();

				if ( $user_data ) {
					$wholesale_suite_role = array_values( array_intersect( $wholesale_suite_roles, $user_data->roles ) );
					if ( isset( $wholesale_suite_role[0] ) ) {
						wholesalex()->change_role( $user_id, $wholesale_suite_role[0], get_user_meta( $user_id, '__wholesalex_role', true ) );
						update_user_meta( $user_id, '__wholesalex_status', 'active' );
					}
				}

				$tax_exemption_status = get_user_meta( $user_id, 'wwpp_tax_exemption', true );
				switch ( $tax_exemption_status ) {
					case 'yes':
					case 'no':
						$settings_data['_wholesalex_profile_override_tax_exemption'] = $tax_exemption_status;
						break;
					default:
						break;
				}
				$shipping_status = get_user_meta( $user_id, 'wwpp_override_shipping_options', true );

				switch ( $shipping_status ) {
					case 'yes':
						$settings_data['_wholesalex_profile_override_shipping_method'] = $shipping_status;
						$shipping_methods_type = get_user_meta( $user_id, 'wwpp_shipping_methods_type', true );
						if ( 'force_free_shipping' === $shipping_methods_type ) {
							$settings_data['_wholesalex_profile_shipping_method_type'] = 'force_free_shipping';
						} elseif ( 'specify_shipping_methods' === $shipping_methods_type ) {
							$settings_data['_wholesalex_profile_shipping_method_type'] = 'specific_shipping_methods';
							$shipping_methods = get_user_meta( $user_id, 'wwpp_shipping_methods', true );

							$wholesalex_shipping_methods = array();

							$settings_data['_wholesalex_profile_shipping_zone'] = get_user_meta( $user_id, 'wwpp_shipping_zone', true );

							foreach ( $shipping_methods as $method_id ) {
								$method                        = WC_Shipping_Zones::get_shipping_method( $method_id );
								$wholesalex_shipping_methods[] = array(
									'name'  => $method->get_title(),
									'value' => $method_id,
								);
							}

							$settings_data['_wholesalex_profile_shipping_zone_methods'] = $wholesalex_shipping_methods;

						}

						break;
					case 'no':
						$settings_data['_wholesalex_profile_override_shipping_method'] = $shipping_status;
						break;

					default:
						// code...
						break;
				}

				$payment_gateways_status = get_user_meta( $user_id, 'wwpp_override_payment_gateway_options', true );
				switch ( $payment_gateways_status ) {
					case 'yes':
						$settings_data['_wholesalex_profile_override_payment_gateway'] = 'yes';
						$payment_gateways        = get_user_meta( $user_id, 'wwpp_payment_gateway_options', true );
						$wholesalex_gateway_data = array();

						$available_payment_gateways = WC()->payment_gateways->payment_gateways();

						foreach ( $payment_gateways as $gateway_id ) {
							if ( isset( $available_payment_gateways[ $gateway_id ] ) ) {
								$wholesalex_gateway_data[] = array(
									'name'  => $available_payment_gateways[ $gateway_id ]->title,
									'value' => $gateway_id,
								);
							}
						}

						$settings_data['_wholesalex_profile_payment_gateways'] = $wholesalex_gateway_data;

						break;
					case 'no':
						$settings_data['_wholesalex_profile_override_payment_gateway'] = 'no';
						// code...
						break;

					default:
						// code...
						break;
				}

				$wholesalex_discount_data = array( 'tiers' => array() );

				$tier_discounts = get_user_meta( $user_id, 'wwpp_wholesale_discount_qty_discount_mapping', true );
				foreach ( $tier_discounts as $tier ) {
					$wholesalex_discount_data['tiers'][] = array(
						'_id'              => uniqid(),
						'_discount_type'   => 'percentage',
						'_discount_amount' => $tier['percent_discount'],
						'_min_quantity'    => $tier['start_qty'],
						'src'              => 'profile',
						'_product_filter'  => 'all_products',
					);
				}

				$profile_discounts = array( '_profile_discounts' => $wholesalex_discount_data );

				update_user_meta( $user_id, '__wholesalex_profile_discounts', $profile_discounts );
				update_user_meta( $user_id, '__wholesalex_profile_settings', $settings_data );
			}
		}
	}



	public static function get_wholesalex_default_form() {
		$form = array(
			array(
				'index'                 => 0,
				'id'                    => 2,
				'type'                  => 'email',
				'title'                 => 'Email',
				'name'                  => 'user_email',
				'required'              => true,
				'isLabelHide'           => false,
				'placeholder'           => 'example@example.com',
				'help_message'          => '',
				'excludeRoles'          => array(),
				'enableForRegistration' => true,

			),
			array(
				'index'                 => 1,
				'id'                    => 3,
				'type'                  => 'password',
				'title'                 => 'Password',
				'name'                  => 'user_pass',
				'required'              => true,
				'isLabelHide'           => false,
				'placeholder'           => 'pass',
				'help_message'          => '',
				'excludeRoles'          => array(),
				'enableForRegistration' => true,
			),
		);

		return json_encode( $form );
	}

}
