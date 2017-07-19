<?php
wp_enqueue_script('cycle');
wp_enqueue_script( 'bookblock', get_template_directory_uri() . '/js/jquery.bookblock.min.js', array('jquery'), '1.0', false );
  $layout = mom_option('category_layout');
  if ($layout == '') {
    $layout = mom_option('main_layout');
  }
$site_width = mom_option('site_width');
$db_posts = array();
$count = 7;
if (strpos($layout,'both') === false) {
    $count = 6;
    if ($site_width == 'wide') {
	$count = 7;
    }
}

$rndn = rand(1, 100);
if ($layout == 'fullwidth' && strpos(mom_option('main_layout'), 'both') !== false) {
   $count = 7;
}
?>

<section class="section clearfix mom_visibility_desktop" style="overflow:hidden;">
    <div class="cat-slider">
    	<!-- ================== -->
    	<div id="bb-bookblock" class="bb-bookblock"><!-- bookblock -->
    		<div class="bb-item">
    			<?php if(mom_option('cat_slider_mpop') != 0) { ?>
		        <a id="bb-nav-next" class="cat-slider-pop" href=""><?php _e('Most Popular ', 'framework') ?><i class="<?php if ( is_rtl() ) { ?>enotype-icon-arrow-left2<?php } else { ?>enotype-icon-arrow-right2<?php } ?>"></i></a>
		        <?php } ?>

		        <div class="slider-widget-nav">
			        <a class="slider-widget-prev widget-slider-prev<?php echo $rndn; ?>" href="#">
			            <span class="enotype-icon-arrow-left7"></span>
			        </a>
			        <a class="slider-widget-next widget-slider-next<?php echo $rndn; ?>" href="#">
			            <span class="enotype-icon-uniE6D8"></span>
			        </a>
			    </div>
				<div class="cat-slider-wrap">
		            <?php
		            $category_id = get_query_var('cat') ;
		            $cat_slider_by = mom_option('cat_slider_display');
		            $query = new WP_Query( array( 'cat' => $category_id, 'posts_per_page' => $count , 'orderby' => $cat_slider_by, 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );

                    update_post_thumbnail_cache( $query );
		            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			    $db_posts[] = $post->ID;
		            ?>
		            <div class="cat-slider-item" itemscope="" itemtype="http://schema.org/Article">
		                <a href="<?php the_permalink(); ?>">
				<?php
					$thumb_size = 'catslider1-thumb';
					if (strpos($layout,'both') === false) {
					    $thumb_size = 'catslider-thumb';
				    	    if ($site_width == 'wide') {
						$thumb_size = 'catslider1-thumb';
					    }
					}
					if ($layout == 'fullwidth' && strpos(mom_option('main_layout'), 'both') !== false) {
					    $thumb_size = 'catslider1-thumb';
					}

				    ?>
		                	<h2 class="mob-title"><?php the_title(); ?></h2>
		                	<?php mom_post_image_full($thumb_size); ?>
		                </a>

		            </div>
		            <?php
		            endwhile;
		            else:
		            ?>
		            <?php
		            endif;
		            ?>
		            <?php wp_reset_postdata(); ?>

		        </div>
    		</div>

    		<?php if(mom_option('cat_slider_mpop') != 0) { ?>
    		<div class="bb-item">
				<div class="cat-slider-mpop">
					<div class="cat-slider-mpop-head">
						<h2><?php _e('Most Popular', 'framework'); ?></h2>
						<a id="bb-nav-prev" class="cat-slider-pop" href=""><i class="<?php if ( is_rtl() ) { ?>enotype-icon-arrow-right2<?php } else { ?>enotype-icon-arrow-left2<?php } ?>"></i><?php _e(' Go Back', 'framework') ?></a>
					</div>
					<?php
					$category = get_query_var('cat');
					$query = new WP_Query( array( 'cat' => $category, 'posts_per_page' => 2, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );
                    update_post_thumbnail_cache( $query );
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					?>
					<div class="slider-mpop-big">
						<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
							<?php mom_post_image_full('npic-thumb'); ?>
		                </a></figure>
						<div class="f-p-title">
		                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		                    <span class="post-format-icon"></span>
							<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time('F j, Y'); ?></time>
		                </div>
					</div>
					<?php
					endwhile; endif;
					wp_reset_postdata();
					?>
					<ul>
						<?php
						$categoryid = get_query_var('cat');
						$query = new WP_Query( array( 'cat' => $categoryid, 'posts_per_page' => 4, 'offset' => 2, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );
                    update_post_thumbnail_cache( $query );
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
						?>
						<li>
							<?php if( mom_post_image() != false ) { ?>
							<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
		                    	<?php mom_post_image_full('postlist-thumb'); ?>
			                </a></figure>
			                <?php } ?>
							<div class="f-p-title">
			                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			                    <span class="post-format-icon"></span>
			                </div>
			                <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time('F j, Y'); ?></time>
						</li>
						<?php
						endwhile; endif;
						wp_reset_postdata();
						?>
					</ul>
				</div>
    		</div>
			<?php } ?>
		</div><!-- bookblock -->
		<!-- ================== -->
		<?php
		if($cat_slider_by == 'date') {
			$cs_title = __('Latest News', 'framework');
		} elseif ($cat_slider_by == 'modified') {
			$cs_title = __('Last Modified', 'framework');
		} elseif ($cat_slider_by == 'name') {
			$cs_title = __('Category Posts', 'framework');
		} else {
			$cs_title = __('Random News', 'framework');
		}
		?>
        <div class="cat-slider-nav">
            <p class="cat-slider-nav-title"><?php echo $cs_title; ?></p>
            <ul>
                <?php
		            $query = new WP_Query( array( 'posts_per_page' => $count,'post__in' => $db_posts, 'orderby' => 'post__in', 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );
                    update_post_thumbnail_cache( $query );
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                ?>
                <li itemscope="" itemtype="http://schema.org/Article">
                    <a href="<?php the_permalink(); ?>" itemprop="url">
                    <h2 itemprop="name"><?php short_title(47); ?></h2>
                    <div class="entry-meta">
                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time('Y/m/d'); ?></time>
                        <div class="author-link">
                            <?php _e('by ', 'framework') ?><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
                        </div>
                    </div>
                    </a>
                </li>
                <?php
                endwhile;
                else:
                ?>
                <!-- Else in here -->
                <?php
                endif;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
        <?php if(mom_option('cat_slider_mpop') != 0) { ?>
        <!-- ================== -->
        <div class="top-cat-slider-nav">
            <p class="cat-slider-nav-title"><?php echo $cs_title; ?></p>
            <ul>
                <?php
		            $query = new WP_Query( array( 'posts_per_page' => $count,'post__in' => $db_posts, 'orderby' => 'post__in', 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );
                    update_post_thumbnail_cache( $query );
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                ?>
                <li itemscope="" itemtype="http://schema.org/Article">
                    <a href="<?php the_permalink(); ?>" itemprop="url">
                    <h2 itemprop="name"><?php short_title(47); ?></h2>
                    <div class="entry-meta">
                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time('Y/m/d'); ?></time>
                        <div class="author-link">
                            <?php _e('by ', 'framework') ?><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
                        </div>
                    </div>
                    </a>
                </li>
                <?php
                endwhile;
                else:
                ?>
                <!-- Else in here -->
                <?php
                endif;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
        <!-- ================== -->
        <?php } ?>
    </div>
</section>
<?PHP $rndn = rand(0,100);  $timeout = mom_option('cat_slider_timeout'); ?>
<script>
jQuery(document).ready(function($) {
    var timeout = <?php echo $timeout; ?>;
    if (timeout === '') {
      timeout = 4000;
    }
    //Category Slider
    $('.cat-slider-wrap').cycle({
    fx:     'fade',
    pager:  '.cat-slider-nav ul',
    next:   '.widget-slider-next<?php echo $rndn; ?>',
    prev:   '.widget-slider-prev<?php echo $rndn; ?>',
    timeout: timeout,
    pagerAnchorBuilder: function(idx, slide) {
        // return selector string for existing anchor
        return '.cat-slider-nav ul li:eq(' + idx + ')';
    },
    after: function(el, next_el) {
        $(next_el).addClass('active');
    },
    timeoutFn: function(el, next_el) {
        $(next_el).addClass('active');
        return timeout;
    },
    onPagerEvent: function(i, se) {
      $(se).addClass('active');
    },
    before: function(el) {
        $(el).removeClass('active');
    }
    });

        li = $('.cat-slider-nav').find('li');
        ul = $('.cat-slider').find('.cat-slider-nav');
        ull = $('.cat-slider').find('.top-cat-slider-nav');
        $( '#bb-nav-next' ).click(function () {
	        li.addClass('inactive_arrow');
	        ull.css('display', 'block');
	        ul.css('display', 'none');
	        $('.cat-slider-mpop #bb-nav-prev').fadeIn(2000);

        });

        $( '#bb-nav-prev' ).click(function () {
	        li.removeClass('inactive_arrow');
	        ull.css('display', 'none');
	        ul.css('display', 'block');
	        $('.cat-slider-mpop #bb-nav-prev').hide();
        });


	var Page = (function() {

				var config = {
						$bookBlock : $( '#bb-bookblock' ),
						$navNext : $( '#bb-nav-next' ),
						$navPrev : $( '#bb-nav-prev' )
					},
					init = function() {
						config.$bookBlock.bookblock( {
							speed : 1000,
							shadowSides : 0.8,
							shadowFlip : 0.4,
							shadows     : true,
						} );
						initEvents();
					},
					initEvents = function() {

						var $slides = config.$bookBlock.children();

						// add navigation events
						config.$navNext.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'next' );
							return false;
						} );

						config.$navPrev.on( 'click touchstart', function() {
							config.$bookBlock.bookblock( 'prev' );
							return false;
						} );

						// add swipe events
						$slides.on( {
							'swipeleft' : function( event ) {
								config.$bookBlock.bookblock( 'next' );
								return false;
							},
							'swiperight' : function( event ) {
								config.$bookBlock.bookblock( 'prev' );
								return false;
							}
						} );

						// add keyboard events
						$( document ).keydown( function(e) {
							var keyCode = e.keyCode || e.which,
								arrow = {
									left : 37,
									up : 38,
									right : 39,
									down : 40
								};

							switch (keyCode) {
								case arrow.left:
									config.$bookBlock.bookblock( 'prev' );
									break;
								case arrow.right:
									config.$bookBlock.bookblock( 'next' );
									break;
							}
						} );
					};

					return { init : init };

			})();
                   	Page.init();

                    });

		</script>
    <section class="section mom_visibility_device"><!--def slider-->
        <div class="def-slider">
            <div class="def-slider-wrap momizat-custom-slider" data-srtl="false" data-animate_out='' data-animate_in="" data-autoplay="false" data-timeout="4000" data-bullets_event="click">
                <?php
                $query = new WP_Query( array( 'posts_per_page' => $count,'post__in' => $db_posts, 'orderby' => 'post__in', 'no_found_rows' => true, 'cache_results' => false, 'ignore_sticky_posts' => 1 ) );
      update_post_thumbnail_cache( $query );
      if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
      ?>
                <?php if( mom_post_image() != false ) { ?>
                <div class="def-slider-item"  data-dot="<?php echo $count; ?>">
                    <a href="<?php the_permalink(); ?>">
                      <?php
                        $thumbsize = 'slider-thumb';
                        if(mom_option('site_width') == 'wide'){
                          $classes = get_body_class();
    if (in_array('right-sidebar',$classes) || in_array('left-sidebar',$classes) ) {
                            $thumbsize = 'big-thumb-hd';
    }
                        }
                        mom_post_image_full($thumbsize);
                      ?>
                    </a>
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
    </section><!--def slider-->
