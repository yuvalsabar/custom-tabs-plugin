<?php
/**
 * Plugin admin helpers.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'ct_register_acf_settings_page' );
add_action( 'acf/init', 'ct_register_acf_fields' );
add_action( 'admin_menu', 'ct_register_fallback_settings_page' );
add_action( 'wp_enqueue_scripts', 'ct_enqueue_styles' );

/**
 * Enqueue the plugin stylesheet on the frontend.
 */
function ct_enqueue_styles() {
	wp_enqueue_style(
		'custom-tabs-plugin-style',
		CUSTOM_TABS_PLUGIN_URL . 'assets/css/custom-tabs-plugin.css',
		array(),
		defined( 'CUSTOM_TABS_PLUGIN_VERSION' ) ? CUSTOM_TABS_PLUGIN_VERSION : false
	);
}

/**
 * Register the ACF options page for custom tabs plugin settings.
 */
function ct_register_acf_settings_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title'  => __( 'Custom Tabs Plugin Settings', 'custom-tabs-plugin' ),
			'menu_title'  => __( 'Custom Tabs Plugin', 'custom-tabs-plugin' ),
			'menu_slug'   => 'custom-tabs-plugin-settings',
			'capability'  => 'manage_options',
			'parent_slug' => 'options-general.php',
			'position'    => 80,
			'redirect'    => false,
		)
	);
}

/**
 * Register the plugin settings fields using ACF.
 */
function ct_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_ct_settings',
			'title'                 => __( 'Custom Tabs Plugin Settings', 'custom-tabs-plugin' ),
			'fields'                => array(
				array(
					'key'           => 'field_ct_enable_feature',
					'label'         => __( 'Enable Custom Tabs Plugin Feature', 'custom-tabs-plugin' ),
					'name'          => 'ct_enable_feature',
					'type'          => 'true_false',
					'instructions'  => __( 'Toggle the custom tabs plugin feature on or off.', 'custom-tabs-plugin' ),
					'required'      => 0,
					'ui'            => 1,
					'ui_on_text'    => __( 'Enabled', 'custom-tabs-plugin' ),
					'ui_off_text'   => __( 'Disabled', 'custom-tabs-plugin' ),
					'default_value' => 0,
				),
				array(
					'key'           => 'field_ct_api_key',
					'label'         => __( 'Plugin API Key', 'custom-tabs-plugin' ),
					'name'          => 'ct_api_key',
					'type'          => 'text',
					'instructions'  => __( 'Enter an API key or secret token used by the custom tabs plugin.', 'custom-tabs-plugin' ),
					'required'      => 0,
					'default_value' => '',
				),
				array(
					'key'           => 'field_ct_custom_message',
					'label'         => __( 'Custom Message', 'custom-tabs-plugin' ),
					'name'          => 'ct_custom_message',
					'type'          => 'textarea',
					'instructions'  => __( 'Add a custom message or description for the custom tabs plugin settings.', 'custom-tabs-plugin' ),
					'required'      => 0,
					'default_value' => '',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'custom-tabs-plugin-settings',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
		)
	);
}

/**
 * Register a fallback settings page when ACF is not available.
 */
function ct_register_fallback_settings_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	add_options_page(
		__( 'Custom Tabs Plugin Settings', 'custom-tabs-plugin' ),
		__( 'Custom Tabs Plugin', 'custom-tabs-plugin' ),
		'manage_options',
		'custom-tabs-plugin-settings',
		'ct_fallback_settings_page_html'
	);
}

/**
 * Output fallback settings page content when ACF is unavailable.
 */
function ct_fallback_settings_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Custom Tabs Plugin Settings', 'custom-tabs-plugin' ); ?></h1>
		<p><?php esc_html_e( 'The embedded ACF library could not be loaded. Please verify ACF is included and activated within the plugin.', 'custom-tabs-plugin' ); ?></p>
	</div>
	<?php
}
