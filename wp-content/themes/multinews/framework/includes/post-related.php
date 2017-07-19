<?php
$dateformat = mom_option('date_format');
?>
<section class="post-section-box">
        <header class="post-section-title">
                <h2><?php _e( 'Related posts', 'framework' ) ?></h2>
        </header>

        <ul class="mom-related-posts clearfix">
                <?php  if(mom_option('related_type') == 'tag') { ?>
                <?php
                global $post;
                $tags = wp_get_post_tags($post->ID);
                if ($tags) :
                $tag_ids = array();
                foreach($tags as $individual_tag){ $tag_ids[] = $individual_tag->term_id;}

                $args=array(
                'tag__in' => $tag_ids,
                'post__not_in' => array($post->ID),
                'showposts'=> mom_option('related_count'),
                'ignore_sticky_posts'=>1,
                'no_found_rows' => true,
                'cache_results' => false
                );

                $query = new WP_Query($args);
            update_post_thumbnail_cache($query);

                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                ?>
                <li>
                  <div class="related_posts_item_inner">
                		<?php if( mom_post_image() != false ) { ?>
                        <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                        <?php mom_post_image_full('related-thumb'); ?>
                        </a></figure>
                        <?php } ?>
                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <div class="entry-meta">
                        <time datetime="<?php the_time('c'); ?>" content="<?php the_time('c'); ?>"><?php the_time($dateformat); ?></time>
                        </div>
                    </div>
                </li>
                <?php
                endwhile;
                else:
                endif;
                wp_reset_postdata();
                endif;
                ?>
                <?php } else { ?>
                <?php
                global $post;
                $cats = get_the_category($post->ID);
                if ($cats) :
                    $cat_ids = array();
                    foreach($cats as $individual_cat){ $cat_ids[] = $individual_cat->cat_ID;}

                    $args=array(
                        'category__in' => $cat_ids,
                        'post__not_in' => array($post->ID),
                        'showposts'=>mom_option('related_count'),
                        'ignore_sticky_posts'=>1,
                        'no_found_rows' => true,
                        'cache_results' => false
                    );
                $query = new WP_Query($args);
            update_post_thumbnail_cache($query);

                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                ?>
                <li>
                  <div class="related_posts_item_inner">
                		<?php if( mom_post_image() != false ) { ?>
                        <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                        <?php mom_post_image_full('related-thumb'); ?>
                        </a></figure>
                        <?php } ?>
                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <div class="entry-meta">
                        <time datetime="<?php the_time('c'); ?>" content="<?php the_time('c'); ?>"><?php the_time($dateformat); ?></time>
                        </div>
                    </div>
                </li>
                <?php
                endwhile;
                else:
                endif;
                wp_reset_postdata();
                endif;
                ?>
                <?php } ?>
        </ul>
</section>
