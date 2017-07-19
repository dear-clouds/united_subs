<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
if ( sq_option( 'blog_archive_meta', 1 ) == 1 ) {
    $template_classes .= ' with-meta';
} else {
    $template_classes .= ' no-meta';
}

if ( $blog_type == 'standard' && sq_option('blog_standard_meta', 'left' ) == 'inline' ) {
    $template_classes .= ' inline-meta';
}
add_filter('kleo_main_template_classes', create_function('$cls','$cls .=" posts-listing ' . $template_classes . '"; return $cls;'));
?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php if ( category_description() ) : ?>
    <div class="archive-description"><?php echo category_description(); ?></div>
<?php endif; ?>

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
            $post_format = kleo_get_post_format();
            get_template_part( 'content', $post_format );
        endif;

    endwhile;
    ?>

    <?php
    if ($blog_type == 'masonry') {
        echo '</div>';
    }
    ?>

    <?php
    // page navigation.
    kleo_pagination();

else :
    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );

endif;
?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>