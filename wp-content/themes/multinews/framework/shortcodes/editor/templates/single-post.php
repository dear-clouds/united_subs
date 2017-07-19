<div class="mom-su-posts mom-su-posts-single-post">
	<?php
		// Prepare marker to show only one post
		$first = true;
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;

				// Show oly first post
				if ( $first ) {
					$first = false;
					?>
					<div id="mom-su-post-<?php the_ID(); ?>" class="mom-su-post">
						<h1 class="mom-su-post-title"><?php the_title(); ?></h1>
						<div class="mom-su-post-meta"><?php _e( 'Posted', 'theme' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?> | <a href="<?php comments_link(); ?>" class="mom-su-post-comments-link"><?php comments_number( __( '0 comments', 'theme' ), __( '1 comment', 'theme' ), __( '%n comments', 'theme' ) ); ?></a></div>
						<div class="mom-su-post-content">
							<?php the_content(); ?>
						</div>
					</div>
					<?php
				}
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'theme' ) . '</h4>';
		}
	?>
</div>