<?php  global $theLayout;

if (have_posts()) : 
	while (have_posts()) : the_post();	
	?>
	<div class="content-page">
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<div class="the-post-container">
			
				<?php if (!get_meta('hide_title')) : ?>
				<header class="entry-header">
					<!-- Title / Page Headline -->
					<h1 class="entry-title" title="<?php echo the_title_attribute('echo=0'); ?>"><?php the_title(); ?></h1>
				</header>
				<?php endif; ?>
				
				<!-- Page Text and Main Content -->
				<div class="entry-content clearfix">
					<?php the_content(); ?>
				</div>
	
				<!-- Post Extras -->
				<footer class="postFooter">
					<?php
					// Multi-page content <!--nextpage--> ?>
					<div class="nextPageLinks"> <?php wp_link_pages('before=<p><span class="nextPageTitle">'. __( 'Pages:', THEME_NAME ) .' </span>&after=</p>'); ?> </div>
					<?php 
					// Edit post link
					edit_post_link('Edit','<p class="postEdit">','</p>'); ?>
				</footer>
				
				<?php comments_template('', true); // Display comments ?>
	
			</div>
		</article>
		
	</div>
	<?php 
	endwhile; 
endif; ?>
