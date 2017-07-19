<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>

<?php 
//Specific class for post listing */
$blog_type = sq_option( 'blog_type','masonry' );
$blog_type = apply_filters( 'kleo_blog_type', $blog_type );

$template_classes = $blog_type . '-listing';
if ( sq_option('blog_archive_meta', 1 ) == 1 ) {
    $template_classes .= ' with-meta';
} else {
    $template_classes .= ' no-meta';
}
if ( $blog_type == 'standard' && sq_option('blog_standard_meta', 'left' ) == 'inline' ) {
    $template_classes .= ' inline-meta';
}

add_filter('kleo_main_template_classes', create_function( '$cls','$cls .=" posts-listing ' . $template_classes.'"; return $cls;' ));


/***************************************************
:: Title section
***************************************************/

//title
$title_arr['show_title'] = true;
$page_title = kleo_title();

if ( sq_option( 'title_location', 'breadcrumb' ) == 'main' ) {
	$title_arr['show_title'] = false;
}

//breadcrumb
$title_arr['show_breadcrumb'] = true;
if( sq_option( 'breadcrumb_status', 1 ) == 0 ) {
	$title_arr['show_breadcrumb'] = false;
}

//extra info
if ( sq_option( 'title_info', '' ) == '' ) {
	$show_info = FALSE;
}
else {
	$show_info = TRUE;
}

//If we have designated a page for latest posts like Blog page
if ( get_option( 'page_for_posts' ) ) {
	$blogpage_id = get_option('page_for_posts');
	$page_title = get_the_title( $blogpage_id );

    if ( get_cfield( 'custom_title', $blogpage_id ) && get_cfield( 'custom_title', $blogpage_id ) != ''  ) {
        $page_title = get_cfield( 'custom_title', $blogpage_id );
    }

	if( get_cfield( 'title_checkbox', $blogpage_id ) == 1 ) {
		$title_arr['show_title'] = false;
	}	
	
	if ( get_cfield( 'hide_info', $blogpage_id ) == 1 ) {
		$show_info = FALSE;
	}

	if( get_cfield( 'hide_breadcrumb', $blogpage_id ) == 1 ) {
		$title_arr['show_breadcrumb'] = false;
	} else if ( get_cfield( 'hide_breadcrumb', $blogpage_id ) === '0' ) {
		$title_arr['show_breadcrumb'] = true;
	}
}

$title_arr['title'] = $page_title;

if ( ( isset( $title_arr['show_breadcrumb'] ) && $title_arr['show_breadcrumb'] ) || $show_info === TRUE || $title_arr['show_title'] ) {
	echo kleo_title_section( $title_arr );
}
/* END TITLE SECTION */
?>

<?php get_template_part('page-parts/general-before-wrap');?>

<?php
	if (kleo_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

<?php
if ( have_posts() ) : ?>

    <?php if (sq_option('blog_switch_layout', 0) == 1 ) : /* Blog Layout Switcher */ ?>

    <?php kleo_view_switch( sq_option( 'blog_enabled_layouts' ), $blog_type ); ?>

    <?php endif; ?>

    <?php
    if ($blog_type == 'masonry') : ?>
        <div class="row responsive-cols kleo-masonry per-row-<?php echo sq_option( 'blog_columns', 3 );?>">
    <?php endif; ?>
				
	<?php
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		?>
		<?php 
		if ( $blog_type != 'standard' ) :
            get_template_part( 'page-parts/post-content-' . $blog_type );
		else:  
            get_template_part( 'content', get_post_format() );
		endif;
		
	endwhile;
	
	if ($blog_type == 'masonry') : ?>
		</div>
	<?php endif; ?>	

	<?php
	
	// Post navigation.
	kleo_pagination();

else :
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap');?>

<?php get_footer(); ?>