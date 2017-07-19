<?php
/**
 * The Template for displaying all single project
 */
 
// UPDATE POST
global $post;

$postTitleError = '';
$current_user_is_admin = woffice_current_is_admin();
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
	    'post_type' => 'project'
	);
	// UPDATE THE POST
	wp_update_post( $post_information );
	
	/* We update the taxnonmy */
	if (isset($_POST['project_category']) && $_POST['project_category'] != "no-category") : 
		$project_catgeory_object = get_term_by( 'slug', $_POST['project_category'], 'project-category' );		
		//fw_print($project_catgeory_object);
		$value_set = wp_set_post_terms( $post->ID, array($project_catgeory_object->term_id), 'project-category');
		//fw_print($value_set);
	endif;

	/* We check if dates are set */
	if (!empty($_POST['project_start']) && !empty($_POST['project_end'])){

		$start_date = wp_strip_all_tags($_POST['project_start']);
		$end_date = wp_strip_all_tags($_POST['project_end']);

		/* We check if dates are end isn't before date start */
		if (strtotime($_POST['project_end']) > strtotime($_POST['project_end'])){
			$postDateError = __( 'Dates are not good, please check again.','woffice');
			$has_error = true;
		}

		fw_set_db_post_option($post->ID, 'project_date_start', $start_date);
		fw_set_db_post_option($post->ID, 'project_date_end', $end_date);

	}
	else {
		$start_date = $end_date = '';
	}

	/* Projects Member */
	/* We check if some members have been selected */
	if(!empty($_POST['project_members'])) {
		$projects_users = array();
		foreach($_POST['project_members'] as $member) {
			$projects_users[] = $member;
		}
		fw_set_db_post_option($post->ID, 'project_members', $projects_users);
	}

    $user = wp_get_current_user();
    if($post->post_author == $user->ID || $current_user_is_admin) {
        if (isset($_POST['only_author_can_edit']) && $_POST['only_author_can_edit'] == 'yes') {
            fw_set_db_post_option($post->ID, 'only_author_can_edit', true);
        } else {
            fw_set_db_post_option($post->ID, 'only_author_can_edit', false);
        }
    } else {
        $only_author_can_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'only_author_can_edit') : '';
        fw_set_db_post_option($post->ID, 'only_author_can_edit', $everyone_edit);
    }
		
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
					
					<?php if (woffice_is_user_allowed_projects()) : ?>
					
						<?php $post_classes = array('box','content'); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
							<?php if ( has_post_thumbnail()) : ?>
								<!-- THUMBNAIL IMAGE -->
                                <?php woffice_render_featured_image_single_post($post->ID) ?>

							<?php endif; ?>
							<div id="project-nav" class="intern-box">
								<div class="item-list-tabs-project">
									<?php 
									if (function_exists('woffice_get_project_menu')){
										echo woffice_get_project_menu($post);
									}
									?>
								</div>
							</div>
							
											
							<!-- DISPLAY ALL THE CONTENT OF THE project ARTICLE-->
							<div id="project-content-view">
								
								<header id="project-meta">
							
									<?php //GET THE PROGRESS BAR
									echo woffice_project_progressbar(); ?>
									
									<div class="row">
										
										<?php // GET THE PROJECT DATES
										$project_date_start = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_start') : '';
										$project_date_end = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_end') : '';
										
										// GET THE TERMS
										$project_terms = get_the_term_list( $post->ID, 'project-category', '', ', ' );
										
										// GET MEMBERS 
										$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_members') : '';
										// GET THE LINKS
										$project_links = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_links') : '';
										
										// CLASS FOR THE COLUMN
										/*if( ( empty($project_date_start) && empty($project_terms) ) || ( empty($project_members) || empty($project_links ) ) ):
											$column_class = 6;
										elseif( ( empty($project_date_start) && empty($project_terms) && empty($project_members) ) || 
										( empty($project_date_start) && empty($project_terms) && empty($project_links) )):
											$column_class = 12;
										else : 
											$column_class = 4;
										endif;*/
										?>

										<?php if (!empty($project_terms) || !empty($project_date_start)): ?>
											
											<div class="col-md-4">
												<ul class="project-meta-list">
													<?php if(!empty($project_date_start)): ?>
														<li class="project-meta-date">
															<?php echo date_i18n(get_option('date_format'),strtotime(esc_html($project_date_start))).' - '.date_i18n(get_option('date_format'),strtotime(esc_html($project_date_end))); ?>
														</li>
													<?php endif; ?>
													
													<?php if (!empty($project_terms)): ?>
														<li class="project-meta-category">
															<?php echo get_the_term_list( $post->ID, 'project-category', '', ', ' ); ?>
														</li>
													<?php endif; ?>
												</ul>
											</div>
										<?php endif; ?>
										
										<?php if (!empty($project_members)): ?>
											<div class="col-md-4">
												<ul class="project-meta-list">
													<li class="project-meta-users"><?php _e("Project's Members","woffice"); ?></li>
												</ul>
												<div class="project-members">
													<?php 
													foreach($project_members as $project_member) {
														if (function_exists('bp_is_active')):
															$user_info = get_userdata($project_member);
															if (!empty($user_info->display_name)){
																$name = woffice_get_name_to_display($user_info);
																echo'<a href="'. esc_url(bp_core_get_user_domain($project_member)) .'" title="'. $name .'" data-toggle="tooltip" data-placement="top">';
																	echo get_avatar($project_member);
																echo'</a>';
															}
															else {
																echo'<a href="'. esc_url(bp_core_get_user_domain($project_member)) .'">';
																	echo get_avatar($project_member);
																echo'</a>';	
															}
														else : 
															echo get_avatar($project_member);
														endif;
													} ?>
												</div>
											</div>
										<?php endif; ?>
										
										<?php if (!empty($project_links)): ?>
											<div class="col-md-4">
												<ul class="project-meta-list">
													<li  class="project-meta-links"><?php _e("Project's Links","woffice"); ?></li>
												</ul>
												<ul id="project-links">
													<?php 
													foreach($project_links as $project_link){
														echo'<li><a href="'.esc_url($project_link['href']).'" target="_blank">';
															echo'<i class="'.esc_attr($project_link['icon']).'"></i> '.esc_html($project_link['title']);
														echo'</a></li>';
													}
													?>
												</ul>
											</div>
										<?php endif; ?>
									</div>
								</header>
								
								<div class="intern-padding">
									<?php // THE CONTENT 
									the_content(); ?>
								</div>
							</div>
								
							<div class="intern-padding">
								<!-- LOADER -->
								<div id="project-loader" class="woffice-loader">
									<i class="fa fa-spinner"></i>
								</div>
								
								<?php
								$project_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_edit') : '';
								if ( $project_edit == 'frontend-edit' && is_user_logged_in() ) : ?>
									<!-- EDIT THE CONTENT IN FRONTEND VIEW-->
									<div id="project-content-edit">
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
											<?php if (isset($postDateError)) { ?>
												<div id="message" class="infobox error">
													<?php echo $postDateError; ?>
												</div>
											<?php } ?>

											<div class="row">
												<div class="col-md-6">
													<p>
														<label for="project_start"><?php _e( 'Project\'s starting date:', 'woffice' ); ?></label>
														<input type="text" name="project_start" id="project_start" class="datepicker" value="<?php echo $project_date_start; ?>" placeholder="<?php echo $project_date_start; ?>"/>
													</p>
												</div>
												<div class="col-md-6">
													<p>
														<label for="project_end"><?php _e( 'Project\'s ending date:', 'woffice' ); ?></label>
														<input type="text" name="project_end" id="project_end" class="datepicker" value="<?php echo $project_date_end; ?>" placeholder="<?php echo $project_date_end; ?>"/>
													</p>
												</div>
											</div>

											<?php
											// MEMBERS SELECT
											$tt_users = array();
											$tt_users_obj = get_users(array( 'fields' => array( 'ID', 'user_nicename' )));
											foreach ($tt_users_obj as $tt_user) {
												$tt_users[$tt_user->ID] = woffice_get_name_to_display($tt_user->ID); }
											$tt_users_tmp = $tt_users;  ?>
											<p>
												<label for="project_members"><?php _e( 'Project\'s members:', 'woffice' ); ?></label>
												<small><?php _e( 'If it\'s empty, all the members will be allowed to see the project', 'woffice' ); ?></small>
												<select multiple="multiple" name="project_members[]" class="form-control">
													<?php
													foreach ($tt_users as $key => $user) {
														$selected = (in_array($key, $project_members)) ? "selected" : "";
														echo'<option value="'.$key.'" '.$selected.'>'.$user.'</option>';
													}
													?>
												</select>
											</p>
										    
										    <?php 
									    	// SEARCH FOR PROJECT CATEGORIES
							                $terms = get_terms('project-category', array('hide_empty' => false));
											if ($terms) : ?>
												<p>            
											        <label for="project_category"><?php _e( 'Change Project\'s Category:', 'woffice' ); ?></label>
											        <?php // DROPDOWN LIST
											        echo'<select name="project_category" class="postform">';
												        echo'<option value="no-category">----</option>';
												        foreach ( $terms as $term ) {
												            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
												        }
											        echo'</select>'; ?>
											    </p>
											<?php endif; ?>
										 
										    <p>            
										        <label for="postcontent"><?php _e( 'Article\'s Content:', 'woffice' ); ?></label>
										        <?php 
										        	$settings = array(
										        		'textarea_name' => 'postcontent',
										        		'textarea_rows' => '20'
										        	);
											        wp_editor( $content, 'postcontent', $settings);
										        ?>
										    </p>
                                            <?php
                                            $user = wp_get_current_user();
                                            if($post->post_author == $user->ID || $current_user_is_admin) : ?>
                                                <p>
                                                    <?php $only_author_can_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'only_author_can_edit') : '';?>
                                                    <label for="only_author_can_edit">Only author can edit?</label>
                                                    <input type="checkbox" name="only_author_can_edit" id="only_author_can_edit" value="yes" <?php echo ($only_author_can_edit == true) ? 'checked' : ''; ?>/>
                                                </p>
                                            <?php endif;?>
										    <p class="text-right">        
										        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
										        <input type="hidden" name="submitted" id="submitted" value="true" />
										        <button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i> <?php _e( 'Update Project', 'woffice'); ?></button>
										    </p>
										</form>
									</div>
								<?php endif; ?>
								
								<?php $project_todo = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_todo') : '';
								if($project_todo): ?>
									<!-- SEE THE TODO LIST-->
									<div id="project-content-todo">
										<?php // IF THERE IS A WUNDERLIST LINK 
										$project_wunderlist = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_wunderlist') : '';
										if(!empty($project_wunderlist)): ?>
										
											<iframe src="https://www.wunderlist.com/lists/<?php echo $project_wunderlist; ?>"; width="100%" height="600"></iframe>
											
										<?php else: ?>
									
											<?php woffice_projects_todo($post); ?>
									
										<?php endif; ?>
										
									</div>
								<?php endif; ?>
								
								<!-- SEE THE FILES-->
								<div id="project-content-files">
                                    <?php
                                    //Subdir fix
                                    if(isset($_GET['drawer']) && strpos('projects_', $_GET['drawer']) === FALSE ) { ?>
                                        <script>
                                            (function($){
                                                if(!window.location.hash) {
                                                    location.href = window.location.href + '#project-content-files';
                                                }
                                            })(jQuery);
                                        </script>
                                    <?php
                                    }
                                    ?>
									<?php // IF THERE IS FILES
									$project_files = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_files') : '';
									if(!empty($project_files)):
									
										if (defined('fileaway')): 	
											$post_slug = $post->post_name;	
											woffice_projects_fileway_manager($post_slug);
										else : 
											$post_slug = $post->post_name;
											$the_terms = get_term_by( 'slug', $post_slug, 'multiverso-categories');
											$first = true;
											foreach ($the_terms as $term):
												if (!empty($term) && $first):
													echo do_shortcode('[mv_single_category id='.$term.']');	
													 mv_managefiles_projects($term);	
													$first = false;
												endif;
											endforeach;
										endif;
									endif; ?>
								</div>
								
								<!-- SEE THE COMMENTS-->
								<div id="project-content-comments">
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
								
							</div>
						</article> 
					<?php else : 
						get_template_part( 'content', 'private' );
					endif; ?>
				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->
	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();