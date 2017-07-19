<?php

if ( ! function_exists( 'gp_activity' ) ) {
	function gp_activity( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'header' => 'Latest Activity',
			'scope' => '',
			'per_page' => '5',
			'comments' => 'threaded',
			'allow_comments' => 'false',
			'order' => 'desc',
			'pagination' => 'true',
			'max' => '',
			'user_id' => '',
		), $atts ) );
				
		// Add global variable for per page for activity loop function		
		if ( ! update_option( 'activity_per_page', $per_page ) ) {
			add_option( 'activity_per_page', $per_page );
		} else { 
			update_option( 'activity_per_page', $per_page );
		}

		ob_start(); ?>
	
		<?php if ( function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) ) { ?>
			
			<?php if ( $header ) { ?><h3 class="post-header"><?php echo $header; ?></h3><?php } ?>
			
			<div id="buddypress">
			
				<div class="bp-wrapper gp-activity-stream activity post-wrapper<?php if ( $allow_comments == 'true' ) { ?> gp-allow-comments<?php } ?>">
	
					<?php
			
					do_action( 'bp_before_activity_loop' ); ?>
			
					<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) . "&scope=$scope&per_page=$per_page&display_comments=$comments&sort=$order&max=$max&user_id=$user_id&count_total=count_query&page_arg=actsc" ) ) : ?>
			
						<?php if ( empty( $_POST['page'] ) ) : ?>
			
							<ul id="activity-stream" class="activity-list item-list">
			
						<?php endif; ?>
			
						<?php while ( bp_activities() ) : bp_the_activity(); ?>

							<?php bp_get_template_part( 'activity/entry' ); ?>

						<?php endwhile; ?>
					
						<?php if ( bp_activity_has_more_items() && $pagination == 'true' ) : ?>

							<?php if ( function_exists( 'bp_activity_load_more_link' ) ) { ?>
							
								<li class="load-more">
									<a href="<?php bp_activity_load_more_link(); ?>"><?php _e( 'Load More', 'gp_lang' ); ?></a>
								</li>
							
							<?php } ?>
							
						<?php endif; ?>
					
						<?php if ( empty( $_POST['page'] ) ) : ?>
							
							</ul>
						
						<?php endif; ?>
		
						<?php if ( ! function_exists( 'bp_activity_load_more_link' ) && $pagination == 'true' ) : ?>
			
							<div class="wp-pagenavi cat-navi">
								<div class="pages"><?php bp_activity_pagination_count(); ?></div>
								<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
							</div>
		
						<?php endif; ?>
				
					<?php else : ?>
			
						<div id="message" class="info">
							<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'gp_lang' ); ?></p>
						</div>
			
					<?php endif; ?>
			
					<?php do_action( 'bp_after_activity_loop' ); ?>
			
					<?php if ( empty( $_POST['page'] ) ) : ?>

						<form action="" name="activity-loop-form" id="activity-loop-form" method="post">

							<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

						</form>

					<?php endif; ?>
	
				</div>
			
			</div>
		
		<?php } ?>
			
		<?php 

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;

	}
}
add_shortcode( 'activity', 'gp_activity' );

// Change number of items per page in activity loop
if ( ! function_exists( 'gp_activity_loop' ) ) {
	function gp_activity_loop( $query_string, $object ) {
		if ( ! empty( $query_string ) ) {
			$query_string .= '&';
		}
		if ( bp_is_blog_page() ) {
			$query_string .= 'per_page=' . get_option( 'activity_per_page' );
		} else {
			$query_string .= 'per_page=20';	
		}
		return $query_string;	
	}
}
add_action( 'bp_ajax_querystring', 'gp_activity_loop', 20, 2 );

?>