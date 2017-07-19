<?php
function mom_scrollers($atts, $content = null) {
	
	global $unique_posts;
	global $do_unique_posts;
	
	extract(shortcode_atts(array(
      'style' => 'sc1',
      'title' => '',
      'title_size' => '17',
      'sub_title' => '',
  		'display' => 'latest',
  		'cats' => '',
  		'tags' => '',
  		'orderby' => '',
  		'number_of_posts' => '5',
  		'auto_play' => '3000',
  		'speed' => '300',
      'items' => '4',
	), $atts));
        static $id = 75;
        $id++;
	if ($cats == 'Select a Category') { $cats = '';}
  if ($tags == 'Select a Tag') { $tags = '';}

$output = get_transient('mom_scroller_'.$id.$style.$display.$cats.$tags.$items.$orderby);
if ($orderby == 'rand') {
  $output = false;
}
if ($output == false) { 
	ob_start();
	//wp_enqueue_script('owl');
        
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
        $authormeta = mom_option('post_head_author');
        $rndn = rand(0,100);
            
        global $wpdb;
        $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE 'name' = '".$tags."'");
        
        $nb_link = '';
        if($display == 'cats') {
        	if($title == '') { 
	            $nb_title = get_cat_name($cats);
	            $nb_link = get_category_link($cats);
            } else {
				$nb_title = $title;
            }
        } elseif ($display == 'tags') {
        	if($title == '') { 
	            $nb_title = $tags;
	            $nb_link = get_tag_link($tag_ID);
	        } else {
				$nb_title = $title;
            }
        } else {
            $nb_title = $title;
            $nb_link = '';
        }
        
        if($auto_play != '') {
	        $autoplay = 'true';
        } else {
	        $autoplay = 'false';
        }

        if(is_rtl()) {
          $rtl = 'true';
        } else {
          $rtl = 'false';
        }

	$link_start = '';
	$link_end = '';
	if ($nb_link != '') {
		$link_start = '<a href="'.$nb_link .'">';
		$link_end = '</a>';
	}
	?>
                
                <?php if($style == 'sc1') { ?>
                                
                    <section class="section scroller-section scroller-<?php echo $id;?>">
                        
                        <header class="section-header">
                        	<?php if($title_size == '17') { ?>
                            <h2 class="section-title"><?php echo $link_start.$nb_title.$link_end; ?></h2>
                            <?php } else { ?>
                            <h1 class="section-title2"><?php echo $link_start.$nb_title.$link_end; ?></h1>
                            <?php } ?>
                            <?php if($sub_title != '') { ?><span class="mom-sub-title"><?php echo $sub_title; ?></span><?php } ?>
                        </header>
                        
                        <div class="scroller">
                            <div class="scroller-wrap scroller-wrap-1" data-sc-auto="<?php echo $autoplay; ?>" data-sc-autotime="<?php echo $auto_play; ?>" data-sc-speed="<?php echo $speed ; ?>" data-sc-rtl="<?php echo $rtl; ?>" data-items="<?php echo $items; ?>">
                                <?php
	                            if($display == 'cats') {
	                            	$squery = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cats, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            } elseif($display == 'tags') {
	                                $squery = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tags, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            } else {
	                                $squery = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            }
                                update_post_thumbnail_cache( $squery );
	                            if ( $squery->have_posts() ) : while ( $squery->have_posts() ) : $squery->the_post();
	                            if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
                              $post_url = get_post_meta(get_the_ID(), 'mom_post_custom_link', true);
                              if ($post_url == '') {
                                $post_url = get_permalink();
                              }
	                            ?>
                               <?php if( mom_post_image() != false ) { ?>
                                <div class="scroller-item">
                                    <a itemprop="url" href="<?php echo $post_url; ?>">
                                        <figure class="post-thumbnail">
                                          <?php mom_post_image_full('scroller-thumb'); ?>
                                        </figure>
                                        <h2 itemprop="headline"><?php the_title(); ?></h2>
                                         </a>
                                        <?php if($post_head != 0) { ?>
                                        <div class="entry-meta">
                                            <?php if ($post_head_author == 1) { ?>
					    <div class="author-link">
                                                <i class="momizat-icon-user3"></i><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
                                            </div>
					    <?php } ?>
					    <?php if($post_head_date != 0) { ?>
                                            <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><i class="momizat-icon-calendar"></i><?php the_time('Y/m/d'); ?></time>
                                            <?php } ?>
					    <?php if($post_head_cat != 0) { ?>
					    <div class="cat-link">
                                                <i class="momizat-icon-folder-open"></i><?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
                                            </div>
					    <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>
                                <?php } ?>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                        
                    </section>
                <?php } else { ?>
                            	
                    <section class="section scroller-section scroller-<?php echo $id;?>">
                        <header class="section-header">
                            <?php if($title_size == '17') { ?>
                            <h2 class="section-title"><?php echo $link_start.$nb_title.$link_end; ?></h2>
                            <?php } else { ?>
                            <h1 class="section-title2"><?php echo $link_start.$nb_title.$link_end; ?></h1>
                            <?php } ?>
                            <?php if($sub_title != '') { ?><span class="mom-sub-title"><?php echo $sub_title; ?></span><?php } ?>
                        </header>
                        
                        <div class="scroller2">
                            <div class="scroller2-wrap scroller-wrap-2" data-sc2-auto="<?php echo $autoplay; ?>" data-sc2-autotime="<?php echo $auto_play; ?>" data-sc2-speed="<?php echo $speed ; ?>" data-sc2-rtl="<?php echo $rtl; ?>" data-items="<?php echo $items; ?>">
                               <?php
	                            if($display == 'cats') {
	                            	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cats, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            } elseif($display == 'tags') {
	                                $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tags, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            } else {
	                                $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
	                            }
                                update_post_thumbnail_cache( $query );
	                            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
	                            if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
                              $post_url = get_post_meta(get_the_ID(), 'mom_post_custom_link', true);
                              if ($post_url == '') {
                                $post_url = get_permalink();
                              }                              
	                            ?>
                                <div class="scroller-item">
                                    <a itemprop="url" href="<?php echo $post_url; ?>">
                                <?php if( mom_post_image() != false ) { ?>
                                        <figure class="post-thumbnail">
                                            <?php mom_post_image_full('scroller-thumb'); ?>
                                        </figure>

                                        <?php } ?>
                                        <h2 itemprop="headline"><?php the_title(); ?></h2>
                                    </a>
                                        <?php if($post_head != 0) { ?>
                                        <div class="entry-meta">
                                            <?php if ($post_head_author == 1) { ?>
					    <div class="author-link">
                                                <i class="momizat-icon-user3"></i><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
                                            </div>
					    <?php } ?>
					    <?php if($post_head_date != 0) { ?>
                                            <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><i class="momizat-icon-calendar"></i><?php the_time('Y/m/d'); ?></time>
                                            <?php } ?>
					    <?php if($post_head_cat != 0) { ?>
					    <div class="cat-link">
                                                <i class="momizat-icon-folder-open"></i><?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
                                            </div>
					    <?php } ?>
                                        </div>
                                <?php } ?>
        
                                </div>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </section>
          
                <?php } ?>
	<?php 
      $output = ob_get_contents();
      ob_end_clean();
        set_transient('mom_scroller_'.$id.$style.$display.$cats.$tags.$items.$orderby, $output, 60*60*24);
  }

      return $output;
}
add_shortcode("scroller", "mom_scrollers");