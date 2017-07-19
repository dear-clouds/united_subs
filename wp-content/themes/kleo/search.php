<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//Specific class for post listing */
$blog_type = sq_option('blog_type','masonry');
$blog_type = apply_filters( 'kleo_blog_type', $blog_type );

$template_classes = $blog_type . '-listing';
if (sq_option('blog_archive_meta', 1) == 1) { $template_classes .= ' with-meta'; } else { $template_classes .= ' no-meta'; }
add_filter('kleo_main_template_classes', create_function('$cls','$cls .=" posts-listing '.$template_classes.'"; return $cls;'));


/***************************************************
:: Title section
***************************************************/
if (sq_option('title_location', 'breadcrumb') == 'main') {
	$title_arr['show_title'] = false;
}
else {
	$title_arr['title'] = kleo_title();
}

if(sq_option('breadcrumb_status', 1) == 0) {
	$title_arr['show_breadcrumb'] = false;
}

echo kleo_title_section($title_arr);
?>


<?php get_template_part('page-parts/general-before-wrap'); ?>


	<?php if ( have_posts() ) : ?>

    <?php if (sq_option('blog_switch_layout', 0) == 1 ) : /* Blog Layout Switcher */ ?>

        <?php kleo_view_switch( sq_option( 'blog_enabled_layouts' ), $blog_type ); ?>

    <?php endif; ?>

    <?php
    if ($blog_type == 'masonry') {
        echo '<div class="row responsive-cols kleo-masonry per-row-' . sq_option( 'blog_columns', 3 ) . '">';
    }
    ?>


	<?php
    // Start the Loop.
    while ( have_posts() ) : the_post();

        /*
         * Include the post format-specific template for the content. If you want to
         * use this in a child theme, then include a file called called content-___.php
         * (where ___ is the post format) and that will be used instead.
         */

        if ($blog_type != 'standard') :
            get_template_part( 'page-parts/post-content-' . $blog_type );
        else:
            get_template_part( 'content', get_post_format() );
        endif;

    endwhile;
    ?>

    <?php
    if ($blog_type == 'masonry') {
        echo '</div>';
    }
    ?>

		<?php
		
		// Previous/next post navigation.
		kleo_pagination();

	else :
		// If no content, include the "No posts found" template.
		get_template_part( 'content', 'none' );

	endif;
?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>