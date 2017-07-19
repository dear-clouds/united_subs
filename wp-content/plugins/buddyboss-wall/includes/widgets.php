<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class BuddyBoss_Most_Liked_Activity_Widget extends WP_Widget
{
	/**
	 * @var int how many words of activity to display
	 */
	protected $word_count = 10;

	public function __construct()
	{
		parent::__construct( 'BuddyBoss_Most_Liked_Activity_Widget', __( '(BuddyBoss Wall) Most Liked Activity', 'buddyboss-wall' ), array(
			'classname'   => 'widget_most_liked_activities buddypress',
			'description' => __( 'Display a list of most liked activities site-wide.', 'buddyboss-wall' ),
		) );
	}

  function form( $instance )
  {
  	$instance = wp_parse_args( (array) $instance, array( 'title' => 'Most Liked Activity', 'count' => 5, 'wordcount' => 10 ) );
    $title		= $instance['title'];
		$count		= $instance['count'];
		$wordcount	= $instance['wordcount'];
    ?>
    <p>
    	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','buddyboss-wall');?>:
    		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
    		name="<?php echo $this->get_field_name('title'); ?>" type="text"
    		value="<?php echo esc_attr($title); ?>" />
    	</label>
    </p>
    <p>
    	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Max activity posts to show','buddyboss-wall');?>:
    		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>"
    		name="<?php echo $this->get_field_name('count'); ?>" type="number"
    		value="<?php echo esc_attr($count); ?>" style="width: 30%" />
    	</label>
    </p>
    <p>
    	<label for="<?php echo $this->get_field_id('wordcount'); ?>"><?php _e('Max words per activity post','buddyboss-wall');?>:
    		<input class="widefat" id="<?php echo $this->get_field_id('wordcount'); ?>"
    		name="<?php echo $this->get_field_name('wordcount'); ?>" type="number"
    		value="<?php echo esc_attr($wordcount); ?>" style="width: 30%" />
    	</label>
    </p>
    <?php
  }

	function update( $new_instance, $old_instance )
	{
    $instance = $old_instance;
    $instance['title']		 = $new_instance['title'];
		$instance['count']		 = $new_instance['count'];
		$instance['wordcount'] = $new_instance['wordcount'];
    
    return $instance;
  }

	function widget_activity_filter( $activity_content, $activity )
	{
		$activity_content = trim( $activity_content );
		
		if ( empty( $activity_content ) )
		{
			$activity_content = bp_get_activity_action();
		}

		return $activity_content;
	}

	function widget( $args, $instance )
	{
		extract($args, EXTR_SKIP);

		echo $before_widget;

		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (!empty($title)){
			echo $before_title . $title . $after_title;
		}

		add_filter( 'bp_activity_paged_activities_sql', array( $this, 'activity_orderby_query' ), 11 );
		add_filter( 'bp_activity_get_user_join_filter', array( $this, 'activity_orderby_query' ), 11 );
		add_filter( 'bp_get_activity_content_body',     array( $this, 'widget_activity_filter' ), 11, 2 );
		add_filter( 'bp_get_activity_content_body',		  array( $this, 'trim_activity_content' ),  11, 2 );

		$this->word_count = $instance['wordcount'];

		$params = array(
			'user_id' 			=> false,
			'scope'				=> false,
			'per_page'			=> $instance['count'],
			'display_comments' 	=> false,
			'meta_query'		=> array(
				array(
					'key'		=> 'favorite_count'
				)
			),
		);

		if ( bp_has_activities( $params ) ) :?>
			<ul id="most-liked-activities" class="item-list">
			<?php while ( bp_activities() ) : bp_the_activity();?>

				<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">

					<div class="item-avatar">
						<a href="<?php bp_activity_user_link(); ?>">
							<?php bp_activity_avatar(); ?>
						</a>
					</div>

					<div class="item">

						<div class="item-title fn">
							<a href="<?php bp_activity_thread_permalink(); ?>"><?php bp_activity_content_body(); ?></a>
						</div>

						<div class="item-meta">
							<span class="activity">
								<?php printf( __( '%d Likes', 'buddyboss-wall' ), (int)bp_activity_get_meta( bp_get_activity_id(), 'favorite_count', true) ); ?>
							</span>
						</div>

					</div>

				</li>

			<?php endwhile; ?>
			</ul>
		<?php endif;


		remove_filter( 'bp_activity_paged_activities_sql',	array( $this, 'activity_orderby_query' ), 11 );
		remove_filter( 'bp_activity_get_user_join_filter',	array( $this, 'activity_orderby_query' ), 11 );
		remove_filter( 'bp_get_activity_content_body',	  	array( $this, 'trim_activity_content' ),  11, 2 );
		remove_filter( 'bp_get_activity_content_body',      array( $this, 'widget_activity_filter' ), 11, 2 );

		echo $after_widget;
	}

	function activity_orderby_query( $sql )
	{
		/*
		 SELECT DISTINCT a.id  FROM wp_bp_activity a  INNER JOIN wp_bp_activity_meta ON (a.id = wp_bp_activity_meta.activity_id)
		 WHERE a.is_spam = 0 AND a.hide_sitewide = 0 AND
		 (wp_bp_activity_meta.meta_key = 'favorite_count' ) AND a.type != 'activity_comment' AND a.type != 'last_activity'
		 ORDER BY a.date_recorded DESC LIMIT 0, 5
		 */
		global $wpdb;
        $result_sql = str_replace( 'ORDER BY a.date_recorded', 'ORDER BY CAST('. $wpdb->base_prefix .'bp_activity_meta.meta_value AS SIGNED)', $sql );
        //echo $result_sql; exit;
		return $result_sql;
	}

	function trim_activity_content( $activity_content, $activity )
	{
		$new_c1 = strip_tags($activity_content);

        if( isset( $this->word_count ) && !empty( $this->word_count ) ){
            $content = explode(" ", $new_c1, $this->word_count);
            if (count($content)>=$this->word_count) {
                array_pop($content);

                $more_content = "...";
                $content[] = $more_content;
            }
            $activity_content = implode(" ",$content);
        }

		return $activity_content;
	}
}
