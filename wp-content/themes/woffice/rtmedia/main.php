<?php
/* * **************************************
 * Main.php
 *
 * The main template file, that loads the header, footer and sidebar
 * apart from loading the appropriate rtMedia template
 * *************************************** */
// by default it is not an ajax request
global $rt_ajax_request ;
$rt_ajax_request = false ;

// check if it is an ajax request
if ( ! empty ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest') {
    $rt_ajax_request = true ;
}
?>
<div id="buddypress" class="box clearfix">
<?php
//if it's not an ajax request, load headers
if ( ! $rt_ajax_request ) {
	// if this is a BuddyPress page, set template type to
	// buddypress to load appropriate headers
	if ( class_exists ( 'BuddyPress' ) && ! bp_is_blog_page () && apply_filters( 'rtm_main_template_buddypress_enable', true ) ) {
		$template_type = 'buddypress' ;
	} else {
		$template_type = '' ;
	}
	//get_header( $template_type );

	if ( $template_type == 'buddypress' ) {
		//load buddypress markup
		if ( bp_displayed_user_id () ) {

			//if it is a buddypress member profile
			?>
	<?php do_action( 'bp_before_member_home_content' ); ?>
	<!-- ADDED FOR WOFFICE -->
	<?php 
	$user_ID = bp_displayed_user_id();
	$the_cover = woffice_get_cover_image($user_ID);
	if (!empty($the_cover)):
		echo'<div id="item-header" role="complementary" style="background-image: url('.esc_url($the_cover).')">';
	else :
		echo'<div id="item-header" role="complementary">';
	endif;
	?>

		<?php bp_get_template_part ( 'members/single/member-header' ) ?>

		<div class="user-cover-layer"></div>
		
		<?php echo (function_exists('woffice_upload_cover_btn')) ? woffice_upload_cover_btn() : ''; ?>
		 
	</div><!-- #item-header -->

	<div id="item-nav" class="intern-box">
		<div class="item-list-tabs no-ajax rtmedia-tabs" id="object-nav" role="navigation">
			<ul>

				<?php bp_get_displayed_user_nav () ; ?>

				<?php do_action ( 'bp_member_options_nav' ) ; ?>

			</ul>
		</div>
	</div><!--#item-nav-->

	<div id="item-body" role="main"><div class="intern-padding">

		<?php do_action ( 'bp_before_member_body' ) ; ?>
		<?php do_action ( 'bp_before_member_media' ) ; ?>
		<div class="item-list-tabs no-ajax rtmedia-tabs-inside" id="subnav">
			<ul>

				<?php rtmedia_sub_nav () ; ?>

				<?php do_action ( 'rtmedia_sub_nav' ) ; ?>

			</ul>
		</div><!-- .item-list-tabs -->

	<?php
		} else if ( bp_is_group () ) {

	//not a member profile, but a group
	?>

	<?php if (bp_has_groups()) : while (bp_groups()) : bp_the_group(); ?>
	<div id="item-header" class="no-featured group-header">

		<?php bp_get_template_part( 'groups/single/group-header' ); ?>

	</div><!--#item-header-->

	<div id="item-nav" class="intern-box">
		<div class="item-list-tabs no-ajax rtmedia-tabs" id="object-nav" role="navigation">
			<ul>

				<?php bp_get_options_nav(); ?>

				<?php do_action( 'bp_group_options_nav' ); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->


	<div id="item-body"><div class="intern-padding">

		<?php do_action( 'bp_before_group_body' ); ?>
		<?php do_action( 'bp_before_group_media' ); ?>
		<div class="item-list-tabs no-ajax rtmedia-tabs-inside" id="subnav">
			<ul>

				<?php rtmedia_sub_nav(); ?>

				<?php do_action( 'rtmedia_sub_nav' ); ?>

			</ul>
		</div><!-- .item-list-tabs -->
		
	<?php endwhile; endif; // group/profile if/else
		}
	}else{ ////if BuddyPress
		?>
	<div id="item-body"><div class="intern-padding">
		<?php
	}
} // if ajax
        // include the right rtMedia template
        rtmedia_load_template () ;
        
        if ( ! $rt_ajax_request ) {
			if ( function_exists ( "bp_displayed_user_id" ) && $template_type == 'buddypress' && (bp_displayed_user_id () || bp_is_group ()) ) {
				if ( bp_is_group () ) {
					do_action ( 'bp_after_group_media' ) ;
					do_action ( 'bp_after_group_body' ) ;
				}
				if ( bp_displayed_user_id () ) {
					do_action ( 'bp_after_member_media' ) ;
					do_action ( 'bp_after_member_body' ) ;
				}
			}
			?>
	</div></div><!--#item-body-->
			<?php
			if ( function_exists ( "bp_displayed_user_id" ) && $template_type == 'buddypress' && (bp_displayed_user_id () || bp_is_group ()) ) {
				if ( bp_is_group () ) {
					do_action( 'bp_after_group_home_content' );
				}
				if ( bp_displayed_user_id () ) {
					do_action( 'bp_after_member_home_content' );
				}
			}
        }
        //close all markup
        ?>
</div><!--#buddypress-->
            <?php
            //get_sidebar($template_type);
            //get_footer($template_type);
        // if ajax

        