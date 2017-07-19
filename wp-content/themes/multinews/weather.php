<?php
/*
Template Name: Weather Page
*/
?>

<?php get_header(); 
	global $post;
	$layout = get_post_meta(get_the_ID(), 'mom_page_layout', true);
    $weatherlocation = get_post_meta($post->ID, 'mom_we_location', true);
    $lang = get_post_meta($post->ID, 'mom_we_language', true);
    $units = get_post_meta($post->ID, 'mom_we_d_unit', true);
    $display = get_post_meta($post->ID, 'mom_we_city_title', true);
    $PS = get_post_meta(get_the_ID(), 'mom_page_share', true);
    $PC = get_post_meta(get_the_ID(), 'mom_page_comments', true);
?>
<?php mom_weather_page($weatherlocation, $units, 'm/d/Y', $lang, $display); ?>
                 
                <div class="main-container"><!--container--> 
                                
                   	<?php if ($layout != 'fullwidth') { ?>	 
                    <div class="main-left"><!--Main Left-->
                        <div class="main-content" role="main"><!--Main Content-->
                    <?php } ?>
                            <div class="site-content page-wrap">
								

									<header class="block-title weather-maps">
										<h2><?php the_title(); ?></h2>
									</header>
								
                                <?php 
                                 if ( have_posts() ) : while ( have_posts() ) : the_post();
                                	the_content();
                                	wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) );  
                                    endwhile; else : 
                                    endif;
                                ?>
                                <?php if ($PS != false) { mom_posts_share(get_the_ID(),get_permalink()); } ?>
								<?php if ($PC != false) { comments_template(); } ?> 
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