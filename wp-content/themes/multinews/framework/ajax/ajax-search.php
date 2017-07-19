<?php
add_action( 'init', 'mom_autocomplete_init' );
function mom_autocomplete_init() {
	// add scripts
        wp_register_script( 'mom_ajax_search', get_template_directory_uri().'/framework/ajax/ajax-search.js',  array('jquery','jquery-ui-autocomplete'),'1.0',true);
	wp_localize_script( 'mom_ajax_search', 'MyAcSearch', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' ),
		'homeUrl' => home_url(),
		'viewAll' => __('View All Results', 'framework'),
		'noResults' => __('Sorry, no posts matched your criteria', 'framework'),
		)
	);
        wp_enqueue_script('mom_ajax_search');
	
        // ajax Action
        add_action( 'wp_ajax_mom_ajaxsearch', 'mom_ajax_search' );  
        add_action( 'wp_ajax_nopriv_mom_ajaxsearch', 'mom_ajax_search');
}

function mom_ajax_search () {
// stay away from bad guys 
$nonce = $_POST['nonce'];
if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
die ( 'Nope!' );
?>
<?php
$posts_query = new WP_Query( array('s' =>$_POST['term'], 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 5) );
if ( $posts_query->have_posts() ) {
?>
<h4 class="search-results-title"><?php _e('Posts', 'framework'); ?></h4>
<?php
// The Loop
while ( $posts_query ->have_posts() ) {
$posts_query ->the_post();
?>
<a href="<?php the_permalink(); ?>" <?php post_class('ajax-search-item'); ?>>
<?php if (mom_post_image() != false) { ?>
<img src="<?php echo mom_post_image('search-thumb'); ?>" alt="<?php the_title(); ?>">
<?php } else { ?>
<span class="post_format"></span>
<?php } ?>
<?php if(is_rtl()) { ?>
<h2><?php short_title(30); ?></h2>
<?php } else { ?>
<h2><?php short_title(25); ?></h2>
<?php } ?>
<span><?php the_time('F j, Y'); ?></span>
</a>
<?php } //end while  ?>
<?php } ?>
<?php wp_reset_postdata();
?>
<?php
$pages_query = new WP_Query( array('s' =>$_POST['term'], 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 5) );
if ( $pages_query->have_posts() ) {
?>
<h4 class="search-results-title"><?php _e('Pages', 'framework'); ?></h4>
<?php
// The Loop
while ( $pages_query ->have_posts() ) {
$pages_query ->the_post();
?>
<a href="<?php the_permalink(); ?>" <?php post_class('ajax-search-item'); ?>>
<?php if (mom_post_image() != false) { ?>
<img src="<?php echo mom_post_image('search-thumb'); ?>" alt="<?php the_title(); ?>">
<?php } else { ?>
<span class="post_format"></span>
<?php } ?>
<?php if(is_rtl()) { ?>
<h2><?php short_title(30); ?></h2>
<?php } else { ?>
<h2><?php short_title(25); ?></h2>
<?php } ?>
<span><?php the_time('F j, Y'); ?></span>
</a>
<?php } //end while  ?>
<?php } ?>
<?php wp_reset_postdata(); ?>
<?php 
exit();
}