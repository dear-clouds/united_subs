<?php 
	get_header();
	  $layout = mom_option('category_layout');
  if ($layout == '') {
    $layout = mom_option('main_layout');
  }

	$cat_data = get_option("category_".get_query_var('cat'));
	$cat_icon = isset($cat_data['icon']) ? $cat_data['icon'] : '' ;
	$cat_slider = isset($cat_data['slider']) ? $cat_data['slider'] : '' ;
	$cat_layout = isset($cat_data['layout']) ? $cat_data['layout'] : '' ;
	$cat_layout_style = isset($cat_data['layout_style']) ? $cat_data['layout_style'] : '' ;
	$dateformat = mom_option('date_format');
	
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
?>
                
                <div class="main-container"><!--container-->
                    
                    <?php if(mom_option('breadcrumb') != 0) { ?>
                    <?php if(mom_option('cats_bread')) { 
	                  $cclass = '';
	                  if(mom_option('cat_slider') == false or $cat_slider == '0') {
		              	$cclass = 'post-crumbs ';    
	                  }  
                    ?>
                    <div class="<?php echo $cclass; ?>entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <?php if ($cat_icon != '') { 
				if (0 === strpos($cat_icon, 'http')) {
					echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$cat_icon.')"></i></div>';
				} else {
					echo '<div class="crumb-icon"><i class="'.$cat_icon.'"></i></div>';
				}
			} ?>
                        <?php mom_breadcrumb(); ?>
                        
                        <?php
                        if(mom_option('cat_rss')) {
                        $category = get_category( get_query_var('cat') );
                        if ( ! empty( $category ) ) {
                        ?>
                        <span class="cat-feed"><a href="<?php echo get_category_feed_link( $category->cat_ID ); ?>" rel="nofollow"><i class="enotype-icon-rss"></i></a></span>
                        <?php } } ?>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    
                    <?php if(mom_option('cat_slider') != false) { if ($cat_slider != '0') { get_template_part( 'framework/includes/category-slider' ); } } ?>
                    
                    <?php
                    if(mom_option('cat_desc')) { 
                    $category_description = category_description();
                    if ( ! empty( $category_description ) ) {
                    ?>
                    <section class="section cat-desc">
                    	<?php echo $category_description; ?>
                    </section>
                    <?php } } ?>
                    <?php if($layout == 'fullwidth') { ?>
                            <?php mom_category_content(3); ?>
		    <?php } else { ?>
                    <div class="main-left"><!--Main Left-->
                        <div class="main-content" role="main"><!--Main Content-->
                            <?php mom_category_content(); ?>
                        </div><!--Main Content-->
                        <?php get_sidebar('left'); ?>                    
                    </div><!--Main left-->
                    <?php get_sidebar(); ?>
		    <?php } ?>

                </div><!--container-->
    
            </div><!--wrap-->
            
            <?php get_footer(); ?>