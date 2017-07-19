<?php
/**
 * The Template for displaying all single posts
 */

global $post;
$current_user_is_admin = woffice_current_is_admin();
if (woffice_edit_allowed() == true) {

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
		    'post_type' => $post->post_type
		);
		// UPDATE THE POST
		wp_update_post( $post_information );

		/* We update the taxnonmy */
		if (isset($_POST['blog_category']) && $_POST['blog_category'] != "no-category") :
			$post_catgeory_object = get_category_by_slug($_POST['blog_category']);
			//fw_print($post_catgeory_object);
			$value_set = wp_set_post_terms( $post->ID, array($post_catgeory_object->term_id), 'category' );
			//fw_print($value_set);
		endif;


        if($current_user_is_admin) {
            if (isset($_POST['everyone_edit']) && $_POST['everyone_edit'] == 'yes') {
                fw_set_db_post_option($post->ID, 'everyone_edit', true);
            } else {
                fw_set_db_post_option($post->ID, 'everyone_edit', false);
            }
        } else {
            $everyone_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'everyone_edit') : '';
            fw_set_db_post_option($post->ID, 'everyone_edit', $everyone_edit);
        }
		// REFRESH TO SEE CHANGES :
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
	/*END*/

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
					<?php // We check for the role : 
					if (woffice_is_user_allowed()) { ?>
						
						<?php // Include the page content template.
						get_template_part( 'content');
						?>
						
						<?php
						/*
						 * FRONT END EDIT
						 */
						if (woffice_edit_allowed() == true) { ?>
							
							<div class="box">
								<div class="intern-padding">
							
									<div class="center" id="blog-bottom">
									
										<?php echo'<a href="javascript:void(0)" class="btn btn-default" id="show-blog-edit"><i class="fa fa-pencil-square-o"></i> '. __("Edit Post", "woffice") .'</a>'; ?>

										<?php
										// Delete button :
										$current_user = wp_get_current_user();
										if (is_user_logged_in() && (current_user_can('edit_others_posts') || $current_user->ID == $post->post_author) ) {
											echo '<a onclick="return confirm(\'' . __('Are you sure you wish to delete article :', 'woffice') . ' ' . get_the_title() . ' ?\')" href="' . get_delete_post_link(get_the_ID(), '', true) . '" class="btn btn-default">
												<i class="fa fa-trash-o"></i> ' . __("Delete", "woffice") . '
											</a>';
										} ?>

									</div>
									
									<!-- LOADER -->
									<div id="blog-loader" class="intern-padding woffice-loader">
										<i class="fa fa-spinner"></i>
									</div>
									
									<!-- EDIT THIS ARTICLE-->
									<div id="blog-edit" class="intern-padding">
										<!-- THE FORM -->
										<?php 
										// GET INFOS : 
										$current_post = $post->ID;
								        $title = get_the_title();
								        $content = get_the_content();
										?>
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
								        	// SEARCH FOR BLOG CATEGORIES
											$blog_categories_args = array(
												'type'                     => 'post',
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'number'				   => '10',
												'taxonomy'                 => 'category',
											);
											$terms = get_categories($blog_categories_args);
											if ($terms) : ?>
												<p>            
											        <label for="blog_category"><?php _e( 'Change Article\'s Category :', 'woffice' ); ?></label>
											        <?php // DROPDOWN LIST
											        echo'<select name="blog_category" class="postform">';
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
                                            <?php
                                                if($current_user_is_admin):
                                                    $everyone_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'everyone_edit') : '';
                                                    ?>
                                                <p>
                                                    <label for="everyone_edit">Everyone can edit?</label>
                                                    <input type="checkbox" name="everyone_edit" id="everyone_edit" value="yes" <?php if($everyone_edit) echo 'checked' ?>/>
                                                </p>
                                                <?php endif; ?>
										    <p class="text-right">        
										        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
										        <input type="hidden" name="submitted" id="submitted" value="true" />
										        <button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i> <?php _e( 'Update Article', 'woffice'); ?></button>
										    </p>
										</form>
										
										<div class="center">
											<a href="javascript:void(0)" class="btn btn-default" id="hide-blog-edit">
												<i class="fa fa-arrow-left"></i> <?php _e("Go Back", "woffice"); ?>
											</a>
										</div>
									</div>
									
								</div>
							</div>
						
						<?php } ?>
					
					
						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					
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