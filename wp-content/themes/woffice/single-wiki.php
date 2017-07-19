<?php
/**
 * The Template for displaying all single wiki
 */
 
// UPDATE POST
global $post;

$postTitleError = '';

if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ) {
 	// IF NO TITLE
    if ( trim( $_POST['postTitle'] ) === '' ) {
        $postTitleError = __('Please enter a title.','woffice');
        $hasError = true;
    }
    // GET INFORMATIONS
	$post_information = array(
	    'ID' => $post->ID,
	    'post_title' =>  wp_strip_all_tags( $_POST['postTitle'] ),
	    'post_content' => $_POST['postcontent'],
	    'post_type' => 'wiki'
	);
	// UPDATE THE POST
	wp_update_post( $post_information );
		
	/* We update the taxnonmy */
	if (isset($_POST['wiki_category']) && $_POST['wiki_category'] != "no-category") : 
		$wiki_catgeory_object = get_term_by( 'slug', $_POST['wiki_category'], 'wiki-category' );		
		//fw_print($wiki_catgeory_object);
		$value_set = wp_set_post_terms( $post->ID, array($wiki_catgeory_object->term_id), 'wiki-category');
		//fw_print($value_set);
	endif;
	
	// REFRESH TO SEE CHANGES :
	header('Location: '.$_SERVER['REQUEST_URI']);
}

get_header(); ?>

	<?php // Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div id="left-content">

			<?php  //GET THEME HEADER CONTENT

			woffice_title(get_the_title()); ?> 	

			<!-- START THE CONTENT CONTAINER -->
			<div id="content-container">
				<!-- START CONTENT -->
				<div id="content">
					<?php if (woffice_is_user_allowed_wiki()){
						
						$post_classes = array('box','content'); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
							<?php if ( has_post_thumbnail()) : ?>
								<!-- THUMBNAIL IMAGE -->
								<?php woffice_render_featured_image_single_post(get_the_ID()); ?>
							<?php endif; ?>
							<div id="wiki-nav" class="intern-box">
								<div class="item-list-tabs-wiki">
									<ul>
										<li id="wiki-tab-view" class="active">
											<a href="javascript:void(0)" class="fa-file-o"><?php _e("View","woffice"); ?></a>
										</li>
										<?php if (woffice_edit_allowed() == true) { ?>
											<li id="wiki-tab-edit">
												<a href="javascript:void(0)" class="fa-pencil-square-o"><?php _e("Edit","woffice"); ?></a>
											</li>
										<?php } ?>
										<li id="wiki-tab-comments">
											<a href="javascript:void(0)" class="fa-comments-o">
												<?php _e("Comments","woffice"); ?>
												<span><?php comments_number( '0', '1', '%' ) ?></span>
											</a>
										</li>
										<li id="wiki-tab-revisions">
											<a href="javascript:void(0)" class="fa-history"><?php _e("Revisions","woffice"); ?></a>
										</li>
										<?php
										$current_user = wp_get_current_user();
										if ($post->post_author == $current_user->ID || woffice_current_is_admin()) :
										?>
											<li id="wiki-tab-delete">
												<a onclick="return confirm('<?php echo __('Are you sure you wish to delete article :','woffice').' '. get_the_title(); ?> ?')" href="<?php echo get_site_url().wp_nonce_url('/wp-admin/post.php?action=delete&amp;post='.get_the_ID(), 'delete-post_'.get_the_ID() ); ?>" class="fa-trash-o">
													<?php _e("Delete","woffice"); ?>
												</a>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
							<div class="intern-padding">
								<!-- LOADER -->
								<div id="wiki-loader" class="woffice-loader">
									<i class="fa fa-spinner"></i>
								</div>
								
								<!-- DISPLAY ALL THE CONTENT OF THE WIKI ARTICLE-->
								<div id="wiki-content-view">
									<?php // THE CONTENT 
									the_content(); ?>
									<?php // THE LIKE BUTTON 
									echo woffice_get_wiki_like_html(get_the_ID()); ?>
							  		<?php // DISPLAY THE NAVIGATION
							  		woffice_post_nav(); ?>
								</div>
								
								<?php if (woffice_edit_allowed() == true) { ?>
									<!-- EDIT THE CONTENT IN FRONTEND VIEW-->
									<div id="wiki-content-edit">
										<?php 
										// GET INFOS : 
										$current_post = $post->ID;
								        $title = get_the_title();
								        $content = get_the_content();
								        ?>
								        <!-- THE FORM -->
								        <form action="<?php the_permalink(); ?>" id="primaryPostForm" method="POST">
										    <p>
										        <label for="postTitle"><?php _e( 'Article\'s Title:', 'woffice' ); ?></label>
										        <input type="text" name="postTitle" id="postTitle" value="<?php echo esc_attr($title); ?>" class="required" />	 
										    </p>
										 
										    <?php if ( $postTitleError != '' ) { ?>
										        <div id="message" class="infobox error">
										        	<?php _e("Please enter a title","woffice"); ?>
										        </div>
										    <?php } ?>
										    
										    <?php 
								        	// SEARCH FOR WIKI CATEGORIES
							                $terms = get_terms('wiki-category', array('hide_empty' => false));
											if ($terms) : ?>
												<p>            
											        <label for="wiki_category"><?php _e( 'Change Article\'s Category:', 'woffice' ); ?></label>
											        <?php // DROPDOWN LIST
											        echo'<select name="wiki_category" class="postform">';
												        echo'<option value="no-category">----</option>';
												        foreach ( $terms as $term ) {
												            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
												        }
											        echo'</select>'; ?>
											    </p>
											<?php endif; ?>
										 
										    <p>            
										        <label for="postcontent"><?php _e( 'Article\'s Content:', 'framework' ); ?></label>
										        <?php 
										        	$settings = array(
										        		'textarea_name' => 'postcontent',
										        		'textarea_rows' => '20'
										        	);
											        wp_editor( $content, 'postcontent', $settings);
										        ?>
										    </p>
										 
										    <p class="text-right">        
										        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
										        <input type="hidden" name="submitted" id="submitted" value="true" />
										        <button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i> <?php _e( 'Update Article', 'woffice'); ?></button>
										    </p>
										</form>
									</div>
								<?php } ?>
								
								<!-- SEE THE COMMENTS-->
								<div id="wiki-content-comments">
									<?php 
									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) {
										comments_template();
									}
									else {
										_e("Comments are closed...","woffice");
									}
									?>
								</div>
								
								<!-- SEE THE REVISIONS-->
								<div id="wiki-content-revisions">
									<p>
										<?php echo __('This post was last modified by','woffice') .' <strong>'. get_the_modified_author() .'</strong>';
										echo __(' on','woffice').'<strong> '. get_the_modified_date().'</strong>.'; ?>
									</p>
									<?php // GET REVISIONS
										$revisions = wp_get_post_revisions(get_the_ID());
										if(!empty($revisions)):
											echo '<ul class="list-styled list-change">'; 
											foreach ($revisions as $revision) {
												$date = wp_post_revision_title($revision, false);
												echo '<li>'. esc_html($date) .'</li>';
											}
											echo '</ul>';
										else : 
											echo "<p>". __("This article has not been revised since publication.","woffice") ."</p>";
										endif; 
									?>
									<p>
										<?php echo __('This post was created by','woffice') .' <strong>'. get_the_author() .'</strong>';
										echo __(' on','woffice') .'<strong> '. get_the_date() .'</strong>.'; ?>
									</p>
								</div>
								
							</div>
						</article> 
					<?php } else { 
						get_template_part( 'content', 'private' );
					} ?>

				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->
	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();