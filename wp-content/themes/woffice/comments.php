<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>

	<div id="comments-container" class="box">
		<div class="intern-padding">
		
			<!-- THE TITLE -->
			<div class="heading">
				<h2><?php printf( _n( '<i class="fa fa-comment"></i> One comment', '<i class="fa fa-comments"></i> %1$s comments', get_comments_number(), 'woffice' ),
					number_format_i18n( get_comments_number() ), get_the_title() ); ?>
				</h2>
			</div>
			
			<!-- THE COMMENTS LIST -->
			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'      => 'ol',
						'reply_text'  => '<i class="fa fa-reply"></i> '. __('Reply','woffice'),
						'short_ping' => true,
						'avatar_size'=> 75,
					) );
				?>
			</ol><!-- .comment-list -->
			
			<!-- THE COMMENTS NAVIGATION -->
			<!-- NEED CHANGES -->
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'woffice' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '<i class="fa fa-chevron-left"></i> Older Comments', 'woffice' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <i class="fa fa-chevron-right"></i>', 'woffice' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
			<?php endif; // Check for comment navigation. ?>
	
			<?php if ( ! comments_open() ) : ?>
				<p class="no-comments"><?php _e( 'Comments are closed.', 'woffice' ); ?></p>
			<?php endif; ?>
			
		</div>
	</div>
	
<?php endif; // have_comments() ?>

<!-- THE COMMENT FORM --> 
<div class="box">
	<div class="intern-padding">
		<?php 
		$args = array(
		  'id_form'           => 'comment-form',
		  'id_submit'         => 'submit',
		  'title_reply'       => __( 'Leave a Reply', 'woffice' ),
		  'title_reply_to'    => __( 'Leave a Reply to %s', 'woffice' ),
		  'cancel_reply_link' => __( 'Cancel Reply', 'woffice' ),
		  'label_submit'      => __( 'Post Comment', 'woffice'),
		  'comment_notes_before' => '',
		  'comment_notes_after' => '',
		); ?>
	
		<?php 
		ob_start();
		comment_form($args);
		echo str_replace('class="comment-form"','class="comment-form form-horizontal"',ob_get_clean());
		?>
	</div>
</div>
