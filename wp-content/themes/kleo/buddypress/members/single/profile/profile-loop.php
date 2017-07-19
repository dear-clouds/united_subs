<?php do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

		
				<div class="hr-title hr-full hr-double"><abbr><?php bp_the_profile_group_name(); ?></abbr></div>
				<div class="gap-10"></div>
					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<?php if ( bp_field_has_data() ) : ?>
              
              
              
              <dl<?php bp_field_css_class('dl-horizontal'); ?>>
                <dt><?php bp_the_profile_field_name(); ?></dt>
                <dd><?php bp_the_profile_field_value(); ?></dd>
              </dl>
              

						<?php endif; ?>

						<?php do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>

                        
                        
                        
			</div><!-- end bp-widget -->

			<?php do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
