<?php
/*
Template Name: Authors List
*/
?>
<?php get_header(); 
	global $post;
	$pagebreadcrumb = get_post_meta($post->ID, 'mom_hide_breadcrumb', true);
	$icon = get_post_meta($post->ID, 'mom_page_icon', true);
	$layout = get_post_meta(get_the_ID(), 'mom_page_layout', true);
	$PS = get_post_meta(get_the_ID(), 'mom_page_share', true);
	$PC = get_post_meta(get_the_ID(), 'mom_page_comments', true);
?>


<div class="main-container"><!--container-->                  
     
    <?php if(mom_option('breadcrumb') != 0) { ?>
    <?php if ($pagebreadcrumb != true) { ?>    
    <div class="post-crumbs archive-page entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                    	<?php if($icon != '') { 
				if (0 === strpos($icon, 'http')) {
					echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$icon.')"></i></div>';
				} else {
					echo '<div class="crumb-icon"><i class="'.$icon.'"></i></div>';
				}
				 } else { ?>
        <div class="crumb-icon"><i class="momizat-icon-user3"></i></div>
        <?php } ?>
        <span>
            <?php the_title(); ?>
        </span>
    </div>
    <?php } ?> 
    <?php } else { ?>
		<span class="mom-page-title"><h1><?php the_title(); ?></h1></span>
	<?php } ?>

	<?php if ($layout != 'fullwidth') { ?>
	<div class="main-left"><!--Main Left-->	 
	<div class="main-content" role="main"><!--Main Content-->
	<?php } ?>
	<div class="site-content page-wrap">

            <?php the_content(); ?>
			
			<div class="auhtor-list-temp">
				<?php
				$exclude = get_post_meta(get_the_ID(), 'mom_exc_athour', true);
				$counter = get_post_meta(get_the_ID(), 'mom_num_athour', true);
				$offset = get_post_meta(get_the_ID(), 'mom_offset_athour', true);
				$role = get_post_meta(get_the_ID(), 'mom_role_author', true);

				if ($exclude) { 
					explode(',', $exclude);
				} 
				
				//print_r($exclude);
				$users = get_users(
					array(
						'blog_id' => 1,
						'orderby' => 'post_count',
						'order' => 'DESC',
						'exclude' => $exclude,
						'offset' => $offset,
						'number' => $counter,
						'role' => $role
					)       
				);
                    foreach ($users as $user) {	
				?>
				<div class="author-list-box">
					<div class="author-box-content">
						<?php echo get_avatar( get_the_author_meta( 'user_email' , $user->ID ), apply_filters( 'MFW_author_bio_avatar_size', 80 ) ); ?>
						<div class="author-box-data">
							<div class="author-bio-name"><a href="<?php echo get_author_posts_url( $user->ID ); ?>" itemprop="author"><?php echo $user->display_name ?></a></div>
							<div class="entry-contnet">
								 <p><?php the_author_meta( 'description', $user->ID ); ?></p>
							</div>
						</div>
					</div>
					<footer class="author-box-footer">
						<span><?php _e('Article ', 'framework'); ?><?php echo count_user_posts( $user->ID ); ?></span>
						<ul class="author-bio-social">
								<?php if ( get_the_author_meta( 'url', $user->ID ) ) : ?>
	                                <li><a href="<?php the_author_meta( 'url', $user->ID ); ?>"><i class="momizat-icon-home2"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'twitter', $user->ID ) ) : ?>
	                                <li class="twitter"><a href="<?php the_author_meta( 'twitter', $user->ID ); ?>"><i class="momizat-icon-twitter"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'facebook', $user->ID ) ) : ?>
	                                <li class="fb"><a href="<?php the_author_meta( 'facebook', $user->ID ); ?>"><i class="enotype-icon-facebook"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'googleplus', $user->ID ) ) : ?>
	                                <li class="google"><a href="<?php the_author_meta( 'googleplus', $user->ID ); ?>?rel=author"><i class="momizat-icon-google-plus"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'youtube', $user->ID ) ) : ?>
	                                <li class="youtube"><a href="<?php the_author_meta( 'youtube', $user->ID ); ?>"><i class="fa-icon-youtube"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'linkedin', $user->ID ) ) : ?>
	                                <li class="linkedin"><a href="<?php the_author_meta( 'linkedin', $user->ID ); ?>"><i class="fa-icon-linkedin"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'pinterest', $user->ID ) ) : ?>
	                                <li class="pin"><a href="<?php the_author_meta( 'pinterest', $user->ID ); ?>"><i class="enotype-icon-pinterest"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'flickr', $user->ID ) ) : ?>
	                                <li class="flicker"><a href="<?php the_author_meta( 'flickr', $user->ID ); ?>"><i class="fa-icon-flickr"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'dribbble', $user->ID ) ) : ?>
	                                <li class="dribble"><a href="<?php the_author_meta( 'dribbble', $user->ID ); ?>"><i class="fa-icon-dribbble"></i></a></li>
	                            <?php endif ?>
	                            <?php if(mom_option('email-author-box') != 0) { ?>
	                            <?php if ( get_the_author_meta( 'email', $user->ID ) ) : ?>
	                                <li><a href="mailto:<?php the_author_meta( 'email', $user->ID ); ?>"><i class="dashicons dashicons-email-alt"></i></a></li>
	                            <?php endif ?>
	                            <?php } ?>
	                        </ul>
					</footer>
				</div>
				<?php } ?>
			</div>
			<?php if ($PS == true) mom_posts_share(get_the_ID(), get_permalink()); ?>
					<?php if ($PC == true) comments_template(); ?>
        </div>

		<?php if ($layout != 'fullwidth') { ?>
    	</div><!--Main Content-->
		<?php get_sidebar('left'); ?>
	</div><!--Main left-->
	<?php get_sidebar(); ?>
	<?php } ?>
</div><!--container-->

</div><!--wrap-->
<?php get_footer(); ?>