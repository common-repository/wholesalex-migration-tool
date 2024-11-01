<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WC_Background_Process', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/abstracts/class-wc-background-process.php';
}

/**
 * Background Migration to WholesaleX
 * @since 1.0.0
 */
class WholesaleX_Background_Migration extends WC_Background_Process {

    public function __construct()
    {
        $this->prefix ='wholesalex_'.get_current_blog_id(  );
        $this->action = 'wholesalex_migration';

        parent::__construct();
    }

    /**
	 * Handle cron healthcheck
	 *
	 * Restart the background process if not already running
	 * and data exists in the queue.
	 */
	public function handle_cron_healthcheck() {
		if ( $this->is_process_running() ) {
			// Background process already running.
			return;
		}

		if ( $this->is_queue_empty() ) {
			// No data to process.
			$this->clear_scheduled_event();
			return;
		}

		$this->handle();
	}


    /**
	 * Schedule fallback event.
	 */
	protected function schedule_event() {
		if ( ! wp_next_scheduled( $this->cron_hook_identifier ) ) {
			wp_schedule_event( time() + 10, $this->cron_interval_identifier, $this->cron_hook_identifier );
		}
	}

	/**
	 * Finishes replying to the client, but keeps the process running for further (async) code execution.
	 *
	 * @see https://core.trac.wordpress.org/ticket/41358 .
	 */
	protected function close_http_connection() {
		// Only 1 PHP process can access a session object at a time, close this so the next request isn't kept waiting.
		// @codingStandardsIgnoreStart
		if ( session_id() ) {
			session_write_close();
		}
		// @codingStandardsIgnoreEnd

		wc_set_time_limit( 0 );

		// fastcgi_finish_request is the cleanest way to send the response and keep the script running, but not every server has it.
		if ( is_callable( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		} else {
			// Fallback: send headers and flush buffers.
			if ( ! headers_sent() ) {
				header( 'Connection: close' );
			}
			@ob_end_flush(); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged
			flush();
		}
	}

	/**
	 * Save and run queue.
	 */
	public function dispatch_queue() {
		$this->save()->dispatch();
	}

    /**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param string $callback Update callback function.
	 * @return string|bool
	 */
	protected function task( $item ) {
		set_transient('wholesalex_migrating',true);

		if (  ! $item || !isset($item['task']) || empty( $item['task'] ) ) {
			return false;
		}


		$process = 0;

		switch ($item['task']) {
			case 'migrate_group_to_roles':
				$process = WholesaleX_B2BKing_Migration::migrate_group_to_roles($item['page'],$item['limit']);
				break;
			case 'migrate_registration_form_fields':
				$process = WholesaleX_B2BKing_Migration::migrate_registration_form_fields($item['page'],$item['limit']);
				break;
			case 'migrate_dynamic_rules':
				$process = WholesaleX_B2BKing_Migration::migrate_dynamic_rules($item['page'],$item['limit']);
				break;
			case 'migrate_products_meta':
				$process = WholesaleX_B2BKing_Migration::migrate_products_meta($item['page'],$item['limit']);
				break;
			case 'migrate_variation_meta':
				$process = WholesaleX_B2BKing_Migration::migrate_product_variations_meta($item['page'],$item['limit']);
				break;
			case 'migrate_users_meta':
				$process = WholesaleX_B2BKing_Migration::migrate_users_meta($item['page'],$item['limit']);
				break;
			case 'migrate_conversations':
				$process = WholesaleX_B2BKing_Migration::migrate_conversations($item['page'],$item['limit']);
				break;
			case 'migrate_settings':
				$process = WholesaleX_B2BKing_Migration::migrate_settings($item['page'],$item['limit']);
				break;
			case 'migrate_purchase_lists':
				$process = WholesaleX_B2BKing_Migration::migrate_purchase_lists($item['page'],$item['limit']);
				break;
			default:
				# code...
				break;
		}

		$migration_data = get_transient('wholesalex_migration_stats');
		if(!($migration_data && is_array($migration_data))) {
			$migration_data= array();
		}
		
		if(isset($migration_data[$item['task']])) {
			$migration_data[$item['task']] = $migration_data[$item['task']]+ $item['completed_percentage'];
		} else {
			$migration_data[$item['task']] = $item['completed_percentage'];
		}

		set_transient('wholesalex_migration_stats',$migration_data);

		return false;
	}

    /**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
        wholesalex()->log('Migration Finished','info');
		delete_transient('wholesalex_migrating');
		wholesalex()->set_setting('migration_complete',true);
		parent::complete();
	}
}