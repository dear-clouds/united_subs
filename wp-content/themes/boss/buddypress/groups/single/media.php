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


		<?php 
		if ( ! $rt_ajax_request ) {
		
		do_action( 'bp_before_group_body' ); ?>
		<?php do_action( 'bp_before_group_media' ); ?>
		<div class="item-list-tabs no-ajax" id="subnav">
			<ul>

				<?php rtmedia_sub_nav(); ?>

				<?php do_action( 'rtmedia_sub_nav' ); ?>

			</ul>
		</div><!-- .item-list-tabs -->
		
<?php
	

        rtmedia_load_template () ;
        
       
			if ( function_exists ( "bp_displayed_user_id" ) && $template_type == 'buddypress' && (bp_displayed_user_id () || bp_is_group ()) ) {
				if ( bp_is_group () ) {
					do_action ( 'bp_after_group_media' ) ;
					do_action ( 'bp_after_group_body' ) ;
				}
				
				if ( bp_is_group () ) {
					do_action( 'bp_after_group_home_content' );
				}
				
			}
			}
?>		
		