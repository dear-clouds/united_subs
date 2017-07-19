<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to buddyboss_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<?php if ( comments_open() || have_comments() ) : ?>
	
	<div id="comments" class="comments-area">

		<?php // You can start editing here -- including this comment! ?>

		<?php if ( have_comments() ) : ?>

		    <?php $comments_list = wp_list_comments( array( 'callback' => 'buddyboss_comment', 'style' => 'ol', 'echo' => false ) ); ?>
		    
		    <?php if($comments_list): ?>		
		
                <h2 class="comments-title">
                    <?php
                    _e( 'Comments','boss' );
                    ?>
                </h2>

                <ol class="commentlist">
                    <?php echo $comments_list; ?>
                </ol><!-- .commentlist -->

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav id="comment-nav-below" class="navigation" role="navigation">
                    <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'boss' ); ?></h1>
                    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'boss' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'boss' ) ); ?></div>
                </nav>
                <?php endif; // check for comment navigation ?>

                <?php
                /* If there are no comments and comments are closed, let's leave a note.
                 * But we only want the note on posts and pages that had comments in the first place.
                 */
                if ( ! comments_open() && get_comments_number() ) : ?>
                <p class="nocomments"><?php _e( 'Comments are closed.' , 'boss' ); ?></p>
                <?php endif; ?>
			
			<?php endif; // $comments_list ?>

		<?php endif; // have_comments() ?>

		<?php comment_form(array(
                    'title_reply' => '',
                    'logged_in_as' => '',
                    'comment_notes_after' => '',
//                    'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.__('Your Comment...', 'boss').'"></textarea></p>',
                    'label_submit' => __('Comment', 'boss')
                )); 
            ?>
	</div><!-- #comments .comments-area -->

<?php endif; // comments_open() ?>
