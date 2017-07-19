<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

// GET BLOG POSTS
$shortcode_blog_query = new WP_Query(array(
	'post_type' => 'post',
	'showposts' => $atts['number'],
	'order' => 'ASC'
));
$loop_number = 0;
?>

<div class="blog-shortcode-container">

	<?php
	if ( $shortcode_blog_query->have_posts() ) {
		echo '<ul class="list-styled list-arrow">';
		while($shortcode_blog_query->have_posts()) : $shortcode_blog_query->the_post();
		?>
			<li>
				<h4>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php echo human_time_diff( get_the_date('U'), current_time('timestamp') ) . ' '. __('ago','woffice'); ?></span>
				</h4>
				<?php if($atts['excerpt']): ?>
					<p><?php the_excerpt(); ?></p>
				<?php endif; ?>
			</li>
		<?php
		endwhile;
		echo '</ul>';
	}
	?>

</div>