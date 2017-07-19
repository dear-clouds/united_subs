<?php
/**
 * Dashboard template: Plugins list
 *
 * Display a list of all available plugins, with relevant management functions
 * like installing, activating or updating plugins.
 *
 * Following variables are passed into the template:
 *   $data (membership data)
 *   $urls (urls of all dashboard menu items)
 *   $tags (list of plugin tags)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

// Render the page header section.
$page_title = __( 'Plugins', 'wpmudev' );
$this->render_header( $page_title );

?>
<div class="row row-space">
	<div class="col-half">
		<input type="search" placeholder="<?php esc_attr_e( 'Search plugins', 'wpmudev' ) ?>" class="search" data-no-empty-msg="true" />
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

		<span class="input-group">
			<label for="sel_category" class="inline-label">
				<?php esc_html_e( 'Category', 'wpmudev' ); ?>
			</label>
			<select id="sel_category" class="sel-category">
				<option value="0"><?php esc_html_e( 'All', 'wpmudev' ); ?></option>
				<?php foreach ( $tags as $tid => $tag ) : ?>
				<option value="<?php echo esc_attr( $tid ); ?>">
					<?php echo esc_html( $tag['name'] ); ?>
				</option>
				<?php endforeach; ?>
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
	<h3 class="section-title" id="section1">
		<span class="title" data-title="<?php esc_attr_e( 'Installed %s Plugins', 'wpmduev' ); ?>"></span>
		<span class="count"></span>
	</h3>
	<div class="content">
		<div class="content-inner"></div>
	</div>
	<div class="no-content">
		<?php esc_html_e( 'No Plugins found', 'wpmudev' ); ?>
	</div>
	<div class="row-sep"></div>
</div>

<div class="row row-projects uninstalled">
	<h3 class="section-title" id="section2">
		<span class="title" data-title="<?php esc_attr_e( 'Available %s Plugins', 'wpmduev' ); ?>"></span>
		<span class="count"></span>
	</h3>
	<div class="content">
		<div class="content-inner"></div>
	</div>
	<div class="no-content">
		<?php esc_html_e( 'No Plugins found', 'wpmudev' ); ?>
	</div>
	<div class="row-sep"></div>
</div>


<?php $this->load_template( 'element-last-refresh' ); ?>

<div class="project-list hidden">
	<?php
	foreach ( $data['projects'] as $project ) {
		if ( empty( $project['id'] ) ) { continue; }
		if ( 'plugin' != $project['type'] ) { continue; }

		$this->render_project( $project['id'] );
	}
	?>
</div>

<script>
jQuery(function(){
	window.WDP = window.WDP || {};
	WDP.data = WDP.data || {};
	WDP.data.hash_show_popup = <?php echo json_encode( wp_create_nonce( 'show-popup' ) ); ?>;
});
</script>
