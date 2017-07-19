<?php
/**
 * BuddyPress Media - group album list template
 *
 * @package WordPress
 * @subpackage BuddyBoss Media
 */
?>

<h2 class="entry-title"><?php _e( 'Albums', 'buddyboss-media' );?>
	<?php if( bbm_groups_user_can_create_albums() ): ?>
		<?php global $bp;
		$create_album_url = esc_url( add_query_arg( array('album' => 'new' ) ) ); ?>

		<a href="<?php echo esc_url( $create_album_url );?>" class="button album-create bp-title-button">
			<?php _e( 'Create an Album', 'buddyboss-media' );?>
		</a>

	<?php endif; ?>
</h2>

	<form action="" method="post" id="albums-directory-form" class="dir-form">
		
		<div id="albums-dir-list" class="albums dir-list">

			<?php if ( buddyboss_media_has_albums() ) : ?>

				<div id="pag-top" class="pagination no-ajax">

					<div class="pagination-links" id="album-dir-pag-top">

						<?php buddyboss_media_albums_pagination_links(); ?>

					</div>

				</div>

				<ul id="members-list" class="albums-list item-list" role="main">

				<?php while ( buddyboss_media_albums() ) : buddyboss_media_the_album(); ?>

					<li id='album-<?php echo buddyboss_media_album_id();?>'>
						<div class="item-avatar">
							<a href='<?php buddyboss_media_album_permalink();?>'>
								<?php buddyboss_media_album_avatar( 'width=50&height=50' ); ?>
							</a>
						</div>

						<div class="item">
							<div class="item-title"><a href='<?php buddyboss_media_album_permalink();?>'><?php buddyboss_media_album_title(); ?></a></div>
							<div class="item-meta">
								<span class="activity photos-count"><?php buddyboss_media_album_photos_count(); ?> / <?php buddyboss_media_album_date(); ?></span>
							</div>

							<div class="item-desc"><?php buddyboss_media_album_short_description(); ?></div>
						</div>

						<div class="clear"></div>
					</li>

				<?php endwhile; ?>

				</ul>

				<div id="pag-bottom" class="pagination no-ajax">

					<div class="pagination-links" id="album-dir-pag-bottom">

						<?php buddyboss_media_albums_pagination_links(); ?>

					</div>

				</div>

			<?php else: ?>

				<div id="message" class="info">
					<p><?php _e( 'There were no albums found.', 'buddyboss-media' ); ?></p>
				</div>

			<?php endif; ?>


		</div><!-- #albums-dir-list -->

	</form><!-- #albums-directory-form -->
	