<?php
/**
 * Dashboard popup template: Project info
 *
 * Will output the contents of a Dashboard popup element with details about a
 * single project.
 *
 * Following variables are passed into the template:
 *   $pid (project ID)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$res = WPMUDEV_Dashboard::$site->get_project_infos( $pid );

if ( ! $res || ! is_object( $res ) ) {
	include 'popup-no-data-found.php';
	return;
}

$gallery_items = array();
if ( ! empty( $res->url->video ) ) {
	$gallery_items[] = array(
		'thumb' => $res->url->thumbnail,
		'full' => $res->url->video,
		'desc' => '',
		'type' => 'video',
	);
}
if ( is_array( $res->screenshots ) ) {
	foreach ( $res->screenshots as $item ) {
		$gallery_items[] = array(
			'thumb' => $item['url'],
			'full' => $item['url'],
			'desc' => $item['desc'],
			'type' => 'image',
		);
	}
}

if ( empty( $gallery_items ) ) {
	$gallery_items[] = array(
		'thumb' => $res->url->thumbnail,
		'full' => $res->url->thumbnail,
		'desc' => '',
		'type' => 'image',
	);
}

$slider_class = '';
if ( 1 == count( $gallery_items ) ) {
	$slider_class = 'no-nav';
}

if ( is_array( $res->features ) && ! empty( $res->features ) ) {
	$has_features = true;
	$feature_break = count( $res->features ) / 2;
	$feature_count = 0;
} else {
	$has_features = false;
}

?>
<dialog title="<?php echo esc_attr( $res->name ); ?>">
<div class="wdp-info" data-project="<?php echo esc_attr( $pid ); ?>">

<div class="title-action" data-project="<?php echo esc_attr( $pid ); ?>">
	<?php if ( $res->is_licensed ) : ?>
		<?php if ( $res->is_installed && $res->has_update ) { ?>
		<a href="#update" class="button button-small show-project-update">
			<?php esc_html_e( 'Update available', 'wpmudev' ); ?>
		</a>
		<?php } elseif ( ! $res->is_installed ) { ?>
			<?php if ( $res->url->install ) { ?>
			<a href="<?php echo esc_url( $res->url->install ); ?>"
				class="button button-small button-cta button-green"
				data-project="<?php echo esc_attr( $pid ); ?>"
				data-action="project-install"
				data-hash="<?php echo esc_attr( wp_create_nonce( 'project-install' ) ); ?>">
				<?php
				if ( 'plugin' == $res->type ) {
					esc_html_e( 'Install Plugin', 'wpmudev' );
				} else {
					esc_html_e( 'Install Theme', 'wpmudev' );
				}
				?>
			</a>
			<?php } elseif ( $res->is_compatible ) { ?>
			<a href="<?php echo esc_url( $res->url->website ); ?>" target="_blank" class="button button-small button-secondary">
				<?php
				if ( 'plugin' == $res->type ) {
					esc_html_e( 'Download Plugin', 'wpmudev' );
				} else {
					esc_html_e( 'Download Theme', 'wpmudev' );
				}
				?>
			</a>
			<?php } ?>
		<?php } ?>
	<?php else : ?>
		<a href="#upgrade" class="button button-small" rel="dialog">
			<?php esc_html_e( 'Upgrade', 'wpmudev' ); ?>
		</a>
	<?php endif; ?>
</div>

<div class="slider <?php echo esc_attr( $slider_class ); ?>">
	<ul class="slider-big">
		<?php foreach ( $gallery_items as $key => $item ) : ?>
		<li class="item-<?php echo esc_attr( $key ); ?> <?php echo esc_attr( $item['type'] ); ?>"
			data-full="<?php echo esc_url( $item['full'] ); ?>">
			<span style="background-image:url(<?php echo esc_url( $item['thumb'] ); ?>)"></span>
			<?php if ( ! empty( $item['desc'] ) ) : ?>
			<span class="desc"><?php echo esc_html( $item['desc'] ); ?></span>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<div class="slider-nav-wrapper">
	<span class="nav nav-left"><i class="wdv-icon wdv-icon-chevron-left"></i></span>
		<div class="slider-nav-items">
		<ul class="slider-nav">
			<?php foreach ( $gallery_items as $key => $item ) : ?>
			<li class="item <?php echo esc_attr( $item['type'] ); ?>"
				data-key="item-<?php echo esc_attr( $key ); ?>"
				data-full="<?php echo esc_url( $item['full'] ); ?>">
				<span style="background-image:url(<?php echo esc_url( $item['thumb'] ); ?>)"></span>
			</li>
			<?php endforeach; ?>
		</ul>
		</div>
	<span class="nav nav-right"><i class="wdv-icon wdv-icon-chevron-right"></i></span>
	</div>
</div>

<section class="overview">
	<h3><?php esc_html_e( 'Overview', 'wpmudev' ); ?></h3>
	<p><?php echo esc_html( $res->info ); ?></p>
	<p><a href="<?php echo esc_url( $res->url->website ); ?>" target="_blank">
		<?php esc_html_e( 'More information on WPMU DEV', 'wpmudev' ); ?>
		<i class="wdv-icon wdv-icon-arrow-right"></i>
	</a></p>
</section>

<section class="features group">
<?php if ( $has_features ) : ?>
	<h3><?php esc_html_e( 'Features', 'wpmudev' ); ?></h3>
	<ul>
		<?php foreach ( $res->features as $feature ) : ?>
			<?php if ( $feature_count++ >= $feature_break ) : ?>
			<?php $feature_count = -2; ?>
			</ul><ul>
			<?php endif; ?>
		<li>
			<i class="dev-icon dev-icon-radio_checked"></i>
			<?php echo esc_html( $feature ); ?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</section>

<div class="row-sep">
	<a href="#changelog" class="show-project-changelog button button-small button-light">
		<span class="loading-icon"></span>
		<?php esc_html_e( 'Show changelog', 'wpmudev' ); ?>
	</a>
</div>

<script>
jQuery(function(){
	var slider = jQuery('.wdp-info .slider'),
		previews = slider.find('.slider-big'),
		thumbs = slider.find('.slider-nav'),
		navRight = slider.find('.nav-right'),
		nevLeft = slider.find('.nav-left');

	function selectImage() {
		var thumb = jQuery(this),
			key = thumb.data('key'),
			big = previews.find('.' + key),
			pos = big.position();

		previews.css({'margin-left': (-1 * pos.left) });
		thumbs.find('.current').removeClass('current');
		thumb.addClass('current');
	}

	function scrollRight() {
		var curPos = thumbs.position(),
			curLeft = curPos.left,
			width = thumbs.outerWidth();

		curLeft -= 250;
		if (curLeft + width <= 350) {
			curLeft = 350 - width;
		}
		thumbs.css({'left': curLeft + 'px'});
	}

	function scrollLeft() {
		var curPos = thumbs.position(),
			curLeft = curPos.left;

		curLeft += 250;
		if (curLeft >= 0) {
			curLeft = 0;
		}
		thumbs.css({'left': curLeft + 'px'});
	}

	thumbs.on('click', 'li.item', selectImage);
	nevLeft.on('click', scrollLeft);
	navRight.on('click', scrollRight);
	thumbs.find('li.item').first().addClass('current');
});
</script>
</div>
</dialog>
