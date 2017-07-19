<div class="mom-su-posts mom-su-posts-default-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

				<div id="mom-su-post-<?php the_ID(); ?>" class="mom-su-post">
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="mom-su-post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php endif; ?>
					<h2 class="mom-su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="mom-su-post-meta"><?php _e( 'Posted', 'theme' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?></div>
					<div class="mom-su-post-excerpt">
						<?php the_excerpt(); ?>
					</div>
					<a href="<?php comments_link(); ?>" class="mom-su-post-comments-link"><?php comments_number( __( '0 comments', 'theme' ), __( '1 comment', 'theme' ), '% comments' ); ?></a>
				</div>

				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'theme' ) . '</h4>';
		}
	?>
</div>