<?php
/**
 * WholesaleX Migration Tool
 *
 * @link    https://www.wpxpo.com/
 * @since   1.0.0
 * @package WholesaleX Migration Tool
 *
 * Plugin Name:       WholesaleX Migration Tool
 * Plugin URI:        https://wordpress.org/plugins/wholesalex-migration-tool
 * Description:       This is a migration tool for wholesalex.
 * Version:           1.0.1
 * Author:            wpxpo
 * Author URI:        https://wpxpo.com/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wholesalex-migration-tool
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Plugin Defined.
define( 'WHOLESALEX_MIGRATION_VER', '1.0.1' );
define( 'WHOLESALEX_MIGRATION_URL', plugin_dir_url( __FILE__ ) );
define( 'WHOLESALEX_MIGRATION_BASE', plugin_basename( __FILE__ ) );
define( 'WHOLESALEX_MIGRATION_PATH', plugin_dir_path( __FILE__ ) );


/**
 * Load Language
 */
function wholesalex_migration_language_load() {
	load_plugin_textdomain( 'wholesalex-migration', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'wholesalex_migration_language_load' );


/**
 * Begins Execution of the Plugin.
 */
function wholesalex_migration_run() {

	if(in_array( 'wholesalex/wholesalex.php', get_option( 'active_plugins', array() ), true )) {
		require_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-migration-tool.php';
		
		WholesaleXMigrationTool::run();
	} else {
		include_once WHOLESALEX_MIGRATION_PATH . 'includes/class-wholesalex-migration-notice.php';
		
		$notice = new WholesaleX_Migration_Notice();
		$notice->install_notice();
	}
	
}
// wholesalex_migration_run();

add_action('plugins_loaded','wholesalex_migration_run');
