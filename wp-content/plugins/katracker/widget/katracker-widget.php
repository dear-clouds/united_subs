<?php

// default widget content
$torrents = get_torrents( array(
	'torrent_ids'  => !empty( $instance['torrents_id'] ) ? $instance['torrents_id'] : null,
	'numtorrents'  => $instance['numtorrents'],
	'orderby'      => 'date',
	'order'        => 'DESC',
) );
if ( !empty( $torrents ) ):
echo $args['before_title'] . apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Torrents', 'katracker' ) ) . $args['after_title'];
?>
<ul class="katracker-widget-ul">
<?php foreach ( $torrents as $torrent ): ?>
	<li id="katracker_widget_<?php echo $torrent->ID; ?>" class="katracker-widget-item">
		<a href="<?php the_permalink($torrent->ID); ?>"><?php echo get_the_title($torrent->ID); ?></a>
		<?php if ( $instance['show_date'] ) : ?>
			<span class="post-date"><?php echo get_the_date( '', $torrent->ID ); ?></span>
		<?php endif; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; // Get Torrents

?>
