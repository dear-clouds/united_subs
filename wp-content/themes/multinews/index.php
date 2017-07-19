<?php get_header(); ?>
        <div class="main-container clearfix"><!--container-->       
            <div class="main-left"><!--Main Left-->
                <div class="main-content" role="main"><!--Main Content-->
                    <?php
                    	$display = mom_option('hp-display');
                    	$style = mom_option('hp-blog-style');
                    	$post = mom_option('hp-blog-posts');
                        $unique_posts = '';
                        $unique_posts = mom_option('uni_posts');
                    	if($display == 'builder') {
                        	echo apply_filters('the_content', mom_option('home_page_builder'));
                    	} else {
                        	echo do_shortcode('[blog style="'.$style.'" posts_per_page="'.$post.'"]');
                    	}	 
                    ?>                   	                        	
                </div><!--Main Content-->                
                <?php get_sidebar('left'); ?>                
            </div><!--Main left-->               
            <?php get_sidebar(); ?>                                 
        </div><!--container-->
    </div><!--wrap-->   
<?php get_footer(); ?>