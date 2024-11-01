<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WholesaleXMigrationTool {

	/**
	 * Instance of this class
	 *
	 * @since 1.0.0
	 */
	protected static $_instance = null;
	protected $classes          = array();

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

	function __construct() {
		$this->init_migrations();

		add_filter( 'wholesalex_migration_fields', array( $this, 'wholesalex_migration_fields' ) );

		/**
		 * Fires as an admin screen or script is being initialized.
		 *
		 */
		add_action('admin_init',function() : void {
			if(isset($_GET['reset_migration']) && $_GET['reset_migration']=='reset' ) {
				wholesalex()->set_setting('wholesale_suite_migration_complete',false);
				wholesalex()->set_setting('b2bking_migration_complete',false);
				delete_transient('wholesalex_b2bking_migration_stats');
				delete_transient('wholesalex_wholesale_suite_migration_stats');
				die();
			}
		} );

	}

	/**
	 * Save Wholesalex Tools Actions
	 *
	 * @since 1.2.9
	 */
	public function migration_tool_restapi_init() {
		register_rest_route(
			'wholesalex/v1',
			'/migration/',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'migration_restapi_action' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
					'args'                => array(),
				),
			)
		);
	}


	/**
	 * Save Wholesalex Tools
	 *
	 * @param object $server Server.
	 * @since 1.2.9
	 */
	public function migration_restapi_action( $server ) {
		$post = $server->get_params();
		if ( ! ( isset( $post['nonce'] ) && wp_verify_nonce( $post['nonce'], 'wholesalex-migration' ) ) ) {
			return;
		}

		do_action( 'wholesalex_migration_tools_restapi_action', $post );

	}

	/**
	 * Tools Sub Menu Page Callback
	 *
	 * @since 1.2.9
	 * @access public
	 */
	public static function migration_tools_content() {
		wp_enqueue_script( 'whx_migration_tools' );
		wp_enqueue_script( 'whx_migration_tools', WHOLESALEX_MIGRATION_URL . 'assets/js/whx_migration_tools.js', array( 'react', 'react-dom', 'wp-polyfill', 'wp-api-fetch', 'wholesalex_components', 'wholesalex_node_vendors' ), WHOLESALEX_MIGRATION_VER, true );
		wp_localize_script(
			'whx_migration_tools',
			'wholesalex_migration',
			array(
				'nonce'                           => wp_create_nonce( 'wholesalex-migration' ),
				'fields'                          => self::get_tool_fields(),
				'allow_wholesale_suite_migration' => ! wholesalex()->get_setting( 'wholesale_suite_migration_complete', false ),
				'allow_b2bking_migration'         => ! wholesalex()->get_setting( 'b2bking_migration_complete', false ),
				'migration_status'                => array(
					'b2bking_migration'         => get_transient( 'wholesalex_b2bking_migrating' ) ? 'running' : ( wholesalex()->get_setting( 'b2bking_migration_complete' )?'complete':false),
					'wholesale_suite_migration' => get_transient( 'wholesalex_wholesalex_suite_migrating' ) ? 'running' :  ( wholesalex()->get_setting( 'wholesale_suite_migration_complete' )?'complete':false)
				),
				'stats' => array(
					'b2bking_migration' => get_transient('wholesalex_b2bking_migration_stats'),
					'wholesale_suite_migration' => get_transient('wholesalex_wholesale_suite_migration_stats'),
				)
			)
		);
		?>
			<div id="wholesalex_migration_tools_root"></div> 
		<?php
	}

	/**
	 * Settings Field Return
	 */
	public static function get_tool_fields() {

		return apply_filters(
			'wholesalex_migration_fields',
			self::wholesalex_migration_fields(),
		);
	}

	public static function wholesalex_migration_fields() {
		$b2bking_migration_fields = array();
		if ( function_exists( 'b2bkingcore_run' ) ) {
			$b2bking_migration_fields = array(
				'b2bking_migration' => array(
					'label' => __( 'B2BKing Migration', 'wholesalex' ),
					'attr'  => array(
						'migrate_group_to_roles'          => array(
							'label' => 'Groups',
							'desc'  => 'B2Bking Groups to WholesaleX Roles',
						),
						'migrate_dynamic_rules'           => array(
							'label' => 'Dynamic Rules',
							'desc'  => 'B2Bking Dynamic Rules to WholesaleX Dynamic Rules',
						),
						'migrate_products_meta'           => array(
							'label' => 'Single Product Discounts',
							'desc'  => 'B2Bking Single Product Discounts to WholesaleX Single Product Discounts',
						),
						'migrate_product_variations_meta' => array(
							'label' => 'Single Variation Discounts',
							'desc'  => 'B2Bking Single Product Variation Discounts to WholesaleX Single Product Discounts',
						),
						'migrate_users_meta'              => array(
							'label' => 'Users',
							'desc'  => 'B2Bking Users to WholesaleX Users',
						),
						'migrate_purchase_lists'          => array(
							'label' => 'Purchase Lists',
							'desc'  => 'B2Bking Purchase Lists to WholesaleX Purchase Lists',
						),
						'migrate_conversations'           => array(
							'label' => 'Conversations',
							'desc'  => 'B2Bking Conversations to WholesaleX Conversations',
						),
						'migrate_settings'                => array(
							'label' => 'Settings',
							'desc'  => 'B2Bking Settings to WholesaleX Settings',
						),
					),
				),
			);
		}
		$wholesale_suite_migration_fields = array();

		if ( isset( $GLOBALS['wc_wholesale_prices'] ) && ! empty( $GLOBALS['wc_wholesale_prices'] ) ) {

			$wholesale_suite_migration_fields = array(
				'wholesale_suite_migration' => array(
					'label' => __( 'Wholesale Suite Migration', 'wholesalex' ),
					'attr'  => array(
						'migrate_to_wholesalex_roles'           => array(
							'label' => 'Roles',
							'desc'  => 'Wholesale Suite Roles to WholesaleX Roles',
						),
						'migrate_products_meta'  => array(
							'label' => 'Single Product Discounts',
							'desc'  => 'Wholesale Suite Single Product Discounts to WholesaleX Single Product Discounts',
						),
						'migrate_product_variations_meta'  => array(
							'label' => 'Product Variation Discounts',
							'desc'  => 'Wholesale Suite Product Variation Discounts to WholesaleX Product Variations Discounts',
						),
						'migrate_category_data'         => array(
							'label' => 'Category',
							'desc'  => 'Wholesale Suite Category Discounts to WholesaleX Category Discounts',
						),
						'migrate_registration_fields' => array(
							'label' => 'Registration Fields',
							'desc'  => 'Wholesale Suite Custom Fields to WholesaleX Form Fields',
						),
						'migrate_general_discount' => array(
							'label' => 'General Discounts',
							'desc'  => 'Wholesale Suite General Discounts to WholesaleX Dynamic Rules',
						),
						'migrate_shipping_rule'   => array(
							'label' => 'Shipping Rules',
							'desc'  => 'Wholesale Suite Shipping Rule to WholesaleX Dynamic Rules',
						),
						'migrate_payment_rule' => array(
							'label' => 'Payment Rules',
							'desc'  => 'Wholesale Suite Payment Rule to WholesaleX Dynamic Rules',
						),
						'migrate_tax_rule'        => array(
							'label' => 'Tax Rules',
							'desc'  => 'Wholesale Suite Tax Rule to WholesaleX Dynamic Rules',
						),
						'migrate_users_meta'      => array(
							'label' => 'Users',
							'desc'  => 'Wholesale Suite Users to WholesaleX Users',
						),
					),
				),
			);
		}

		return $b2bking_migration_fields + $wholesale_suite_migration_fields;
	}

	public function init_migrations() {
		$status = false;
		if ( function_exists( 'b2bkingcore_run' ) ) {
			// B2BKing Installed and Activated
			require_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-b2bking-background-migration.php';

			// Require B2BKing Migration
			require_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-b2bking-migration.php';
			WholesaleX_B2BKing_Migration::run();
			$status = true;
		}

		if ( isset( $GLOBALS['wc_wholesale_prices'] ) && ! empty( $GLOBALS['wc_wholesale_prices'] ) ) {
			// Require Wholesale Suite Migration
			require_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-wholesale-suite-background-migration.php';

			require_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-wholesale-suite-migration.php';
			WholesaleX_Wholesale_Suite_Migration::run();
			$status = true;
		}

		if ( $status ) {
			//add_action( 'admin_menu', array( $this, 'migration_tool_submenu_page_callback' ) );
			add_action( 'rest_api_init', array( $this, 'migration_tool_restapi_init' ) );

		}
	}
}
