<?php
function mom_blog_post($style = 1, $nexcerpt, $class) {
    global $post;

	$post_meta_hp = mom_option('post_meta_hp');
	if($post_meta_hp == 1) {
	$post_head = mom_option('post_head');
	$post_head_author = mom_option('post_head_author');
	$post_head_date = mom_option('post_head_date');
	$post_head_cat = mom_option('post_head_cat');
	$post_head_commetns= mom_option('post_head_commetns');
	$post_head_views = mom_option('post_head_views');
	} else {
	$post_head = 1;
	$post_head_author = 1;
	$post_head_date = 1;
	$post_head_cat = 1;
	$post_head_commetns= 1;
	$post_head_views = 1;
	}

	if ($style == 'large') { ?>

			<article <?php post_class('blog-post-big nb1 '.$class); ?> data-id="<?php echo $post->ID; ?>">
				<?php if( mom_post_image() != false ) { ?>
				<figure class="post-thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php
						//$thumbsize = 'blogb-thumb';
						$thumbsize = 'big-thumb-hd';
						mom_post_image_full($thumbsize);
						?>
						<span class="post-format-icon"></span>
					</a>
				</figure>
				<?php } ?>
				<h2>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php if($post_head != 0) { ?>
				<div class="entry-meta">
					<?php if($post_head_author != 0) { ?>
					<div class="author-link">
			        <?php _e('Posted by ', 'framework') ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
			        </div>
			        <?php } ?>
			        <?php if($post_head_date != 0) { ?>
					<span>|</span><time class="entry-date" content="<?php the_time('c'); ?>"><?php mom_date_format(); ?></time>
					<?php } ?>
					<?php if($post_head_cat != 0) { ?>
					<div class="cat-link">
			        <span>|</span><?php _e('in :', 'framework') ?> <?php the_category(', ') ?>
			        </div>
			        <?php } ?>
			        <?php if($post_head_commetns != 0) { ?>
			        <div class="comments-link">
			        <span>|</span><a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
			        </div>
			        <?php } ?>
			        <?php if($post_head_views != 0) { ?>
					<div class="post-views">
			        <span>|</span><?php echo getPostViews(get_the_ID()); ?>
			        </div>
			        <?php } ?>
				</div>
				<?php } ?>
				<div class="entry-content">
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						if($nexcerpt != '') {
						echo wp_html_excerpt(strip_shortcodes($excerpt), $nexcerpt, '...');
						} else {
						echo wp_html_excerpt(strip_shortcodes($excerpt), 304, '...');
						}
					?>
				</div>
				<?php if(is_rtl()) { ?>
			    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-left"></i></a>
			    <?php } else { ?>
			    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-right"></i></a>
				<?php } ?>
			</article>

	<?php } elseif($style == 'grid') {
											$dateformat = mom_option('date_format');
	?>
	                                        <li <?php post_class(); ?> data-id="<?php echo $post->ID; ?>">
	                                            <h2 class="cat-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <?php if($post_head != 0) { ?>
	                                            <div class="cat-list-meta entry-meta">
	                                                <?php if($post_head_author != 0) { ?>
	                                                <div class="author-link">
	                                                <?php _e('Posted by', 'framework') ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
	                                                </div>
	                                                <?php } ?>
	                                                <?php if($post_head_date != 0) { ?>
	                                                <span>|</span><time class="entry-date" content="<?php the_time('c'); ?>"><?php _e('Date: ', 'framework') ?><?php the_time($dateformat); ?></time>
	                                                <?php } ?>
	                                                <?php if($post_head_commetns != 0) { ?>
	                                                <div class="comments-link">
	                                                <span>|</span><a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
	                                                </div>
	                                                <?php } ?>
	                                            </div>
	                                            <?php } ?>
	                                            <?php if( mom_post_image() != false ) { ?>
	                                            <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
	                                            	<?php mom_post_image_full('nb1-thumb'); ?>
	                                                <span class="post-format-icon"></span>
	                                            </a></figure>
	                                            <?php } ?>
	                                            <h2 class="cat-grid-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <div class="entry-content cat-grid-meta">
	                                                <p>
	                                                    <?php global $post;
	                                                    $excerpt = $post->post_excerpt;
	                                                    if($excerpt==''){
	                                                    $excerpt = get_the_content('');
	                                                    }
	                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),105, '...');
	                                                    ?> ...
	                                                </p>
	                                            </div>
	                                            <?php
	                                            if( mom_post_image() != false ) {
		                                        	$mom_class = ' class="fix-right-content"';
		                                        } else {
			                                        $mom_class = '';
		                                        }
	                                            ?>

	                                            <div<?php echo $mom_class; ?>>
		                                            <div class="entry-content cat-list-meta">
		                                                <p>
		                                                    <?php global $post;
		                                                    $excerpt = $post->post_excerpt;
		                                                    if($excerpt==''){
		                                                    $excerpt = get_the_content('');
		                                                    }
		                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),200, '...');
		                                                    ?> ...
		                                                </p>
		                                            </div>
		                                            <?php if($post_head != 0) { ?>
		                                            <div class="cat-grid-meta entry-meta">
		                                            	<?php if($post_head_date != 0) { ?>
		                                                <time class="entry-date" content="<?php the_time('c'); ?>"><?php the_time($dateformat); ?> </time>
		                                                <?php } ?>
		                                                <?php if($post_head_author != 0) { ?>
		                                                <div class="author-link">
		                                                    |<?php _e(' by ', 'framework') ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
		                                                </div>
		                                                <?php } ?>
		                                                <?php if($post_head_commetns != 0) { ?>
		                                                <div class="comments-link">
		                                                    |<a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
		                                                </div>
		                                                <?php } ?>
		                                            </div>
		                                            <?php } ?>
		                                            <?php if(is_rtl()) { ?>
		                                            <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-left"></i></a>
		                                            <?php } else { ?>
		                                            <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-right"></i></a>
													<?php } ?>
	                                            </div>
	                                        </li>
	<?php } else { ?>

			<article <?php post_class('blog-post nb1 '.$class); ?> data-id="<?php echo $post->ID; ?>">
				<h2>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php if($post_head != 0) { ?>
				<div class="entry-meta">
					<?php if($post_head_author != 0) { ?>
					<div class="author-link">
			        <?php _e('Posted by ', 'framework') ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
			        </div>
			        <?php } ?>
			        <?php if($post_head_date != 0) { ?>
					<span>|</span><time class="entry-date" content="<?php the_time('c'); ?>"><?php mom_date_format(); ?></time>
					<?php } ?>
					<?php if($post_head_cat != 0) { ?>
					<div class="cat-link">
			        <span>|</span><?php _e('in :', 'framework') ?> <?php the_category(', ') ?>
			        </div>
			        <?php } ?>
			        <?php if($post_head_commetns != 0) { ?>
			        <div class="comments-link">
			        <span>|</span><a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
			        </div>
			        <?php } ?>
			        <?php if($post_head_views != 0) { ?>
					<div class="post-views">
			        <span>|</span><?php echo getPostViews(get_the_ID()); ?>
			        </div>
			        <?php } ?>
				</div>
				<?php } ?>
				<?php if( mom_post_image() != false ) { ?>
				<figure class="post-thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php mom_post_image_full('blog-thumb'); ?>
						<span class="post-format-icon"></span>
					</a>
				</figure>
				<?php } ?>
				<div class="entry-content">
					<?php
			           $excerpt = get_the_excerpt();
			            if ($excerpt == false) {
			            $excerpt = get_the_content();
			            }

			            if($nexcerpt != '') {
						echo wp_html_excerpt(strip_shortcodes($excerpt), $nexcerpt, '...');
						} else {
						echo wp_html_excerpt(strip_shortcodes($excerpt), 170, '...');
						}
					?>
				</div>
				<?php if(is_rtl()) { ?>
			    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-left"></i></a>
			    <?php } else { ?>
			    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-right"></i></a>
				<?php } ?>
			</article>
	<?php }
}
?>
