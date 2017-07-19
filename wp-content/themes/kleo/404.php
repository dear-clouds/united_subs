<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
add_filter('kleo_main_template_classes', create_function('$cols', '$cols .= " text-center"; return $cols;'));
?>

<?php 
$title_arr['title'] = kleo_title();
if (sq_option('title_location', 'breadcrumb') == 'main') {
	$title_arr['show_title'] = false;
}
?>
<?php echo kleo_title_section( $title_arr ); ?>

<?php get_template_part( 'page-parts/general-before-wrap' ); ?>

<div class="row">
	<div class="col-sm-12">
			<img src="<?php echo get_template_directory_uri();?>/assets/img/404_image.png"><br>
			<h2 class="article-title"><?php esc_html_e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'kleo_framework' ); ?></h2>

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'kleo_framework' ); ?></p>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-sm-offset-3 search-404">
			<?php get_search_form(); ?>
	</div>
</div>

<br><br><br>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>