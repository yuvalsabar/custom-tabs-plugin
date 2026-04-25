<?php
/**
 * Plugin admin helpers.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'ct_enqueue_assets' );

/**
 * Enqueue plugin stylesheet, Typekit fonts, and tab widget JS on the frontend.
 */
function ct_enqueue_assets() {
	$ver = defined( 'CUSTOM_TABS_PLUGIN_VERSION' ) ? CUSTOM_TABS_PLUGIN_VERSION : false;

	wp_enqueue_style(
		'custom-tabs-typekit',
		'https://use.typekit.net/wuz0gtr.css',
		array(),
		null
	);

	wp_enqueue_style(
		'custom-tabs-plugin-style',
		CUSTOM_TABS_PLUGIN_URL . 'assets/css/custom-tabs-plugin.css',
		array( 'custom-tabs-typekit' ),
		$ver
	);

	wp_enqueue_script(
		'custom-tabs-plugin-script',
		CUSTOM_TABS_PLUGIN_URL . 'assets/js/custom-tabs.js',
		array(),
		$ver,
		true
	);
}
