<?php
/**
 * The template for displaying Buddypress pages
 *
 *
 * @package Wordpress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

/* Change page display based on current Page settings */
add_action('wp_head','kleo_bp_page_options');

/* Add custom HTML to BP page header set from Page options */
add_action('kleo_before_main', 'kleo_bp_header', 8);

/* Add custom HTML to BP page bottom set from Page options */
add_action( 'kleo_after_main_content', 'kleo_bp_bottom', 12 );

/* Custom menu page option */
add_filter('wp_nav_menu_args', 'kleo_bp_set_custom_menu');

get_header(); ?>

<?php

//remove title in main content area since it is handled by Buddypress setting in Theme options - Buddypress 
remove_action( 'kleo_before_main_content', 'kleo_title_main_content' );

$title_arr = array();

if( in_array( sq_option( 'bp_title_location', 'breadcrumb' ), array( 'disabled', 'main' ) ) ||
    ( sq_option( 'bp_title_location', 'breadcrumb' ) == 'default' && sq_option( 'title_location', 'breadcrumb' ) == 'main' ) ) {
	$title_arr['show_title'] = false;
}

$title = get_the_title();
if ( bp_is_group_create() ) {
	$title = preg_replace( "/<a\b[^>]*>(.*?)<\/a>/i","", $title );
}
$title_arr['title'] = $title;

if( sq_option('bp_breadcrumb_status', 1) == 0 ) {
	$title_arr['show_breadcrumb'] = false;
}

if ( sq_option('bp_custom_info', 0) == 1 ) {
    $extra_info = sq_option('bp_title_info', '');
} else {
    $extra_info = sq_option('title_info', '');
}

if ( $extra_info == '') {
    $title_arr['extra'] = '';
} else {
    $title_arr['extra'] = '<p class="page-info">' . $extra_info . '</p>';
}


/* Page settings */
$current_page_id = kleo_bp_get_page_id();

if ( $current_page_id ) {
    //title settings
    if ( get_cfield('title_checkbox', $current_page_id) == 1 ) {
        $title_arr['show_title'] = false;
    }

    //hide breadcrumb?
    if (sq_option('breadcrumb_status', 1) == 0) {
        $title_arr['show_breadcrumb'] = false;
    }
    if (get_cfield('hide_breadcrumb', $current_page_id) == 1) {
        $title_arr['show_breadcrumb'] = false;
    } else if (get_cfield('hide_breadcrumb', $current_page_id) === '0') {
        $title_arr['show_breadcrumb'] = true;
    }

    //hide extra info?
    if (get_cfield('hide_info', $current_page_id) == 1) {
        $title_arr['extra'] = '';
    }
}

/* disable Profile page breadcrumb option */
if (bp_is_user() && sq_option( 'bp_profile_breadcrumb_disable', 0 ) == 1 ) {
    $title_arr['show_breadcrumb'] = false;
    $title_arr['show_title'] = false;
    $title_arr['extra'] = '';
}

if(  isset ( $title_arr['show_breadcrumb'] ) && $title_arr['show_breadcrumb'] == false
        && isset( $title_arr['show_title'] )
        && $title_arr['extra'] == ''
    )
{
	//hide the breadcrumb section
}
else
{
	echo kleo_title_section( $title_arr );
}
?>

<?php if( sq_option( 'bp_full_profile', 0 ) == 1 && bp_is_user() ): ?>

    <section class="alternate-color bp-full-width-profile">
        <div id="item-header" role="complementary">

            <?php
            /**
             * If the cover image feature is enabled, use a specific header
             */
            if ( version_compare( BP_VERSION, '2.4', '>=' ) && bp_displayed_user_use_cover_image_header() ) :
                bp_get_template_part( 'members/single/cover-image-header' );
            else :
                bp_get_template_part( 'members/single/member-header' );
            endif;
            ?>

        </div>
        <!-- #item-header -->
    </section>

<?php endif; ?>

<?php if( sq_option( 'bp_full_group', 0 ) == 1 && bp_is_single_item() && bp_is_groups_component() ): ?>

    <?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

    <section class="alternate-color bp-full-width-profile">
        <div id="item-header" role="complementary">

            <?php
            /**
             * If the cover image feature is enabled, use a specific header
             */
            if ( version_compare( BP_VERSION, '2.4', '>=' ) &&  bp_group_use_cover_image_header() ) :
                bp_get_template_part( 'groups/single/cover-image-header' );
            else :
                bp_get_template_part( 'groups/single/group-header' );
            endif;
            ?>

        </div>
        <!-- #item-header -->
    </section>

     <?php endwhile; endif; ?>

<?php endif; ?>



<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php
if ( have_posts() ) :
	// Start the Loop.
	while ( have_posts() ) : the_post(); 
	?>
	<div class="row">
		<div class="col-sm-12">
			
			<?php if ( sq_option( 'bp_title_location', 'breadcrumb' ) == 'main' OR ( sq_option( 'bp_title_location', 'breadcrumb' ) == 'default' && sq_option( 'title_location', 'breadcrumb' ) == 'main' ) ) :  ?>
			<h1 class="page-title text-center" style="font-size:20px;"><?php echo $title; ?></h1>
			<?php endif;?>
			
			<div class="article-content">
					<?php the_content(); ?>
			</div><!--end article-content-->
		</div><!--end twelve-->
	</div>


	<?php
	endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>