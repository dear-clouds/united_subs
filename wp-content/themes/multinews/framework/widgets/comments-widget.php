<?php 

add_action('widgets_init','mom_recent_comments');

function mom_recent_comments() {
	register_widget('mom_recent_comments');
	}

class mom_recent_comments extends WP_Widget {

 
	function mom_recent_comments() {
			
		$widget_ops = array('classname' => 'mom_comments','description' => __('Widget display Recent Comments with avatar','framework'));
/*		$control_ops = array( 'twitter name' => 'momizat', 'count' => 3, 'avatar_size' => '32' );
*/		
		parent::__construct('mom_comments',__('Momizat - Recent Comments','framework'),$widget_ops);

/*	add_action( 'save_post', array( $this, 'invalidate_widget_cache' ) );
	add_action( 'deleted_post', array( $this, 'invalidate_widget_cache' ) );
	add_action( 'switch_theme', array( $this, 'invalidate_widget_cache' ) );
*/
	//special Action for this widget
	add_action( 'wp_insert_comment', array( $this, 'invalidate_widget_cache' ) );

	}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$count = $instance['count'];

$output = get_transient($this->id);
$output = false;
if ($output == false) { 
    ob_start();

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

?>
<ul class="latest-comment-list">
	<?php
	global $wpdb;

	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,45) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $count";
	$comments = $wpdb->get_results($sql);
	foreach ($comments as $comment) :
		$has_avatar = ''; if (get_avatar( $comment->comment_author_email) != '') { $has_avatar ='class="has_avatar"';}
	?>
    <li <?php echo $has_avatar; ?>>
    	<?php  if (get_avatar( $comment->comment_author_email) != '') { ?>  
        <figure><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>"><?php echo get_avatar( $comment->comment_author_email, '70' ); ?></a></figure>
        <?php } ?>
        <cite><a rel="author" href="<?php echo comment_author_url( $comment->comment_ID ); ?>" target="_blank"><?php echo get_comment_author( $comment->comment_ID ); ?></a></cite>
        <span><?php _e('on', 'framework');?> <?php echo get_comment_date( mom_option('date_format'), $comment->comment_ID ); ?></span>
        <span><?php _e('in :' , 'framework'); ?> <a href="<?php echo get_permalink($comment->ID); ?>" rel="bookmark"><?php 
			$excerpt = $comment->post_title;
			echo wp_html_excerpt($excerpt,25);
            ?> ...</a></span>
        <div class="comment-body">
            <p><?php 
			$excerpt = $comment->com_excerpt;
			echo wp_html_excerpt($excerpt,145);
            ?> ...</p>
        </div>
    </li>
    <?php endforeach; ?>            
    <?php wp_reset_query(); ?>
</ul>

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;

    $output = ob_get_contents();
    ob_end_clean();
    //set_transient($this->id, $output, 60*60*24);
}

    echo $output;    

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['count'] = $new_instance['count'];
		delete_transient( $this->id );

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __('Comments', 'framework'),
			'count' => '5'
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
    	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('title:', 'framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of comments', 'framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>


   <?php 
}
	public function invalidate_widget_cache()
	{
		delete_transient( $this->id );
	} 
} //end class