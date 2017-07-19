<?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Sorry, you can\'t load this page directly.');

// Do we have comments OR are comments at least open
if ( have_comments() || 'open' == $post->comment_status) : ?>
<!-- Post Comments -->
<div class="userComments" id="Comments">
	<div id="comments" class="invisible"></div>

	
	<?php
	// Show a title "Comments" for the section
	if ( have_comments() ) :
		echo '<h4 class="sectionTitle">' . __('Comments', THEME_NAME) . '</h4>';
	endif;

	// Check if password protected
	if ( post_password_required() ) { 
		echo '<p class="nocomments">';
		_e('This post is password protected. Enter your password to view comments.',THEME_NAME );
		echo '</p>';
		return;
	}
	
	// Comment display function
	function mytheme_comment($comment, $args, $depth) {
		global $themePath, $avatar_size;
		$GLOBALS['comment'] = $comment; ?>
	
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<article id="comment-<?php comment_ID(); ?>">

				<div class="comment-text the-comment-container item-container">
					<div class="the-comment-content">

						<?php 
						$avatar_size = AVATAR_SIZE; // defined in functions.php
						if (!$avatar_size) $avatar_size = 35;

						/*
						// Show the avatar for the current user
						preg_match('/(?<=src=[\'|"])[^\'|"]*?(?=[\'|"])/i', get_avatar($comment, $size=$avatar_size), $avatarURL);  // filter the results for the SRC value only
						$src = $avatarURL[0]; // set the src to the URL value
						
						// Check if we can do a quick resize on the local image (usually a backup image for those without gravatars)
						parse_str(htmlspecialchars_decode($avatarURL[0]), $output);
						$imgURL = str_replace('?s='.$avatar_size, '', $output['d']); // strip query string
						if ( $imgURL ) {
							$image = vt_resize( '', $imgURL, $avatar_size, $avatar_size, true );
							$src = str_replace(urlencode($imgURL), urlencode($image['url']), $avatarURL[0]);
						}
						
						// output the image
						$theAvatar = '<div class="avatar" style="background-image: url(\''.$src.'\');"></div>';
						*/

						echo get_avatar($comment, $size=$avatar_size);
						?>
						
						<header class="comment-header">
							<?php echo isset($theAvatar)? $theAvatar : ''; ?>
							<div class="comment-meta commentmetadata">
								<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply',THEME_NAME), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>  &nbsp; <?php edit_comment_link(__('Edit',THEME_NAME),' ','') ?> 
							</div>
							<h4 class="poster-name"><cite><?php comment_author_link() ?></cite></h4>
							<div class="comment-header-info clearfix">
								<span class="date"><?php comment_date(); ?></span>
							</div>
						</header>
						
						<div class="comment-content">
							<?php comment_text() ?>
						</div>
						
						<footer class="comment-footer">
							<?php if ($comment->comment_approved == '0') : ?>
								<span class="awaiting_moderation"><?php _e('Your comment is awaiting moderation.', THEME_NAME) ?></span><br />
							<?php endif; ?>
						</footer>

					</div>
				</div>
			</article>
		<?php 
	}
	
	function list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
	
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<cite><?php comment_author_link(); ?></cite><span class="date"><?php comment_date('m-d-y'); ?></span><br />
	
		<?php 
	} 
	
	// Comments output
	if  ( have_comments() ) : ?>
	
		<?php 
		if ( ! empty($comments_by_type['comment']) ) : ?>
			<div id="CommentListWrapper">
				<ol class="comment-list">
					<?php 
					// show individual comments
					wp_list_comments('callback=mytheme_comment&type=comment'); 
					?>
				</ol>
					
				<div class="comms-navigation">
					<div style="float:left"><?php previous_comments_link() ?></div>
					<div style="float:right"><?php next_comments_link() ?></div>
				</div>
			</div>
			<?php 
		endif;
		
	endif;
	
	
	// Add Comment Form
	if ('open' == $post->comment_status) : ?>
		
		<div id="RespondToPost">
			<a name="respond"></a>
	
			<div class="the-comment-container">
	
				<h4 class="sectionTitle"><?php comment_form_title( __('Add a comment', THEME_NAME), __('Reply to %s', THEME_NAME) ); ?></h4>

				<div class="cancel-comment-reply">
					<?php cancel_comment_reply_link( __('Cancel reply?', THEME_NAME) ); ?>
				</div>
				
				<?php if ( $user_ID ) : ?>
					<header class="comment-reply-header">
						<?php
						$avatar_size = AVATAR_SIZE; // defined in functions.php
						if (!$avatar_size) $avatar_size = 35;
						
						/*
						// Show the avatar for the current user
						preg_match('/(?<=src=[\'|"])[^\'|"]*?(?=[\'|"])/i', get_avatar($user_ID, $size=$avatar_size), $avatarURL);  // filter the results for the SRC value only
						echo '<div class="avatar" style="background-image: url(\''.$avatarURL[0].'\');"></div>';
						*/

						echo get_avatar($user_ID, $size=$avatar_size);
						?>
						<div class="comment-meta commentmetadata">
						</div>
						<h4 class="poster-name comment-logged-in-link">
							<cite><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></cite>
						</h4>
						<div class="comment-header-info clearfix">
							<span class="already-logged-in"><?php _e('You are currently logged in', THEME_NAME); ?></span> &nbsp;|&nbsp; <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', THEME_NAME); ?>" class="comment-log-out"><?php _e('Log out', THEME_NAME); ?></a>
						</div>
					</header> 
				<?php endif; ?>
				
				<?php 
				if ( get_option('comment_registration') && !$user_ID ) : ?>
					
					<p><?php printf( __('You must be %s logged in %s to comment.', THEME_NAME), '<a href="'. get_option('siteurl') . '/wp-login.php?redirect_to='. urlencode(get_permalink()) .'">', '</a>'); ?></p>
					
				<?php else : ?>
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="PostCommentForm" class="comment-form">
						<?php if ( !$user_ID ) : ?>
							<p>
								<label  class="overlabel" for="author"><?php _e('Name', THEME_NAME); ?> *</label>
								<input type="text" class="textInput" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" />
							</p>
							<p>
								<label class="overlabel" for="email"><?php _e('Email', THEME_NAME); ?> *</label>
								<input type="text" class="textInput" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
							</p>
							<p>
								<label  class="overlabel" for="url"><?php _e('Website', THEME_NAME); ?></label>
								<input type="text" class="textInput" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
							</p>
						<?php endif; ?>
						<p>
							<label class="overlabel for-comment<?php if ( $user_ID ) { echo ' loggedIn'; } ?>" for="comment"><?php _e('Comment', THEME_NAME); ?></label>
							<textarea class="textInput commentTextarea" name="comment" id="comment" cols="50" rows="12" tabindex="4"></textarea>
						</p>
						<div><button type="submit" class="btn"><span><?php _e('Add Comment', THEME_NAME); ?></span></button><?php comment_id_fields(); ?></div>
						<div><?php do_action('comment_form', $post->ID); ?></div>
					</form>	
					<?php 
				endif; // If registration required and not logged in ?>
	
			</div>
			
		</div><!-- END id=Respond -->
		<?php 
		
	endif;	// if ('open' == $post->comment_status) : ?>
	

	<?php // trackbacks
	if ( have_comments() ) :
		if ( ! empty($comments_by_type['pings']) ) : ?>
			<ol class="comment-list">
				<?php wp_list_comments('callback=list_pings&type=pings'); ?>
			</ol>
		
			<div class="comms-navigation">
				<div style="float:left"><?php previous_comments_link() ?></div>
				<div style="float:right"><?php next_comments_link() ?></div>
			</div>
			<?php 
		endif; 		
	endif; ?>


</div>	<!-- END Post Comments -->
<?php endif; // if ( have_comments() || 'open' == $post->comment_status)