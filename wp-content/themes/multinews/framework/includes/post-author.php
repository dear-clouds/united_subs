<section class="post-section-box">
        <header class="post-section-title">
                <h4><?php _e( 'About The Author', 'framework' ) ?></h4>
        </header>
        
        <div class="author-bio-wrap">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 80); ?>
                
                <div class="author-bio-content">
                        <div class="author-bio-name">
                                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" itemprop="author"><?php the_author_meta( 'display_name' ); ?></a>
                        </div>
                        <div class="entry-content">
                                <p><?php the_author_meta( 'description' ); ?></p>
                        </div>
                        <ul class="author-bio-social">
								<?php if ( get_the_author_meta( 'url' ) ) : ?>
	                                <li><a href="<?php the_author_meta( 'url' ); ?>"><i class="momizat-icon-home2"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'twitter' ) ) : ?>
	                                <li class="twitter"><a href="<?php the_author_meta( 'twitter' ); ?>"><i class="momizat-icon-twitter"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'facebook' ) ) : ?>
	                                <li class="fb"><a href="<?php the_author_meta( 'facebook' ); ?>"><i class="enotype-icon-facebook"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'googleplus' ) ) : ?>
	                                <li class="google"><a href="<?php the_author_meta( 'googleplus' ); ?>?rel=author"><i class="momizat-icon-google-plus"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'youtube' ) ) : ?>
	                                <li class="youtube"><a href="<?php the_author_meta( 'youtube' ); ?>"><i class="fa-icon-youtube"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
	                                <li class="linkedin"><a href="<?php the_author_meta( 'linkedin' ); ?>"><i class="fa-icon-linkedin"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
	                                <li class="pin"><a href="<?php the_author_meta( 'pinterest' ); ?>"><i class="enotype-icon-pinterest"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'flickr' ) ) : ?>
	                                <li class="flicker"><a href="<?php the_author_meta( 'flickr' ); ?>"><i class="fa-icon-flickr"></i></a></li>
	                            <?php endif ?>
	                            <?php if ( get_the_author_meta( 'dribbble' ) ) : ?>
	                                <li class="dribble"><a href="<?php the_author_meta( 'dribbble' ); ?>"><i class="fa-icon-dribbble"></i></a></li>
	                            <?php endif ?>
	                            <?php if(mom_option('email-author-box') != 0) { ?>
	                            <?php if ( get_the_author_meta( 'email' ) ) : ?>
	                                <li><a href="mailto:<?php the_author_meta( 'email' ); ?>"><i class="dashicons dashicons-email-alt"></i></a></li>
	                            <?php endif ?>
	                            <?php } ?>
	                        </ul>
                </div>
        </div>
</section>