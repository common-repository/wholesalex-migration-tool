<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WholesaleX_B2BKing_Migration {

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
		self::$background_process = new WholesaleX_B2BKing_Background_Migration();

		add_action( 'wholesalex_migration_tools_restapi_action', array( $this, 'process_tools_restapi' ) );
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
			case 'start_b2bking_migration':
				$this->migration();
				break;
			case 'b2bking_migration_status':
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
				'is_migrating'    => get_transient( 'wholesalex_b2bking_migrating' ),
				'migration_stats' => get_transient( 'wholesalex_b2bking_migration_stats' ),
			)
		);
	}

	public function migration() {
		set_transient( 'wholesalex_b2bking_migration_stats', array() );

		$b2bking_role_count = wp_count_posts( 'b2bking_group' )->publish + wp_count_posts( 'b2bking_group' )->draft;

		$b2bking_group_chunks = $this->split_into_chunk( 20, $b2bking_role_count );
		$total_chunks         = count( $b2bking_group_chunks );

		foreach ( $b2bking_group_chunks as $idx => $limit ) {

			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_group_to_roles',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'B2Bking Groups (' . $completed_percentage . '%) Added to queue for migrating', 'info' );
		}

		$b2bking_fields_count = wp_count_posts( 'b2bking_custom_field' )->publish;

		$b2bking_fields_count_chunks = $this->split_into_chunk( 20, $b2bking_fields_count );
		$total_chunks                = count( $b2bking_fields_count_chunks );

		foreach ( $b2bking_fields_count_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_registration_form_fields',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);

			wholesalex()->log( 'B2Bking Registration Form Fields (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		$b2bking_purchase_lists_count = wp_count_posts( 'b2bking_list' )->publish;

		$b2bking_purchase_list_chunks = $this->split_into_chunk( 20, $b2bking_purchase_lists_count );

		$total_chunks = count( $b2bking_purchase_list_chunks );

		foreach ( $b2bking_purchase_list_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_purchase_lists',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'B2Bking Purchase Lists (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		$b2bking_conversations_count  = wp_count_posts( 'b2bking_conversation' )->publish;
		$b2bking_conversations_chunks = $this->split_into_chunk( 20, $b2bking_conversations_count );
		$total_chunks                 = count( $b2bking_conversations_chunks );

		foreach ( $b2bking_conversations_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_conversations',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);

			wholesalex()->log( 'B2Bking Conversations (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

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
			wholesalex()->log( 'B2Bking Simple Products (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

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
			wholesalex()->log( 'B2Bking Product Variations (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

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

			wholesalex()->log( 'B2Bking Users (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		self::$background_process->push_to_queue(
			array(
				'task'                 => 'migrate_settings',
				'completed_percentage' => 100,
			)
		);
		wholesalex()->log( 'B2Bking Settings Added to queue for migrating', 'info' );

		$b2bking_rule_count = wp_count_posts( 'b2bking_rule' )->publish + wp_count_posts( 'b2bking_rule' )->draft;

		$b2bking_rule_chunks = $this->split_into_chunk( 20, $b2bking_rule_count );

		$total_chunks = count( $b2bking_rule_chunks );

		foreach ( $b2bking_rule_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_dynamic_rules',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'B2Bking Dynamic Rules (' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}
		
		$b2bking_lists_count = wp_count_posts( 'b2bking_list' )->publish;

		$b2bking_lists_chunks = $this->split_into_chunk( 20, $b2bking_lists_count );

		$total_chunks = count( $b2bking_lists_chunks );

		foreach ( $b2bking_lists_chunks as $idx => $limit ) {
			$completed_percentage = ( ( 1 / $total_chunks ) * 100 );
			if ( $total_chunks === ( $idx + 1 ) ) {
				$completed_percentage = ( 100 - ( $idx / $total_chunks ) * 100 );
			}
			self::$background_process->push_to_queue(
				array(
					'task'                 => 'migrate_purchase_lists',
					'page'                 => $idx + 1,
					'limit'                => $limit,
					'completed_percentage' => $completed_percentage,
				)
			);
			wholesalex()->log( 'B2Bking Purchase Lists(' . $completed_percentage . '%) Added to queue for migrating', 'info' );

		}

		self::$background_process->save()->dispatch();

		wp_send_json(
			array(
				'status' => true,
				'data'   => array( 'message' => 'Migration Started.' ),
			)
		);
	}

	public static function migrate_group_to_roles( $page = 0, $limit = 20 ) {
		$count  = 0;
		$groups = get_posts(
			array(
				'post_type'   => 'b2bking_group',
				'post_status' => array( 'publish', 'draft' ),
				'numberposts' => $limit,
				'page'        => $page,
				'fields'      => 'ids',
			)
		);

		if ( $groups ) {
			$prepare_migration_data = array();

			// list all shipping methods
			$shipping_methods = array();
			$zone_names       = array();

			$delivery_zones = WC_Shipping_Zones::get_zones();
			foreach ( $delivery_zones as $key => $the_zone ) {
				foreach ( $the_zone['shipping_methods'] as $value ) {
					array_push( $shipping_methods, $value );
				}
			}

			$payment_methods = WC()->payment_gateways->payment_gateways();

			foreach ( $groups as $group ) {
				$title      = get_the_title( $group );
				$group_data = array(
					'id'                => 'wholesalex_mb2bking_' . $group,
					'_role_title'       => $title,
					'_shipping_methods' => array(),
					'_payment_methods'  => array(),
					'credit_limit'      => '',
				);

				foreach ( $shipping_methods as $shipping_method ) {
					$shipping_method_status = get_post_meta( $group, 'b2bking_group_shipping_method_' . $shipping_method->id . $shipping_method->instance_id, true );
					if ( $shipping_method_status ) {
						$group_data['_shipping_methods'][] = $shipping_method->instance_id;
					}
				}

				foreach ( $payment_methods as $payment_method ) {
					$payment_method_status = get_post_meta( $group, 'b2bking_group_payment_method_' . $payment_method->id, true );
					if ( $payment_method_status ) {
						$group_data['_payment_methods'][] = $payment_method->id;
					}
				}
				$group_data['credit_limit'] = get_option( 'b2bking_group_credit_limit', '' );

				$prepare_migration_data[] = $group_data;
			}

			foreach ( $prepare_migration_data as $role ) {
				wholesalex()->set_roles( $role['id'], $role );
				$count++;

				wholesalex()->log( 'B2Bking Group: (' . $role['_role_title'] . ') Migrated into WnolesaleX Role', 'info' );

			}
		}
		return $count;
	}

	public static function migrate_registration_form_fields( $page = 1, $limit = 20 ) {
		$count         = 0;
		$custom_fields = get_posts(
			array(
				'post_type'   => 'b2bking_custom_field',
				'post_status' => 'publish',
				'numberposts' => $limit,
				'page'        => $page,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
			)
		);

		$migration_fields = array();

		$wholesalex_fields = get_option( '__wholesalex_registration_form', self::get_wholesalex_default_form() );

		foreach ( $custom_fields as $field_id ) {
			$field_type = get_post_meta( $field_id, 'b2bking_custom_field_field_type', true );
			$temp_field = array(
				'id'                    => $field_id,
				'type'                  => $field_type,
				'title'                 => get_post_meta( $field_id, 'b2bking_custom_field_field_label', true ),
				'placeholder'           => get_post_meta( $field_id, 'b2bking_custom_field_field_placeholder', true ),
				'billing_connection'    => get_post_meta( $field_id, 'b2bking_custom_field_billing_connection', true ),
				'required'              => get_post_meta( $field_id, 'b2bking_custom_field_required', true ) || get_post_meta( $field_id, 'b2bking_custom_field_required_billing', true ),
				'custom_field'          => true,
				'name'                  => $field_type . '-' . $field_id,
				'isLabelHide'           => false,
				'help_message'          => '',
				'enableForRegistration' => get_post_meta( $field_id, 'b2bking_custom_field_status', true ) && ! get_post_meta( $field_id, 'b2bking_custom_field_billing_exclusive', true ),
				'enableForBillingForm'  => get_post_meta( $field_id, 'b2bking_custom_field_status', true ) && get_post_meta( $field_id, 'b2bking_custom_field_add_to_billing', true ),
				'excludeRoles'          => array(),
			);

			$migration_fields[] = $temp_field;
			$count++;
			wholesalex()->log( 'B2Bking Registration Fields: (' . $temp_field['title'] . ') Migrated into WnolesaleX Fields', 'info' );
		}

		$wholesalex_fields = json_decode( $wholesalex_fields, 'true' );
		$all_fields        = $wholesalex_fields + $migration_fields;

		update_option( '__wholesalex_registration_form', json_encode( $all_fields ) );

		return $count;

	}

	public static function migrate_dynamic_rules( $page = 1, $limit = 5 ) {
		$count = 0;

		$rule_types = array(
			'discount_amount'             => 'product_discount',
			'discount_percentage'         => 'product_discount',
			'raise_price'                 => '',
			'bogo_discount'               => 'buy_x_get_one',
			'fixed_price'                 => 'product_discount',
			'hidden_price'                => '',
			'tiered_price'                => 'quantity_based',
			'free_shipping'               => 'shipping_rule',
			'minimum_order'               => 'min_order_qty',
			'maximum_order'               => 'max_order_qty',
			'required_multiple'           => '',
			'unpurchasable'               => '',
			'tax_exemption_user'          => '',
			'tax_exemption'               => '',
			'add_tax_percentage'          => '',
			'add_tax_amount'              => '',
			'replace_prices_quote'        => '',
			'set_currency_symbol'         => '',
			'payment_method_minmax_order' => 'payment_order_qty',
			'payment_method_discount'     => 'payment_discount',
			'rename_purchase_order'       => '',
		);

		$b2bking_rules = get_posts(
			array(
				'post_type'   => 'b2bking_rule',
				'post_status' => array( 'publish', 'draft' ),
				'numberposts' => $limit,
				'page'        => $page,
				'fields'      => 'ids',
			)
		);

		$dynamic_rules = get_option( '__wholesalex_dynamic_rules', array() );

		foreach ( $b2bking_rules as $rule_id ) {
			$temp_rule_data = array(
				'id'           => $rule_id,
				'_rule_status' => 'publish' == get_post_status( $rule_id ),
				'_rule_title'  => get_the_title( $rule_id ),
			);

			$rule_type = get_post_meta( $rule_id, 'b2bking_rule_what', true );

			if ( isset( $rule_types[ $rule_type ] ) ) {

				$temp_rule_data['rule_type'] = $rule_types[ $rule_type ];

				$amount = get_post_meta( $rule_id, 'b2bking_rule_howmuch', true );

				$discount_name = get_post_meta( $rule_id, 'b2bking_rule_discountname', true );

				$rule_apply_for = get_post_meta( $rule_id, 'b2bking_rule_who', true );

				$rule_applies_to = get_post_meta( $rule_id, 'b2bking_rule_applies', true );

				$rule_conditions = get_post_meta( $rule_id, 'b2bking_rule_conditions', true );

				$temp_rule_data[ $temp_rule_data['rule_type'] ] = array();

				if ( $rule_apply_for ) {
					switch ( $rule_apply_for ) {
						case 'everyone_registered':
						case 'all_registered';
							$temp_rule_data['_rule_for'] = 'all_users';

							break;
						case 'everyone_registered_b2b':
							$temp_rule_data['_rule_for'] = 'all_roles';
							break;
						case 'everyone_registered_b2c':
								$temp_rule_data['_rule_for']      = 'specific_roles';
								$temp_rule_data['specific_roles'] = array(
									array(
										'value' => 'wholesalex_b2c_users',
										'name'  => wholesalex()->get_role_name_by_role_id( 'wholesalex_b2c_users' ),
									),
								);
							break;
						case 'user_0':
								$temp_rule_data['_rule_for']      = 'specific_roles';
								$temp_rule_data['specific_roles'] = array(
									array(
										'value' => 'wholesalex_guest',
										'name'  => wholesalex()->get_role_name_by_role_id( 'wholesalex_guest' ),
									),
								);
							break;
						case 'multiple_options':
							break;
						case ( preg_match( '/group.*/', $rule_apply_for ) ? true : false ):
							$temp_rule_data['_rule_for']      = 'specific_roles';
							$group                            = explode( '_', $rule_apply_for )[1];
							$temp_rule_data['specific_roles'] = array(
								array(
									'value' => 'wholesalex_mb2bking_' . $group,
									'name'  => wholesalex()->get_role_name_by_role_id( 'wholesalex_mb2bking_' . $group ),
								),
							);
							break;
						case ( preg_match( '/user_.*/', $rule_apply_for ) ? true : false ):
							$temp_rule_data['_rule_for']      = 'specific_users';
							$id                               = explode( '_', $rule_apply_for )[1];
							$user_data                        = get_userdata( $id );
							$temp_rule_data['specific_users'] = array(
								array(
									'value' => 'user_' . $id,
									'name'  => $user_data->user_login,
								),
							);
							break;

						default:
							break;
					}
				}

				if ( $rule_applies_to ) {
					switch ( $rule_applies_to ) {
						case ( preg_match( '/product.*/', $rule_applies_to ) ? true : false ):
							$id      = explode( '_', $rule_applies_to )[1];
							$product = wc_get_product( $id );
							if ( 0 == $product->get_parent_id() ) {
								$temp_rule_data['_product_filter']  = 'products_in_list';
								$temp_rule_data['products_in_list'] = array(
									array(
										'value' => $id,
										'name'  => $product->get_name(),
									),
								);
							} else {
								$productname = $product->get_name();
								if ( is_a( $product, 'WC_Product_Variation' ) ) {
									$attributes           = $product->get_variation_attributes();
									$number_of_attributes = count( $attributes );
									if ( $number_of_attributes > 2 ) {
										$productname .= ' - ';
										foreach ( $attributes as $attribute ) {
											$productname .= $attribute . ', ';
										}
										$productname = substr( $productname, 0, -2 );
									}
								}
								$temp_rule_data['_product_filter']   = 'attribute_in_list';
								$temp_rule_data['attribute_in_list'] = array(
									array(
										'value' => $id,
										'name'  => $productname,
									),
								);
							}
							break;
						case ( preg_match( '/category.*/', $rule_applies_to ) ? true : false ):
							$id   = explode( '_', $rule_applies_to )[1];
							$term = get_term_by( 'id', $id, 'product_cat' );
							if ( $term ) {
								$temp_rule_data['_product_filter'] = 'cat_in_list';
								$temp_rule_data['cat_in_list']     = array(
									array(
										'value' => $id,
										'name'  => $term->name,
									),
								);
							}
							break;
						case 'cart_total':
							$temp_rule_data['_product_filter'] = 'all_products';
							break;
						default:
							break;
					}
				}

				if ( $rule_conditions ) {
					$conditions      = explode( '|', $rule_conditions );
					$condition_tiers = array();
					foreach ( $conditions as $condition_string ) {
						$temp_tier          = array(
							'_id' => uniqid(),
							'src' => 'dynamic_rule',
						);
						$condition_array    = explode( ';', $condition_string );
						$condition_type     = $condition_array[0];
						$condition_operator = $condition_array[1];
						$condition_amount   = $condition_array[2];

						switch ( $condition_type ) {
							case 'cart_total_quantity':
								$temp_tier['_conditions_for'] = 'cart_total_qty';

								break;
							case 'cart_total_value':
								$temp_tier['_conditions_for'] = 'cart_total_value';

								break;

							default:
								$temp_tier['_conditions_for'] = '';
								break;
						}
						switch ( $condition_operator ) {
							case 'greater':
								$temp_tier['_conditions_operator'] = 'greater';
								break;
							case 'equal':
								$temp_tier['_conditions_operator'] = 'equal';
								break;
							case 'smaller':
								$temp_tier['_conditions_operator'] = 'less';
								break;

							default:
								break;
						}

						$temp_tier['_conditions_value'] = $condition_amount;

						$condition_tiers[] = $temp_tier;

					}

					$temp_rule_data['conditions'] = array( 'tiers' => $condition_tiers );

				}

				switch ( $temp_rule_data['rule_type'] ) {
					case 'product_discount':
						if ( 'discount_amount' == $rule_type ) {
							$temp_rule_data[ $temp_rule_data['rule_type'] ]['_discount_type'] = 'amount';
						} elseif ( 'discount_percentage' == $rule_type ) {
							$temp_rule_data[ $temp_rule_data['rule_type'] ]['_discount_type'] = 'percentage';
						} elseif ( 'fixed_price' == $rule_type ) {
							$temp_rule_data[ $temp_rule_data['rule_type'] ]['_discount_type'] = 'fixed';
						}
						$temp_rule_data[ $temp_rule_data['rule_type'] ]['_discount_amount'] = $amount;

						if ( $discount_name ) {
							$temp_rule_data[ $temp_rule_data['rule_type'] ]['_discount_name'] = $discount_name;
						}

						break;
					case 'buy_x_get_one':
						$temp_rule_data['buy_x_get_one'] = array( '_minimum_purchase_count' => $amount );

						break;
					case 'quantity_based':
						$tiers         = array();
						$tiered_price  = get_post_meta( $rule_id, 'b2bking_product_pricetiers_group_b2c', true );
						$b2bking_tiers = explode( ';', $tiered_price );

						foreach ( $b2bking_tiers as $b2bking_tier ) {
							$temp_tier          = array(
								'id'  => uniqid(),
								'src' => 'dynamic_rule',
							);
							$b2bking_tier_array = explode( ':', $b2bking_tier );

							$temp_tier['_discount_type']   = 'fixed';
							$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
							$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

							$tiers[] = $temp_tier;
						}
						$temp_rule_data['quantity_based'] = array( 'tiers' => $tiers );
						break;
					case 'min_order_qty':
						$temp_rule_data['min_order_qty'] = array( '_min_order_qty' => $amount );
						break;
					case 'max_order_qty':
						$temp_rule_data['max_order_qty'] = array( '_max_order_qty' => $amount );
						break;
					case 'payment_discount':
						$b2bking_payment_method = get_post_meta( $rule_id, 'b2bking_rule_paymentmethod', true );
						$b2bking_discount_type  = get_post_meta( $rule_id, 'b2bking_rule_paymentmethod_percentamount', true );
						$payment_method_name    = '';

						$payment_methods = WC()->payment_gateways->payment_gateways();
						foreach ( $payment_methods as $payment_method ) {
							if ( $b2bking_payment_method == $payment_method->id ) {
									$payment_method_name = $payment_method->title;
							}
						}

						$temp_rule_data['payment_discount'] = array(
							'_payment_gateways' => array(
								'name'  => $payment_method_name,
								'value' => $b2bking_payment_method,
							),
							'_discount_type'    => $b2bking_discount_type,
							'_discount_amount'  => $amount,
						);

					default:
						break;
				}
			}

			$dynamic_rules[ $rule_id ] = $temp_rule_data;
			$count++;

			wholesalex()->log( 'B2Bking Dynamic Rule: (' . $temp_rule_data['_rule_title'] . ') Migrated into WnolesaleX Dynamic Rules', 'info' );

		}

		update_option( '__wholesalex_dynamic_rules', $dynamic_rules );

		return $count;
	}

	public static function migrate_products_meta( $page = 1, $limit = 5 ) {
		$count = 0;
		// Get all products
		$product_ids = get_posts(
			array(
				'post_type'   => 'product',
				'post_status' => 'publish',
				'page'        => $page,
				'numberposts' => $limit,
				'fields'      => 'ids',
			)
		);

		 // Get All B2BKing Groups
		$groups = get_posts(
			array(
				'post_type'   => 'b2bking_group',
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);

		$b2bking_product_meta = array(
			'tier'       => array(
				'b2bking_product_pricetiers_group_b2c' => 'wholesalex_b2c_users_tiers',
			),
			'base_price' => array(),
			'sale_price' => array(),
			'setting'    => array(
				'b2bking_show_pricing_table' => 'wholesalex_show_tiered_pricing_table',
			),
		);

		foreach ( $groups as $group_id ) {
			$b2bking_product_meta['tier'][ 'b2bking_product_pricetiers_group_' . $group_id ]          = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_tiers';
			$b2bking_product_meta['base_price'][ 'b2bking_regular_product_price_group_' . $group_id ] = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_base_price';
			$b2bking_product_meta['sale_price'][ 'b2bking_sale_product_price_group_' . $group_id ]    = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_sale_price';
		}

		foreach ( $product_ids as $product_id ) {

			foreach ( $b2bking_product_meta['tier'] as $b2bking_key => $wholesalex_key ) {
				$tiers         = array();
				$tiered_price  = get_post_meta( $product_id, $b2bking_key, true );
				$b2bking_tiers = explode( ';', $tiered_price );

				foreach ( $b2bking_tiers as $b2bking_tier ) {
					$temp_tier          = array(
						'id'  => uniqid(),
						'src' => 'single_product',
					);
					$b2bking_tier_array = explode( ':', $b2bking_tier );

					$temp_tier['_discount_type']   = 'fixed';
					$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
					$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

					$tiers[] = $temp_tier;
				}

				update_post_meta( $product_id, $wholesalex_key, $tiers );

			}

				// Update base price
			foreach ( $b2bking_product_meta['base_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['sale_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['setting'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

			wholesalex()->log( 'B2Bking Simple Product: (#' . $product_id . ') Rolewise Pricing and Tiers Migrated into WnolesaleX Rolewise Pricing and Tiers', 'info' );

			$count++;
		}

		return $count;
	}

	public static function migrate_product_variations_meta( $page = 1, $limit = 5 ) {
		$count             = 0;
		$product_variation = get_posts(
			array(
				'post_type'   => 'product_variation',
				'post_status' => 'publish',
				'numberposts' => $limit,
				'page'        => $page,
				'fields'      => 'ids',
			)
		);

		 // Get All B2BKing Groups
		$groups = get_posts(
			array(
				'post_type'   => 'b2bking_group',
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);

		$b2bking_product_meta = array(
			'tier'       => array(
				'b2bking_product_pricetiers_group_b2c' => 'wholesalex_b2c_users_tiers',
			),
			'base_price' => array(),
			'sale_price' => array(),
			'setting'    => array(
				'b2bking_show_pricing_table' => 'wholesalex_show_tiered_pricing_table',
			),
		);

		foreach ( $groups as $group_id ) {
			$b2bking_product_meta['tier'][ 'b2bking_product_pricetiers_group_' . $group_id ]          = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_tiers';
			$b2bking_product_meta['base_price'][ 'b2bking_regular_product_price_group_' . $group_id ] = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_base_price';
			$b2bking_product_meta['sale_price'][ 'b2bking_sale_product_price_group_' . $group_id ]    = self::get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_sale_price';
		}

		foreach ( $product_variation as $product_id ) {
			foreach ( $b2bking_product_meta['tier'] as $b2bking_key => $wholesalex_key ) {
				$tiers         = array();
				$tiered_price  = get_post_meta( $product_id, $b2bking_key, true );
				$b2bking_tiers = explode( ';', $tiered_price );

				foreach ( $b2bking_tiers as $b2bking_tier ) {
					$temp_tier          = array(
						'id'  => uniqid(),
						'src' => 'single_product',
					);
					$b2bking_tier_array = explode( ':', $b2bking_tier );

					$temp_tier['_discount_type']   = 'fixed';
					$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
					$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

					$tiers[] = $temp_tier;
				}

				update_post_meta( $product_id, $wholesalex_key, $tiers );

			}

				// Update base price
			foreach ( $b2bking_product_meta['base_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['sale_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['setting'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

			wholesalex()->log( 'B2Bking Product Variations: (#' . $product_id . ') Rolewise Pricing and Tiers Migrated into WnolesaleX Rolewise Pricing and Tiers', 'info' );

			$count++;
		}

		return $count;
	}

	public static function migrate_users_meta( $page = 1, $limit = 5 ) {
		$count = 0;

			$users = get_users(
				array(
					'fields' => 'ids',
					'number' => $limit,
					'paged'  => $page,
				)
			);
			foreach ( $users as $user_id ) {
				$wholesalex_role = '';
				$user_group      = get_user_meta( $user_id, 'b2bking_customergroup', true );
				if ( 'no' == $user_group ) {
					$wholesalex_role = 'wholesalex_b2c_users';
				} else {
					$wholesalex_role = self::get_wholesalex_role_id_by_b2bking_group_id( $user_group );
				}
				wholesalex()->change_role( $user_id, $wholesalex_role, get_user_meta( $user_id, '__wholesalex_role', true ) );

				$subaccounts_list = get_user_meta( $user_id, 'b2bking_subaccounts_list', true );
				$subaccounts_list = explode( ',', $subaccounts_list );
				$subaccounts_list = array_filter( array_unique( $subaccounts_list ) );

				foreach ( $subaccounts_list as $subaccount_id ) {
					$parent_id = $user_id;

					$permissions = array();
					if ( get_user_meta( $subaccount_id, 'b2bking_account_permission_buy', true ) ) {
						$permissions[] = 'place_order';
					}
					if ( get_user_meta( $subaccount_id, 'b2bking_account_permission_view_orders', true ) ) {
						$permissions[] = 'view_all_orders';
					}
					if ( get_user_meta( $subaccount_id, 'b2bking_account_permission_view_conversations', true ) ) {
						$permissions[] = 'view_all_conversations';
					}
					if ( get_user_meta( $subaccount_id, 'b2bking_account_permission_view_lists', true ) ) {
						$permissions[] = 'view_all_purchase_lists';
					}

					self::migrate_to_wholesalex_subaccount( $parent_id, $subaccount_id, $permissions );

				}

				wholesalex()->log( 'B2Bking User Role and Subaccounts (#' . $user_id . ') Migrated into WnolesaleX User Role and Subaccounts', 'info' );

				$count++;
			}
		

		return $count;
	}

	public static function migrate_conversations( $page = 1, $limit = 5 ) {
		$count         = 0;
		$conversations = get_posts(
			array(
				'post_type'   => 'b2bking_conversation',
				'post_status' => 'publish',
				'numberposts' => $limit,
				'page'        => $page,
			)
		);

		foreach ( $conversations as $conversationObj ) {
			$conv_id = $conversationObj->ID;
			if ( get_post_meta( $conv_id, 'b2bking_conversations', 'quote' ) ) {
				continue;
			}
			$conv_title                      = $conversationObj->post_title;
			$messages_count                  = get_post_meta( $conv_id, 'b2bking_conversation_messages_number', true );
			$conv_type                       = get_post_meta( $conv_id, 'b2bking_conversation_type', true );
			$wholesalex_conversation_content = '';
			$conversation_author             = $conversationObj->post_author;
			$conv_status                     = get_post_meta( $conv_id, 'b2bking_conversation_status', true );

			for ( $i = 1; $i <= $messages_count; $i++ ) {
				$message                          = get_post_meta( $conv_id, 'b2bking_conversation_message_' . $i, true );
				$author                           = get_post_meta( $conv_id, 'b2bking_conversation_message_' . $i . '_author', true );
				$timestamp                        = get_post_meta( $conv_id, 'b2bking_conversation_message_' . $i . '_time', true );
				$author_id                        = get_user_by( 'login', $author )->ID;
				$wholesalex_conversation_content .= self::generate_new_message( $author_id, $timestamp, $message );
			}

			$data = array(
				'post_title'   => $conv_title,
				'post_type'    => 'wsx_conversation',
				'post_author'  => $conversation_author,
				'post_status'  => 'publish',
				'post_content' => $wholesalex_conversation_content,
			);
			$id   = wp_insert_post( $data );
			update_post_meta( $id, '__conversation_type', $conv_type );
			update_post_meta( $id, '__conversation_status', $conv_status );
			wholesalex()->log( 'B2Bking User Conversations (#' . $conv_id . ') Migrated into WnolesaleX Conversations', 'info' );

			$count++;
		}

		return $count;
	}

	public static function migrate_settings( $page = 1, $limit = 5 ) {
		$count = 0;

		$b2bking_settings = array(
			'b2bking_plugin_status_setting'               => '_settings_status',
			'b2bking_enable_conversations_setting'        => array( 'wsx_addon_conversation', 'wsx_addon_raq' ),
			'b2bking_enable_bulk_order_form_setting'      => 'wsx_addon_bulkorder',
			'b2bking_enable_subaccounts_setting'          => 'wsx_addon_subaccount',
			'b2bking_approval_required_all_users_setting' => '_settings_user_status_option',
			'b2bking_registration_separate_my_account_page_setting' => '_settings_seperate_page_b2b',
			'b2bking_guest_access_restriction_setting'    => array( '_settings_login_to_view_price_product_list', '_settings_login_to_view_price_product_page' ),
			'b2bking_hide_prices_guests_text_setting'     => '_language_login_to_see_prices',
			'b2bking_wholesale_price_text_setting'        => array( '_settings_price_text', '_settings_price_text_product_list_page' ),
			'b2bking_inc_vat_text_setting'                => array( '_settings_wholesalex_price_suffix', '_settings_regular_price_suffix' ),
			'b2bking_ex_vat_text_setting'                 => array( '_settings_wholesalex_price_suffix', '_settings_regular_price_suffix' ),
			'b2bking_disable_coupons_b2b_setting'         => '_settings_disable_coupon',
		);

		foreach ( $b2bking_settings as $b2bking_key => $wholesalex_key ) {
			$b2bking_setting_value    = get_option( $b2bking_key );
			$wholesalex_setting_value = '';

			switch ( $b2bking_key ) {
				case 'b2bking_plugin_status_setting':
					if ( 'b2b' == $b2bking_setting_value ) {
						$wholesalex_setting_value = 'b2b';
					} elseif ( 'hybrid' === $b2bking_setting_value ) {
						$wholesalex_setting_value = 'b2b_n_b2c';
					}
					wholesalex()->log( 'B2Bking Plugin Status settings migrated into wholesalex plugin status', 'info' );

					break;
				case 'b2bking_enable_conversations_setting':
					if ( $b2bking_setting_value ) {
						$wholesalex_setting_value = 'yes';
					} else {
						$wholesalex_setting_value = 'no';
					}
					wholesalex()->log( 'B2Bking enable conversations setting migrated into wholesalex conversation addon status', 'info' );

					break;

				case 'b2bking_enable_bulk_order_form_setting':
					if ( $b2bking_setting_value ) {
						$wholesalex_setting_value = 'yes';
					} else {
						$wholesalex_setting_value = 'no';
					}
					wholesalex()->log( 'B2Bking enable bulk order setting migrated into wholesalex bulkorder addon status', 'info' );

					break;
				case 'b2bking_enable_subaccounts_setting':
					if ( $b2bking_setting_value ) {
						$wholesalex_setting_value = 'yes';
					} else {
						$wholesalex_setting_value = 'no';
					}
					wholesalex()->log( 'B2Bking enable subaccount setting status migrated into wholesalex subaccount addon status', 'info' );

					break;
				case 'b2bking_approval_required_all_users_setting':
					if ( $b2bking_setting_value ) {
						$wholesalex_setting_value = 'admin_approve';
					} else {
						$wholesalex_setting_value = 'auto_approve';
					}

					wholesalex()->log( 'B2Bking approval required all users settings  migrated into wholesalex user status settings', 'info' );

					break;
				case 'b2bking_guest_access_restriction_setting':
					if ( 'hide_prices' == $b2bking_setting_value ) {
						$wholesalex_setting_value = 'yes';
					} else {
						$wholesalex_setting_value = 'no';
					}
					wholesalex()->log( 'B2Bking Guest access restriction (Hide prices)  migrated into wholesalex login to see prices settings', 'info' );

					break;
				case 'b2bking_registration_separate_my_account_page_setting':
					if ( 'disabled' == $b2bking_setting_value ) {

					} else {
						$wholesalex_setting_value = $b2bking_setting_value;
					}

					wholesalex()->log( 'B2Bking Separate My account page migrated into wholesalex separate my account page', 'info' );

					break;
				case 'b2bking_hide_prices_guests_text_setting':
					$wholesalex_setting_value = $b2bking_setting_value;
					wholesalex()->log( 'B2Bking hide price guest settings migrated into wholesalex login to see prices text settings', 'info' );

					break;
				case 'b2bking_wholesale_price_text_setting':
					$wholesalex_setting_value = $b2bking_setting_value;
					wholesalex()->log( 'B2Bking wholesale price text settings migrated into wholesalex wholesale price text settings', 'info' );

					break;
				case 'b2bking_disable_coupons_b2b_setting':
					if ( 'disabled' == $b2bking_setting_value ) {
						$wholesalex_setting_value = 'yes';
					}
					wholesalex()->log( 'B2Bking Disable coupon for b2b settings migrated into wholesalex disable coupon settings', 'info' );

					break;

				default:
					break;
			}

			if ( $wholesalex_setting_value ) {
				if ( is_array( $wholesalex_key ) ) {
					foreach ( $wholesalex_key as $key ) {
						wholesalex()->set_setting( $key, $wholesalex_setting_value );
					}
				} else {
					wholesalex()->set_setting( $wholesalex_key, $wholesalex_setting_value );
				}
				$count++;
			}
		}
		return $count;
	}

	public static function migrate_purchase_lists( $page = 1, $limit = 5 ) {
		$count = 0;
		$lists = get_posts(
			array(
				'post_type'   => 'b2bking_list',
				'post_status' => 'publish',
				'page' => $page,
				'numberposts' => $limit,
			)
		);

		foreach ( $lists as $listObj ) {
			$wholesalex_list = array();

			$id                   = $listObj->ID;
			$name                 = $listObj->post_title;
			$b2bking_list_details = get_post_meta( $id, 'b2bking_purchase_list_details', true );
			$b2bking_list_details = array_filter( explode( '|', $b2bking_list_details ) );
			$item_count           = count( $b2bking_list_details );
			$quantity_count       = 0;
			$items_data           = array();
			$total_price          = 0;
			foreach ( $b2bking_list_details as $item ) {

				$temp_data = array(
					'id' => uniqid(),
				);
				$item      = explode( ':', $item );

				$temp_data['id']                = uniqid();
				$temp_data['_product_quantity'] = $item[1];
				$product                        = wc_get_product( $item[0] );
				if ( $product ) {
					$quantity_count               += $item[1];
					$temp_data['_price']           = floatval( $item[1] ) * floatval( $product->get_price() );
					$total_price                  += $temp_data['_price'];
					$temp_data['_formatted_price'] = wc_price( $temp_data['price'] );
					$temp_data['_product_sku']     = $product->get_sku();
					$temp_data['_product_select']  = array(
						array(
							'value'      => $product->get_id(),
							'name'       => $product->get_title(),
							'tags'       => $product->get_tag_ids(),
							'categories' => wc_get_product_term_ids( $product->get_id(), 'product_cat' ),
							'sku'        => $product->get_sku(),
						),
					);

					$items_data[] = $temp_data;
				}
				$count++;
			}

			wholesalex()->log( 'B2Bking Purchase Lists (#' . $id . ') Migrated into WnolesaleX Purchase Lists', 'info' );


			$wholesalex_list = array(

				'id'             => $listObj->ID,
				'name'           => $name,
				'item_count'     => $item_count,
				'quantity_count' => $quantity_count,
				'total_price'    => $total_price,
				'price_html'     => wc_price( $total_price ),
				'items'          => $items_data,
			);

			$__lists = get_user_meta( $listObj->post_author, '__bulkorder_purchase_lists', true );

			if ( empty( $__lists ) || ! is_array( $__lists ) ) {
				$__lists = array();
			}

			$__lists[ $wholesalex_list['id'] ] = $wholesalex_list;

			update_user_meta( $listObj->post_author, '__bulkorder_purchase_lists', $__lists );

		}
		
	}

	public static function generate_new_message( $author_id, $time, $content ) {
		$message = '<!-- wp:wsx_reply {"id":"' . uniqid() . '","author":"' . $author_id . '", "time":"' . gmdate( 'Y-m-d h:i:s A', $time ) . '"} -->' . wp_kses(
			nl2br( $content ),
			array(
				'br'     => true,
				'strong' => true,
				'b'      => true,
				'a'      => array(
					'href'   => array(),
					'target' => array(),
				),
			)
		) . '<!-- /wp:wsx_reply -->';
		return $message;

	}

	public static function migrate_to_wholesalex_subaccount( $parent_id, $subaccount_id, $permissions ) {
		$subaccounts = get_user_meta( $parent_id, '__wholesalex_subaccount_lists', true );
		if ( ! $subaccounts ) {
			$subaccounts = array();
		}
		$subaccounts[] = $subaccount_id;

		$subaccounts = array_filter( array_unique( $subaccounts ) );
		update_user_meta( $parent_id, '__wholesalex_subaccount_lists', $subaccounts );

		wholesalex()->change_role( $subaccount_id, wholesalex()->get_user_role( $parent_id ) );

		update_user_meta( $subaccount_id, '__job_title', get_user_meta( $subaccount_id, 'b2bking_account_job_title', true ) );
		update_user_meta( $subaccount_id, '__wholesalex_status', 'active' );
		update_user_meta( $subaccount_id, '__phone', get_user_meta( $subaccount_id, 'b2bking_account_phone', true ) );
		update_user_meta( $subaccount_id, '__wholesalex_account_type', 'subaccount' );
		update_user_meta( $subaccount_id, '__wholesalex_parent_id', $parent_id );
		update_user_meta( $subaccount_id, '__wholesalex_permissions', $permissions );
	}


	public function update_b2bking_single_product() {
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

		 // Get All B2BKing Groups
		$groups = get_posts(
			array(
				'post_type'   => 'b2bking_group',
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);

		$b2bking_product_meta = array(
			'tier'       => array(
				'b2bking_product_pricetiers_group_b2c' => 'wholesalex_b2c_users_tiers',
			),
			'base_price' => array(),
			'sale_price' => array(),
			'setting'    => array(
				'b2bking_show_pricing_table' => 'wholesalex_show_tiered_pricing_table',
			),
		);

		foreach ( $groups as $group_id ) {
			$b2bking_product_meta['tier'][ 'b2bking_product_pricetiers_group_' . $group_id ]          = $this->get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_tiers';
			$b2bking_product_meta['base_price'][ 'b2bking_regular_product_price_group_' . $group_id ] = $this->get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_base_price';
			$b2bking_product_meta['sale_price'][ 'b2bking_sale_product_price_group_' . $group_id ]    = $this->get_wholesalex_role_id_by_b2bking_group_id( $group_id ) . '_sale_price';
		}

		foreach ( $product_ids as $product_id ) {

			foreach ( $b2bking_product_meta['tier'] as $b2bking_key => $wholesalex_key ) {
				$tiers         = array();
				$tiered_price  = get_post_meta( $product_id, $b2bking_key, true );
				$b2bking_tiers = explode( ';', $tiered_price );

				foreach ( $b2bking_tiers as $b2bking_tier ) {
					$temp_tier          = array(
						'id'  => uniqid(),
						'src' => 'single_product',
					);
					$b2bking_tier_array = explode( ':', $b2bking_tier );

					$temp_tier['_discount_type']   = 'fixed';
					$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
					$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

					$tiers[] = $temp_tier;
				}

				update_post_meta( $product_id, $wholesalex_key, $tiers );

			}

				// Update base price
			foreach ( $b2bking_product_meta['base_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['sale_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['setting'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}
		}

		foreach ( $product_ids as $product_id ) {
			foreach ( $b2bking_product_meta as $meta ) {

				foreach ( $meta['tier'] as $b2bking_key => $wholesalex_key ) {
					$tiers         = array();
					$tiered_price  = get_post_meta( $product_id, $b2bking_key, true );
					$b2bking_tiers = explode( ';', $tiered_price );

					foreach ( $b2bking_tiers as $b2bking_tier ) {
						$temp_tier          = array(
							'id'  => uniqid(),
							'src' => 'single_product',
						);
						$b2bking_tier_array = explode( ':', $b2bking_tier );

						$temp_tier['_discount_type']   = 'fixed';
						$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
						$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

						$tiers[] = $temp_tier;
					}

					update_post_meta( $product_id, $wholesalex_key, $tiers );

				}

				// Update base price
				foreach ( $meta['base_price'] as $b2bking_key => $wholesalex_key ) {
					$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
					update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
				}

				// Update sale price
				foreach ( $meta['sale_price'] as $b2bking_key => $wholesalex_key ) {
					$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
					update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
				}

				// Update sale price
				foreach ( $meta['setting'] as $b2bking_key => $wholesalex_key ) {
					$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
					update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
				}
			}
		}

		foreach ( $product_variation as $product_id ) {
			foreach ( $b2bking_product_meta['tier'] as $b2bking_key => $wholesalex_key ) {
				$tiers         = array();
				$tiered_price  = get_post_meta( $product_id, $b2bking_key, true );
				$b2bking_tiers = explode( ';', $tiered_price );

				foreach ( $b2bking_tiers as $b2bking_tier ) {
					$temp_tier          = array(
						'id'  => uniqid(),
						'src' => 'single_product',
					);
					$b2bking_tier_array = explode( ':', $b2bking_tier );

					$temp_tier['_discount_type']   = 'fixed';
					$temp_tier['_min_quantity']     = $b2bking_tier_array[0];
					$temp_tier['_discount_amount'] = $b2bking_tier_array[1];

					$tiers[] = $temp_tier;
				}

				update_post_meta( $product_id, $wholesalex_key, $tiers );

			}

				// Update base price
			foreach ( $b2bking_product_meta['base_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['sale_price'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
			}

				// Update sale price
			foreach ( $b2bking_product_meta['setting'] as $b2bking_key => $wholesalex_key ) {
				$b2bking_base_price = get_post_meta( $product_id, $b2bking_key, true );
				update_post_meta( $product_id, $wholesalex_key, $b2bking_base_price );
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
	/**
	 * Get wholesalex role id by b2bking group id
	 *
	 * @param int $group_id Group Id
	 * @return string wholesalex role id
	 */
	public static function get_wholesalex_role_id_by_b2bking_group_id( $group_id ) {
		return 'wholesalex_mb2bking_' . $group_id;
	}

}
