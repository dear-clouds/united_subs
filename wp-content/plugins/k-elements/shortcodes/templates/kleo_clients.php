<?php
/**
 * Clients Shortcode
 * [kleo_clients number=5 animated=yes animation=fade]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = '';
extract(shortcode_atts(array(
    'number' => '5',
    'tags' => '',
    'animated' => 'yes',
    'animation' => "fade",
    'target' => '',
    'el_class' => ''
), $atts));

$class = esc_attr($el_class);
$class .= ' client-wrapper';

if ( $animated != '' ) {
	wp_enqueue_script( 'waypoints' );
	$class .= " one-by-one-animated animate-when-almost-visible";
}

$target = ($target == '_blank') ? ' target="_blank"' : '';

$args=array(
	'post_type' => 'kleo_clients',
	'showposts'=> $number
);

if ( $tags != '' && $tags != 'all' ) {
    $terms = explode( ',', $tags );
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'clients-tag',
            'terms'    => $terms,
        ),
    );
}

query_posts($args);

if ( have_posts() ) :

	ob_start();
	?>
	<div class="<?php echo $class; ?>">
		
		<?php while ( have_posts() ) : the_post();

		$client_link = '';
		if(get_cfield('client_link')) {
			$client_link = 'href="' . get_cfield('client_link') . '"';
		}
		if (get_post_thumbnail_id()) {
		?>
			<div class="client <?php if ( $animated != '' ) { echo 'list-el-animated';} ?>">
				<a <?php echo $client_link;?> <?php if ( $animated != '' ) { echo 'class="el-'.$animation.'"';} ?><?php echo $target;?>>
					<?php the_post_thumbnail();?>
				</a>
			</div>
	
		<?php 
		}
	endwhile; ?>
	
	</div>
	
<?php

$output = ob_get_clean();

endif;

wp_reset_query();


