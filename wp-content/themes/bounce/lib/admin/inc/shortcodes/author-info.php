<?php

if ( ! function_exists( 'gp_author_info_panel' ) ) {
	function gp_author_info_panel($atts, $content = null) {

		// If Author Has Website
		if(get_the_author_meta('user_url')) {
			$website ='<a href="'.get_the_author_meta('user_url').'">'.__('Visit My Website', 'gp_lang').'</a> / ';
		} else {
			$website = '';
		}
		
		$out =
	
		'<div class="author-info"><div class="author-info-fold"></div>'.
	
			get_avatar(get_the_author_meta('ID'), 50).'
	
			<div class="author-meta">
		
				<div class="author-meta-top">
				
					<div class="author-name">'.get_the_author().'</div>'.
				
					'<div class="author-links">'.$website.'<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.__('View My Other Posts', 'gp_lang').'</a></div>
			
				</div>
			
				<div class="author-desc">'.get_the_author_meta('description').'</div>
		
			</div>
		
		</div>
		';
				
	   return $out;
   
	}
}
add_shortcode("author", "gp_author_info_panel");

?>