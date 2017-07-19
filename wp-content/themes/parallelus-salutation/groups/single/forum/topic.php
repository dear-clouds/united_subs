<?php do_action( 'bp_before_group_forum_topic' ); ?>

<?php if ( bp_has_forum_topic_posts() ) : ?>

	<form action="<?php bp_forum_topic_action() ?>" method="post" id="forum-topic-form" class="standard-form">

		<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
			<ul>
				<li>
					<a href="<?php bp_forum_topic_new_reply_link() ?>" class="new-reply-link"><?php _e( 'New Reply', 'buddypress' ) ?></a>
				</li>
				<?php if ( bp_forums_has_directory() ) : ?>
					<li>
						<a href="<?php bp_forums_directory_permalink() ?>"><?php _e( 'Forum Directory', 'buddypress') ?></a>
					</li>
				<?php endif; ?>
			</ul>
			<?php if ( bp_group_is_admin() || bp_group_is_mod() || bp_get_the_topic_is_mine() ) : ?>
				<div class="last admin-links">
					<?php bp_the_topic_admin_links() ?> &nbsp;
				</div>
			<?php endif; ?>
		</div>


		<h3><?php bp_the_topic_title() ?> <?php //echo '('; bp_the_topic_total_post_count(); echo ')'; ?></h3>


		<div class="bp-pagination no-ajax">
			<div id="post-count" class="pag-count">
				<?php bp_the_topic_pagination_count() ?>
			</div>
			<div class="pagination-links" id="topic-pag topic-pag-top">
				<?php bp_the_topic_pagination() ?>
			</div>
		</div>
				
		<?php do_action( 'bp_before_group_forum_topic_posts' ) ?>

		<ul id="topic-post-list" class="item-list">
			<?php while ( bp_forum_topic_posts() ) : bp_the_forum_topic_post(); ?>

				<li id="post-<?php bp_the_topic_post_id() ?>" class="item-li <?php bp_the_topic_post_css_class() ?>">
					<div class="item-container">
						<div class="item-content">
						
							<article>
								<div class="poster-avatar">
									<a href="<?php bp_the_topic_post_poster_link() ?>">
										<?php 
										// get the avatar image, get the default, resize default, replace URL of default with resized, insert new URL.
										// $size = 35;
										// $avatarURL = bp_theme_avatar_url(
										// 	$size,$size,
										// 	'', 
										// 	bp_core_fetch_avatar(array( 'item_id' => $GLOBALS['topic_template']->post->poster_id, 'type' => 'full', 'html' => 'false', 'width' => $size, 'height' => $size ))
										// );
										// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:'.$size.'px; height:'.$size.'px; "></div>';  
										bp_the_topic_post_poster_avatar( 'width=35&height=35' ) ?>
									</a>
								</div>
								
								<div class="item-content-container">
									
									<header class="comment-header item-header">
										<div class="topic-post-title">
											<h4 class="poster-name"><?php bp_the_topic_post_poster_name() ?></h4> <span class="said"><?php _e( 'said', 'buddypress' ) ?></span>
										</div>
									</header>
				
									<div class="post-content">
										<?php bp_the_topic_post_content() ?>
									</div>
				
									<footer class="post-footer item-footer clearfix">
										<div class="date"><?php bp_the_topic_post_time_since() ?></div>
										<div class="item-actions admin-links">
											<?php if ( bp_group_is_admin() || bp_group_is_mod() || bp_get_the_topic_post_is_mine() ) : ?>
												<?php bp_the_topic_post_admin_links() ?> | 
											<?php endif; ?>
											<a href="#post-<?php bp_the_topic_post_id() ?>" title="<?php _e( 'Permanent link to this post.', 'buddypress' ) ?>"><?php _e( 'Permalink', 'buddypress' ) ?></a>
										</div>
									</footer>
									
								</div>
							</article>
						
						</div>
					</div>
				</li>

			<?php endwhile; ?>
		</ul>


		<div class="bp_after_group_forum_topic_posts">
			<?php do_action( 'bp_after_group_forum_topic_posts' ) ?>
		</div>

		<div class="bp-pagination bp-pagination-bottom no-ajax">
			<div id="post-count" class="pag-count">
				<?php bp_the_topic_pagination_count() ?>
			</div>
			<div class="pagination-links" id="topic-pag topic-pag-bottom">
				<?php bp_the_topic_pagination() ?>
			</div>
		</div>

		<div id="topic-meta">
			<?php if ( bp_forum_topic_has_tags() ) : ?>
				<div class="topic-tags">
					<?php _e( 'Topic tags:', 'buddypress' ) ?> <?php bp_forum_topic_tag_list() ?>
				</div>
			<?php endif; ?>
			<?php do_action( 'bp_group_forum_topic_meta' ); ?>
		</div>
		

		<?php if ( ( is_user_logged_in() && 'public' == bp_get_group_status() ) || bp_group_is_member() ) : ?>

			<?php if ( bp_get_the_topic_is_last_page() ) : ?>

				<?php if ( bp_get_the_topic_is_topic_open() && !bp_group_is_user_banned() ) : ?>

					<div id="post-topic-reply">
						<p id="post-reply"></p>

						<?php if ( bp_groups_auto_join() && !bp_group_is_member() ) : ?>
							<p><?php _e( 'You will auto join this group when you reply to this topic.', 'buddypress' ) ?></p>
						<?php endif; ?>

						<?php do_action( 'groups_forum_new_reply_before' ) ?>

						<h4><?php _e( 'Add a reply:', 'buddypress' ) ?></h4>

						<textarea name="reply_text" id="reply_text"></textarea>

						<div class="submit">
							<input type="submit" name="submit_reply" id="submit" value="<?php _e( 'Post Reply', 'buddypress' ) ?>" />
						</div>

						<?php do_action( 'groups_forum_new_reply_after' ) ?>

						<?php wp_nonce_field( 'bp_forums_new_reply' ) ?>
					</div>

				<?php elseif ( !bp_group_is_user_banned() ) : ?>

					<div id="message" class="info">
						<p><?php _e( 'This topic is closed, replies are no longer accepted.', 'buddypress' ) ?></p>
					</div>

				<?php endif; ?>

			<?php endif; ?>

		<?php endif; ?>

	</form><!-- #forum-topic-form -->

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There are no posts for this topic.', 'buddypress' ) ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_group_forum_topic' ) ?>
