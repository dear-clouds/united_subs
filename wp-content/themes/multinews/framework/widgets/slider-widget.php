<?php 

add_action('widgets_init','mom_widget_slider');

function mom_widget_slider() {
	register_widget('mom_widget_slider');
	
	}

class mom_widget_slider extends WP_Widget {
	function mom_widget_slider() {
			
		$widget_ops = array('classname' => 'slider','description' => __('Widget display slider order by : Popular, Random, Recent','framework'));
		parent::__construct('momizat-slider',__('Momizat - slider','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = $instance['display'];
		$animation = isset( $instance['animation'] ) ? esc_attr( $instance['animation'] ) : '';
		$animationin = isset( $instance['animationin'] ) ? esc_attr( $instance['animationin'] ) : '';
		$animationout = isset( $instance['animationout'] ) ? esc_attr( $instance['animationout'] ) : '';
		$autoplay = isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : '';
		$timeout = isset( $instance['timeout'] ) ? esc_attr( $instance['timeout'] ) : '';
		$cats = isset($instance['cats']) ? $instance['cats'] : array();


$output = get_transient($this->id);
if ($orderby == 'Random') {
	$output = false;
}
if ($output == false) { 
    ob_start();

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			global $post;
			
	
	    $rndn = rand(0,100);
	    
	if ($animation == 'fade') {
		$animationout = 'fadeOut';
		$animationin = '';
	} elseif ($animation == 'slide') {
		$animationout = '';
		$animationin = '';
		
	} elseif ($animation == 'flip') {
		$animationout = 'slideOutDown';
		$animationin = 'flipInX';
	}
	if ($autoplay == 'no') {
		$autoplay = 'false';
	} else {
		$autoplay = 'true';		
	}
?>

<div class="slider-widget">
    <script>
            //widget slider
	  jQuery(document).ready(function($) {
					var rtl = false;
					<?php if (is_rtl()) { ?>
						rtl = true;
					<?php } ?>
	$('.wmcs-<?php echo $rndn; ?>').owlCarousel({
		animateOut: '<?php echo $animationout; ?>',
		animateIn: '<?php echo $animationin; ?>',
		autoplay:<?php echo $autoplay; ?>,
		<?php if($timeout != '') { ?>
		autoplayTimeout:<?php echo $timeout; ?>,
		<?php } ?>
		autoplayHoverPause:false,
		rtl: rtl,
		items:1,
		nav: true,
		 navText: ['<span class="enotype-icon-arrow-left7"></span>',
			'<span class="enotype-icon-uniE6D8"></span>'
		],
		smartSpeed:1000,
	});
      });
    </script>
    
    <div class="slider-widget-wrap momizat-custom-slider wmcs-<?php echo $rndn; ?>">
   		 <?php if($orderby == 'Popular') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			?>

			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } ?>
		<?php } elseif($orderby == 'Random') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			
			?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'rand', 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } ?>
		<?php } elseif($orderby == 'Recent') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false ) ); ?>
			<?php } ?>
		<?php } ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php if( mom_post_image() != false ) { ?>
        <div class="slider-widget-item">
            <figure class="post-thumbnail">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                	<?php mom_post_image_full('sliderwidget-thumb'); ?>
                </a>
            </figure>
            <div class="slider-widget-title">
                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
            </div>
        </div>
        <?php } ?>
        <?php endwhile; ?>
        <?php else: ?>
        <!-- Else in here -->
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
     </div>
</div>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;

		   $output = ob_get_contents();
    ob_end_clean();
    set_transient($this->id, $output, 60*60*24);
}

    echo $output;  
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['display'] = $new_instance['display'];
		$instance['cats'] = $new_instance['cats'];
		$instance['animation'] = $new_instance['animation'];
		$instance['animationin'] = $new_instance['animationin'];
		$instance['animationout'] = $new_instance['animationout'];
		$instance['autoplay'] = $new_instance['autoplay'];
		$instance['timeout'] = $new_instance['timeout'];
			$this->invalidate_widget_cache();

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Most Popular','framework'), 
			'count' => 5,
			'animation' => 'fade',
			'autoplay' => 'yes',
			'timeout' => '5000',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		if (isset($instance['orderby'])) { $orderbyS = $instance['orderby'];} else {$orderbyS = ''; }
		if (isset($instance['display'])) { $displayS = $instance['display'];} else {$displayS = ''; }
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$categories = get_categories('hide_empty=0');
	?>
	<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $this->get_field_id( 'display' ); ?>').change( function () {
				if ($(this).val() !== 'latest') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				}
				
			});
				if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() !== 'latest') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				}
		});
	</script>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('orderby', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
		<option <?php if ( 'Popular' == $orderbyS ) echo 'selected="selected"'; ?>>Popular</option>
		<option <?php if ( 'Random' == $orderbyS ) echo 'selected="selected"'; ?>>Random</option>
		<option <?php if ( 'Recent' == $orderbyS ) echo 'selected="selected"'; ?>>Recent</option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('display', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
		<option <?php if ( 'latest' == $displayS ) echo 'selected="selected"'; ?> value="latest"><?php _e('Latest Posts', 'framework'); ?></option>
		<option <?php if ( 'cats' == $displayS ) echo 'selected="selected"'; ?> value="cats"><?php _e('Category/s', 'framework'); ?></option>
		</select>
		</p>

		<p class="hidden">
		<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e('cats', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" class="widefat" multiple="multiple">
		<?php foreach ($categories as $cat) { ?>
			<option <?php echo in_array($cat->cat_ID, $cats)? 'selected="selected"':'';?> value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
		<?php } ?>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of Posts:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'animation' ); ?>"><?php _e('Slider Animation', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'animation' ); ?>" name="<?php echo $this->get_field_name( 'animation' ); ?>" class="widefat">
		<option value="fade" <?php selected($instance['animation'], 'fade'); ?>><?php _e('Fade', 'framework'); ?></option>
		<option value="slide" <?php selected($instance['animation'], 'slide'); ?>><?php _e('Slide', 'framework'); ?></option>
		<option value="flip" <?php selected($instance['animation'], 'flip'); ?>><?php _e('Flip', 'framework'); ?></option>
		<option value="custom" <?php selected($instance['animation'], 'custom'); ?>><?php _e('Custom Animation', 'framework'); ?></option>	
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'animationin' ); ?>"><?php _e('Animation In (for custom animation only)', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'animationin' ); ?>" name="<?php echo $this->get_field_name( 'animationin' ); ?>" class="widefat">
			<option value="bounce" <?php selected($instance['animationin'], 'bounce'); ?>><?php _e('bounce', 'framework'); ?></option>
			<option value="flash" <?php selected($instance['animationin'], 'flash'); ?>><?php _e('flash', 'framework'); ?></option>
			<option value="pulse" <?php selected($instance['animationin'], 'pulse'); ?>><?php _e('pulse', 'framework'); ?></option>
			<option value="rubberBand" <?php selected($instance['animationin'], 'rubberBand'); ?>><?php _e('rubberBand', 'framework'); ?></option>
			<option value="shake" <?php selected($instance['animationin'], 'shake'); ?>><?php _e('shake', 'framework'); ?></option>
			<option value="swing" <?php selected($instance['animationin'], 'swing'); ?>><?php _e('swing', 'framework'); ?></option>
			<option value="tada" <?php selected($instance['animationin'], 'tada'); ?>><?php _e('tada', 'framework'); ?></option>
			<option value="wobble" <?php selected($instance['animationin'], 'wobble'); ?>><?php _e('wobble', 'framework'); ?></option>
			<option value="bounceIn" <?php selected($instance['animationin'], 'bounceIn'); ?>><?php _e('bounceIn', 'framework'); ?></option>
			<option value="bounceInDown" <?php selected($instance['animationin'], 'bounceInDown'); ?>><?php _e('bounceInDown', 'framework'); ?></option>
			<option value="bounceInLeft" <?php selected($instance['animationin'], 'bounceInLeft'); ?>><?php _e('bounceInLeft', 'framework'); ?></option>
			<option value="bounceInRight" <?php selected($instance['animationin'], 'bounceInRight'); ?>><?php _e('bounceInRight', 'framework'); ?></option>
			<option value="bounceInUp" <?php selected($instance['animationin'], 'bounceInUp'); ?>><?php _e('bounceInUp', 'framework'); ?></option>
			<option value="fadeIn" <?php selected($instance['animationin'], 'fadeIn'); ?>><?php _e('fadeIn', 'framework'); ?></option>
			<option value="fadeInDown" <?php selected($instance['animationin'], 'fadeInDown'); ?>><?php _e('fadeInDown', 'framework'); ?></option>
			<option value="fadeInDownBig" <?php selected($instance['animationin'], 'fadeInDownBig'); ?>><?php _e('fadeInDownBig', 'framework'); ?></option>
			<option value="fadeInLeft" <?php selected($instance['animationin'], 'fadeInLeft'); ?>><?php _e('fadeInLeft', 'framework'); ?></option>
			<option value="fadeInLeftBig" <?php selected($instance['animationin'], 'fadeInLeftBig'); ?>><?php _e('fadeInLeftBig', 'framework'); ?></option>
			<option value="fadeInRight" <?php selected($instance['animationin'], 'fadeInRight'); ?>><?php _e('fadeInRight', 'framework'); ?></option>
			<option value="fadeInRightBig" <?php selected($instance['animationin'], 'fadeInRightBig'); ?>><?php _e('fadeInRightBig', 'framework'); ?></option>
			<option value="fadeInUp" <?php selected($instance['animationin'], 'fadeInUp'); ?>><?php _e('fadeInUp', 'framework'); ?></option>
			<option value="fadeInUpBig" <?php selected($instance['animationin'], 'fadeInUpBig'); ?>><?php _e('fadeInUpBig', 'framework'); ?></option>
			<option value="flip" <?php selected($instance['animationin'], 'flip'); ?>><?php _e('flip', 'framework'); ?></option>
			<option value="flipInX" <?php selected($instance['animationin'], 'flipInX'); ?>><?php _e('flipInX', 'framework'); ?></option>
			<option value="flipInY" <?php selected($instance['animationin'], 'flipInY'); ?>><?php _e('flipInY', 'framework'); ?></option>
			<option value="lightSpeedIn" <?php selected($instance['animationin'], 'lightSpeedIn'); ?>><?php _e('lightSpeedIn', 'framework'); ?></option>
			<option value="rotateIn" <?php selected($instance['animationin'], 'rotateIn'); ?>><?php _e('rotateIn' , 'framework'); ?></option>
			<option value="rotateInDownLeft" <?php selected($instance['animationin'], 'rotateInDownLeft'); ?>><?php _e('rotateInDownLeft' , 'framework'); ?></option>
			<option value="rotateInDownRight" <?php selected($instance['animationin'], 'rotateInDownRight'); ?>><?php _e('rotateInDownRight' , 'framework'); ?></option>
			<option value="rotateInUpLeft" <?php selected($instance['animationin'], 'rotateInUpLeft'); ?>><?php _e('rotateInUpLeft' , 'framework'); ?></option>
			<option value="rotateInUpRight" <?php selected($instance['animationin'], 'rotateInUpRight'); ?>><?php _e('rotateInUpRight' , 'framework'); ?></option>
			<option value="slideInDown" <?php selected($instance['animationin'], 'slideInDown'); ?>><?php _e('slideInDown' , 'framework'); ?></option>
			<option value="slideInLeft" <?php selected($instance['animationin'], 'slideInLeft'); ?>><?php _e('slideInLeft' , 'framework'); ?></option>
			<option value="slideInRight" <?php selected($instance['animationin'], 'slideInRight'); ?>><?php _e('slideInRight' , 'framework'); ?></option>
			<option value="rollIn" <?php selected($instance['animationin'], 'rollIn'); ?>><?php _e('rollIn' , 'framework'); ?></option> 		
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'animationout' ); ?>"><?php _e('Animation Out (for custom animation only)', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'animationout' ); ?>" name="<?php echo $this->get_field_name( 'animationout' ); ?>" class="widefat">
		
			<option value="bounceOut" <?php selected($instance['animationout'], 'bounceOut'); ?>><?php _e('bounceOut', 'framework'); ?></option>
			<option value="bounceOutDown" <?php selected($instance['animationout'], 'bounceOutDown'); ?>><?php _e('bounceOutDown', 'framework'); ?></option>
			<option value="bounceOutLeft" <?php selected($instance['animationout'], 'bounceOutLeft'); ?>><?php _e('bounceOutLeft', 'framework'); ?></option>
			<option value="bounceOutRight" <?php selected($instance['animationout'], 'bounceOutRight'); ?>><?php _e('bounceOutRight', 'framework'); ?></option>
			<option value="bounceOutUp" <?php selected($instance['animationout'], 'bounceOutUp'); ?>><?php _e('bounceOutUp', 'framework'); ?></option>
			<option value="fadeOut" <?php selected($instance['animationout'], 'fadeOut'); ?>><?php _e('fadeOut', 'framework'); ?></option>
			<option value="fadeOutDown" <?php selected($instance['animationout'], 'fadeOutDown'); ?>><?php _e('fadeOutDown', 'framework'); ?></option>
			<option value="fadeOutDownBig" <?php selected($instance['animationout'], 'fadeOutDownBig'); ?>><?php _e('fadeOutDownBig', 'framework'); ?></option>
			<option value="fadeOutLeft" <?php selected($instance['animationout'], 'fadeOutLeft'); ?>><?php _e('fadeOutLeft', 'framework'); ?></option>
			<option value="fadeOutLeftBig" <?php selected($instance['animationout'], 'fadeOutLeftBig'); ?>><?php _e('fadeOutLeftBig', 'framework'); ?></option>
			<option value="fadeOutRight" <?php selected($instance['animationout'], 'fadeOutRight'); ?>><?php _e('fadeOutRight', 'framework'); ?></option>
			<option value="fadeOutRightBig" <?php selected($instance['animationout'], 'fadeOutRightBig'); ?>><?php _e('fadeOutRightBig', 'framework'); ?></option>
			<option value="fadeOutUp" <?php selected($instance['animationout'], 'fadeOutUp'); ?>><?php _e('fadeOutUp', 'framework'); ?></option>
			<option value="fadeOutUpBig" <?php selected($instance['animationout'], 'fadeOutUpBig'); ?>><?php _e('fadeOutUpBig', 'framework'); ?></option>
			<option value="flip" <?php selected($instance['animationout'], 'flip'); ?>><?php _e('flip', 'framework'); ?></option>
			<option value="flipOutX" <?php selected($instance['animationout'], 'flipOutX'); ?>><?php _e('flipOutX', 'framework'); ?></option>
			<option value="flipOutY" <?php selected($instance['animationout'], 'flipOutY'); ?>><?php _e('flipOutY', 'framework'); ?></option>
			<option value="lightSpeedOut" <?php selected($instance['animationout'], 'lightSpeedOut'); ?>><?php _e('lightSpeedOut', 'framework'); ?></option>
			<option value="rotateOut" <?php selected($instance['animationout'], 'rotateOut'); ?>><?php _e('rotateOut', 'framework'); ?></option>
			<option value="rotateOutDownLeft" <?php selected($instance['animationout'], 'rotateOutDownLeft'); ?>><?php _e('rotateOutDownLeft', 'framework'); ?></option>
			<option value="rotateOutDownRight" <?php selected($instance['animationout'], 'rotateOutDownRight'); ?>><?php _e('rotateOutDownRight', 'framework'); ?></option>
			<option value="rotateOutUpLeft" <?php selected($instance['animationout'], 'rotateOutUpLeft'); ?>><?php _e('rotateOutUpLeft', 'framework'); ?></option>
			<option value="rotateOutUpRight" <?php selected($instance['animationout'], 'rotateOutUpRight'); ?>><?php _e('rotateOutUpRight', 'framework'); ?></option>
			<option value="slideOutDown" <?php selected($instance['animationout'], 'slideOutDown'); ?>><?php _e('slideOutDown', 'framework'); ?></option>
			<option value="slideOutLeft" <?php selected($instance['animationout'], 'slideOutLeft'); ?>><?php _e('slideOutLeft', 'framework'); ?></option>
			<option value="slideOutRight" <?php selected($instance['animationout'], 'slideOutRight'); ?>><?php _e('slideOutRight', 'framework'); ?></option>
			<option value="rollOut" <?php selected($instance['animationout'], 'rollOut'); ?>><?php _e('rollOut' , 'framework'); ?></option>			
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" class="widefat">
		<option value="yes" <?php selected($instance['autoplay'], 'yes'); ?>><?php _e('Yes', 'framework'); ?></option>
		<option value="no" <?php selected($instance['autoplay'], 'no'); ?>><?php _e('No', 'framework'); ?></option>	
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'timeout' ); ?>"><?php _e('the time between each slide with ms, default : 5000:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'timeout' ); ?>" name="<?php echo $this->get_field_name( 'timeout' ); ?>" value="<?php echo $instance['timeout']; ?>" class="widefat" />
		</p>
   <?php 
}
	public function invalidate_widget_cache()
	{
		delete_transient( $this->id );
	} 

	} //end class