<?php get_header(); 
$pageLayout = mom_option('page_layout');
$post_meta_hp = mom_option('post_meta_hp');
$dateformat = mom_option('date_format');
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
                    <?php if(mom_option('archives_bread') != false) { ?>
                    <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                    	<?php if(mom_option('archives_icon')) { ?>
                        <div class="crumb-icon"><i class="brankic-icon-archive"></i></div> 
                        <?php } ?>                       
                        <?php mom_breadcrumb(); ?>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    
                <?php if(is_tag() && tag_description() != '') { ?>
				<div class="tag_desc base-box mom_box_sc_ mom_box_sc clear">
                    <?php echo do_shortcode(tag_description()); ?>
                </div>
                <?php } ?>                
					
                    <div class="main-left"><!--Main Left-->
                        <div class="main-content" role="main"><!--Main Content-->
                            
                            <div class="site-content page-wrap">
                                <?php if(mom_option('archive_swi')) { ?>
                                <div class="f-tabbed-head">
                                    <ul class="f-tabbed-sort cat-sort">
                                        <li class="grid active"><a href="#"><span class="brankic-icon-grid"></span><?php _e(' Grid', 'framework') ?></a></li>
                                        <li class="list"><a href="#"><span class="brankic-icon-list2"></span><?php _e(' List', 'framework') ?></a></li>
                                    </ul>
                                </div>
                                <?php } ?>
                                <?php 
                                $catswi = mom_option('archive_swi_def');
                                $swiclass = 'cat-grid';
                                if($catswi == 'list') {
	                                $swiclass = 'cat-list';
                                }
                                $srclass = '';
                                if(mom_option('archive_swi') != true) {
	                                $srclass = ' no-head';	
                                }
                                ?>
                                <div class="cat-body<?php echo $srclass; ?>">
                                    <ul class="nb1 <?php echo $swiclass; ?> clearfix">
	                                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                                        <li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
	                                            <h2 itemprop="name" class="cat-list-title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <?php if($post_head != 0) { ?>
	                                            <div class="cat-list-meta entry-meta">
	                                                <?php if($post_head_author != 0) { ?>
	                                                <div class="author-link">
	                                                <?php _e('Posted by', 'framework') ?> <a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
	                                                </div>
	                                                <?php } ?>
	                                                <?php if($post_head_date != 0) { ?>
	                                                <span>|</span><time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php _e('Date: ', 'framework') ?><?php the_time($dateformat); ?></time> 
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
	                                            <h2 itemprop="name" class="cat-grid-title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <div class="entry-content cat-grid-meta">
	                                                <p>
	                                                    <?php global $post;
	                                                    $excerpt = $post->post_excerpt;
	                                                    if($excerpt==''){
	                                                    $excerpt = get_the_content('');
	                                                    }
	                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),105);
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
		                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),200);
		                                                    ?> ...
		                                                </p>
		                                            </div>
		                                            <?php if($post_head != 0) { ?>
		                                            <div class="cat-grid-meta entry-meta">
		                                            	<?php if($post_head_date != 0) { ?>
		                                                <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time($dateformat); ?> </time>
		                                                <?php } ?>
		                                                <?php if($post_head_author != 0) { ?>
		                                                <div class="author-link">
		                                                    |<?php _e(' by ', 'framework') ?><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
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
	                                        <?php
	                                        endwhile;
	                                        else:  ?>
	                                        <!-- Else in here -->
	                                        <?php endif; ?>
	                                    </ul>
                                    
                                    <?php mom_pagination(); ?>
                                </div>
                                
                            </div>
                            
                        </div><!--Main Content-->
                        <?php get_sidebar('left'); ?>
                    </div><!--Main left-->
                    
                    <?php get_sidebar(); ?>

                </div><!--container-->
    
            </div><!--wrap-->
            
            <?php get_footer(); ?>