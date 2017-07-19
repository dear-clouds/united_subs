<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() || ! comments_open() ) {
	return;
}
?>
<section class="container-wrap">
	<div class="container">
		<div id="comments" class="comments-area">

            <div class="hr-title hr-long"><abbr><?php comments_number(esc_html__('0 Comments', "kleo_framework"), esc_html__('1 Comment', "kleo_framework"), __('% Comments', "kleo_framework") ); ?></abbr></div>

			<?php if ( have_comments() ) : ?>
			<div id="comments-list">

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<div id="comments-nav-above" class="comments-navigation" role="navigation">
					<div class="paginated-comments-links clearfix">
						<?php paginate_comments_links(array('type'=>'list','prev_text'=> esc_html__('Previous', 'kleo_framework'),
						'next_text'    => esc_html__('Next', 'kleo_framework'))); ?></div>
				</div><!-- #comments-nav-above -->
				<?php endif; // Check for comment navigation. ?>
				<ol>
					<?php wp_list_comments('type=all&callback=kleo_custom_comments'); ?>
				</ol>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<div id="comments-nav-below" class="comments-navigation" role="navigation">
					<div class="paginated-comments-links comments-links-after clearfix"><?php paginate_comments_links(array('type'=>'list','prev_text'=> esc_html__('Previous', 'kleo_framework'),
						'next_text'    => esc_html__('Next', 'kleo_framework'))); ?></div>
				</div><!-- #comments-nav-below -->
				<?php endif; // Check for comment navigation. ?>

				<?php if ( ! comments_open() ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'kleo_framework' ); ?></p>
				<?php endif; ?>
        
                <div class="activity-timeline"></div>
			</div>
      
			<?php endif; // have_comments() ?>

			<?php kleo_comment_form(); ?>

		</div><!-- #comments -->
	</div>
</section>