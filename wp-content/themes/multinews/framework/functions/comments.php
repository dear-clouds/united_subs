<?php
if ( ! function_exists( 'mom_comment' ) ) :
function mom_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class('single_comment'); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'framework' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class('single_comment'); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment single-comment">
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'framework' ); ?></em>
			<?php endif; ?>
			<header class="comment-author-avatar">
				<?php
					echo get_avatar( $comment, 60 );
				?>
			</header><!-- .comment-vcard -->
			<div class="comment-wrap">
                        <header class="comment_header">
                        <?php
                            printf( '<cite>%1$s %2$s</cite>',
                                    get_comment_author_link(),
                                    // If current post author is also comment author, make it known visually.
                                    ( $comment->user_id === $post->post_author ) ? '' : ''
                            );
			
                        ?>
                        <div class="comment-date">
                        <?php
					printf( '<span class="comment-meta commentmetadata "><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'framework' ), get_comment_date(), get_comment_time() )
					);
			edit_comment_link( __( 'Edit', 'framework' ), '<span class="edit-link">', '</span>' ); 
                        ?> 
                        </div>
                        </header>

			<section class="comment-content comment">
				<?php comment_text(); ?>
			</section><!-- .comment-content -->
			<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'framework' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</article><!-- #comment-## -->
		
                        
	<?php
		break;
	endswitch; // end comment_type check
}
endif;