<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<tr id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

		<td class="bbp-forum-info">
			
			<div class="bbp-forum-meta-content">
			
				<div class="bbp-forum-meta-counts">
					<span class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></span>
					<span class="bbp-reply-label"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></span>
					<span class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></span>
					<span class="bbp-topics-label"><?php _e( 'Topics', 'bbpress' ); ?></span>
					<div class="clear"></div>
				</div>
				
				<div class="bbp-forum-meta-latest">
					<span class="bbp-topic-meta">
		
						<?php do_action( 'bbp_theme_before_topic_author' ); ?>
		
						<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 14 ) ); ?></span>
		
						<?php do_action( 'bbp_theme_after_topic_author' ); ?>
		
					</span>
					<span class="bbp-topic-freshness">
					
						<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
			
						<?php bbp_forum_freshness_link(); ?>
			
						<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
						
					</span>
				</div>
	
			</div>

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>

			<h4 class="item-title">
				<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>
			</h4>

			<?php do_action( 'bbp_theme_after_forum_title' ); ?>

			<?php do_action( 'bbp_theme_before_forum_description' ); ?>

			<div class="bbp-forum-description"><?php the_content(); ?></div>

			<?php do_action( 'bbp_theme_after_forum_description' ); ?>

			<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

			<?php bbp_list_forums(array('link_before' => '<li class="bbp-forum sub-forum-list"><h5 class="item-title">', 'link_after' => '</h5></li>', 'separator' => '')); ?>

			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>
			
		</td>

		<?php /*?><td class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></td><?php */?>

		<?php /*?><td class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></td><?php */?>

		<?php /*?><td class="bbp-forum-freshness"><?php */?>
		<?php /*?></td><?php */?>

	</tr><!-- bbp-forum-<?php bbp_forum_id(); ?> -->
