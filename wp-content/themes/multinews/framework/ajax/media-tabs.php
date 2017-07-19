<?php
add_action( 'init', 'mom_media_tabs' );
function mom_media_tabs() {
	// add scripts
        wp_register_script( 'mom_media_tabs', get_template_directory_uri().'/framework/ajax/media-tabs.js',  array('jquery'),'1.0',true);
	wp_localize_script( 'mom_media_tabs', 'momMedia', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' ),
	)
	);
        wp_enqueue_script('mom_media_tabs');
	
        // ajax Action
        add_action( 'wp_ajax_mom_media_tab', 'mom_ajax_media_tab' );  
        add_action( 'wp_ajax_nopriv_mom_media_tab', 'mom_ajax_media_tab');
}

function mom_ajax_media_tab () {
// stay away from bad guys 
$nonce = $_POST['nonce'];
if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
die ( 'Nope!' );
$type = $_POST['type'];
$order = isset($_POST['order']) ? $_POST['order'] : '';
if ($type == 'all') {
    $type = array('post-format-audio', 'post-format-video', 'post-format-gallery');
} else {
    $type = array ('post-format-'.$type);
}

if ($order == 'popular') {
    $order = 'comment_count';
} else {
    $order = 'date';
}

?>
<ul class="media-items-list clearfix">
<?php 
$args = array(
'post_type' => 'post', 
'posts_per_page' => -1,
'orderby' => $order,
'post_status' => 'publish',
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
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
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
<?php the_category(', '); ?>
</div>
</div>
</li>
<?php
} else { ?>
<li <?php post_class('media-item m-items'); ?> id="m-items">
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
<?php the_category(', '); ?>
</div>
</div>
</li>
<?php
}
$i++;
endwhile;
else:
endif;
wp_reset_postdata();
?>                                 
</ul>                    
<?php 
exit();
}