<?php

// ajax call init 
add_action( 'init', 'mom_mu_nbsm_init' );
function mom_mu_nbsm_init() {
    global $wp_query;
	// add scripts
        wp_register_script( 'mom_ajax_nb_sm', get_template_directory_uri().'/framework/ajax/nb-sm.js',  array('jquery'),'1.0',true);
	wp_enqueue_script( 'mom_ajax_nb_sm');
        
   
        // localize the script 
        wp_localize_script( 'mom_ajax_nb_sm', 'nbsm', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' ),
		'nomore' => __('No More Posts', 'framework'),
		)
	);
        
        
        // ajax Action
        add_action( 'wp_ajax_nbsm', 'mom_nb_show_more' );  
        add_action( 'wp_ajax_nopriv_nbsm', 'mom_nb_show_more');
}
function mom_nb_show_more() {
    // stay away from bad guys 
    $nonce = $_POST['nonce'];
    $nbs = $_POST['nbs'];
    $number_of_posts = $_POST['number_of_posts'];
    $orderby = $_POST['orderby'];
    $offset = $_POST['offset'];
    $offset_second = $_POST['offset_second'];
    $offset_all = $_POST['offset_all'];
    $cat = $_POST['cat'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
    $hpmeta = mom_option('post_meta_hp');
?>
<?php if ($nbs == 'nb1') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
<li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb1-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?>    
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 115, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</div>
</li>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php } elseif ($nbs == 'nb2') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
<div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb1-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php 
if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?>  
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 145, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
</div>
</div>

<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
<div class="comments-link">
<a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</li>
<?php
endwhile;
echo '</ul>';
else:
endif;
wp_reset_postdata();
?>
<?php } elseif ($nbs == 'nb3') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 2,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
?>
<div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb1-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php 
if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?>  
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 115, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</div>
</div>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb3-thumb'); ?>
</a></figure>
<?php } ?>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number('(0)','(1)','(%)'); ?></a>
</div>
</div>
<?php } ?>
</li>
<?php
endwhile;
echo '</ul>';
else:
endif;
wp_reset_postdata();
?>
<?php } elseif ($nbs == 'nb4') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
?>
<div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb1-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php 
if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?>  
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 110, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</div>
</div>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb3-thumb'); ?>
</a></figure>
<?php } ?>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<!--
<div class="comments-link">
<a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
-->
</div>
<?php } ?>
</li>
<?php
endwhile;
echo '</ul>';
else:
endif;
wp_reset_postdata();
?>
<?php } elseif ($nbs == 'nb5') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
?>
<div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb5-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?>  
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 180, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</div>
</div>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
<div class="comments-link">
<a href="#"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
</div>
<?php } ?>
</li>
<?php
endwhile;
echo '</ul>';
else:
endif;
wp_reset_postdata();
?>
<?php } elseif ($nbs == 'nb6') {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li <?php post_class(); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('nb5-thumb'); ?>
<span class="post-format-icon"></span>
</a></figure>
<?php } ?>
<?php if( mom_post_image() != false ) { 
$mom_class = ' class="fix-right-content"';    
} else {
$mom_class = '';
}
?>
<div<?php echo $mom_class; ?>>
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
<?php if($nb_excerpt != '0') { ?> 
<p>
<?php global $post;
$excerpt = $post->post_excerpt;
if($excerpt==''){
$excerpt = get_the_content('');
}
if($nb_excerpt == ''){
echo wp_html_excerpt(strip_shortcodes($excerpt), 120, '...');
} else {
echo wp_html_excerpt(strip_shortcodes($excerpt), $nb_excerpt, '...');	
}
?>
</p>
<?php } ?>
</div>
<?php if($hpmeta == 1) { ?>
<div class="entry-meta">
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="#"><?php comments_number('(0)','(1)','(%)'); ?></a>
</div>
</div>
<?php } ?>
</div>
</li>
<?php
endwhile;
echo '</ul>';
else:
endif;
wp_reset_postdata();
?>
<?php } ?>
<?php 
exit();
}