<?php get_header(); 

global $wp_query;
$curauth = $wp_query->get_queried_object();
?>

<div class="main-container author-page"><!--container-->
                    
            <?php if(mom_option('breadcrumb') != 0) { ?>
            <div class="archive-page entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                <div class="crumb-icon"><i class="momizat-icon-user3"></i></div>                        
                <span><?php echo $curauth->display_name; ?></span>
                
                <div class="cat-feed"><a href="<?php echo get_author_feed_link( $curauth->ID ); ?>" rel="nofollow"><i class="enotype-icon-rss"></i></a></div>
            </div>
            <?php } else { ?>
						<span class="mom-page-title"><h1><?php echo $curauth->display_name; ?></h1></span>
					<?php } ?>
            
		            
            <div class="full-main-content" role="main" itemscope itemtype="http://schema.org/Person">
		        <!--Main Content-->
				<div class="author-cover" style="<?php if(get_the_author_meta( 'user_meta_image', $curauth->ID ) != '') { ?>background:url(<?php the_author_meta( 'user_meta_image', $curauth->ID ) ?>) no-repeat center;<?php } else { ?>background:url(<?php echo mom_option('custom_author_cover', 'url'); ?>) no-repeat center;<?php } ?>">
					<div class="author-list-box">
						<div class="author-box-content">
							<?php echo get_avatar( get_the_author_meta( 'user_email' , $curauth->ID ), apply_filters( 'MFW_author_bio_avatar_size', 80 ) ); ?>
							<div class="author-box-data">
								<div class="author-bio-name"><a itemprop="url" href="<?php echo get_author_posts_url( $curauth->ID ); ?>" itemprop="name"><?php echo $curauth->display_name; ?></a></div>
								<div class="entry-contnet" itemscope itemtype="http://schema.org/Organization">
									 <p itemprop="description"><?php the_author_meta( 'description'  , $curauth->ID ); ?></p>
								</div>
							</div>
						</div>
						<footer class="author-box-footer">
						<span><?php _e('Article ', 'framework'); ?><?php echo count_user_posts( $curauth->ID ); ?></span>
						<ul class="author-bio-social">
								<?php if ( get_the_author_meta( 'url', $curauth->ID ) ) : ?>
	                                <li><a href="<?php the_author_meta( 'url', $curauth->ID ); ?>"><i class="momizat-icon-home2"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'twitter', $curauth->ID ) ) : ?>
	                                <li class="twitter"><a href="<?php the_author_meta( 'twitter', $curauth->ID ); ?>"><i class="momizat-icon-twitter"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'facebook', $curauth->ID ) ) : ?>
	                                <li class="fb"><a href="<?php the_author_meta( 'facebook', $curauth->ID ); ?>"><i class="enotype-icon-facebook"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'googleplus', $curauth->ID ) ) : ?>
	                                <li class="google"><a href="<?php the_author_meta( 'googleplus', $curauth->ID ); ?>?rel=author"><i class="momizat-icon-google-plus"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'youtube', $curauth->ID ) ) : ?>
	                                <li class="youtube"><a href="<?php the_author_meta( 'youtube', $curauth->ID ); ?>"><i class="fa-icon-youtube"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'linkedin', $curauth->ID ) ) : ?>
	                                <li class="linkedin"><a href="<?php the_author_meta( 'linkedin', $curauth->ID ); ?>"><i class="fa-icon-linkedin"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'pinterest', $curauth->ID ) ) : ?>
	                                <li class="pin"><a href="<?php the_author_meta( 'pinterest', $curauth->ID ); ?>"><i class="enotype-icon-pinterest"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'flickr', $curauth->ID ) ) : ?>
	                                <li class="flicker"><a href="<?php the_author_meta( 'flickr', $curauth->ID ); ?>"><i class="fa-icon-flickr"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'dribbble', $curauth->ID ) ) : ?>
	                                <li class="dribble"><a href="<?php the_author_meta( 'dribbble', $curauth->ID ); ?>"><i class="fa-icon-dribbble"></i></a></li>
	                            <?php endif ?>
	                            <?php if(mom_option('email-author-box') != 0) { ?>
	                            <?php if ( get_the_author_meta( 'email', $curauth->ID ) ) : ?>
	                                <li><a href="mailto:<?php the_author_meta( 'email', $curauth->ID ); ?>"><i class="dashicons dashicons-email-alt"></i></a></li>
	                            <?php endif ?>
	                            <?php } ?>
	                        </ul>
					</footer>
					</div>
				</div>
				
		        <div class="site-content page-wrap">
			   <?php
			   	$a_counter = mom_option('author_post_counter');
				$user_post_count = count_user_posts( $curauth->ID );
				if ($user_post_count != 0) {
				    mom_posts_timeline($a_counter, $curauth->ID);
				}
			     ?>
		        </div>
		
		    </div>
            

    </div><!--wrap-->
    
    <?php get_footer(); ?>