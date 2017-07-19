<?php get_header(); ?>
<div class="main-container">
    <!--container-->

	<?php if(mom_option('breadcrumb') != 0) { ?>
    <div class="archive-page archive-page entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
        <div class="crumb-icon"><i class="brankic-icon-error"></i></div>
        <span>
            <?php _e('Not Found', 'framework') ?>
        </span>
    </div>
    <?php } ?>


    <div class="full-main-content" role="main">
        <!--Main Content-->

        <div class="site-content page-wrap error-page">
            <h4 class="error-message"><?php _e('Sorry, the page you were looking for was not found.', 'framework'); ?></h4>
            <h1><?php _e('404', 'framework'); ?></h1>
            <div class="search-box">
			    <form role="search" method="get" class="search-form" action="<?php echo home_url();?>">
			            <input type="search" class="search-field" value="<?php _e('Try Another Search', 'framework'); ?>" name="s" title="<?php _e('Search for:', 'framework') ?>" onfocus="if(this.value=='<?php _e('Try Another Search', 'framework') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Try Another Search', 'framework') ?>';">
			    <button type="submit" class="esearch-submit" value="Search"><?php _e('Search', 'framework'); ?></button>
			    </form>
			</div>
			
			<div class="mom-archive clearfix">
                <ul>
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
                    <li>
                        <div class="mom-archive-title">
                            <h2><?php _e('Recent Posts', 'framework'); ?></h2>
                        </div>
                        <ul>
                            <?php 
                                  query_posts(array( 'showposts' => 10)); 
                                  if ( have_posts() ) : while ( have_posts() ) : the_post(); 
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php short_title(40); ?></a>
                            </li>
                            <?php endwhile; ?>
                            <?php  else:  ?>
                            <!-- Else in here -->
                            <?php  endif; ?>
                            <?php wp_reset_query(); ?>
                        </ul>
                    </li>
                </ul>
                <div class="clear"></div>
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
            </div>
			
			
        </div>

    </div>

</div>
<?php get_footer(); ?>