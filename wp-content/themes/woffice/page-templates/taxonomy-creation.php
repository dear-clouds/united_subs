<?php
/**
* Template Name: Taxonomy Creation
*/

get_header(); 
?>

	<?php // Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div id="left-content">

			<?php  //GET THEME HEADER CONTENT

			woffice_title(get_the_title()); ?> 	

			<!-- START THE CONTENT CONTAINER -->
			<div id="content-container">

				<!-- START CONTENT -->
				<div id="content">
					<?php if (woffice_is_user_allowed()) { ?>
						<?php 
						// CUSTOM CLASSES ADDED BY THE THEME
						$post_classes = array('box','content');
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
							
							<div class="intern-padding">
								
								<?php the_content(); ?>
								
								<h3><i class="fa fa-tags"></i> <?php _e('Create a new category','woffice'); ?></h3>
								
								<div id="tax-alert"></div>
								
								<form action="#" method="post" id="taxonomy-creation">
									<div class="form-group">
										<label for="woffice_post_type"><i class="fa fa-file-text-o"></i> <?php _e('Select a post type','woffice'); ?></label>
										<?php 
										// We get all the post types and check if there is a taxonomy
										$the_post_types = get_post_types(array(
											'public' => true,
											'_builtin' => false
										));
										?>
										<select id="catgeory_post_type" class="form-control" name="woffice_post_type">
											<option value="post"><?php _e('post','woffice'); ?></option>
											<?php foreach ($the_post_types as $key=>$post_type) {
												 echo '<option value="'.$key.'">'.$post_type.'</option>';
											} ?>
											
										</select>
									</div>
									
									<div class="form-group" id="taxonomy-ajax">
										
									</div>
									
									<div class="form-group">
										<label for="woffice_tax_name"><i class="fa fa-bookmark-o"></i> <?php _e('Name','woffice'); ?></label>
										<input type="text" name="woffice_tax_name" id="new-tax-name">
									</div>
									
									<div class="form-group text-right">
										<input type="submit" class="btn btn-default" name="woffice_submit_tax" value="<?php _e('Create','woffice'); ?>">
									</div>
									
								</form>
								
								<!-- JS SCRIPT TO FETCH THE TAXONOMIES FROM THE POST NAME -->
								<script type="text/javascript">
									jQuery(document).ready( function() {
										// Fetch the category
										jQuery("#catgeory_post_type").change(function(){
											var Post_Name = jQuery('#catgeory_post_type').val();	
											jQuery.ajax({
												type:"POST",
												url: "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
												data: {
													action : "wofficeTaxonomyFetching",
													ajax_post_name : Post_Name
												},
												success:function(returnval){
													console.log("Taxonmy fetched");
													jQuery("#taxonomy-ajax").empty();
													jQuery("#taxonomy-ajax").html(returnval);
												},
											});
											return false;
										});
										// Submit the form
										jQuery("#taxonomy-creation").submit(function(){
											var Taxonomy = jQuery('#taxonomy-ajax select').val();	
											var New_Tax = jQuery('#new-tax-name').val();		
											jQuery.ajax({
												type:"POST",
												url: "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
												data: {
													action : "wofficeTaxonomyAdd",
													ajax_taxonomy : Taxonomy,
													ajax_new_tax : New_Tax,
												},
												success:function(returnval2){
													console.log("Tax Added");
													jQuery("#tax-alert").empty();
													jQuery("#tax-alert").html(returnval2);
												},
											});
											return false;
										});
									});
								</script>
							
							</div>
							
						</article>
					<?php
					} else { 
						get_template_part( 'content', 'private' );
					}
					?>
				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->

	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();



