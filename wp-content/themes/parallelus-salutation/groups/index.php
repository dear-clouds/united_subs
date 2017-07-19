
	<div id="content">
		<div class="padder">


			<div class="entry-header clearfix">

				<div id="group-dir-search" class="dir-search">
					<?php bp_directory_groups_search_form() ?>
				</div><!-- #group-dir-search -->
				
				<!-- Title / Page Headline -->
				<h1 class="entry-title titleHasButtons"><?php _e( 'Groups Directory', 'buddypress' ) ?></h1>
				<?php if ( is_user_logged_in() ) : ?>
					<div class="titleButtons">
						<?php if ( is_user_logged_in() && bp_user_can_create_groups() ) : ?>
							 &nbsp; <span class="sep">|</span> &nbsp; 
							<a class="button boxLink" href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/create' ); ?>"><?php _e( 'Create a Group', 'buddypress' ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
			</div>
				
			<form action="" method="post" id="groups-directory-form" class="dir-form">
				
				<?php do_action( 'bp_before_directory_groups_content' ) ?>
	
				<div class="item-list-tabs bp-content-tabs">
					<ul>
						<li class="selected" id="groups-all"><a href="<?php bp_root_domain() ?>"><?php printf( __( 'All Groups <span>%s</span>', 'buddypress' ), bp_get_total_group_count() ) ?></a></li>
	
						<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
							<li id="groups-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_root_slug() . '/my-groups/' ?>"><?php printf( __( 'My Groups <span>%s</span>', 'buddypress' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) ?></a></li>
						<?php endif; ?>
	
						<?php do_action( 'bp_groups_directory_group_types' ) ?>
	
					</ul>
				</div><!-- .item-list-tabs -->

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>
						<li id="groups-order-select" class="last filter">
	
							<?php _e( 'Order By:', 'buddypress' ) ?>
							<select>
								<option value="active"><?php _e( 'Last Active', 'buddypress' ) ?></option>
								<option value="popular"><?php _e( 'Most Members', 'buddypress' ) ?></option>
								<option value="newest"><?php _e( 'Newly Created', 'buddypress' ) ?></option>
								<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ) ?></option>
	
								<?php do_action( 'bp_groups_directory_order_options' ) ?>
							</select>
						</li>
					</ul>
				</div><!-- .item-list-tabs -->

				<div id="groups-dir-list" class="groups dir-list">
					<?php locate_template( array( 'groups/groups-loop.php' ), true ) ?>
				</div><!-- #groups-dir-list -->
	
				<?php do_action( 'bp_directory_groups_content' ) ?>
	
				<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ) ?>
	
			</form><!-- #groups-directory-form -->
	
			<?php do_action( 'bp_after_directory_groups_content' ) ?>

		</div><!-- /.padder -->
	</div><!-- /#content -->

	<?php //locate_template( array( 'sidebar.php' ), true ) ?>
