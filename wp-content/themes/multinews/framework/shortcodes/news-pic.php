<?php
function mom_news_pics($atts, $content = null) {
    global $unique_posts;
	global $do_unique_posts;
    extract(shortcode_atts(array(
        'title' => 'Latest Posts',
		'display' => '',
		'cat' => '',
		'tag' => '',
		'orderby' => '',
		'count' => '8',
        'class' => ''
	), $atts));
        static $id = 75;
        $id++;
    
$output = get_transient('mom_news_pix_'.$id);
if ($output == false) { 
   
    ob_start();
    
    global $wpdb;
        $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE 'name' = '".$tag."'");
        
        if($display == 'category') {
            $np_title = get_cat_name($cat);
            $np_link = get_category_link($cat);
        } elseif ($display == 'tag') {
            $np_title = $tag;
            $np_link = get_tag_link($tag_ID);
        } else {
            $np_title = $title;
            $np_link = '#';
        }
?>
<section class="section <?php echo $class; ?> nip-box <?php if($display == 'category') { ?>cat_<?php echo $cat ; } ?>"><!--news pics-->
    <header class="block-title">
        <h2><?php echo $np_title; ?></h2>
    </header>
    
    <div class="nip clearfix">
            <?php
            if($display == 'category') {
            	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cat, 'posts_per_page' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
            } elseif($display == 'tag') {
            	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
            } else {
            	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
            }
            update_post_thumbnail_cache( $query );
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
            if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
            ?>
            <?php if( mom_post_image() != false ) { ?>
            <div class="first-item">
                <figure class="post-thumbnail"><a class="simptip-position-top simptip-movable half-arrow simptip-multiline" href="<?php the_permalink(); ?>" data-tooltip="<?php echo esc_attr(get_the_title()); ?>">
                    <?php mom_post_image_full('npic-thumb'); ?>
                </a></figure>
            </div>
            <?php } ?>
            <?php
            endwhile;
            else:
            endif;
            wp_reset_postdata();
            ?>
            <ul>
                    <?php
                    if($display == 'category') {
                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cat, 'posts_per_page' => $count, 'offset' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                    } elseif($display == 'tag') {
                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => $count, 'offset' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                    } else {
                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $count, 'offset' => 1, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                    }
                    update_post_thumbnail_cache( $query );
                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                    if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
                    ?>
                    <?php if( mom_post_image() != false ) { ?>
                    <li class="simptip-position-top simptip-movable half-arrow simptip-multiline" data-tooltip="<?php echo esc_attr(get_the_title()); ?>">
                    <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                        <?php mom_post_image_full('np-thumb'); ?>
                    </a></figure>
                    </li>
                    <?php } ?>
                    <?php
                    endwhile;
                    else:
                    endif;
                    wp_reset_postdata();
                    ?>
            </ul>
        </div>
    
</section><!--news pics-->
<?php
      $output = ob_get_contents();
      ob_end_clean();
        set_transient('mom_news_pix_'.$id, $output, 60*60*24);
  }
   return $output;
}
add_shortcode("newspic", "mom_news_pics");