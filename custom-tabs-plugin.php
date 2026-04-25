<?php
/**
 * Plugin Name: Custom Tabs Plugin
 * Plugin URI:  https://example.com
 * Description: A custom tabs WordPress plugin.
 * Version:     1.0.0
 * Author:      Yuval Tsabar
 * Author URI:  https://yuvaltsabar.com/
 * Text Domain: custom-tabs-plugin
 * Domain Path: /languages
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

define( 'CUSTOM_TABS_PLUGIN_VERSION', '1.0.0' );
define( 'CUSTOM_TABS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CUSTOM_TABS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CUSTOM_TABS_PLUGIN_DIR . 'inc/setup.php';
