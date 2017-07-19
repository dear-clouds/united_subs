<?php if (function_exists('is_bbpress') && is_bbpress()) {
            get_template_part( 'bbpress', 'page' );
} elseif (function_exists('is_buddypress') && is_buddypress()) {
            get_template_part( 'buddypress', 'page' );
 } else { ?>
<?php get_header(); ?>

<?php
    global $post;
    //page layout
    $layout = get_post_meta($post->ID, 'mom_page_layout', true);
    $icon = get_post_meta($post->ID, 'mom_page_icon', true);
    $custom = get_post_meta($post->ID, 'mom_background_tr', true);
    $PS = get_post_meta(get_the_ID(), 'mom_page_share', true);
    $PC = get_post_meta(get_the_ID(), 'mom_page_comments', true);
    $pagebreadcrumb = get_post_meta($post->ID, 'mom_hide_breadcrumb', true);

    if ($layout == '') {
    	$layout = mom_option('page_layout');
    }
    
    //unique posts variable
    $unique_posts = '';
    $unique_posts = get_post_meta(get_queried_object_id(), 'mom_unique_posts', true);
    if(empty($unique_posts)) {
        $unique_posts = mom_option('uni_posts');
    } 
    ?>
	<div class="main-container clearfix"><!--container-->
		<?php if (! is_front_page()) { ?>
		<?php if(mom_option('breadcrumb') != 0) { ?>
		<?php if ($pagebreadcrumb != true) { ?>
		 <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
		 	<?php if($icon != '') {
				if (0 === strpos($icon, 'http')) {
					echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$icon.')"></i></div>';
				} else {
					echo '<div class="crumb-icon"><i class="'.$icon.'"></i></div>';
				}
				    
			} ?>
           <?php mom_breadcrumb(); ?>
            <?php the_title(); ?>
        </div>
        <?php } ?>
        <?php } else { ?>
			<span class="mom-page-title"><h1><?php the_title(); ?></h1></span>
		<?php } ?>
		<?php } ?>
        		
        
		<?php if ($layout == 'fullwidth') { ?>
				<?php if($custom) { 
                    if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); 
                    endwhile; else:
                    endif;      
                    wp_reset_query();
				} else { ?>
					<div class="site-content page-wrap">
			            <div class="entry-content clearfix">
			            <?php
	                    if ( have_posts() ) : while ( have_posts() ) : the_post();
	                        the_content();
	                        wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); 
	                    endwhile; else:
	                    endif;      
	                    wp_reset_query();
	                    ?>
					<?php if ($PS == 1) mom_posts_share(get_the_ID(), get_permalink()); ?>
					<?php if ($PC == 1) comments_template(); ?>    
			            </div>
					</div>
				<?php } ?>
		<?php } else { ?>
				<?php if($custom) { ?> 
					<div class="main-left"><!--Main Left-->
			            <div class="main-content" role="main"><!--Main Content-->
			        <?php    
                    if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); 
                    endwhile; else:
                    endif;      
                    wp_reset_query();
                    ?>
                    	</div>
                    	 <?php get_sidebar('left'); ?>
					</div>
					<?php get_sidebar(); ?>
				<?php } else { ?>
					<div class="main-left"><!--Main Left-->
			            <div class="main-content" role="main"><!--Main Content-->
							<div class="site-content page-wrap">
								<div class="entry-content clearfix">
					            <?php
			                    if ( have_posts() ) : while ( have_posts() ) : the_post();
			                        the_content();
			                        wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); 
			                    endwhile; else:
			                    endif;      
			                    wp_reset_query();
			                    ?>
			                    <?php if ($PS == 1) mom_posts_share(get_the_ID(), get_permalink()); ?>
								<?php if ($PC == 1) comments_template(); ?>    
								</div>
							</div> 
			            </div>
			            <?php get_sidebar('left'); ?>
					</div>
					<?php get_sidebar(); ?>
				<?php } ?>
		<?php } ?>
	
    </div><!--container-->

</div><!--wrap-->
            
<?php get_footer(); ?>
<?php } ?>