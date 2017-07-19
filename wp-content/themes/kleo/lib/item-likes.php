<?php
/*
Add likes to posts

*/

class ItemLikes {

	function __construct() 
	{
		add_filter('body_class', array(&$this, 'body_class'));
		add_action('publish_post', array(&$this, 'setup_likes'));
		add_action('kleo_post_footer', array(&$this, 'show_likes'));
		add_action('kleo_show_love', array(&$this, 'show_likes'));
		add_action('wp_ajax_item-likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_item-likes', array(&$this, 'ajax_callback'));
		add_shortcode('item_likes', array(&$this, 'shortcode'));
		add_action('widgets_init', create_function('', 'register_widget("ItemLikes_Widget");'));
	}

	function show_likes()
	{
		//$post_types = array( 'post', 'attachment' );
		//$post_types = apply_filters( 'kleo_likes_post_types', $post_types );
		//$current_post_type = get_post_type();
		
		//if( in_array( $current_post_type, $post_types ) ) {
			echo $this->do_likes();
		//}
	}
	
	function setup_likes( $post_id ) 
	{
		if(!is_numeric($post_id)) return;
	
		add_post_meta($post_id, '_item_likes', '0', true);
	}
	
	function ajax_callback($post_id) 
	{
		if( isset($_POST['likes_id']) ) {
			// Click event. Get and Update Count
			$post_id = str_replace('item-likes-', '', $_POST['likes_id']);
			echo $this->like_this($post_id, sq_option('likes_zero_text', ''), sq_option('likes_one_text', ''), sq_option('likes_more_text', ''), 'update');
		} else {
			// AJAXing data in. Get Count
			$post_id = str_replace('item-likes-', '', $_POST['post_id']);
			echo $this->like_this($post_id, sq_option('likes_zero_text', ''), sq_option('likes_one_text', ''), sq_option('likes_more_text', ''), 'get');
		}
		
		exit;
	}
	
	function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get') 
	{
		if(!is_numeric($post_id)) return;
		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);

		if ( defined('ICL_SITEPRESS_VERSION') ){
            global $sitepress;
            if (is_object($sitepress)) {
                $post_id = icl_object_id($post_id, 'post', true, $sitepress->get_default_language());
            }
        }
		
		switch($action) {
		
			case 'get':
				$likes = get_post_meta($post_id, '_item_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_id, '_item_likes', $likes, true);
				}
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="item-likes-count">'. $likes .'</span> <span class="item-likes-postfix">'. $postfix .'</span>';
				break;
				
			case 'update':
				$likes = get_post_meta($post_id, '_item_likes', true);
				if( isset($_COOKIE['item_likes_'. $post_id]) ) return $likes;
				
				$likes++;
				update_post_meta($post_id, '_item_likes', $likes);
				setcookie('item_likes_'. $post_id, $post_id, time()*20, '/');
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="item-likes-count">'. $likes .'</span> <span class="item-likes-postfix">'. $postfix .'</span>';
				break;
		
		}
	}
	
	function shortcode( $atts )
	{
		extract( shortcode_atts( array(
		), $atts ) );
		
		return $this->do_likes();
	}
	
	function do_likes( $post_id = null )
	{
        if ( ! $post_id ) {
            global $post;
            $post_id = $post->ID;
        }

		if ( defined('ICL_SITEPRESS_VERSION') ){
            global $sitepress;
            $post_id = icl_object_id( $post_id, 'post', true, $sitepress->get_default_language() );
        }
		
		$output = $this->like_this($post_id, sq_option('likes_zero_text', ''), sq_option('likes_one_text', ''), sq_option('likes_more_text', ''));
  
  		$class = 'item-likes';
  		$title = sq_option('like_this_text', 'Like this');
		if( isset($_COOKIE['item_likes_'. $post_id]) ){
			$class = 'item-likes liked';
			$title = sq_option('likes_already', 'You already like this');
		}
		
		return '<a href="#" class="'. $class .'" id="item-likes-'. $post_id .'" title="'. $title .'">'. $output .'</a>';
	}
	
    function body_class($classes) {
        
        if( sq_option('likes_ajax', 0) == 1 ) {
            $classes[] = 'ajax-item-likes';
        }
			
    	return $classes;
    }
	
}
global $kleo_item_likes;
$kleo_item_likes = new ItemLikes();

/**
 * Template Tag
 */
function kleo_item_likes( $post_id = null, $return = false )
{
	global $kleo_item_likes;
    if ( $return === true ) {
        return $kleo_item_likes->do_likes($post_id);
    } else {
        echo $kleo_item_likes->do_likes($post_id);
    }
}

/**
 * Widget to display posts by likes popularity
 */

class ItemLikes_Widget extends WP_Widget {

	function __construct() {
		parent::__construct( 'item_likes_widget', 'ItemLikes', array( 'description' => __('Displays your most popular posts sorted by most liked', 'kleo_framework') ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$desc = $instance['description'];
		$posts = empty( $instance['posts'] ) ? 1 : $instance['posts'];
		$display_count = $instance['display_count'];

		// Output our widget
		echo $before_widget;
		if( !empty( $title ) ) echo $before_title . $title . $after_title;

		if( $desc ) echo '<p>' . $desc . '</p>';

		$likes_posts_args = array(
			'numberposts' => $posts,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_item_likes',
			'post_type' => 'post',
			'post_status' => 'publish'
		);
		$likes_posts = get_posts($likes_posts_args);

		echo '<ul class="popular-posts">';
		foreach( $likes_posts as $likes_post ) {
			$count_output = '';
			if( $display_count ) {
				$count = get_post_meta( $likes_post->ID, '_item_likes', true);
				$count_output = " <span class='item-likes-count'>($count)</span>";
			}
			echo '<li><a href="' . get_permalink($likes_post->ID) . '">' . get_the_title($likes_post->ID) . '</a>' . $count_output . '</li>';
		}
		echo '</ul>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em><span>');
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['display_count'] = strip_tags($new_instance['display_count']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);

		$defaults = array(
			'title' => __('Popular Posts', 'kleo_framework'),
			'description' => '',
			'posts' => 5,
			'display_count' => 1
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$description = $instance['description'];
		$posts = $instance['posts'];
		$display_count = $instance['display_count'];
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',"kleo_framework"); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:',"kleo_framework"); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo $description; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Posts:',"kleo_framework"); ?></label> 
			<input id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="text" value="<?php echo $posts; ?>" size="3" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('display_count'); ?>" name="<?php echo $this->get_field_name('display_count'); ?>" type="checkbox" value="1" <?php checked( $display_count ); ?>>
			<label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Display like counts',"kleo_framework"); ?></label>
		</p>

		<?php
	}
}