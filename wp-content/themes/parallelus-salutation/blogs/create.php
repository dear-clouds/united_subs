
	<div id="content">
		<div class="padder">

			<?php do_action( 'template_notices' ) ?>
	
			<header class="entry-header clearfix">

				<!-- Title / Page Headline -->
				<h1 class="entry-title titleHasButtons"><?php _e( 'Create a Blog', 'buddypress' ) ?></h1>
				<div class="titleButtons">
					 &nbsp; <span class="sep">|</span> &nbsp;
					<a class="button boxLink" href="<?php echo bp_get_root_domain() . '/' . BP_BLOGS_SLUG . '/' ?>"><?php _e( 'Blogs Directory', 'buddypress' ) ?></a>
				</div>
									
			</header>
	
			<?php do_action( 'bp_before_create_blog_content' ) ?>
	
			<div class="create-form" id="createBlogForm">
			
				<h4><?php _e( 'Blog Settings', 'buddypress' ) ?></h4>
				
				<br>

				<?php if ( bp_blog_signup_enabled() ) : ?>
		
					<?php bp_show_blog_signup_form() ?>
		
				<?php else: ?>
		
					<div id="message" class="info">
						<p><?php _e( 'Blog registration is currently disabled', 'buddypress' ); ?></p>
					</div>
		
				<?php endif; ?>
			
			</div>

	
			<?php do_action( 'bp_after_create_blog_content' ) ?>
	
	
			<?php do_action( 'bp_after_create_blog_content' ) ?>

		</div><!-- /.padder -->
	</div><!-- /#content -->

	<?php //locate_template( array( 'sidebar.php' ), true ) ?>
