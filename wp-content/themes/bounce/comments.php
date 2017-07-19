<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if(post_password_required()) { ?>
	
<?php
	return;
}


/////////////////////////////////////// Comment Template ///////////////////////////////////////

function comment_template($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	
	<div id="comment-<?php comment_ID(); ?>" class="comment-box">

		<div class="comment-avatar">
			<?php echo get_avatar($comment, $size='60',$default=get_template_directory_uri().'/lib/images/gravatar.png'); ?>
			<span class="post-author"><?php _e('Author', 'gp_lang'); ?></span>
		</div>
		
		<div class="comment-body">
			
			<div class="comment-author">
				<?php printf(__('%s', 'gp_lang'), comment_author_link()) ?>
			</div>
			
			<div class="comment-date">
				<?php comment_time(get_option('date_format')); ?>, <?php comment_time(get_option('time_format')); ?> &nbsp;&nbsp;/&nbsp; <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'gp_lang'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
				
			</div>	
					
			<div class="comment-text">
				<?php comment_text() ?>
				<?php if($comment->comment_approved == '0') { ?>
					<div class="error">
						<?php _e('Your comment is awaiting moderation.', 'gp_lang'); ?>
					</div>
				<?php } ?>
			</div>
			
		</div>	
		
	</div>

<?php } ?>

<?php if('open' == $post->comment_status OR have_comments()) { ?>	
	<div id="comments">
<?php } ?>

	<?php if(have_comments()) { // If there are comments ?>
		
		<h3 class="comments"><?php comments_number(__('No Comments', 'gp_lang'), __('1 Comment', 'gp_lang'), __('% Comments', 'gp_lang')); ?></h3>
		
		<ol id="commentlist">
			<?php wp_list_comments('callback=comment_template'); ?>
		</ol>
							
		<?php $total_pages = get_comment_pages_count(); if($total_pages > 1) { ?>
			<div class="wp-pagenavi comment-navi"><?php paginate_comments_links(); ?></div>
		<?php } ?>	

		<?php if('open' == $post->comment_status) {} else { ?>
		
			<h4><?php _e('Comments are now closed on this post.', 'gp_lang'); ?></h4>
	
		<?php } ?>
		
	<?php } ?>

	<?php if('open' == $post->comment_status) { 

		$aria_req = ( $req ? " aria-required='true'" : '' );
		$required_text = sprintf( '' . __('Required fields are marked %s', 'gp_lang' ), '<span class="required">*</span>');	
			
		$comment_args = array(

		'title_reply' => __('Leave a Reply', 'gp_lang'),
		'title_reply_to' => __('Leave a Reply to %s', 'gp_lang'),
		'cancel_reply_link' => __('Cancel Reply', 'gp_lang'),
		'label_submit' => __('Post Comment', 'gp_lang'),

		'comment_field' => '<p class="comment-form-comment"><label for="comment">'.__('Comment', 'gp_lang').'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',

		'must_log_in' => '<p class="must-log-in">'.sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'gp_lang'), wp_login_url(apply_filters('the_permalink', get_permalink()))).'</p>',

		'logged_in_as' => '<p class="logged-in-as">'.sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'gp_lang'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))).'</p>',

		'comment_notes_before' => '<p class="comment-notes">'.__('Your email address will not be published. ', 'gp_lang').($req ? $required_text : '').'</p>',

		'comment_notes_after' => '<p class="form-allowed-tags">'.sprintf(__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'gp_lang'), ' <code>'.allowed_tags().'</code>').'</p>',

		'fields' => apply_filters('comment_form_default_fields', array(

			'author' => '<p class="comment-form-author">'.'<label for="author">'.__('Name', 'gp_lang').'</label> '.($req ? '<span class="required">*</span>' : '').'<input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30"'.$aria_req.' /></p>',
	
			'email' => '<p class="comment-form-email"><label for="email">'.__('Email', 'gp_lang').'</label> '.( $req ? '<span class="required">*</span>' : '').'<input id="email" name="email" type="text" value="'.esc_attr( $commenter['comment_author_email']).'" size="30"'.$aria_req.' /></p>',
	
			'url' => '<p class="comment-form-url"><label for="url">'.__('Website', 'gp_lang').'</label>'.'<input id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30" /></p>'
	
		)));
				
		comment_form($comment_args);
		
	} ?>

<?php if('open' == $post->comment_status OR have_comments()) { ?>
	</div>
<?php } ?>