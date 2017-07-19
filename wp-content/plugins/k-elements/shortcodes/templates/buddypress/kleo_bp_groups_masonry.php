<?php
/**
 * Buddypress Groups Masonry.
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = '';

extract(
	shortcode_atts( array(
		'type' => 'newest',
		'number' => 12,
		'class' => '',
		'rounded' => "rounded"
	), $atts ) 
);

$params = array(
	'type' => $type,
	'per_page' => $number
);
if ($rounded == 'rounded') {
	$rounded = 'kleo-rounded';
}

if ( function_exists('bp_is_active') && bp_is_active('groups') ) {

	if ( bp_has_groups( $params ) ){
		
		ob_start();
		?>
		<div class="wpb_wrapper">
		<div id="groups-dir-list" class="groups dir-list">
		<ul id="groups-list" class="item-list row kleo-isotope masonry <?php echo $class;?>">

			<?php while ( bp_groups() ) : bp_the_group(); ?>

				<li <?php bp_group_class(); ?>>
					<div class="group-inner-list animated animate-when-almost-visible bottom-to-top">
						<div class="item-avatar <?php echo $rounded;?>">
							<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=80&height=80' ); echo  kleo_get_img_overlay(); ?></a>
							<span class="member-count high-bg"><?php echo preg_replace('/\D/', '', bp_get_group_member_count());  ?></span>
						</div>

						<div class="item">
							<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
							<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>

							<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

							<?php do_action( 'bp_directory_groups_item' ); ?>

						</div>

						<div class="action">



							<div class="meta">

								<?php bp_group_type(); ?>

							</div>

							<?php do_action( 'bp_directory_groups_actions' ); ?>

						</div>
					</div><!--end group-inner-lis-->
				</li>

			<?php endwhile; ?>

			</ul>
		</div>
		</div>
		
	<?php	
	$output = ob_get_clean();
	
	}
	else
	{
		$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'k-elements' ) . '</div>';
	}

}
else
{
	$output = __("This shortcode must have Buddypress installed to work.","k-elements");
}

