<?php
/**
 * Tabs custom post type.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'ct_register_tabs_cpt' );
add_filter( 'manage_ct_tabs_posts_columns', 'ct_tabs_admin_columns' );
add_action( 'manage_ct_tabs_posts_custom_column', 'ct_tabs_admin_column_content', 10, 2 );

function ct_register_tabs_cpt() {
	register_post_type(
		'ct_tabs',
		array(
			'labels'          => array(
				'name'               => __( 'Tabs Components', 'custom-tabs-plugin' ),
				'singular_name'      => __( 'Tabs Component', 'custom-tabs-plugin' ),
				'add_new_item'       => __( 'Add New Tabs Component', 'custom-tabs-plugin' ),
				'edit_item'          => __( 'Edit Tabs Component', 'custom-tabs-plugin' ),
				'new_item'           => __( 'New Tabs Component', 'custom-tabs-plugin' ),
				'search_items'       => __( 'Search Tabs Components', 'custom-tabs-plugin' ),
				'not_found'          => __( 'No tabs components found', 'custom-tabs-plugin' ),
				'not_found_in_trash' => __( 'No tabs components found in Trash', 'custom-tabs-plugin' ),
				'menu_name'          => __( 'Tabs', 'custom-tabs-plugin' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_position'   => 25,
			'menu_icon'       => 'dashicons-table-row-before',
			'supports'        => array( 'title' ),
			'has_archive'     => false,
			'rewrite'         => false,
			'capability_type' => 'post',
			'show_in_rest'    => false,
		)
	);
}

function ct_tabs_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['shortcode'] = __( 'Shortcode', 'custom-tabs-plugin' );
		}
	}
	return $new;
}

function ct_tabs_admin_column_content( $column, $post_id ) {
	if ( 'shortcode' !== $column ) {
		return;
	}
	printf(
		'<code>[custom_tabs id="%d"]</code>',
		absint( $post_id )
	);
}
