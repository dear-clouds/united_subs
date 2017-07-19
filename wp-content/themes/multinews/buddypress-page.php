<?php get_header(); ?>
<?php
    global $post;
    //page layout
    $p_id = get_queried_object_id();
    $layout = get_post_meta($p_id, 'mom_page_layout', true);
    $icon = get_post_meta($p_id, 'mom_page_icon', true);
    if($icon == ''){
    	$icon = mom_option(''); 
    }
    $custom = get_post_meta($p_id, 'mom_background_tr', true);
    $PS = get_post_meta($p_id, 'mom_page_share', true);
    $PC = get_post_meta($p_id, 'mom_page_comments', true);
    $pagebreadcrumb = get_post_meta($p_id, 'mom_hide_breadcrumb', true);
    
    if ($layout == '') {
        $layout = mom_option('bbpress_layout');
    }


?>
	<div class="main-container"><!--container-->
		
		<?php if($custom == '') { ?>
		<?php if(mom_option('breadcrumb') != 0) { ?>
		<?php if ($pagebreadcrumb != true) { ?>
		 <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
		 	<?php if($icon != '') { ?>
            <div class="crumb-icon"><i class="<?php echo $icon; ?>"></i></div>
            <?php } ?>
            <?php mom_breadcrumb(); ?>
	    <?php
	    		if (function_exists('bp_is_active')) {
			    if ( bp_is_user() && !bp_is_register_page() ) { ?>
				<?php echo bp_user_fullname(); ?>
			<?php } else {
			    the_title();
			}
			}

	    ?>
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
					<?php if ($PS == true) mom_posts_share(get_the_ID(), get_permalink()); ?>
					<?php if ($PC == true) comments_template(); ?>    
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
			                    <?php if ($PS == true) mom_posts_share(get_the_ID(), get_permalink()); ?>
								<?php if ($PC == true) comments_template(); ?>    
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