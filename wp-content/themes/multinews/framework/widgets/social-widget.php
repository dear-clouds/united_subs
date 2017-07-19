<?php 

add_action('widgets_init','mom_social_widget');

function mom_social_widget() {
	register_widget('mom_social_widget');
	
	}

class mom_social_widget extends WP_Widget {
	function mom_social_widget() {
			
		$widget_ops = array('classname' => 'social-icons','description' => __('Social Icons Widget','framework'));

		parent::__construct('social-icons',__('Momizat - Social icons widget','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$google = $instance['google'];
		$youtube = $instance['youtube'];
		$rss = $instance['rss'];
		$dribble = $instance['dribble'];
		$pin = $instance['pin'];
		$instgram = $instance['instgram'];
		$vimeo = $instance['vimeo'];
		$tumblr = $instance['tumblr'];
		$linkedin = $instance['linkedin'];
		$soundcloud = $instance['soundcloud'];
		$skype = $instance['skype'];
		$picasa = $instance['picasa'];
		$flicker = $instance['flicker'];
		$stum = $instance['stum'];
		$forrst = $instance['forrst'];
		$email = $instance['email'];


		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
              
              <ul class="social-widget clearfix">
              <?php if($twitter) { ?>
                    <li class="twitter"><a href="<?php echo $twitter; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($facebook) { ?>
                    <li class="facebook"><a href="<?php echo $facebook; ?>" target="_blank"></a></li>
              <?php } ?> 
              <?php if($google) { ?>       
                    <li class="gplus"><a href="<?php echo $google; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($rss) { ?>
                    <li class="rss"><a href="<?php echo $rss; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($youtube) { ?>
                    <li class="youtube"><a href="<?php echo $youtube; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($dribble) { ?>
                    <li class="dribble"><a href="<?php echo $dribble; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($pin) { ?>
                    <li class="pin"><a href="<?php echo $pin; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($instgram) { ?>
                    <li class="instagram"><a href="<?php echo $instgram; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($vimeo) { ?>
                    <li class="vimeo"><a href="<?php echo $vimeo; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($tumblr) { ?> 
                    <li class="tumblr"><a href="<?php echo $tumblr; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($linkedin) { ?>
                    <li class="linkedin"><a href="<?php echo $linkedin; ?>" target="_blank"></a></li>
              <?php } ?>  
              <?php if($soundcloud) { ?>
                    <li class="soundcloude"><a href="<?php echo $soundcloud; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($skype) { ?>
                    <li class="skype"><a href="<?php echo $skype; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($picasa) { ?>
                    <li class="picasa"><a href="<?php echo $picasa; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($flicker) { ?>
                    <li class="flicker"><a href="<?php echo $flicker; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($stum) { ?> 
                    <li class="stum"><a href="<?php echo $stum; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($forrst) { ?>
                    <li class="forrst"><a href="<?php echo $forrst; ?>" target="_blank"></a></li>
              <?php } ?>
              <?php if($email) { ?>
                    <li class="semail"><a href="<?php echo $email; ?>" target="_blank"></a></li>
              <?php } ?>
              </ul>
              

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter'] = $new_instance['twitter'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['google'] = $new_instance['google'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['rss'] = $new_instance['rss'];
		$instance['dribble'] = $new_instance['dribble'];
		$instance['pin'] = $new_instance['pin'];
		$instance['instgram'] = $new_instance['instgram'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['soundcloud'] = $new_instance['soundcloud'];
		$instance['skype'] = $new_instance['skype'];
		$instance['picasa'] = $new_instance['picasa'];
		$instance['flicker'] = $new_instance['flicker'];
		$instance['stum'] = $new_instance['stum'];
		$instance['forrst'] = $new_instance['forrst'];
		$instance['email'] = $new_instance['email'];


		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __('Follow','framework'),
			'twitter' => 'https://twitter.com/momizat',
			'facebook' => 'https://www.facebook.com/momizat',
			'youtube' => 'http://www.youtube.com/user/momizat',
			'google' => '',
			'rss' => '',
			'dribble' => '',
			'pin' => '',
			'instgram' => '',
			'vimeo' => '',
			'tumblr' => '',
			'linkedin' => '',
			'soundcloud' => '',
			'skype' => '',
			'picasa' => '',
			'flicker' => '',
			'stum' => '',
			'forrst' => '',
			'email' => '',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

    	<p>
		<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('facebook:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('twitter:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'google' ); ?>"><?php _e('google plus:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'google' ); ?>" name="<?php echo $this->get_field_name( 'google' ); ?>" value="<?php echo $instance['google']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('youtube:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $instance['youtube']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('vimeo:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $instance['vimeo']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'pin' ); ?>"><?php _e('pinterest:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'pin' ); ?>" name="<?php echo $this->get_field_name( 'pin' ); ?>" value="<?php echo $instance['pin']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'instgram' ); ?>"><?php _e('instgram:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'instgram' ); ?>" name="<?php echo $this->get_field_name( 'instgram' ); ?>" value="<?php echo $instance['instgram']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('linkedin:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('rss:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'flicker' ); ?>"><?php _e('flicker:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'flicker' ); ?>" name="<?php echo $this->get_field_name( 'flicker' ); ?>" value="<?php echo $instance['flicker']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('tumblr:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" value="<?php echo $instance['tumblr']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'soundcloud' ); ?>"><?php _e('soundcloud:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'soundcloud' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud' ); ?>" value="<?php echo $instance['soundcloud']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('skype:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $instance['skype']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'picasa' ); ?>"><?php _e('picasa:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'picasa' ); ?>" name="<?php echo $this->get_field_name( 'picasa' ); ?>" value="<?php echo $instance['picasa']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'stum' ); ?>"><?php _e('stumbleupon:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'stum' ); ?>" name="<?php echo $this->get_field_name( 'stum' ); ?>" value="<?php echo $instance['stum']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'forrst' ); ?>"><?php _e('forrst:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'forrst' ); ?>" name="<?php echo $this->get_field_name( 'forrst' ); ?>" value="<?php echo $instance['forrst']; ?>"  class="widefat" type="text" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'dribble' ); ?>"><?php _e('dribbble:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'dribble' ); ?>" name="<?php echo $this->get_field_name( 'dribble' ); ?>" value="<?php echo $instance['dribble']; ?>"  class="widefat" type="text" />
		</p>
        
        <p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>"  class="widefat" type="text" />
		</p>
       	
   <?php 
}
	} //end class