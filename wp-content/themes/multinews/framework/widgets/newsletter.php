<?php 

add_action('widgets_init','mom_widget_newsletter');

function mom_widget_newsletter() {
	register_widget('mom_widget_newsletter');
	
	}

class mom_widget_newsletter extends WP_Widget {
	function mom_widget_newsletter() {
			
		$widget_ops = array('classname' => 'momizat-news_letter','description' => __('Widget display NewsLetter Subscribe form it support Mailchimp, feedburner','framework'));
		parent::__construct('momizatNewsLetter',__('Momizat - NewsLetter','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];
		$msg = $instance['msg'];
		$list = $instance['list'];
		$feed_url = $instance['feed_url'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
                        <div class="newsletter mom-newsletter">
							<p class="nsd"><?php echo $msg; ?></p>
							<?php if ($type == 'feedburner') { ?>
							<form class="newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feed_url; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
							        <input type="text" class="nsf" name="email" value="Your Email" onfocus="if(this.value=='<?php _e('Your Email', 'framework'); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Your Email', 'framework'); ?>';">
							        <input type="hidden" name="loc" value="en_US">
							        <input type="hidden" value="<?php echo $feed_url; ?>" name="uri">
							        <input type="submit" class="nsb" value="Subscribe">
							</form>
							<?php } else { ?>
							<form action="" class="mn-form mom_mailchimp_subscribe" method="post" data-list_id="<?php echo $list; ?>">
								<span class="sf-loading"><img src="<?php echo MOM_IMG; ?>/ajax-search-nav.png" alt="loading..." width="16" height="16"></span>
								<input name="email" class="mms-email nsf" type="text" placeholder="<?php _e('Enter your e-mail ..', 'framework'); ?>">
								<button class="button nsb" type="submit"><?php _e('Subscribe','framework');?></button>
							</form>
							<?php } ?>
						</div>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = $new_instance['type'];
		$instance['msg'] = $new_instance['msg'];
		$instance['list'] = $new_instance['list'];
		$instance['feed_url'] = $new_instance['feed_url'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __('Newsletter','framework'),
			'type' => 'mailchimp',
			'msg' => __('Get Journal good news straight to your email.', 'framework'),
			'list' => '',
			'feed_url' => ''
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$api_key = mom_option('mailchimp_api_key');
			include_once(MOM_FW . '/inc/mailchimp/Mailchimp.php');
		if ($api_key != '') {
			$Mailchimp = new Mom_Mailchimp( $api_key );
			$Mailchimp_Lists = new Mom_Mailchimp_Lists( $Mailchimp );
			print_r($Mailchimp_Lists);
			if (null !== $Mailchimp_Lists->getList()) {
			$lists = $Mailchimp_Lists->getList();
			}
		}
			//echo '<pre>'; print_r($lists['data']); echo '</pre>';
	
		?>
	<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $this->get_field_id( 'type' ); ?>').change( function () {
				if ($(this).val() === 'mailchimp') {
					$('#<?php echo $this->get_field_id('list'); ?>').parent().fadeIn();
					$('#<?php echo $this->get_field_id('feed_url'); ?>').parent().fadeOut();
				} else {
					$('#<?php echo $this->get_field_id('list'); ?>').parent().fadeOut();
					$('#<?php echo $this->get_field_id('feed_url'); ?>').parent().fadeIn();
				}
				
			});
				if ($('#<?php echo $this->get_field_id( 'type' ); ?>').val() === 'mailchimp') {
					$('#<?php echo $this->get_field_id('list'); ?>').parent().fadeIn();
					$('#<?php echo $this->get_field_id('feed_url'); ?>').parent().fadeOut();
				} else {
					$('#<?php echo $this->get_field_id('list'); ?>').parent().fadeOut();
					$('#<?php echo $this->get_field_id('feed_url'); ?>').parent().fadeIn();
				}
		});
	</script>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'msg' ); ?>"><?php _e('Message:','framework'); ?></label>
		<textarea id="<?php echo $this->get_field_id( 'msg' ); ?>" name="<?php echo $this->get_field_name( 'msg' ); ?>" class="widefat" cols="20" rows="2"><?php echo $instance['msg']; ?></textarea>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Maillist Type', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
		<option value="mailchimp" <?php selected($instance['type'], 'mailchimp'); ?>><?php _e('Mailchimp', 'framework'); ?></option>
		<option value="feedburner" <?php selected($instance['type'], 'feedburner'); ?>><?php _e('feedburner', 'framework'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'list' ); ?>"><?php _e('Select List', 'framework') ?></label>
		<?php if ($api_key != '') { ?>
		<select id="<?php echo $this->get_field_id( 'list' ); ?>" name="<?php echo $this->get_field_name( 'list' ); ?>" class="widefat">
		<?php
		 	if(isset($lists['data'])) {
			foreach ($lists['data'] as $list ) {
		?>
			<option value="<?php echo $list['id']; ?>" <?php selected($instance['list'], $list['id']); ?>><?php echo $list['name']; ?></option>
		<?php
			}
		}
		?>
		</select>
		<?php
		} else {
			echo '<span id="'.$this->get_field_id( 'list' ).'" style="color:red;">'.__('No API key Go to "<a href="'.admin_url('themes.php?page=theme_options').'">options</a> / API\'s Authentication" Section and add Mailchimp API Key','framework').'</span>';
		}
		?>
		</p>

		<p class="hide">
		<label for="<?php echo $this->get_field_id( 'feed_url' ); ?>"><?php _e('feedburner name: (your name without http://feeds.feedburner.com/) ', 'framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'feed_url' ); ?>" name="<?php echo $this->get_field_name( 'feed_url' ); ?>" value="<?php echo $instance['feed_url']; ?>" class="widefat" />
		</p>


<?php 
}
	} //end class