<?php /* Template Name: Archive */ ?>
<?php 
get_header(); 
global $post;
	$pagebreadcrumb = get_post_meta($post->ID, 'mom_hide_breadcrumb', true);
	$icon = get_post_meta($post->ID, 'mom_page_icon', true);
	$archives = get_post_meta($post->ID, 'mom_arch_list', false);
?>
<div class="main-container">
    <!--container-->
	
	<?php if(mom_option('breadcrumb') != 0) { ?>
	<?php if ($pagebreadcrumb != true) { ?>
    <div class="archive-page entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                    	<?php if($icon != '') { 
				if (0 === strpos($icon, 'http')) {
					echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$icon.')"></i></div>';
				} else {
					echo '<div class="crumb-icon"><i class="'.$icon.'"></i></div>';
				}
				 } else { ?>
        <div class="crumb-icon">
            <i class="brankic-icon-archive"></i>
        </div>
        <?php } ?>
        <span>
            <?php the_title(); ?>
        </span>
    </div>
    <?php } ?>
    <?php } else { ?>
		<span class="mom-page-title"><h1><?php the_title(); ?></h1></span>
	<?php } ?>
	

    <div class="main-archive-content" role="main">
        <!--Main Content-->

        <div class="site-content page-wrap">

            <?php the_content(); ?>

            <div class="mom-archive clearfix">
                <ul>
					<?php if (in_array("cats", $archives)) { ?>                
                    <li>
                        <div class="mom-archive-title">
                            <h2>
                                <?php _e( 'Categories', 'framework'); ?>
                            </h2>
                        </div>
                        <ul>
                            <?php wp_list_categories( 'title_li=&show_count=1'); ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if (in_array("pages", $archives)) { ?>
                    <li>
                        <div class="mom-archive-title">
                            <h2>
                                <?php _e( 'pages', 'framework'); ?>
                            </h2>
                        </div>
                        <ul>
                            <?php wp_list_pages( 'title_li='); ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if (in_array("popular", $archives)) { ?>
                    <li>
                        <div class="mom-archive-title">
                            <h2><?php _e('Popular Posts', 'framework'); ?></h2>
                        </div>
                        <ul>
                            <?php 
                            	  $query = new WP_Query( array( 'posts_per_page' => 10, 'orderby' => 'comment_count' ) );
                                  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php short_title(40); ?></a>
                            </li>
                            <?php endwhile; ?>
                            <?php  else:  ?>
                            <!-- Else in here -->
                            <?php  endif; ?>
                            <?php wp_reset_postdata(); ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if (in_array("recent", $archives)) { ?>
                    <li>
                        <div class="mom-archive-title">
                            <h2>
                                <?php _e( 'Recent Posts', 'framework'); ?>
                            </h2>
                        </div>
                        <ul>
                            <?php 
                            	  $query = new WP_Query( array( 'posts_per_page' => 10 ) );
                                  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php short_title(40); ?></a>
                            </li>
                            <?php endwhile; ?>
                            <?php  else:  ?>
                            <!-- Else in here -->
                            <?php  endif; ?>
                            <?php wp_reset_postdata(); ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if (in_array("authors", $archives)) { ?>
                    <li>
                        <div class="mom-archive-title">
                            <h2>
                                <?php _e( 'Authors', 'framework'); ?>
                            </h2>
                        </div>
                        <ul>
                            <?php wp_list_authors('optioncount=1&exclude_admin=0'); ?>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
                <div class="clear"></div>
                <?php if (in_array("tags", $archives)) { ?>
                <div class="mom-archive-title">
                    <h2>
                        <?php _e( 'tags' , 'framework'); ?>
                    </h2>
                </div>
                <div class="tagcloud">
                    <?php $tags= get_tags(); 
                    if ($tags) { 
                        foreach ($tags as $tag) 
                        { echo '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a> '; }
                     } ?>
                </div>
                <?php } ?>
            </div>

        </div>

    </div>
    <!--Main Content-->


</div>
<!--container-->

</div>
<!--wrap-->

<?php get_footer(); ?>
