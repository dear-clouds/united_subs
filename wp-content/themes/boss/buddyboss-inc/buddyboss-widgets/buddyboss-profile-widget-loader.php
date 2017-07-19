<?php
/**
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

/**
 * Sets up a BuddyPress profile login widget to add to your sidebars.
 * BuddyPress must be activated for the widget to appear.
 */

class BuddyBossLoginWidget extends WP_Widget
{
  function __construct()
  {
      $widget_ops = array('classname' => 'buddyboss-login-widget', 'description' => 'Displays BuddyPress login and profile info.' );
      parent::__construct('BuddyBossLoginWidget', __( '(BuddyBoss) Profile Login Widget', 'boss' ), $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
 
        // set widget title when logged out

        if ( !is_user_logged_in() ) :
          $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

          if (!empty($title))
            echo $before_title . $title . $after_title;
        endif;
 
        // start widget display code
        
          if ( function_exists('bp_is_active') ) :
            // check is user is logged in
            if ( is_user_logged_in() ) :
              
              echo "<div id='sidebarme'>";
                  echo "<a href='".bp_loggedin_user_domain()."'>";
                  echo bp_loggedin_user_avatar( 'type=thumb' );
                  echo "</a>";
                  echo "<ul class='sidebarme-quicklinks'>";
                    echo "<li class='sidebarme-username'>".bp_core_get_userlink( bp_loggedin_user_id() )."</li>";
                    echo "<li class='sidebarme-profile'>";
                      echo "<a href='".bp_loggedin_user_domain()."profile/edit'>".__( 'Edit Profile' , 'boss' )."</a>";
                      echo " &middot; ";
                      echo wp_loginout();
                    echo "</li>";
                  echo "</ul>";
              echo "</div>";
           
            // check if user is logged out
            else :
              
              echo "<form name='login-form' id='sidebar-login-form' class='standard-form' action='".site_url( 'wp-login.php', 'login_post' )."' method='post'>";
                echo "<label>".__( 'Username', 'boss' )."</label>";
                $return = isset($_POST['value']) ? $_POST['value'] : '';
                $return .= "<input type='text' name='log' id='sidebar-user-login' class='input' value='";
                if ( isset( $user_login) ) {
                  $return .= esc_attr(stripslashes($user_login));
                }
                $return .="' tabindex='97' />";
                echo $return;

                echo "<label>".__( 'Password', 'boss' )."</label>";
                echo "<input type='password' name='pwd' id='sidebar-user-pass' class='input' value='' tabindex='98' />";

                echo "<p class='forgetmenot'><input name='rememberme' type='checkbox' id='sidebar-rememberme' value='forever' tabindex='99' /> ".__( 'Remember Me', 'boss' )."</p>";

                echo do_action( 'bp_sidebar_login_form' );
                echo do_action( 'login_form' );
                echo "<input type='submit' name='wp-submit' id='sidebar-wp-submit' value='".__( 'Log In', 'boss' )."' tabindex='100' />";

                if ( bp_get_signup_allowed() ) {
                  echo " <a class='sidebar-wp-register' href='".bp_get_signup_page()."'>".__( 'Register', 'boss' )."</a>";
                }

              echo "</form>";

            endif;
          endif;
     
        // end widget display code

    echo $after_widget; 
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("BuddyBossLoginWidget");') );


/**
 * BuddyBoss Recent_Posts widget class
 *
 * @since Boss 1.0.0
 */
class BuddyBossRecentPosts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_buddyboss_recent_post', 'description' => __( "Your site&#8217;s most recent Posts.", 'boss') );
		parent::__construct('recent-posts', __( '(BuddyBoss) Recent Posts', 'boss' ), $widget_ops);
		$this->alt_option_name = 'widget_buddyboss_recent_post';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_buddyboss_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'boss' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
                <div class="table">
                    <?php if ( has_post_thumbnail() ) { ?>
                    <a href="<?php the_permalink(); ?>" class="table-cell image-wrap">
                    <?php
                        the_post_thumbnail('thumbnail');
                    ?>
                    </a>
                    <?php } ?>
                    <div class="content table-cell">
                        <h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                        <?php 
                            $content = strip_tags(get_the_content());
                            $content = wp_trim_words($content, 10, $more = null);
                            echo $content;
                        ?>
                        
                        <?php
                        $post_categories = wp_get_post_categories( get_the_ID() );
        
                        $c = $post_categories[0];
                        $cat = get_category( $c );
                        $category_link = get_category_link( $cat->term_id );
                        echo '<a href="'.esc_url( $category_link ).'" class="category-link">'.$cat->name.'</a>';
                        ?>
                        
                        <?php if ( $show_date ) : ?>
                        <span class="post-time">
                        <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_buddyboss_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_buddyboss_recent_post']) )
			delete_option('widget_buddyboss_recent_post');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_buddyboss_recent_posts', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'boss' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'boss' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'boss' ); ?></label></p>
<?php
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("BuddyBossRecentPosts");') );

