<?php
/*
	Template name: Magazine
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
    header('X-UA-Compatible: IE=edge,chrome=1');
    ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    
	<?php if(mom_option('enable_responsive') != true) { ?>
	<meta name="viewport" content="user-scalable=yes, minimum-scale=0.25, maximum-scale=3.0" />
	<?php } else {  ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php } ?>
    <?php if(mom_option('sharee_print') != 0) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo MOM_CSS; ?>/print.css" media="print" />
    <?php } ?>
	<?php if ( mom_option('custom_favicon') != 'false') { ?>
	<link rel="shortcut icon" href="<?php echo mom_option('custom_favicon', 'url'); ?>" />
	<?php } ?>
	<?php if ( mom_option('apple_touch_icon', 'url') != '') { ?>
	<link rel="apple-touch-icon" href="<?php echo mom_option('apple_touch_icon', 'url'); ?>" />
	<?php } else { ?>
	<link rel="apple-touch-icon" href="<?php echo MOM_URI; ?>/apple-touch-icon-precomposed.png" />
	<?php } ?> 
<?php wp_head(); ?>
	<?php $dateformat = mom_option('date_format'); ?>
    <?php
	global $post;
    $magdisplay = get_post_meta($post->ID, 'mom_mag_display', true);
    $orderby = get_post_meta($post->ID, 'mom_mag_orderby', true);
    $magcat = get_post_meta($post->ID, 'mom_mag_cat', true);
    $magposts = get_post_meta($post->ID, 'mom_mag_posts', true);
    $maglogo = get_post_meta($post->ID, 'mom_mag_logo', true);
    if($maglogo == '') {
		$maglogo = MOM_IMG. '/magazine-logo.png';    
    }
    $magauto = get_post_meta($post->ID, 'mom_mag_auto', true);
    $maginterval = get_post_meta($post->ID, 'mom_mag_interval', true);

    $excats = get_post_meta($post->ID, 'mom_exc_cats', true);
    
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
		$direction = '';
		if(is_rtl()) {
			$direction = 'rtl';
		} else {
			$direction = 'ltr';
		}
		if ($maginterval == '') {
			$maginterval = 3000;
		}

    ?>
    </head>
    <body <?php body_class('magazine-wrap'); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	    	<header class="fixed-header">
		    	<div class="inner">
			    	<div class="logo" itemscope="itemscope" itemtype="http://schema.org/Organization">
		                <a href="<?php echo esc_url(home_url()); ?>" itemprop="url" title="<?php bloginfo('name'); ?>"><img itemprop="logo" src="<?php echo $maglogo; ?>" alt="<?php bloginfo('name'); ?>"></a>
		                <meta itemprop="name" content="<?php bloginfo('name'); ?>">
		            </div>
		            
		            <?php get_template_part( 'framework/includes/navigation' ); ?>
		            
		    	</div>
	    	</header>
	    	
	    	<div class="magazine-container">
			<div class="bb-custom-wrapper">
				
				<div id="bb-bookblock" class="bb-bookblock" data-autoplay="<?php echo $magauto; ?>" data-timeout="<?php echo $maginterval; ?>" data-direction="<?php echo $direction; ?>">
					<?php
                                        if($magdisplay == 'cat'){
                                        	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $magcat, 'posts_per_page' => $magposts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false ) );
                                        } else {
                                        	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $magposts, 'orderby' => $orderby, 'cat' => $excats, 'no_found_rows' => true, 'cache_results' => false ) );
                                        }
	                                    update_post_thumbnail_cache( $query );


                                        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                                        ?>
                                            <div class="bb-item" itemscope="" itemtype="http://schema.org/Article">
                                            	<!-- Loading -->
                                            	<div id="circularG">
													<img src="<?php echo MOM_IMG ?>/mag-loader.gif">
												</div>
                                            	<!-- Loading -->
                                                <div itemprop="image" class="magazine-page-img" style="background-image: url(<?php echo mom_post_image('full'); ?>);background-attachment: scroll;"></div>
                                                <div class="ma-content-wrap">
                                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                                        <?php if($post_head != 0) { ?>
                                                        <div class="entry-meta">
													    <?php if($post_head_author != 0) { ?>
													    <div class="author-link">
			                                            <?php _e('Posted by: ', 'framework'); ?><a itemprop="author" href="get_author_posts_url( get_the_author_meta( 'ID' ) );" rel="author"><?php echo get_the_author() ?></a>
			                                            </div>
			                                            <?php } ?>
			                                            <?php if($post_head_date != 0) { ?>
			                                            <div class="entry-date">
			                                            <?php _e('Date:', 'framework'); ?> <time datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time($dateformat); ?></time>
			                                            </div>
			                                            <?php } ?>
			                                            <?php if($post_head_cat != 0) { ?>
			                                            <div class="cat-link">
			                                            <?php _e('in:', 'framework'); ?> <a href=""><?php the_category(', ') ?> </a>
			                                            </div>
			                                            <?php } ?>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="entry-content">
                                                                <p>
                                                                    <?php global $post;
                                                                    $excerpt = $post->post_excerpt;
                                                                    if($excerpt==''){
                                                                    $excerpt = get_the_content('');
                                                                    }
                                                                    echo wp_html_excerpt(strip_shortcodes($excerpt), 245);
                                                                    ?> ...
                                                                </p>
                                                        </div>
                                                        <?php if(is_rtl()) { ?>
                                                        <a class="read-more" href="<?php the_permalink(); ?>"><i class="fa-icon-angle-double-left"></i> <?php _e('Read more', 'framework'); ?></a>
                                                        <?php } else { ?>
                                                        <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-right"></i></a>
														<?php } ?>
                                                </div>
                                            </div>
					<?php
                                        endwhile;
                                        else:
                                        endif;
                                        wp_reset_postdata();
                                        ?>
				</div>

				<nav class="magazine-nav">
					<a id="bb-nav-prev" href="#" class="bb-custom-icon bb-custom-left"><i class="enotype-icon-arrow-left7"></i></a>
					<a id="bb-nav-next" href="#" class="bb-custom-icon bb-custom-right"><i class="enotype-icon-uniE6D8"></i></a>
				</nav>

			</div>

		</div><!-- /container -->
             <?php wp_footer(); ?>
	</body>
</html>	    	