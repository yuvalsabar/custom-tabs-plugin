<?php
/**
 * ACF field group for tabs components.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'ct_register_tabs_fields' );

function ct_register_tabs_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_ct_tabs_cpt',
			'title'                 => __( 'Tabs Component', 'custom-tabs-plugin' ),
			'fields'                => array(
				array(
					'key'          => 'field_ct_tabs_repeater',
					'label'        => __( 'Tabs', 'custom-tabs-plugin' ),
					'name'         => 'tabs',
					'type'         => 'repeater',
					'instructions' => __( 'Add one item per tab.', 'custom-tabs-plugin' ),
					'required'     => 0,
					'min'          => 0,
					'max'          => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add Tab', 'custom-tabs-plugin' ),
					'sub_fields'   => array(

						// ── Tab title ────────────────────────────────────────
						array(
							'key'      => 'field_ct_tab_title',
							'label'    => __( 'Tab Title', 'custom-tabs-plugin' ),
							'name'     => 'tab_title',
							'type'     => 'text',
							'required' => 1,
						),

						// ── Testimonial group ─────────────────────────────────
						array(
							'key'       => 'field_ct_sep_testimonial',
							'label'     => __( 'Testimonial', 'custom-tabs-plugin' ),
							'name'      => '',
							'type'      => 'tab',
							'placement' => 'left',
						),
						array(
							'key'           => 'field_ct_testimonial_bg_image',
							'label'         => __( 'Background Image', 'custom-tabs-plugin' ),
							'name'          => 'testimonial_bg_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
						array(
							'key'          => 'field_ct_testimonial_text',
							'label'        => __( 'Testimonial', 'custom-tabs-plugin' ),
							'name'         => 'testimonial_text',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
						),
						array(
							'key'           => 'field_ct_testimonial_cite_image',
							'label'         => __( 'Cite Image', 'custom-tabs-plugin' ),
							'name'          => 'testimonial_cite_image',
							'type'          => 'image',
							'instructions'  => __( 'Photo of the person who gave the testimonial.', 'custom-tabs-plugin' ),
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
							'library'       => 'all',
						),
						array(
							'key'   => 'field_ct_testimonial_cite_name',
							'label' => __( 'Cite Name', 'custom-tabs-plugin' ),
							'name'  => 'testimonial_cite_name',
							'type'  => 'text',
						),
						array(
							'key'         => 'field_ct_testimonial_cite_position',
							'label'       => __( 'Cite Position', 'custom-tabs-plugin' ),
							'name'        => 'testimonial_cite_position',
							'type'        => 'text',
							'placeholder' => __( 'e.g. Head of Marketing', 'custom-tabs-plugin' ),
						),
						array(
							'key'           => 'field_ct_testimonial_company_image',
							'label'         => __( 'Company Image', 'custom-tabs-plugin' ),
							'name'          => 'testimonial_company_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
							'library'       => 'all',
						),

						// ── Stats group ───────────────────────────────────────
						array(
							'key'       => 'field_ct_sep_stats',
							'label'     => __( 'Stats', 'custom-tabs-plugin' ),
							'name'      => '',
							'type'      => 'tab',
							'placement' => 'left',
						),
						array(
							'key'         => 'field_ct_stats_number',
							'label'       => __( 'Number', 'custom-tabs-plugin' ),
							'name'        => 'stats_number',
							'type'        => 'text',
							'placeholder' => __( 'e.g. 1.5%', 'custom-tabs-plugin' ),
						),
						array(
							'key'   => 'field_ct_stats_text',
							'label' => __( 'Text', 'custom-tabs-plugin' ),
							'name'  => 'stats_text',
							'type'  => 'text',
						),

						// ── CTA group ─────────────────────────────────────────
						array(
							'key'       => 'field_ct_sep_cta',
							'label'     => __( 'CTA', 'custom-tabs-plugin' ),
							'name'      => '',
							'type'      => 'tab',
							'placement' => 'left',
						),
						array(
							'key'           => 'field_ct_cta_link',
							'label'         => __( 'Link', 'custom-tabs-plugin' ),
							'name'          => 'cta_link',
							'type'          => 'link',
							'return_format' => 'array',
						),

						// ── Company logos group ───────────────────────────────
						array(
							'key'       => 'field_ct_sep_logos',
							'label'     => __( 'Company Logos', 'custom-tabs-plugin' ),
							'name'      => '',
							'type'      => 'tab',
							'placement' => 'left',
						),
						array(
							'key'         => 'field_ct_trusted_by_label',
							'label'       => __( 'Trusted By Label', 'custom-tabs-plugin' ),
							'name'        => 'trusted_by_label',
							'type'        => 'text',
							'placeholder' => __( 'e.g. TRUSTED BY', 'custom-tabs-plugin' ),
						),
						array(
							'key'           => 'field_ct_company_logos',
							'label'         => __( 'Company Logos', 'custom-tabs-plugin' ),
							'name'          => 'company_logos',
							'type'          => 'gallery',
							'instructions'  => __( 'Upload or select company logo images.', 'custom-tabs-plugin' ),
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
							'min'           => 0,
							'max'           => 0,
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ct_tabs',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
		)
	);
}
