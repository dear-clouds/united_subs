<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div <?php bbp_reply_class(); ?>>
	<div class="item-container">
		<div class="item-content">
			<article>
				<div class="bbp-reply-author">
					<?php bbp_reply_author_link( array( 'type' => 'avatar', 'size' => 35 ) ); ?>
				</div>

				<div class="item-content-container">
					<header class="item-header comment-header">
						<div class="reply-post-title">
							<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
							
							<h4 class="poster-name"><?php bbp_reply_author_link( array( 'type' => 'name' ) ); ?></h4> <span class="said"><?php _e( 'said', 'bbpress' ) ?></span>

							<?php if ( is_super_admin() ) : ?>
						
								<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>
						
								<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>
						
								<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>
						
							<?php endif; ?>
						
							<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

						</div>
					</header>
				</div>

				<div class="post-content">
					<div class="bbp-reply-content">

						<?php do_action( 'bbp_theme_before_reply_content' ); ?>

						<?php bbp_reply_content(); ?>

						<?php do_action( 'bbp_theme_after_reply_content' ); ?>

					</div><!-- .bbp-reply-content -->
				</div>

				<footer class="item-footer clearfix">
					
					<div class="item-actions admin-links">

						<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

						<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

						<?php bbp_reply_admin_links(); ?>
			
						<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

						<div class="date">
							<?php bbp_reply_post_date(); ?>
						</div>

					</div>
				</footer>
			</article>
		</div>
	</div>
</div><!-- .reply -->