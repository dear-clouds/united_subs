<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_blogs_loop' ) ?>

<?php if ( bp_has_blogs( bp_ajax_querystring( 'blogs' ) ) ) : ?>

	<div class="bp-pagination">

		<div class="pag-count" id="blog-dir-count">
			<?php bp_blogs_pagination_count() ?>
		</div>

		<div class="pagination-links" id="blog-dir-pag">
			<?php bp_blogs_pagination_links() ?>
		</div>

	</div>

	<ul id="blogs-list" class="item-list">
	<?php while ( bp_blogs() ) : bp_the_blog(); ?>

		<li class="item-li">
			<div class="item-container">
				<div class="item-content">

					<div class="item-avatar">
						<a href="<?php bp_blog_permalink() ?>"><?php 
							
							$size = 64;
							
							// Using code from the function "bp_blog_avatar()" to return the image before converting it to the theme's required code
							// $avatar = apply_filters( 'bp_get_blog_avatar_' . $GLOBALS['blogs_template']->blog->blog_id, bp_core_fetch_avatar( array( 'item_id' => $GLOBALS['blogs_template']->blog->admin_user_id, 'email' => $GLOBALS['blogs_template']->blog->admin_user_email, 'type' => 'full', 'html' => 'false', 'width' => $size, 'height' => $size ) ) );
							// $blogAvatar = apply_filters( 'bp_get_blog_avatar', $avatar, $GLOBALS['blogs_template']->blog->blog_id, array( 'item_id' => $GLOBALS['blogs_template']->blog->admin_user_id, 'email' => $GLOBALS['blogs_template']->blog->admin_user_email, 'type' => 'full', 'html' => 'false', 'width' => $size, 'height' => $size ) );
							
							// get the avatar image
							// $avatarURL = bp_theme_avatar_url($size,$size,'',$blogAvatar );
							// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:'.$size.'px; height:'.$size.'px; "></div>';
							
							bp_blog_avatar('type=full') ?>
						</a>
					</div>

					<div class="action">
						<div class="generic-button blog-button visit">
							<a href="<?php bp_blog_permalink() ?>" class="visit" title="<?php _e( 'Visit Blog', 'buddypress' ) ?>"><?php _e( 'Visit Blog', 'buddypress' ) ?></a>
						</div>
		
						<div class="meta">
							<?php bp_blog_latest_post() ?>
						</div>
		
						<?php do_action( 'bp_directory_blogs_actions' ) ?>
					</div>
		
					<div class="item">
						<h4 class="item-title"><a href="<?php bp_blog_permalink() ?>"><?php bp_blog_name() ?></a></h4>
						<div class="item-meta"><span class="activity"><?php bp_blog_last_active() ?></span></div>
		
						<?php do_action( 'bp_directory_blogs_item' ) ?>
					</div>
		
					<div class="clear"></div>
				
				</div>
			</div>


		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_directory_blogs_list' ) ?>

	<?php bp_blog_hidden_fields() ?>

<?php else: ?>

	<div id="message" class="messageBox note icon">
		<span><?php _e( 'Sorry, there were no blogs found.', 'buddypress' ) ?></span>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_blogs_loop' ) ?>
