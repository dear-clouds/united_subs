<?php
/**
 * The template used for displaying post content
 */
?>
<?php 
// CUSTOM CLASSES ADDED BY THE THEME
$post_classes = array('box','content');
$blog_listing_content = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('blog_listing_content') : 'excerpt';
$hide_image_single_post = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('hide_image_single_post') : 'nope';
$hide_author_box = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('hide_author_box_single_post') : 'nope';
$hide_like_counter = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('hide_like_counter_inside_author_box') : 'nope';
$hide_learndash_meta = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('hide_learndash_meta') : 'nope';

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
		<?php if (has_post_thumbnail() && (!is_single() || is_single() && $hide_image_single_post == 'nope')) : ?>
			<!-- THUMBNAIL IMAGE -->
			<?php /*GETTING THE POST THUMBNAIL URL*/
            $featured_height = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'featured_height') : '';
            woffice_render_featured_image_single_post($post->ID, $featured_height);
            ?>

		<?php endif; ?>

        <?php if (strpos(get_post_type(), 'sfwd') === FALSE || is_search()) : ?>
		<div class="intern-padding heading-container">
			<?php if (!is_single()): ?>
				<?php // THE TITLE
				if (is_sticky()):
					the_title( '<div class="heading"><h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="fa fa-star-o"></i>', '</a></h2></div>' ); 
				else: 
					the_title( '<div class="heading"><h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></div>' ); 
				endif; ?>
			<?php else : ?>
				<?php // THE TITLE
				the_title( '<div class="heading"><h2>', '</h2></div>' ); ?>
			<?php endif; ?>
		</div>
        <?php endif; ?>

		<?php // We display the post meta in the top only for the blog articles
		if ($post->post_type == "post") : ?>
			<div class="intern-box">
				<?php // THE POST META
				woffice_postmetas(); ?>
			</div>
		<?php endif; ?>
		<div class="intern-padding clearfix">
			<?php // THE EXCERRPT ?>
			<p class="blog-sum-up">
				<?php if (is_single() || $blog_listing_content == 'content'): ?>
                    <?php the_content(); ?>
				<?php else : ?>
                    <?php the_excerpt(); ?>
				<?php endif; ?>
			</p>
			
			<?php if (!is_single()): ?>
				<div class="blog-button">
	  				<a href="<?php the_permalink(); ?>" class="btn btn-default"><i class="fa fa-arrow-right"></i> <?php _e('Read More','woffice'); ?></a>
	  			</div>	
	  		<?php endif; ?>

	  		<?php if (is_single() && get_post_type() == 'post' && $hide_author_box != 'yep') : ?>
	  			<div class="blog-authorbox clearfix">
	  				<?php echo get_avatar( get_the_author_meta('ID')); ?>
	  				<div class="blog-authorbox-right">

                        <?php if($hide_like_counter != 'yep'): ?>
		  				<div class="blog-like-container">
			  				<?php 
				  				$post_ID = get_the_id();
				  				$vote_count = get_post_meta($post_ID, "votes_count", true);
								$vote_count_disp = (empty($vote_count)) ? '0' : $vote_count; 
								echo '<p class="like-text">'.__('Have you enjoyed the post ?','woffice').'</p>';
								echo '<p class="wiki-like">';
									if(woffice_blog_user_has_already_voted($post_ID)) {
								        echo ' <span title="'.__('I like this post', 'woffice').'" class="like alreadyvoted">
								        	<i class="fa fa-thumbs-up"></i>
								        </span>';
								    } else { 
								        echo '<a href="javascript:void(0)" data-post_id="'.$post_ID.'">
							                <i class="fa fa-thumbs-o-up"></i>
							            </a>';
								    }
								    echo '<span class="count">'.$vote_count_disp.'</span>';
								echo '</p>';
							?>
						</div>
                        <?php endif; ?>
		  				<?php 
			  			$first_name_get = get_the_author_meta('first_name');
			  			$first_name = (!empty($first_name_get)) ? $first_name_get : '';
			  			$last_name_get = get_the_author_meta('last_name');
			  			$last_name = (!empty($last_name_get)) ? $last_name_get : '';
			  			if (!empty($first_name) || !empty($last_name)) {
				  			$display = $first_name." ".$last_name;
			  			} else {
				  			$display = get_the_author_meta('user_login');
			  			}?>
		  				<?php 
			  				if (function_exists('bp_is_active')) {
				  				echo '<h3><a href="' . bp_core_get_user_domain(get_the_author_meta('ID')) . '">'.$display.'</a></h3>';
			  				} else {
				  				echo '<h3>'.$display.'</h3>';
			  				}
		  				?>
		  				<?php 
			  			$desc = get_the_author_meta('description');
			  			if(!empty($desc)) {
			  				echo '<p>'.get_the_author_meta('description').'</p>';	
			  			} ?>
	  				</div>
	  			</div>	
	  		<?php endif; ?>
				
			<?php 
			// DISPLAY THE NAVIGATION
			(is_single()) ? woffice_post_nav() : ''; ?>
	  		
	  		<?php // We check the post type to display the post meta datas in the footer
			if (strpos(get_post_type(), 'sfwd') !== FALSE && $hide_learndash_meta != 'yep') : ?>
				<div class="metadatas-footer">
					<?php // THE POST META
					woffice_postmetas(); ?>
				</div>
			<?php endif; ?>
		</div>
	</article>
