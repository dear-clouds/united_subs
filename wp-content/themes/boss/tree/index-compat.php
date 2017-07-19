<?php do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress">

	<?php do_action( 'bp_before_directory_groups' ); ?>
	
	<div class="filters">
        <div class="row">
            <div class="col-6">
               
				<div class="item-list-tabs" role="navigation">
                    <ul>
                       <li id="groups-order-select" class="filter">

                            <label for="groups-order-by"><?php _e( 'Order By:', 'boss' ); ?></label>

                            <select id="groups-order-by">
                                <option value="active"><?php _e( 'Last Active', 'boss' ); ?></option>
                                <option value="popular"><?php _e( 'Most Members', 'boss' ); ?></option>
                                <option value="newest"><?php _e( 'Newly Created', 'boss' ); ?></option>
                                <option value="alphabetical"><?php _e( 'Alphabetical', 'boss' ); ?></option>

                                <?php do_action( 'bp_groups_directory_order_options' ); ?>
                            </select>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="col-6">
                <div id="group-dir-search" class="dir-search" role="search">
                    <?php bp_directory_groups_search_form(); ?>
                </div><!-- #group-dir-search -->
            </div>
        </div>
    </div>

	<form action="" method="post" id="groups-directory-form" class="dir-form">

		<?php do_action( 'template_notices' ); ?>

		<div class="item-list-tabs" role="navigation">
			<ul>
				<li class="selected" id="tree-all"><a href="<?php bp_groups_directory_permalink(); ?>"><?php bp_group_hierarchy_group_tree_name(); ?></a></li>

				<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
					<li id="groups-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>"><?php printf( __( 'My Groups <span>%s</span>', 'buddypress' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>
				<?php endif; ?>

				<?php do_action( 'bp_groups_directory_group_filter' ); ?>
					
				<?php do_action( 'bp_groups_directory_group_types' ); ?>

			</ul>
		</div><!-- .item-list-tabs -->

		<div id="groups-dir-list" class="groups dir-list">
			<?php bp_get_template_part( 'tree/tree-loop' ); ?>
		</div><!-- #groups-dir-list -->

		<?php do_action( 'bp_directory_groups_content' ); ?>

		<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

		<?php do_action( 'bp_after_directory_groups_content' ); ?>

	</form><!-- #groups-directory-form -->

	<?php do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_groups_page' ); ?>