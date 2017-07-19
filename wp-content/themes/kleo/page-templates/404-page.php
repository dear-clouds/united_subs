<?php
/**
 * Template Name: 404 Page
 *
 * Description: Use this page template to show a 404 page
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
add_filter('kleo_main_template_classes', create_function('$cols', '$cols .= " text-center"; return $cols;'));

?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

				<div class="row">
					<div class="col-sm-12">
							<img src="<?php echo get_template_directory_uri();?>/assets/img/404_image.png"><br>
							<h2 class="article-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'kleo_framework' ); ?></h2>

							<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'kleo_framework' ); ?></p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 search-404">
							<?php get_search_form(); ?>
					</div>
				</div>

				<br><br><br>

	
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>

	<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>