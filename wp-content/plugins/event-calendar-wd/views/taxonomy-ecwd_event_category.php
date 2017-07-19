<?php
/**
 * The template for displaying ECWD Category pages
 *
 * @package WordPress
 * @subpackage Event Calendar WD
 */
global $ecwd_options;
$option = get_option('ecwd_event_category_' . $wp_query->queried_object->term_id);
$img_src = (isset($option['ecwd_taxonomy_image'])) ? $option['ecwd_taxonomy_image'] : "";
$term_description = $wp_query->queried_object->description;
$display_description = (!isset($ecwd_options['category_archive_description']) || (isset($ecwd_options['category_archive_description']) && $ecwd_options['category_archive_description'] === '1'));
$display_image = (!isset($ecwd_options['category_archive_image']) || (isset($ecwd_options['category_archive_image']) && $ecwd_options['category_archive_image'] === '1'));
$cat_title = $wp_query->queried_object->name;

get_header();
?>

<section id="primary" class="content-area">    
    <div id="content" class="site-content" role="main">     
        <header class="page-header">
            <h1 class="page-title"><?php echo $cat_title; ?></h1>			
        </header>
        <div class="entry-header">                       
            <?php if ($display_image && $img_src != "") { ?>
                <div id="ecwd_category_archive_img">
                    <img src="<?php echo $img_src; ?>" />
                </div>
            <?php } ?>
            <?php if ($display_description) { ?>
                <div id="ecwd_category_archive_description">
                    <h2><?php echo $term_description; ?></h2>
                </div>
            <?php } ?> 
        </div>
        <?php if (have_posts()) : ?>
            <?php /* The loop */ ?>
            <?php while (have_posts()) : the_post(); ?>                                
                <?php get_template_part('content', get_post_format()); ?>
            <?php endwhile; ?>
            <?php
            the_posts_pagination(array(
                'prev_text' => __('Previous page'),
                'next_text' => __('Next page')                
            ));
            ?>
        </div>

    <?php else : ?>
        <?php get_template_part('content', 'none'); ?>
    <?php endif; ?>         
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>