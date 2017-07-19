
	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_member_plugin_template' ) ?>

			<div class="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax bp-content-tabs" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>

						<?php do_action( 'bp_members_directory_member_types' ) ?>
					</ul>
				</div>
			</div>

			<div id="item-body">

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul class="sub-tabs">
						<?php bp_get_options_nav() ?>
					</ul>
				</div>

				<?php if ( class_exists( 'BuddyDrive' ) ) { echo '<h3>'; do_action( 'bp_template_title' ); echo '</h3>'; } ?>
				
				<?php do_action( 'bp_template_content' ) ?>

				<?php do_action( 'bp_directory_members_content' ) ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_plugin_template' ) ?>


		</div><!-- /.padder -->
	</div><!-- /#content -->

	<?php //locate_template( array( 'sidebar.php' ), true ) ?>
