<?php
/**
 * Dashboard template: Themes list
 *
 * This template displays a list of all the themes and offers basic theme
 * management functions.
 *
 * Following variables are passed into the template:
 *   $data (membership data)
 *   $urls (urls of all dashboard menu items)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

// Render the page header section.
$page_title = __( 'Themes', 'wpmudev' );
$this->render_header( $page_title );

?>
<div class="row row-space">
	<div class="col-half">
		<input type="search" placeholder="<?php esc_attr_e( 'Search themes', 'wpmudev' ) ?>" class="search" data-no-empty-msg="true" />
	</div>
	<div class="col-half tr">
		<span class="input-group">
			<label for="sel_sort" class="inline-label">
				<?php esc_html_e( 'Sort', 'wpmudev' ); ?>
			</label>
			<select id="sel_sort" class="sel-sort">
				<option value="def"><?php esc_html_e( 'Default', 'wpmudev' ); ?></option>
				<option value="popularity"><?php esc_html_e( 'Popularity', 'wpmudev' ); ?></option>
				<option value="released"><?php esc_html_e( 'Release Date', 'wpmudev' ); ?></option>
				<option value="updated"><?php esc_html_e( 'Recently Updated', 'wpmudev' ); ?></option>
				<option value="downloads"><?php esc_html_e( 'Downloads', 'wpmudev' ); ?></option>
				<option value="alphabetical"><?php esc_html_e( 'Alphabetically', 'wpmudev' ); ?></option>
			</select>
		</span>
	</div>
</div>


<div class="row row-projects updates hide-empty">
	<h3 class="section-title" id="section1">
		<span class="title"><?php esc_html_e( 'Available updates', 'wpmduev' ); ?></span>
		<span class="count"></span>
	</h3>
	<div class="content">
		<div class="content-inner"></div>
	</div>
	<div class="no-content"></div>
	<div class="row-sep"></div>
</div>

<div class="row row-projects installed hide-empty">
	<div class="content">
		<div class="content-inner"></div>
	</div>
	<div class="no-content">
		<?php esc_html_e( 'No Themes found', 'wpmudev' ); ?>
	</div>
	<div class="row-sep"></div>
</div>

<div class="project-list hidden">
	<?php
	foreach ( $data['projects'] as $project ) {
		if ( empty( $project['id'] ) ) { continue; }
		if ( 'theme' != $project['type'] ) { continue; }

		$this->render_project( $project['id'] );
	}
	?>
</div>

<?php $this->load_template( 'element-last-refresh' ); ?>

<script>
jQuery(function(){
	window.WDP = window.WDP || {};
	WDP.data = WDP.data || {};
	WDP.data.hash_show_popup = <?php echo json_encode( wp_create_nonce( 'show-popup' ) ); ?>;
});
</script>
