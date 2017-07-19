<?php

/* Query args */
$args=array(
    'post__not_in' => array($post->ID),
    'showposts'=> 8,
    'orderby' => 'rand' //random posts
);

//logic for blog posts
if (is_singular('post')) {

    //related text
    $related_text = esc_html__("Related Articles", "kleo_framework");

    $categories = get_the_category($post->ID);

    if (!empty($categories)) {
        $category_ids = array();
        foreach ($categories as $rcat) {
            $category_ids[] = $rcat->term_id;
        }

        $args['category__in'] = $category_ids;
    }
}
// logic for custom post types
else {

    //related text
    $related_text = esc_html__("Related", "kleo_framework");

    global $post;
    $categories = get_object_taxonomies($post);

    if (!empty($categories)) {
        foreach( $categories as $tax ) {
            $terms = wp_get_object_terms($post->ID, $tax, array('fields' => 'ids'));

            $args['tax_query'][] = array(
                'taxonomy' => $tax,
                'field' => 'id',
                'terms' => $terms
            );
        }
    }
}

/* Remove this line to show related posts even no categories are found */
if (!$categories) { return; }

?>

<?php query_posts($args); if ( have_posts() ) : ?>

<section class="container-wrap">
	<div class="container">
		<div class="related-wrap">
        
            <div class="hr-title hr-long"><abbr><?php echo $related_text; ?></abbr></div>
        
            <div class="kleo-carousel-container dot-carousel">
                <div class="kleo-carousel-items kleo-carousel-post" data-min-items="1" data-max-items="6">
                    <ul class="kleo-carousel">

                        <?php
                        while ( have_posts() ) : the_post();

                            get_template_part('page-parts/post-content-carousel');

                        endwhile;
                        ?>

                    </ul>
                </div>
                <div class="carousel-arrow">
                    <a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
                    <a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
                </div>
                <div class="kleo-carousel-post-pager carousel-pager"></div>
            </div><!--end carousel-container-->
		</div>
	</div>
</section>

<?php
endif;

// Reset Query
wp_reset_query();
?>