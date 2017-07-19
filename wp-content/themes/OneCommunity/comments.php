<?php
	if ( post_password_required() ) {
		echo '<h3 class="comments-header">' . __( 'Password Protected', 'OneCommunity' ) . '</h3>';
		echo '<p class="alert password-protected">' . __( 'Enter the password to view comments.', 'OneCommunity' ) . '</p>';
		return;
	}

	if ( is_page() && !have_comments() && !comments_open() && !pings_open() )
		return;

	if ( have_comments() ) :
		$num_comments = 0;
		$num_trackbacks = 0;
		foreach ( (array) $comments as $comment ) {
			if ( 'comment' != get_comment_type() )
				$num_trackbacks++;
			else
				$num_comments++;
		}
?>
	<div id="comments">


		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'bp_dtheme_blog_comments', 'type' => 'comment' ) ); ?>
		</ol><!-- .comment-list -->

		<?php if ( get_option( 'page_comments' ) ) : ?>
			<div class="comment-navigation paged-navigation">
				<?php paginate_comments_links(); ?>
			</div>
		<?php endif; ?>

	</div><!-- #comments -->
<?php else : ?>

	<?php if ( pings_open() && !comments_open() && ( is_single() || is_page() ) ) : ?>
		<p class="comments-closed pings-open">
			<?php printf( __( 'Comments are closed, but <a href="%1$s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', 'OneCommunity' ), trackback_url( '0' ) ); ?>
		</p>
	<?php elseif ( !comments_open() && ( is_single() || is_page() ) ) : ?>
		<p class="comments-closed">
			<?php _e( 'Comments are closed.', 'OneCommunity' ); ?>
		</p>
	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<div id="container-comment-form"><?php comment_form(); ?></div><!-- container-comment-form -->
<?php endif; ?>

<?php if ( !empty( $num_trackbacks ) ) : ?>
	<div id="trackbacks">

		<ul id="trackbacklist">
			<?php foreach ( (array) $comments as $comment ) : ?>

				<?php if ( 'comment' != get_comment_type() ) : ?>
					<li>
						<h5><?php comment_author_link(); ?></h5>
						<em>on <?php comment_date(); ?></em>
					</li>
 				<?php endif; ?>

			<?php endforeach; ?>
		</ul>

	</div>
<?php endif; ?>