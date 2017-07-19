<div class="userpro userpro-<?php echo $i; ?> userpro-<?php echo $layout; ?>" <?php userpro_args_to_data( $args ); ?>>

	<a href="#" class="userpro-close-popup"><?php _e('Close','userpro'); ?></a>
	
	<div class="userpro-head">
		<div class="userpro-left"><?php echo $args["{$template}_heading"]; ?></div>
		<?php if (isset($args["{$template}_side"])) { ?>
		<div class="userpro-right"><a href="#" data-template="<?php echo $args["{$template}_side_action"]; ?>"><?php echo $args["{$template}_side"]; ?></a></div>
		<?php } ?>
		<div class="userpro-clear"></div>
	</div>
	
	<div class="userpro-body">
	
		<?php do_action('userpro_pre_form_message'); ?>

		<form action="" method="post" data-action="<?php echo $template; ?>">
		
			<input type="hidden" name="user_id-<?php echo $i; ?>" id="user_id-<?php echo $i; ?>" value="<?php echo $user_id; ?>" />
				<?php if (isset($_GET['post_id'])){?>
				<input type="hidden" name="postid-<?php echo $i; ?>" id="postid-<?php echo $i; ?>" value="<?php echo $_GET['post_id']; ?>" />
			<?php } // Hook into fields $args, $user_id
			if (!isset($user_id)) $user_id = 0;
			$hook_args = array_merge($args, array('user_id' => $user_id, 'unique_id' => $i));
			do_action('userpro_before_fields', $hook_args);
			?>
			
			<!-- Begin Publisher -->
		<?php 	?>
			<?php if (isset($args['publish_field_order'])) { ?>
			<?php
				$order = explode(',',$args['publish_field_order']);
				foreach($order as $k) {
				
					switch($k) {
						case 'title':
							echo userpro_edit_field_misc( $i, 'post_title', $args, null, null, __('Enter post title here...','userpro') );
							break;
						case 'content':
							echo userpro_post_editor( $i, 'userpro_editor', $args );
							break;
						case 'featured_image':
							echo userpro_edit_field_misc( $i, 'post_featured_image', $args );
							break;
						case 'post_type':
							if ( count(userpro_publish_types($args)) > 1 ) {
								echo userpro_edit_field_misc( $i, 'post_type', $args, __('Post Type','userpro') ); } else { ?>
								<input type="hidden" name="post_type-<?php echo $i; ?>" id="post_type-<?php echo $i; ?>" value="<?php if (isset($args['post_type'])) echo $args['post_type']; ?>" /><?php }
							break;
						case 'category':
							if (isset($args['taxonomy']) && isset($args['category'])){ ?>
								<input type="hidden" name="taxonomy-<?php echo $i; ?>" id="taxonomy-<?php echo $i; ?>" value="<?php echo $args['taxonomy']; ?>" />
								<input type="hidden" name="category-<?php echo $i; ?>" id="category-<?php echo $i; ?>" value="<?php echo $args['category']; ?>" />
							<?php } else { echo userpro_edit_field_misc( $i, 'post_categories', $args, null, null, __('Select Categories','userpro') ); }
							break;
						default:
							if (isset($args['post_meta']) && isset($args['post_meta_labels']) ) {
								$post_meta = explode(',',$args['post_meta']);
								$post_meta = array_combine( $post_meta, explode(',', $args['post_meta_labels']) );
								foreach($post_meta as $meta_key => $meta_label) {
									if ($meta_key == $k) {
										echo userpro_edit_field_misc( $i, $meta_key, $args, $meta_label );
									}
								}
							}
							break;
					}
				}
				
			?>
			
			<?php } else { ?>
			
			<?php echo userpro_edit_field_misc( $i, 'post_title', $args, null, null, __('Enter post title here...','userpro') ); ?>
			
			<?php echo userpro_post_editor( $i, 'userpro_editor', $args ); ?>
			
			<?php echo userpro_edit_field_misc( $i, 'post_featured_image', $args ); ?>
			
			<?php if ( count(userpro_publish_types($args)) > 1 ) { echo userpro_edit_field_misc( $i, 'post_type', $args, __('Post Type','userpro') ); } else { ?>
				<input type="hidden" name="post_type-<?php echo $i; ?>" id="post_type-<?php echo $i; ?>" value="<?php if (isset($args['post_type'])) echo $args['post_type']; ?>" />
			<?php } ?>
		
			<?php if (isset($args['taxonomy']) && isset($args['category'])){ ?>
				<input type="hidden" name="taxonomy-<?php echo $i; ?>" id="taxonomy-<?php echo $i; ?>" value="<?php echo $args['taxonomy']; ?>" />
				<input type="hidden" name="category-<?php echo $i; ?>" id="category-<?php echo $i; ?>" value="<?php echo $args['category']; ?>" />
			<?php
			} else {
				echo userpro_edit_field_misc( $i, 'post_categories', $args, null, null, __('Select Categories','userpro') );
			}
			?>
			
			<?php
			if (isset($args['post_meta']) && isset($args['post_meta_labels']) ) {
				$post_meta = explode(',',$args['post_meta']);
				$post_meta = array_combine( $post_meta, explode(',', $args['post_meta_labels']) );
				foreach($post_meta as $meta_key => $meta_label) {
					echo userpro_edit_field_misc( $i, $meta_key, $args, $meta_label );
				}
			}
			?>
			
			<?php } ?>
			
			<!-- End of Publisher -->

			<?php // Hook into fields $args, $user_id
			if (!isset($user_id)) $user_id = 0;
			$hook_args = array_merge($args, array('user_id' => $user_id, 'unique_id' => $i));
			do_action('userpro_after_fields', $hook_args);
			?>
			
			<?php // Hook into fields $args, $user_id
			if (!isset($user_id)) $user_id = 0;
			$hook_args = array_merge($args, array('user_id' => $user_id, 'unique_id' => $i));
			do_action('userpro_before_form_submit', $hook_args);
			?>
			
			<?php if ( isset( $args["{$template}_button_primary"] ) || isset( $args["{$template}_button_secondary"] ) ) { ?>
			<div class="userpro-field userpro-submit userpro-column">
				
				<?php if (isset($args["{$template}_button_primary"]) ) { ?>
				<?php if(isset($_GET['post_id']))
				{
					$my_post = get_post($_GET['post_id'] ); // $id - Post ID
                                         $author_id= $my_post->post_author;
                                if(get_current_user_id()==$author_id)
                                {         	
                                         	?>
				<input type="submit" value="<?php echo $args["{$template}_button_primary"]; ?>" class="userpro-button" />
				<?php }}
				elseif (empty($_GET['post_id']))
				{?>
					<input type="submit" value="<?php echo $args["{$template}_button_primary"]; ?>" class="userpro-button" />
				<?php }
			
			} ?>

				<img src="<?php echo $userpro->skin_url(); ?>loading.gif" alt="" class="userpro-loading" />
				<div class="userpro-clear"></div>
				
			</div>
			<?php } ?>
		
		</form>
	
	</div>

	</div>
<?php 
		/** Facebook Auto Post Bring Back , Added By Rahul */
?>
<?php 
	if (userpro_get_option('facebook_publish_autopost')) {							
		if ( userpro_get_option('facebook_publish_autopost_name') ) {
			$name = userpro_get_option('facebook_publish_autopost_name');  // post title
		} else { 
			$name = '';
		}				
		if ( userpro_get_option('facebook_publish_autopost_body') ) {
			$body = userpro_get_option('facebook_publish_autopost_body'); // post body
		} else {
			$body = '';
		}
		if ( userpro_get_option('facebook_publish_autopost_caption') ) {
			$caption = userpro_get_option('facebook_publish_autopost_caption'); // caption, url, etc.
		} else {
			$caption = '';
		} 
		if ( userpro_get_option('facebook_publish_autopost_description') ) {
			$description = userpro_get_option('facebook_publish_autopost_description'); // full description
		} else {
			$description = '';
		}
		if ( userpro_get_option('facebook_publish_autopost_link') ) {
			$link = userpro_get_option('facebook_publish_autopost_link'); // link
		} else {
			$link = '';
		} 
?>

<div id="fb-post-data" data-fbappid="<?php echo userpro_get_option('facebook_app_id'); ?>" data-message="<?php echo $body; ?>" data-caption="<?php echo $caption; ?>" data-link="<?php echo $link; ?>" data-name="<?php echo $name; ?>" data-description="<?php echo $description; ?>"></div>
<?php 
	}
?>
