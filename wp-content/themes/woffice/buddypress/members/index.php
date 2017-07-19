<?php do_action( 'bp_before_directory_members_page' ); ?>

<div id="buddypress">

	<?php do_action( 'bp_before_directory_members' ); ?>

	<?php do_action( 'bp_before_directory_members_content' ); ?>

	<div id="members-extra">
		<?php 
		/* GET THE MEMBERS MAP */
		if (function_exists('woffice_get_members_map')){
			echo woffice_get_members_map();
		}
		/*GET THE FILTERS*/
		woffice_members_filter();
		?>
	</div>
	
	<?php do_action( 'bp_before_directory_members_tabs' ); ?>

	<form action="" method="post" id="members-directory-form" class="dir-form">
		<!-- ADDED .intern-padding -->
		<div class="intern-padding">

			<div id="members-dir-list" class="members dir-list">
				<?php bp_get_template_part( 'members/members-loop' ); ?>
			</div><!-- #members-dir-list -->
	
			<?php do_action( 'bp_directory_members_content' ); ?>
	
			<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>
	
			<?php do_action( 'bp_after_directory_members_content' ); ?>
			
		</div>

	</form><!-- #members-directory-form -->

	<?php do_action( 'bp_after_directory_members' ); ?>

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_members_page' ); ?>