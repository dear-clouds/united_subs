<?php
//global $atts;

// for [torrent] shortcode
function katracker_shortcode_single( $atts ) {
	$atts = shortcode_atts( array(
		'id'     => isset( $atts['hash'] ) ? get_torrent_id_from_hash( $atts['hash'] ) : null,
		'title'  => get_the_title( $atts['id'] ),
		'stats'  => 1,
		'files'  => 0
	), $atts );

	if ( isset( $atts['id'] ) ) {
		katracker_shortcode_print_torrent( $atts );
	}
	return;
}

// for [torrents] shortcode
function katracker_shortcode_many( $atts ) {
	$atts = shortcode_atts( array(
		'numtorrents'	   => -1,
		'project_order'  => 'name',
		'torrent_order'  => 'title',
		'category'       => null,
		'stats'          => 1,
		'files'          => 0
	), $atts );

	if ( isset( $atts['category'] )) {
		return katracker_shortcode_print_torrents( get_torrents( array(
				'orderby'      => $atts['torrent_order'],
				'numtorrents'  => $atts['numtorrents'],
				'category'     => $atts['category'],
			) ) , $atts);
	}

	if ( isset( $atts['id'] ))
		return katracker_shortcode_print_torrents( get_torrents( array(
				'orderby'      => $atts['torrent_order'],
				'numtorrents'  => $atts['numtorrents'],
				'post__in'     => $atts['id']
			) ) , $atts);

	$categories = get_katracker_categories();
	if ( !empty( $categories ) ):
	?>

	<div class="<?php echo KATRACKER_PRE . '-torrent-list'; ?>">
		<?php
		$excluded = array();
		foreach ( $categories as $category ) {
			$metadata = get_option( 'taxonomy_' . $category->term_id );
			$second_name = !empty( $metadata['second_name'] ) ? ' / ' . $metadata['second_name'] : '';
			$torrents = get_torrents( array( 'orderby' => $atts['torrent_order'], 'category' => $category->term_id, 'bonus' => false ) );
			$bonuses = get_torrents( array( 'orderby' => $atts['torrent_order'], 'category' => $category->term_id, 'bonus' => true ) );
			if ( !empty( $torrents ) || !empty( $bonuses ) ): ?>
				<div>
					<h3><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name . $second_name; ?></a></h3>
					<?php
					katracker_shortcode_print_torrents( $torrents, $atts );
					if ( !empty( $bonuses ) ) {
						katracker_shortcode_print_torrents( $bonuses, array_merge( $atts, array( 'bonus' => true ) ) );
						$torrents = array_merge( $torrents, $bonuses );
					}
					?>
				</div>
			<?php
				foreach( $torrents as $torrent ) {
					$excluded[] = $torrent->ID;
				}
			endif;
		}

		$torrents = get_torrents( array( 'orderby' => $atts['torrent_order'], 'exclude' => $excluded ) );
		if ( !empty( $torrents ) ) { ?>
			<div>
				<h3><?php _e( 'Other', 'katracker' ); ?></h3>
				<?php katracker_shortcode_print_torrents( $torrents, $atts ); ?>
			</div>
		<?php
		}
	?>
	</div>

	<?php endif;
}

/**
 * A helper function for the shortcode
 * prints a list of torrents
 *
 * @param array $torrents Array of torrents to print
 * @param array $options print options
 */
function katracker_shortcode_print_torrents( $torrents, $options ) {
	$options = shortcode_atts( array(
		'stats' => 1,
		'bonus' => 0,
		'files' => 1,
	), $options );

	if ( $options['bonus'] ): ?>
	<h4><?php _e( 'Bonuses', 'katracker' ) ?></h4>
	<?php endif; ?>
	<ul class="torrent-list">
	<?php foreach ( $torrents as $torrent ):
		setup_postdata( $torrent ); ?>
		<li class="collapse-head">
			<?php katracker_shortcode_print_torrent( array(
				'id'     => $torrent->ID,
				'stats'  => $options['stats'],
				'title'  => get_the_title( $torrent->ID ),
				'files'  => $options['files']
			) ); ?>
			</li>
	<?php endforeach; ?>
	</ul>
	<?php
}


/**
 * A helper function for the shortcode
 * prints a single torrent link
 *
 * @param array $options print options/shortcode attributes
 */
function katracker_shortcode_print_torrent( $options = array() ) {
	if ( $permalink = get_permalink( $options['id'] ) ): ?>
		<a href="<?php echo $permalink; ?>"><?php echo $options['title']; ?></a>
		<?php if ( $options['stats'] ): ?>
			<span class="katracker-stats-seed" title="<?php _e( 'Seeders', 'katracker' ); ?>"><?php echo get_torrent_meta( $options['id'], 'seeders' ); ?></span> 
			<span class="katracker-stats-leech" title="<?php _e( 'Leechers', 'katracker' ); ?>"><?php echo get_torrent_meta( $options['id'], 'leechers' ); ?></span>
			<span class="katracker-stats-hits" title="<?php _e( 'Hits', 'katracker' ); ?>"><?php echo get_torrent_meta( $options['id'], 'hits' ); ?></span>
		<?php endif; // stats
		if ($options['files']): ?>
			<table class="torrent-file-list">
				<thead>
					<tr>
						<th><?php _e( 'File Name', 'katracker' ); ?></th>
						<th><?php _e( 'Size', 'katracker' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $lastfilesize = 0;
					foreach( get_torrent_meta( $options['id'], 'files' ) as $path => $offset ): ?>
					<tr>
						<td><?php echo basename( $path ) ?></td>
						<td><?php echo TorrentFile::format( $offset['size'] - $lastfilesize ); ?></td>
					</tr>
					<?php $lastfilesize = $offset['size'];
					endforeach; ?>
				</tbody>
			</table>
		<?php endif; // files
	endif; // permalink
}

?>
