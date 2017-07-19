<?php 
    $br_enb = '';
    if( mom_option('bn_bar_news') == false ) {
    $br_enb = ' brnews-disable';
    }
    
    $br_login = '';
    if (mom_option('bar_login') == 1) {
    $br_login = ' nav-login-on';
    }

     $speed = mom_option('bn_scroll_speed');
    if ($speed == '') {
    $speed = 0.07;
    } else {
    $speed = $speed/100;
    }

    $bspeed = mom_option('bn_speed');
    $duration = mom_option('bn_duration');

    if(mom_option('bn_type') == 'up') {
        $type = 'right';
    } elseif(mom_option('bn_type') == 'fade') {
        $type = 'fade';
    } else {
        $type = 'default';
    }
    $target = '';
    if (mom_option('bn_bar_links_open') == 1) {
        $target = 'target="_blank"';
    }
?>
<div class="breaking-news<?php echo $br_enb; ?><?php echo $br_login; ?>"><!--breaking news-->
    <div class="inner"><!--inner-->
        
    <?php if( mom_option('bn_bar_news') != false ) { ?>
    <div class="breaking-news-items">
        <span class="breaking-title"><?php echo mom_option('bn_bar_title'); ?></span>
        <div class="breaking-cont">
            <ul class="webticker" data-br_type="<?php echo $type; ?>" data-br_speed="<?php echo $speed; ?>" data-br_bspeed="<?php echo $bspeed; ?>" data-br_duration="<?php echo $duration; ?>">
                <?php
                $numposts = mom_option('num_br_posts');
                $rssfeed = mom_option('bn_bar_rss');
                if (mom_option('bn_bar_display') == 'rss') {
                    include_once( ABSPATH . WPINC . '/feed.php' );
                    $rss = fetch_feed( $rssfeed );
                    if ( ! is_wp_error( $rss ) ) : 
                    $maxitems = $rss->get_item_quantity( $numposts ); 
                    $rss_items = $rss->get_items( 0, $maxitems );
                    endif;
                ?>
                    <?php if ( $maxitems == 0 ) : ?>
                        <li><?php _e( 'No items', 'framework' ); ?></li>
                    <?php else : ?>
                        <?php foreach ( $rss_items as $item ) : ?>
                            <li><h4><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span><a <?php echo $target; ?>href="<?php echo esc_url( $item->get_permalink() ); ?>" rel="bookmark"><?php echo esc_html( $item->get_title() ); ?></a></h4></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php
                } elseif (mom_option('bn_bar_display') == 'cats') {
                    $bn_query = new WP_Query( array( 'cat' => implode(', ',mom_option('bn_bar_cats')), 'posts_per_page' => $numposts, 'no_found_rows' => true, 'cache_results' => false ) );
                    if ( $bn_query->have_posts() ) : while ( $bn_query->have_posts() ) : $bn_query->the_post(); ?>
                    <li><h4><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span><a <?php echo $target; ?>href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4></li>
                <?php endwhile; else: endif; wp_reset_postdata();
                } elseif (mom_option('bn_bar_display') == 'tags') {
            $tags = explode(',', mom_option('bn_bar_tags'));
                    $bn_query = new WP_Query( array( 'tag__in' => $tags, 'posts_per_page' => $numposts, 'no_found_rows' => true, 'cache_results' => false ) );
                    if ( $bn_query->have_posts() ) : while ( $bn_query->have_posts() ) : $bn_query->the_post(); ?>
                    <li><h4><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span><a <?php echo $target; ?>href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4></li>
                <?php endwhile; else: endif; wp_reset_postdata();
                } elseif (mom_option('bn_bar_display') == 'custom') { ?>
                  <?php
                    $bn_custom = '<li><h4 itemprop="name"><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</h4></li>\n<li><h4 itemprop='name'><span class='enotype-icon-arrow-right6'></span>"),trim(mom_option('bn_bar_custom'),"\n\r")).'</h4></li>';
                    echo $bn_custom;
                } elseif(mom_option('bn_bar_display') == 'modified') {
                    $query = new WP_Query( array( 'posts_per_page' => -1, 'post_type' => 'post', 'no_found_rows' => true, 'cache_results' => false, 'orderby' => 'modified', 
                                'date_query' => array(
        array(
            'column' => 'post_modified_gmt',
            'after' => '2 days ago',
        ),
     )

                     ) );
                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
                    global $post;
                    $cat_ID = get_the_category( $post->ID );
                    if ($cat_ID != false) {
                    $cat_ID = $cat_ID[0]->term_id;
                    }   

                    $cat_color = '';
                    if ($cat_ID != false) {
                        $cat_data = get_option("category_".$cat_ID);
                        $cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;
                    } 
                    ?>
                    <li><h4><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span><a <?php echo $target; ?>href="<?php the_permalink(); ?>" rel="bookmark" style="color:<?php echo $cat_color; ?>"><?php the_title(); ?></a></h4></li>
                <?php endwhile; else: endif; wp_reset_postdata();
                } else {
                    $query = new WP_Query( array( 'posts_per_page' => $numposts, 'post_type' => 'post', 'no_found_rows' => true, 'cache_results' => false ) );
                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li><h4><span class="<?php if(is_rtl()) { ?>enotype-icon-arrow-left6<?php } else { ?>enotype-icon-arrow-right6<?php } ?>"></span><a <?php echo $target; ?>href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4></li>
                <?php endwhile; else: endif; wp_reset_postdata();
                }
                ?>
            </ul>
        </div>
    </div>  
    <?php } ?>
       
    <?php 
    if(mom_option('bn_bar_menu')) { ?>
    <div class="brmenu">
    <?php if ( has_nav_menu( 'breaking' ) ) {
    ?>
    <?php wp_nav_menu( array( 'container' => 'ul', 'menu_class' => 'br-right' , 'theme_location' => 'breaking', 'walker' => new mom_custom_Walker())); ?>
    <?php } ?>
    <?php if (mom_option('bar_login') == 1) { ?>
    <span class="nav-button nav-login">
        <i class="momizat-icon-users"></i>
    </span>
    <div class="nb-inner-wrap">
        <div class="nb-inner lw-inner">
        <?php mom_login_form(); ?>
        </div>
    </div>
    <?php } ?>
    </div>
    <?php }
    ?>
        
    </div><!--inner-->
</div><!--breaking news-->