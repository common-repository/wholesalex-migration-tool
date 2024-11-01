<?php
/**
 * Notice
 *
 * @package WholesaleX_Migration
 * @since 1.0.0
 */

/**
 * WholesaleX Migration Notice
 */
class WholesaleX_Migration_Notice {


	/**
	 * Admin WooCommerce Installation Notice Action
	 *
	 * @since 1.0.0
	 */
	public function install_notice() {
        add_action( 'wp_ajax_install_wholesalex', array( $this, 'wholesalex_installation_callback' ) );
        add_action( 'admin_notices', array( $this, 'wholesalex_intro_notice' ) );

	}

    public function wholesalex_intro_notice() {
		// check wholesalex is installed or not.
		$wholesalex_installed = file_exists( WP_PLUGIN_DIR . '/wholesalex/wholesalex.php' );

		$regular_text = $wholesalex_installed?esc_html__('Activate','wholesalex-migration'):esc_html__('Install','wholesalex-migration');
		$processing_text = $wholesalex_installed?esc_html__('Activating..','wholesalex-migration'):esc_html__('Installing..','wholesalex-migration');
		$processed_text = $wholesalex_installed?esc_html__('Activated','wholesalex-migration'):esc_html__('Installed','wholesalex-migration');


		if(defined('WHOLESALEX_VER') && WHOLESALEX_VER) {
			return;
		}
		
		
			ob_start();
			?>
				<style>
					/*----- WholesaleX Into Notice ------*/
					.notice.notice-success.wholesalex-migration-wholesalex-notice {
						border-left-color: #4D4DFF;
						padding: 0;
					}

					.wholesalex-migration-notice-container {
						display: flex;
					}

					.wholesalex-migration-notice-container a{
						text-decoration: none;
					}

					.wholesalex-migration-notice-container a:visited{
						color: white;
					}

					.wholesalex-migration-notice-image {
						padding-top: 15px;
						padding-left: 12px;
						padding-right: 12px;
						background-color: #f4f4ff;
						max-width: 40px;
					}
					.wholesalex-migration-notice-image img{
						max-width: 100%;
					}

					.wholesalex-migration-notice-content {
						width: 100%;
						padding: 16px;
						display: flex;
						flex-direction: column;
						gap: 8px;
					}

					.wholesalex-migration-notice-wholesalex-button {
						max-width: fit-content;
						padding: 8px 15px;
						font-size: 16px;
						color: white;
						background-color: #4D4DFF;
						border: none;
						border-radius: 2px;
						cursor: pointer;
						margin-top: 6px;
						text-decoration: none;
					}

					.wholesalex-migration-notice-heading {
						font-size: 18px;
						font-weight: 500;
						color: #1b2023;
					}

					.wholesalex-migration-notice-content-header {
						display: flex;
						justify-content: space-between;
						align-items: center;
					}

					.wholesalex-migration-notice-close .dashicons-no-alt {
						font-size: 25px;
						height: 26px;
						width: 25px;
						cursor: pointer;
						color: #585858;
					}

					.wholesalex-migration-notice-close .dashicons-no-alt:hover {
						color: red;
					}

					.wholesalex-migration-notice-content-body {
						font-size: 14px;
						color: #343b40;
					}

					.wholesalex-migration-notice-wholesalex-button:hover {
						background-color: #6C6CFF;
						color: white;
					}

					span.wholesalex-migration-bold {
						font-weight: bold;
					}
					a.wholesalex-migration-wholesalex-pro-dismiss:focus {
						outline: none;
						box-shadow: unset;
					}
					.loading {
						width: 16px;
						height: 16px;
						border: 3px solid #FFF;
						border-bottom-color: transparent;
						border-radius: 50%;
						display: inline-block;
						box-sizing: border-box;
						animation: rotation 1s linear infinite;
						margin-left: 10px;
					}

					@keyframes rotation {
						0% {
							transform: rotate(0deg);
						}

						100% {
							transform: rotate(360deg);
						}
					}
					/*----- End WholesaleX Into Notice ------*/

				</style>
				<div class="notice notice-success wholesalex-migration-wholesalex-notice">
					<div class="wholesalex-migration-notice-container">
						<div class="wholesalex-migration-notice-image"><img src="<?php echo esc_url( WHOLESALEX_MIGRATION_URL ) . 'assets/img/wholesalex-icon.svg'; ?>"/></div>
						<div class="wholesalex-migration-notice-content">
							<div class="wholesalex-migration-notice-content-header">
								<div class="wholesalex-migration-notice-heading">
									<?php echo esc_html__( 'WholesaleX Migration Tool needs the “WholesaleX” plugin to run.', 'wholesalex-migration' ); //phpcs:ignore WordPress.Security.EscapeOutput ?>
								</div>
							</div>
							<?php if(current_user_can( 'install_plugins' )) {
								?>
								<a id="wholesalex-migration_install_wholesalex" class="wholesalex-migration-notice-wholesalex-button " ><?php echo esc_html($regular_text); ?></a>
								<?php
							} ?>
						</div>
					</div>
				</div>

				<script>
					const installWholesaleX = (element)=>{
						element.innerHTML = "<?php echo esc_html($processing_text); ?> <span class='loading'></span>";
						const wholesalex_migration_ajax = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
						const formData = new FormData();
						formData.append('action','install_wholesalex');
						formData.append('wpnonce',"<?php echo esc_attr( wp_create_nonce( 'install_wholesalex' ) ); ?>");
						fetch(wholesalex_migration_ajax, {
							method: 'POST',
							body: formData,
						})
						.then(res => res.json())
						.then(res => {
							if(res) {
								if (res.success ) {
									element.innerHTML = "<?php echo esc_html($processed_text); ?>";
								} else {
									console.log("installation failed..");
								}
							}
							location.reload();
						})
					}
					const wholesalex_migration_element = document.getElementById('wholesalex-migration_install_wholesalex');
					wholesalex_migration_element.addEventListener('click',(e)=>{
						e.preventDefault();
						installWholesaleX(wholesalex_migration_element);
					})
				</script>
			<?php
			echo ob_get_clean(); //phpcs:ignore
		
	}

    /**
	 * WholesaleX Installation Callback From Banner.
	 *
	 * @return void
	 */
	public function wholesalex_installation_callback() {
		if ( ! isset( $_POST['wpnonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['wpnonce'] ) ), 'install_wholesalex' ) ) {
			wp_send_json_error( 'Nonce Verification Failed' );
			die();
		}

		$wholesalex_installed = file_exists( WP_PLUGIN_DIR . '/wholesalex/wholesalex.php' );

		if ( ! $wholesalex_installed ) {
			$status = $this->plugin_install( 'wholesalex' );
			if ( $status && ! is_wp_error( $status ) ) {
				$activate_status = activate_plugin( 'wholesalex/wholesalex.php', '', false, true );
				if ( is_wp_error( $activate_status ) ) {
					wp_send_json_error( array( 'message' => __( 'WholesaleX Activation Failed!', 'wholesalex-migration' ) ) );
				}
			} else {
				wp_send_json_error( array( 'message' => __( 'WholesaleX Installation Failed!', 'wholesalex-migration' ) ) );
			}
		} else {
			$is_wc_active = is_plugin_active( 'wholesalex/wholesalex.php' );
			if ( ! $is_wc_active ) {
				$activate_status = activate_plugin( 'wholesalex/wholesalex.php', '', false, true );
				if ( is_wp_error( $activate_status ) ) {
					wp_send_json_error( array( 'message' => __( 'WholesaleX Activation Failed!', 'wholesalex-migration' ) ) );
				}
			}
		}

		wp_send_json_success( __( 'Successfully Installed and Activated', 'wholesalex-migration' ) );

	}

	/**
	 * Plugin Install
	 *
	 * @param string $plugin Plugin Slug.
	 * @return boolean
	 * @since 2.6.1
	 */
	public function plugin_install( $plugin ) {

		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'sections' => false,
				),
			)
		);

		if ( is_wp_error( $api ) ) {
			return $api->get_error_message();
		}

		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );
		$result   = $upgrader->install( $api->download_link );

		return $result;
	}

}
