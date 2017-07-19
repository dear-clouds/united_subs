<div id="buddypress">                    

    <?php if ( bp_is_active( 'groups' ) && bp_has_groups( array( 'include'=>bp_doc_single_group_id() ) ) ) : while ( bp_groups() ) : bp_the_group(); ?>

    <?php do_action( 'bp_before_group_home_content' ); ?>

    <div id="item-header" role="complementary">

            <?php bp_get_template_part( 'groups/single/group-header' ); ?>


    </div><!-- #item-header -->


    <div id="primary" class="site-content"> <!-- moved from top -->

       <div id="content" role="main"> <!-- moved from top -->

            <div class="below-cover-photo">

                <div id="group-description">
                    <?php bp_group_description(); ?>
                    <?php do_action( 'bp_group_header_meta' ); ?>
                </div>

            </div>

            <?php do_action( 'bp_group_header_meta' ); ?>

            <div id="item-nav"> <!-- movwed inside #primary-->
                <?php get_template_part( 'docs/single/groupnav' );?>
            </div><!-- #item-nav -->

            <div id="item-body">

                    <?php 
                    /**
                     * Fires before the display of the group home body.
                     *
                     * @since BuddyPress (1.2.0)
                     */
                    do_action( 'bp_before_group_body' );
                    ?>

                    <?php get_template_part( 'docs/single/index', 'inner' ); ?>

                    <?php 
                    /**
                     * Fires after the display of the group home body.
                     *
                     * @since BuddyPress (1.2.0)
                     */
                    do_action( 'bp_after_group_body' ); ?>

            </div><!-- #item-body -->


        </div><!-- #content -->

    </div><!-- #primary -->

<?php

global $groups_template;
//backup the group current loop to ignore loop conflict from widgets
$groups_template_safe = $groups_template;
?>

    <div id="secondary" class="widget-area" role="complementary">
        <div class="secondary-inner">
            <a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>" class="group-header-avatar">

                <?php bp_group_avatar('type=full&width=300&height=300'); ?>

            </a>
            <div id="group-description">
                <h3><?php _e("Group Info",'boss'); ?></h3>
                <?php bp_group_description(); ?>
                <?php do_action( 'bp_group_header_meta' ); ?>
            </div>

            <div id="item-actions">

                <?php if ( bp_group_is_visible() ) : ?>

                    <h3><?php _e( 'Group Admins', 'boss' ); ?></h3>

                    <?php bp_group_list_admins();

                    do_action( 'bp_after_group_menu_admins' );

                    if ( bp_group_has_moderators() ) :
                        do_action( 'bp_before_group_menu_mods' ); ?>

                        <h3><?php _e( 'Group Mods' , 'boss' ); ?></h3>

                        <?php bp_group_list_mods();

                        do_action( 'bp_after_group_menu_mods' );

                    endif;

                endif; ?>

            </div><!-- #item-actions -->                           

            <?php dynamic_sidebar( 'group' ); ?>   
        </div>
    </div><!-- #secondary -->	
    
<?php 
//restore the oringal $groups_template before sidebar.
$groups_template = $groups_template_safe;

?>


<?php do_action( 'bp_after_group_home_content' ); ?>

<?php endwhile; ?>
<?php else:?>
<?php get_template_part( 'docs/single/index', 'inner' ); ?>
<?php endif; ?>



</div><!-- #buddypress -->