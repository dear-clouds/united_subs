<?php if ( bp_has_forum_topics( bp_ajax_querystring( 'forums' ) ) ) : ?>

	<div class="bp-pagination">

		<div id="post-count" class="pag-count">
			<?php bp_forum_pagination_count() ?>
		</div>

		<div class="pagination-links" id="topic-pag">
			<?php bp_forum_pagination() ?>
		</div>

	</div>


	<?php do_action( 'bp_before_directory_forums_list' ) ?>

	<div class="forum forum-list-container item-container">
		<ul class="forum-list">
			<?php while ( bp_forum_topics() ) : bp_the_forum_topic(); ?>
	
			<li class="<?php bp_the_topic_css_class() ?> forum-li">
				<div class="thread-poster">
					<a href="<?php bp_the_topic_permalink() ?>">
						<div class="topic_poster_avatar">
							<?php 
							// get the avatar image
							// $size = 64;
							// $avatarURL = bp_theme_avatar_url($size,$size,'', bp_core_fetch_avatar( array( 'email' =>  bb_get_user_email($GLOBALS['forum_template']->topic->topic_poster), 'item_id' => $GLOBALS['forum_template']->topic->topic_poster, 'type' => 'full', 'html' => 'false', 'width' => $size, 'height' => $size )) );
							// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:'.$size.'px; height:'.$size.'px; "></div>';
							bp_the_topic_poster_avatar( 'type=full' ) ?>
						</div>
					</a>
					<!--<div class="poster-name"><?php bp_the_topic_poster_name(); //bp_the_topic_last_poster_name() ?></div>-->
				</div>
				
				<div class="thread-info">
					<div class="thread-title">
						<h4 class="item-title">
							<a class="topic-title" href="<?php bp_the_topic_permalink() ?>" title="<?php bp_the_topic_title() ?> - <?php _e( 'Permalink', 'buddypress' ) ?>"><?php bp_the_topic_title() ?></a>
						</h4>
					</div>
				
					<?php if ( !bp_is_group_forum() ) : ?>
						<div class="thread-group">
							<div class="object-name"><?php _e( 'Posted in:', 'buddypress' ) ?> <a href="<?php bp_the_topic_object_permalink() ?>" title="<?php bp_the_topic_object_name() ?>"><?php bp_the_topic_object_name() ?></a></div>
						</div>
					<?php endif; ?>

					<div class="thread-post-users">
						<span class="poster-name thread-creator"><?php _e( 'Creator:', 'buddypress' ) ?> <?php bp_the_topic_poster_name(); ?></span>
						<span class="sep">|</span>
						<span class="poster-name latest-reply"><?php _e( 'Latest:', 'buddypress' ) ?> <?php bp_the_topic_last_poster_name(); ?></span>					
					</div>
				</div>
				
				<div class="thread-history">
					<div class="thread-postcount">
						<span class="postCount"><?php bp_the_topic_total_posts() ?></span>
						<span class="replies"><?php _e( 'replies', 'buddypress' ) ?></span>
						<div class="clear"></div>
					</div>
					<div class="thread-freshness"><?php bp_the_topic_time_since_last_post() ?></div>
				</div>

				<?php do_action( 'bp_directory_forums_extra_cell' ) ?>
				
				<div class="clear"></div>
			</li>
	
			<?php do_action( 'bp_directory_forums_extra_row' ) ?>
	
			<?php endwhile; ?>
		</ul>

	</div>
	<?php do_action( 'bp_after_directory_forums_list' ) ?>

	
	<div class="bp-pagination bp-pagination-bottom">

		<div id="post-count" class="pag-count">
			<?php bp_forum_pagination_count() ?>
		</div>

		<div class="pagination-links" id="topic-pag topic-pag-bottom">
			<?php bp_forum_pagination() ?>
		</div>

	</div>


<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, there were no forum topics found.', 'buddypress' ) ?></p>
	</div>

<?php endif;?>

<div class="clear"></div>