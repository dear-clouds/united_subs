<?php

// ajax call init
add_action( 'init', 'mom_mu_ajax_init' );
function mom_mu_ajax_init() {

        //show more
        add_action( 'wp_ajax_nbsm', 'mom_nb_show_more' );
        add_action( 'wp_ajax_nopriv_nbsm', 'mom_nb_show_more');

        //news tabs
        add_action( 'wp_ajax_nbtabs', 'mom_nb_tabs' );
        add_action( 'wp_ajax_nopriv_nbtabs', 'mom_nb_tabs');

        //search
        add_action( 'wp_ajax_mom_ajaxsearch', 'mom_ajax_search' );
        add_action( 'wp_ajax_nopriv_mom_ajaxsearch', 'mom_ajax_search');

        //Media tabs
        add_action( 'wp_ajax_mom_media_tab', 'mom_ajax_media_tab' );
        add_action( 'wp_ajax_nopriv_mom_media_tab', 'mom_ajax_media_tab');

        //Mailchimp
        add_action( 'wp_ajax_mom_mailchimp', 'mom_mailchimp_subscribe' );
        add_action( 'wp_ajax_nopriv_mom_mailchimp', 'mom_mailchimp_subscribe');
}



/* ==========================================================================
 *                Ajax Search
   ========================================================================== */
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
<?php mom_post_image_full('search-thumb'); ?>
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
if(mom_option('search_page_ex') != true) {
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
<?php mom_post_image_full('search-thumb'); ?>
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
<?php }
exit();
}


/* ==========================================================================
 *                Media tab
   ========================================================================== */

function mom_ajax_media_tab () {
// stay away from bad guys
$nonce = $_POST['nonce'];
if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
die ( 'Nope!' );
$type = $_POST['type'];
$count = $_POST['count'];
$order = isset($_POST['order']) ? $_POST['order'] : '';
$offset = isset($_POST['offset']) ? $_POST['offset'] : '';

if ($type == 'all') {
    $type = array('post-format-audio', 'post-format-video', 'post-format-gallery');
} else {
    $type = array ('post-format-'.$type);
}
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

if ($order == 'popular') {
    $order = 'comment_count';
} else {
    $order = 'date';
}
?>
<?php
$args = array(
'post_type' => 'post',
'posts_per_page' => $count,
'orderby' => $order,
'paged' => $paged,
'post_status' => 'publish',
'offset' => $offset,
'tax_query' => array(
array(
'taxonomy' => 'post_format',
'field' => 'slug',
'terms' => $type,
'operator' => 'IN'
))
);
$query = new WP_Query( $args );
$i = 0;
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) : ?>
<ul class="media-items-list clearfix">
<?php while ( $query->have_posts() ) : $query->the_post();
global $posts_st;
$extra = get_post_meta(get_the_ID(), $posts_st->get_the_id(), TRUE);
if (isset($extra['video_type'])) { $video_type = $extra['video_type']; }
if (isset($extra['video_id'])) { $video_id = $extra['video_id']; }
if (isset($extra['html5_mp4_url'])) { $html5_mp4 = $extra['html5_mp4_url']; }
if (isset($extra['html5_duration'])) { $html5_duration = $extra['html5_duration']; } else { $html5_duration = '00:00'; }
if (isset($extra['slides'])) { $slides = $extra['slides']; } else { $slides = ''; }
$post_format = get_post_format();
$num_of_slides = $post_format == 'gallery' ? count($slides) :'';
if ($i < 2) {
?>
<li <?php post_class('media-item featured'); ?>>
<div class="media-item--inner">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail">
<a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('media1-thumb'); ?>
</a>
<div class="media-data">
<div class="media-format"></div>
<?php if ($post_format == ('video')) { ?>
<?php if ($video_type == 'youtube') { ?>
<div class="video-time">
<?php echo mom_youtube_duration($video_id); ?>
</div>
<?php } elseif ($video_type == 'vimeo') { ?>
<div class="video-time">
<?php echo mom_vimeo_duration($video_id); ?>
</div>
<?php } else { ?>
<div class="video-time">
<?php echo $html5_duration; ?>
</div>
<?php } ?>
<?php } elseif ($post_format == ('gallery')) { ?>
<div class="video-time"><?php echo $num_of_slides; ?></div>
<?php } else { ?>
<div class="video-time">
<?php echo $html5_duration; ?>
</div>
<?php } ?>
</div>
</figure>
<?php } ?>
<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="entry-meta">
<time datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
<div class="cat-link">
<?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
</div>
</div>
</div>
</li>
<?php
} else { ?>
<li <?php post_class('media-item m-items'); ?>>
<div class="media-item--inner">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail">
<a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('media-thumb'); ?>
</a>
<div class="media-data">
<div class="media-format"></div>
<?php if ($post_format == ('video')) { ?>
<?php if ($video_type == 'youtube') { ?>
<div class="video-time">
<?php echo mom_youtube_duration($video_id); ?>
</div>
<?php } elseif ($video_type == 'vimeo') { ?>
<div class="video-time">
<?php echo mom_vimeo_duration($video_id); ?>
</div>
<?php } else { ?>
<div class="video-time">
<?php echo $html5_duration; ?>
</div>
<?php } ?>
<?php } elseif ($post_format == ('gallery')) { ?>
<div class="video-time"><?php echo $num_of_slides; ?></div>
<?php } else { ?>
<div class="video-time">
<?php echo $html5_duration; ?>
</div>
<?php } ?>
</div>
</figure>
<?php } ?>
<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="entry-meta">
<time datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
<div class="cat-link">
<?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
</div>
</div>
</div>
</li>
<?php
}
$i++;
endwhile; ?>
</ul>
<?php else:
endif;
?>
<?php
wp_reset_postdata();
exit();
}

/* ==========================================================================
 *                newsbox Show more
   ========================================================================== */
function mom_nb_show_more() {
    // stay away from bad guys
    $nonce = $_POST['nonce'];
    $nbs = $_POST['nbs'];
    $display = $_POST['display'];
    $tag = $_POST['tag'];
    $number_of_posts = $_POST['number_of_posts'];
    $orderby = $_POST['orderby'];
    $offset = $_POST['offset'];
    $offset_second = $_POST['offset_second'];
    $offset_all = $_POST['offset_all'];
    $post_type = $_POST['post_type'];
    $cat = $_POST['cat'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
    $post_meta_hp = mom_option('post_meta_hp');
    if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}
    $nb_excerpt = $_POST['nb_excerpt'];
?>
<?php if ($nbs == 'nb1') { ?>
<?php
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => 2,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 2,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number('0','1','%'); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset_all , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li <?php post_class(); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('scroller-thumb'); ?>
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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number('0','1','%'); ?></a>
</div>
<?php } ?>
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
<?php } elseif ($nbs == 'list') { ?>
<?php
if ($display == 'tag') {
    $query = new WP_Query( array( 'tag' => $tag, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
} else {
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_type' => $post_type, 'post_status' => 'publish' ) );
}
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
<li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_cat != 0) { ?>
<span class="cat-link">
<i class="momizat-icon-folder-open"></i><?php the_category(', '); ?>
</span>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<span class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>

</span>
<?php } ?>
<div class="clear"></div>
</div>
<?php } ?>
</li>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php } ?>
<?php
exit();
}
/* ==========================================================================
 *                News Box tabs
   ========================================================================== */

function mom_nb_tabs() {
    // stay away from bad guys
    $nonce = $_POST['nonce'];
    $nbs = $_POST['nbs'];
    $number_of_posts = $_POST['number_of_posts'];
    $cat = $_POST['cat'];
    $orderby = '';
    $offset = $_POST['offset'];;
    $nb_excerpt = $_POST['nb_excerpt'];
        $post_meta_hp = mom_option('post_meta_hp');
	if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
?>
               <?php if ($nbs == 'nb1') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 2, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number('0','1','%'); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 1, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts,'offset' => $offset , 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li role="article" itemscope="" itemtype="http://schema.org/Article">
<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
</div>
<?php } ?>
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
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) :
echo '<ul>';
while ( $query->have_posts() ) : $query->the_post();
?>
<li <?php post_class(); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
<?php if( mom_post_image() != false ) { ?>
<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
<?php mom_post_image_full('scroller-thumb'); ?>
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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<div class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number('0','1','%'); ?></a>
</div>
<?php } ?>
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
<?php } elseif ($nbs == 'list') { ?>
<?php
$query = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'post_status' => 'publish' ) );
update_post_thumbnail_cache( $query );

if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
<li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
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
<?php if($post_head != 0) { ?>
<div class="entry-meta">
<?php if($post_head_date != 0) { ?>
<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
<?php } ?>
<?php if($post_head_cat != 0) { ?>
<span class="cat-link">
<i class="momizat-icon-folder-open"></i><?php the_category(', '); ?>
</span>
<?php } ?>
<?php if($post_head_commetns != 0) { ?>
<span class="comments-link">
<i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>

</span>
<?php } ?>
<div class="clear"></div>
</div>
<?php } ?>
</li>
<?php
endwhile;
else:
endif;
wp_reset_postdata();
?>
<?php } ?>
<?php
exit();
}

/* ==========================================================================
 *                MailChimp
   ========================================================================== */
function mom_mailchimp_subscribe () {
// stay away from bad guys
$nonce = $_POST['nonce'];
$list_id = $_POST['list_id'];
if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
die ( 'Nope!' );
$api_key = mom_option('mailchimp_api_key');
if ($api_key != '') {
require(MOM_FW . '/inc/mailchimp/Mailchimp.php');
$Mailchimp = new Mom_Mailchimp( $api_key );
$Mailchimp_Lists = new Mom_Mailchimp_Lists( $Mailchimp );
if (isset($_POST['email'])) {
    $meminfo = $Mailchimp_Lists->memberInfo( $list_id, array ( array( 'email' => htmlentities($_POST['email']) ) ));
    if ($meminfo['success_count'] == 1) {
        echo 'already';
    } else {
        $subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($_POST['email']) ) );
        if ( ! empty( $subscriber['leid'] ) ) {
        echo "success";
        }
        else
        {
        echo "fail";
        }
        }
    }

} else {
    echo 'auth';
}
exit();
}
