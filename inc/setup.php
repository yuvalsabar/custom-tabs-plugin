<?php
/**
 * Plugin initialisation.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action( 'plugins_loaded', 'ct_init' );
/**
 * Loads the plugin text domain and initializes ACF.
 */
function ct_init() {
	load_plugin_textdomain( 'custom-tabs-plugin', false, dirname( plugin_basename( CUSTOM_TABS_PLUGIN_DIR ) ) . '/languages' );
	ct_include_acf();
	require_once CUSTOM_TABS_PLUGIN_DIR . 'inc/admin.php';
}

/**
 * Include the embedded ACF library if it is not already loaded.
 */
function ct_include_acf() {
	if ( class_exists( 'ACF' ) ) {
		return;
	}

	if ( ! defined( 'ACF_LITE' ) ) {
		define( 'ACF_LITE', true );
	}

	require_once CUSTOM_TABS_PLUGIN_DIR . 'inc/acf/acf.php';
}
