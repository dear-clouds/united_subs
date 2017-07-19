<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Boss
 */

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<li class="bbp-forum-info">
	
		<div class="bbp-forum-info-content">

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>
	
			<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>
	
			<?php do_action( 'bbp_theme_after_forum_title' ); ?>
	
			<?php do_action( 'bbp_theme_before_forum_description' ); ?>
	
			<div class="bbp-forum-content"><?php the_content(); ?></div>
	
			<?php do_action( 'bbp_theme_after_forum_description' ); ?>
	
			<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>
	
			<?php bbp_list_forums(); ?>
	
			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>
	
			<?php bbp_forum_row_actions(); ?>
			
		</div>

	</li>

    <li class="bbp-forum-topic-count"><span><?php bbp_forum_topic_count(); ?></span></li>

    <li class="bbp-forum-reply-count"><span><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></span></li>

	<li class="bbp-forum-freshness">

			<?php do_action( 'bbp_theme_before_topic_author' ); ?>
			
				<?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'avatar', 'size' => 35 ) ); ?>
				
				<p class="bbp-topic-meta">
				
					<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?></span>
					
					<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

						<span class="bbp-topic-freshness-link"><?php bbp_forum_freshness_link(); ?></span>
			
					<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
					
				</p>
			
			<?php do_action( 'bbp_theme_after_topic_author' ); ?>

	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
