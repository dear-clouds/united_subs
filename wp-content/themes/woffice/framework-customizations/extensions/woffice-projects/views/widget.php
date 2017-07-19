<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>
	<!-- WIDGET -->
	<ul class="list-styled list-projects">
		<?php 
			//QUERY $tax
			$query_args = array(
				'post_type' => 'project',
			);
			if (!empty($category) && $category != "all") {
				$the_tax = array(array(
					'taxonomy' => 'project-category',
					'terms' => array($category),
					'field' => 'slug',
				));
				$query_args['tax_query'] = $the_tax;
			}
			// GET PROJECTS POSTS
			$widget_projects_query = new WP_Query($query_args);
			$numberprojects = 0;
			while($widget_projects_query->have_posts()) : $widget_projects_query->the_post(); 
				if (woffice_is_user_allowed_projects()) : 
					echo'<li>';
						echo '<a href="'. get_the_permalink() .'" rel="bookmark">'. get_the_title() .'</a>';
						echo woffice_project_progressbar();
					echo '</li>';
					$numberprojects++;
				else :
					$numberprojects = $numberprojects;
				endif;
			endwhile;
			echo ($numberprojects==0) ? __("Sorry you don't have any project yet.","woffice"):""; 
			wp_reset_postdata();
		?>
	</ul>
<?php echo $after_widget ?>