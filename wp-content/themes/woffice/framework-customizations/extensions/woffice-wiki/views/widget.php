<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>
	<!-- WIDGET -->
	<ul class="list-styled list-wiki">
		<?php 
			
			// GET WIKI POSTS
			$widget_wiki_query = new WP_Query('post_type=wiki&showposts='.$show);
			while($widget_wiki_query->have_posts()) : $widget_wiki_query->the_post();
			 
				if (woffice_is_user_allowed_wiki()){
					$likes = woffice_get_wiki_likes(get_the_id());
					$likes_display = (!empty($likes)) ? $likes : '';
					echo'<li><a href="'. get_the_permalink() .'" rel="bookmark">'. get_the_title() . $likes_display.'</a></li>';
				}
				
			endwhile;
			wp_reset_postdata();
		?>
	</ul>
<?php echo $after_widget ?>