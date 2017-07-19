<?php
/**
 * The sidebar containing the BuddyPress widget areas.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
	
	<!-- Check if BuddyPress is activated -->
	<?php if ( function_exists('bp_is_active') ) : ?>

		<!-- if there are widgets in the Members: Directory sidebar -->	
		<?php if ( is_active_sidebar('members') && bp_is_current_component( 'members' ) && !bp_is_user() ) : ?>
					
				<div id="secondary" class="widget-area" role="complementary">				
					<?php dynamic_sidebar( 'members' ); ?>
				</div><!-- #secondary -->

		<!-- if there are widgets in the Member: Single Profile sidebar -->
		<?php elseif ( is_active_sidebar('profile') && bp_is_user() ) : ?>
		
				<div id="secondary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'profile' ); ?>
				</div><!-- #secondary -->
		
		<!-- if there are widgets in the Groups: Directory sidebar -->		
		<?php elseif ( is_active_sidebar('groups') && bp_is_current_component( 'groups' ) && !bp_is_group() && !bp_is_user() ) : ?>
		
				<div id="secondary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'groups' ); ?>
				</div><!-- #secondary -->

		<!-- if there are widgets in the Group: Single sidebar -->
		<?php elseif ( bp_is_group() && ! bp_is_group_create() ) : ?>
		    <?php 
            global $learner;
            $group_status = groups_get_groupmeta( bp_get_group_id(), 'bp_course_attached', true ); 
            ?>
		    
				<div id="secondary" class="widget-area" role="complementary">
				                    
                <?php if($group_status && $learner): ?> 
                     <?php dynamic_sidebar( 'group' ); ?> 
                <?php else: ?> 
                
				    <div class="secondary-inner">
                        <a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>" class="group-header-avatar">

                            <?php bp_group_avatar('type=full&width=300&height=300'); ?>

                        </a>
                        <div id="group-description">
                            <h3><?php _e("Group Info",'boss'); ?></h3>
                            <?php bp_group_description(); ?>
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

						<?php if ( $group_type_list =  bp_get_group_type_list( bp_get_group_id(), array( 'label' => false ) ) ): ?>
							<div id="group-types-list">

								<h3><?php _e("Group Types",'boss'); ?></h3>

								<?php echo $group_type_list ?>

							</div><!-- #group-types-list-->
						<?php endif; ?>

                        <?php dynamic_sidebar( 'group' ); ?> 
                          
                    </div><!-- .secondary-inner -->
                <?php endif; ?>
				</div><!-- #secondary -->	
		
		<!-- if there are widgets in the Activity: Directory sidebar -->		
		<?php elseif ( is_active_sidebar('activity') && bp_is_current_component( 'activity' ) && !bp_is_user() ) : ?>
			
				<div id="secondary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'activity' ); ?>
				</div><!-- #secondary -->	
		
		<!-- if Multisite is activated AND there are widgets in the Blogs: Directory sidebar -->	
		<?php elseif ( is_active_sidebar('blogs') && is_multisite() && bp_is_current_component( 'blogs' ) && !bp_is_user() ) : ?>
		
				<div id="secondary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'blogs' ); ?>
				</div><!-- #secondary -->

		<!-- if Legacy Forums (not bbPress) are activated AND there are widgets in the Forums: Directory sidebar -->	
		<?php elseif ( is_active_sidebar('forums') && bp_is_current_component( 'forums' ) && !bp_is_user() ) : ?>
		
				<div id="secondary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'forums' ); ?>
				</div><!-- #secondary -->
			
		<!-- otherwise, no sidebar! -->
		
		<?php endif; ?>

	<?php endif; ?>
