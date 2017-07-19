<ul class="mom-su-posts mom-su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<li id="mom-su-post-<?php the_ID(); ?>" class="mom-su-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
	}
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'theme' ) ?></li>
<?php
}
?>
</ul>
