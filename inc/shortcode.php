<?php
/**
 * [custom_tabs id="X"] shortcode.
 *
 * @package Custom_Tabs_Plugin
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'custom_tabs', 'ct_render_tabs_shortcode' );
add_shortcode( 'ct_hello', 'ct_hello_world' );

function ct_hello_world() {
	return '<p>Hello World from ct_hello</p>';
}

function ct_render_tabs_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'id' => 0 ), $atts, 'custom_tabs' );

	$post_id = absint( $atts['id'] );
	if ( ! $post_id ) {
		return ct_tabs_admin_notice( 'No id attribute provided.' );
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		return ct_tabs_admin_notice( "No post found with ID {$post_id}." );
	}
	if ( 'ct_tabs' !== $post->post_type ) {
		return ct_tabs_admin_notice( "Post {$post_id} is type &ldquo;{$post->post_type}&rdquo;, expected &ldquo;ct_tabs&rdquo;." );
	}
	if ( 'publish' !== $post->post_status ) {
		return ct_tabs_admin_notice( "Post {$post_id} has status &ldquo;{$post->post_status}&rdquo; — publish it first." );
	}

	$tabs = get_field( 'tabs', $post_id );
	if ( empty( $tabs ) || ! is_array( $tabs ) ) {
		return ct_tabs_admin_notice( "Post {$post_id} exists but has no tabs saved yet." );
	}

	ob_start();
	ct_render_tabs_component( $post_id, $tabs );
	return ob_get_clean();
}

function ct_tabs_admin_notice( $message ) {
	return '<p style="border:2px solid #d63638;padding:10px 14px;color:#d63638;font-family:monospace">'
		. '<strong>[custom_tabs]</strong> ' . $message
		. '</p>';
}

// ─── Component ────────────────────────────────────────────────────────────────

function ct_render_tabs_component( $post_id, $tabs ) {
	$component_id = 'ct-tabs-' . absint( $post_id );
	?>
	<div class="ct-tabs" id="<?php echo esc_attr( $component_id ); ?>">
	<div class="ct-tabs__panel-layout">

		<div class="ct-tabs__nav" role="tablist" aria-label="<?php esc_attr_e( 'Content tabs', 'custom-tabs-plugin' ); ?>">
			<?php foreach ( $tabs as $index => $tab ) : ?>
				<?php
				$tab_id   = $component_id . '-tab-' . $index;
				$panel_id = $component_id . '-panel-' . $index;
				$active   = 0 === $index;
				?>
				<button
					class="ct-tabs__tab<?php echo $active ? ' ct-tabs__tab--active' : ''; ?>"
					role="tab"
					id="<?php echo esc_attr( $tab_id ); ?>"
					aria-controls="<?php echo esc_attr( $panel_id ); ?>"
					aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
					tabindex="<?php echo $active ? '0' : '-1'; ?>"
				>
					<?php echo esc_html( $tab['tab_title'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="ct-tabs__panels">
			<?php foreach ( $tabs as $index => $tab ) : ?>
				<?php
				$tab_id   = $component_id . '-tab-' . $index;
				$panel_id = $component_id . '-panel-' . $index;
				$active   = 0 === $index;
				?>
				<div
					class="ct-tabs__panel<?php echo $active ? ' ct-tabs__panel--active' : ''; ?>"
					role="tabpanel"
					id="<?php echo esc_attr( $panel_id ); ?>"
					aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
					tabindex="0"
					<?php echo $active ? '' : 'hidden'; ?>
				>
					<?php ct_render_tab_panel( $tab ); ?>
				</div>
			<?php endforeach; ?>
		</div>

	</div><!-- /.ct-tabs__panel-layout -->
	</div>
	<?php
}

// ─── Panel sections ───────────────────────────────────────────────────────────

function ct_render_tab_panel( $tab ) {
	$bg_image_id      = ! empty( $tab['testimonial_bg_image'] ) ? absint( $tab['testimonial_bg_image'] ) : 0;
	$cite_image_id    = ! empty( $tab['testimonial_cite_image'] ) ? absint( $tab['testimonial_cite_image'] ) : 0;
	$company_image_id = ! empty( $tab['testimonial_company_image'] ) ? absint( $tab['testimonial_company_image'] ) : 0;
	$cta_link         = ! empty( $tab['cta_link'] ) && is_array( $tab['cta_link'] ) ? $tab['cta_link'] : null;
	$company_logos    = ! empty( $tab['company_logos'] ) && is_array( $tab['company_logos'] ) ? $tab['company_logos'] : array();
	$trusted_by       = ! empty( $tab['trusted_by_label'] ) ? $tab['trusted_by_label'] : '';

	$bg_url = $bg_image_id ? wp_get_attachment_image_url( $bg_image_id, 'full' ) : '';

	$has_testimonial = $bg_url || ! empty( $tab['testimonial_text'] ) || $cite_image_id || ! empty( $tab['testimonial_cite_name'] );
	$has_stats       = ! empty( $tab['stats_number'] ) || ! empty( $tab['stats_text'] );
	$has_cta         = $cta_link && ! empty( $cta_link['url'] );
	$has_logos       = ! empty( $company_logos );
	$has_right_col   = $has_stats || $has_cta;
	?>
	<?php if ( $has_testimonial || $has_right_col ) : ?>
		<div class="ct-tabs__panel-body">

			<?php if ( $has_testimonial ) : // Left column: testimonial ?>
			<div class="ct-tabs__col ct-tabs__col--left">
				<?php
				$bg_style = $bg_url ? ' style="background-image:url(\'' . esc_url( $bg_url ) . '\')"' : '';
				?>
				<div class="ct-tabs__testimonial"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

					<div class="ct-tabs__testimonial-inner">

						<?php if ( ! empty( $tab['testimonial_text'] ) ) : ?>
							<blockquote class="ct-tabs__quote">
								<svg class="ct-tabs__quote-icon" xmlns="http://www.w3.org/2000/svg" width="34" height="28" viewBox="0 0 34 28" fill="none" aria-hidden="true" focusable="false">
									<path d="M0 18C0 23.88 3.48 27.12 7.44 27.12C11.04 27.12 13.8 24.24 13.8 20.76C13.8 17.16 11.4 14.64 8.04 14.64C7.44 14.64 6.6 14.76 6.48 14.76C6.84 10.92 10.32 6.12 14.16 3.6L9.72 0C4.2 3.96 0 10.68 0 18ZM19.2 18C19.2 23.88 22.68 27.12 26.64 27.12C30.24 27.12 33.12 24.24 33.12 20.76C33.12 17.16 30.6 14.64 27.24 14.64C26.64 14.64 25.8 14.76 25.68 14.76C26.16 10.92 29.52 6.12 33.36 3.6L28.92 0C23.4 3.96 19.2 10.68 19.2 18Z" fill="currentColor"/>
								</svg>
								<div class="ct-tabs__quote-body">
									<?php echo wp_kses_post( $tab['testimonial_text'] ); ?>
								</div>
							</blockquote>
						<?php endif; ?>

						<?php if ( $cite_image_id || ! empty( $tab['testimonial_cite_name'] ) || $company_image_id ) : ?>
							<cite class="ct-tabs__cite">

								<div class="ct-tabs__cite-row">
									<?php if ( $cite_image_id ) : ?>
										<span class="ct-tabs__cite-avatar">
											<?php
											echo wp_get_attachment_image(
												$cite_image_id,
												'thumbnail',
												false,
												array(
													'class' => 'ct-tabs__cite-photo',
													'alt' => esc_attr( $tab['testimonial_cite_name'] ?? '' ),
												)
											);
											?>
										</span>
									<?php endif; ?>

									<?php if ( ! empty( $tab['testimonial_cite_name'] ) || ! empty( $tab['testimonial_cite_position'] ) ) : ?>
										<span class="ct-tabs__cite-meta">
											<?php if ( ! empty( $tab['testimonial_cite_name'] ) ) : ?>
												<span class="ct-tabs__cite-name"><?php echo esc_html( $tab['testimonial_cite_name'] ); ?></span>
											<?php endif; ?>

											<?php if ( ! empty( $tab['testimonial_cite_position'] ) ) : ?>
												<span class="ct-tabs__cite-position"><?php echo esc_html( $tab['testimonial_cite_position'] ); ?></span>
											<?php endif; ?>
										</span>
									<?php endif; ?>
								</div>

								<?php if ( $company_image_id ) : ?>
									<div class="ct-tabs__cite-company">
										<?php
										echo wp_get_attachment_image(
											$company_image_id,
											'medium',
											false,
											array( 'class' => 'ct-tabs__cite-company-logo' )
										);
										?>
									</div>
								<?php endif; ?>

							</cite>
						<?php endif; ?>

					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $has_right_col ) : // Right column: stats + CTA ?>
			<div class="ct-tabs__col ct-tabs__col--right">

				<?php if ( $has_stats ) : ?>
				<div class="ct-tabs__stats">
					<?php if ( ! empty( $tab['stats_number'] ) ) : ?>
						<span class="ct-tabs__stats-number"><?php echo esc_html( $tab['stats_number'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $tab['stats_text'] ) ) : ?>
						<span class="ct-tabs__stats-text"><?php echo esc_html( $tab['stats_text'] ); ?></span>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $has_cta ) : ?>
					<?php $opens_new_tab = ! empty( $cta_link['target'] ) && '_blank' === $cta_link['target']; ?>
					<div class="ct-tabs__cta">
					<a
						class="ct-tabs__cta-link"
						href="<?php echo esc_url( $cta_link['url'] ); ?>"
						<?php if ( $opens_new_tab ) : ?>
							target="_blank"
							rel="noopener noreferrer"
						<?php endif; ?>
					>
						<?php echo esc_html( $cta_link['title'] ); ?>
						<svg class="ct-tabs__cta-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 12 13" aria-hidden="true" focusable="false">
							<g fill="none" fill-rule="nonzero" stroke="currentColor" stroke-linecap="round" stroke-width="2">
								<path d="M3 1.233h8v8M10 2.233l-9 9"/>
							</g>
						</svg>
						<?php if ( $opens_new_tab ) : ?>
							<span class="ct-sr-only"><?php esc_html_e( '(opens in new tab)', 'custom-tabs-plugin' ); ?></span>
						<?php endif; ?>
					</a>
				</div>
				<?php endif; ?>

			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

	<?php if ( $has_logos ) : ?>
	<div class="ct-tabs__logos-section">
		<?php if ( $trusted_by ) : ?>
			<p class="ct-tabs__trusted-by"><?php echo esc_html( $trusted_by ); ?></p>
		<?php endif; ?>
		<ul class="ct-tabs__logos-list" role="list">
			<?php foreach ( $company_logos as $logo_id ) : ?>
				<?php
				$logo_id = absint( $logo_id );
				if ( ! $logo_id ) {
					continue;
				}
				?>
				<li class="ct-tabs__logos-item">
					<?php
					echo wp_get_attachment_image(
						$logo_id,
						'medium',
						false,
						array( 'class' => 'ct-tabs__logo' )
					);
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	<?php
}
