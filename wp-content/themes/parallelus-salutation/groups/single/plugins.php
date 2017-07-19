
	<div id="content">
		<div class="padder" class="group-single">

			<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

			<?php do_action( 'bp_before_group_plugin_template' ) ?>

			<header class="entry-header clearfix">
				<div class="item-header">
					<?php locate_template( array( 'groups/single/group-header.php' ), true ) ?>
				</div>
			</header>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax bp-content-tabs" id="sub-nav">
					<ul>
						<?php bp_get_options_nav() ?>

						<?php do_action( 'bp_group_plugin_options_nav' ) ?>
					</ul>
				</div>
			</div>

			<div id="item-body">

				<?php do_action( 'bp_before_group_body' ) ?>

				<?php do_action( 'bp_template_content' ) ?>

				<?php do_action( 'bp_after_group_body' ) ?>
			</div><!-- #item-body -->

			<?php do_action( 'bp_after_group_plugin_template' ) ?>

			<?php endwhile; endif; ?>
				
		</div><!-- /.padder -->
	</div><!-- /#content -->
