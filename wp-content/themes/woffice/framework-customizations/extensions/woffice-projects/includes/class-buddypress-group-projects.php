<?php 
if ( class_exists( 'BP_Group_Extension' ) ) :
  
class Group_Extension_Projects extends BP_Group_Extension {
    /**
     * Here you can see more customization of the config options
     */
    function __construct() {
	    $projects_groups = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_groups') : '';
		if ($projects_groups == "yep") {
	        $args = array(
	            'slug' => 'group-projects',
	            'name' => __('Projects', 'woffice'),
	            'nav_item_position' => 105,
	        );
	        parent::init( $args );
	    }
    }
 
    function display( $group_id = NULL ) {
        $group_id = bp_get_group_id();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
	        'post_type' => 'project', 
	        'paged' => $paged,
	        'tax_query' => array(
				array(
					'taxonomy' => 'project-category',
					'field'    => 'name',
					'terms'    => bp_get_current_group_name(),
				),
			),
        );
		$project_query = new WP_Query($args);

		$pPage = get_posts(array(
			'post_type'  => 'page',
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-templates/projects.php'
		));

		if($pPage){
			echo '<div class="group-create-project center">
				<a href="'.get_page_link($pPage{0}->ID).'#show-project-create" class="btn btn-default"><i class="fa fa-plus"></i> Create a new project</a>
			</div>';
		}

		if ( $project_query->have_posts() ) :
			echo'<ul id="projects-list">';
			// LOOP
			while($project_query->have_posts()) : $project_query->the_post(); 
			
				if (woffice_is_user_allowed_projects()) : 
				
					echo '<li class="intern-padding">'; 
					
						// THE TITLE + INFOS
						echo '<a href="'. get_the_permalink() .'" rel="bookmark" class="project-head">';
							// TITLE
							echo'<h2><i class="fa fa-cubes"></i> '. get_the_title() .'</h2>';
							// COMMENTS
							if (get_comment_count(get_the_ID()) > 0):
								echo '<span class="project-comments"><i class="fa fa-comments-o"></i> '.get_comments_number( '0', '1', '%' ).'</span>';
							endif;
							// CATEGORY
							if( has_term('', 'project-category')): 
								echo '<span class="project-category"><i class="fa fa-tag"></i>';
								echo wp_strip_all_tags(get_the_term_list( get_the_id(), 'project-category', '', ', ' ));
								echo '</span>';
							endif;
							// MEMBERS
							$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_members') : '';
							echo '<span class="project-members"><i class="fa fa-users"></i> '.count($project_members).'</span>';
						echo'</a>';
						// THE PROGRESS BAR
						echo woffice_project_progressbar();
						// EXCERPT
						echo '<p class="project-excerpt">'. get_the_excerpt() .'</p>';
						// LINK READ MORE
						echo '<div class="text-right">';
							echo '<a href="'.get_the_permalink().'" class="btn btn-default">';
								echo __("See Project","woffice").' <i class="fa fa-arrow-right"></i>';
							echo'</a>';
						echo '</div>';
					echo '</li>';
				endif;
			endwhile;
			echo '</ul>';
            woffice_paging_nav($project_query);
		else : 
			get_template_part( 'content', 'none' );
		endif; 
		wp_reset_postdata();
        
    }
 
}
bp_register_group_extension( 'Group_Extension_Projects' );
 
endif;