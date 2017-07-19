<?php 

add_action('widgets_init','mom_widget_twitter');

function mom_widget_twitter() {
	register_widget('mom_widget_twitter');
	
	}

class mom_widget_twitter extends WP_Widget {
	function mom_widget_twitter() {
			
		$widget_ops = array('classname' => 'momizat-twitter','description' => __('Widget display Latest tweets','framework'));
		parent::__construct('momizatTwitter',__('Momizat - Twitter','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$style = $instance['style'];
		$username = $instance['username'];
		$count = $instance['count'];
		
		$tcount = $count;
		if ($tcount < 7) {
			$tcount = 7;
		}
		
$output = get_transient($this->id);
if ($output == false) { 
    ob_start();
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
//delete_transient('mom_twitter_widget_'.$username);
$tweets = get_transient('mom_twitter_widget_'.$username);
if ($tweets == false) { 
if ( mom_option('twitter_ck') != '' && mom_option('twitter_cs') != '' && mom_option('twitter_at') != '' && mom_option('twitter_ats') != '') {
	
// twitter API
require_once(MOM_FW . '/inc/twitterAPI/TwitterAPIExchange.php');

$settings = array(
    'consumer_key' => mom_option('twitter_ck'),
    'consumer_secret' => mom_option('twitter_cs'),
    'oauth_access_token' =>  mom_option('twitter_at'),
    'oauth_access_token_secret' =>  mom_option('twitter_ats'),
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = "?screen_name=$username&count=$tcount";
$twitter = new TwitterAPIExchange($settings);
$tweets = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(),true);
if ($tweets == '') {
    $tweets = array();
}
set_transient('mom_twitter_widget_'.$username, $tweets, 10800);
} // if the keys in there
} // no tweets transient
?>
	<?php if ($style == 'minimum') { ?>
		<div class="twitter-widget">
			        <ul class="tweet_list">
				<?php
				if (isset($tweets) && is_array($tweets)) {
				$i = 0;
				foreach($tweets as $tweet) {
					$txt = $this->mom_tweets_hyperlinks($tweet['text']);
					$txt = $this->mom_tweets_twitter_users($txt);
					$txt = $this->mom_tweets_encode_tweet($txt);

				?>
					<li><div><?php echo $txt; ?></div></li>
				<?php 
				if (++$i == $count) break;
				} } ?>
                                </ul>
		</div>
	<?php } else { ?>
			<ul class="twiter-list">
				<?php
				if (isset($tweets) && is_array($tweets)) {
				$i = 0;
				foreach($tweets as $tweet) {
					$screen_name = $tweet['user']['screen_name'];
					$avatar = $tweet['user']['profile_image_url'];
					$tweet_id = $tweet['id'];
					$txt = $this->mom_tweets_hyperlinks($tweet['text']);
					$txt = $this->mom_tweets_twitter_users($txt);
					$txt = $this->mom_tweets_encode_tweet($txt);

				?>
                                <li class="twiter-list-item">
					<div class="tl-head">
                                   <a target="_blank" href="https://twitter.com/<?php echo $tweet['user']['screen_name']; ?>"><img src="<?php echo $tweet['user']['profile_image_url']; ?>" alt="twitter" width="48" height="48"></a>
                                    <span class="twitter-user"><a target="_blank" href="https://twitter.com/<?php echo $tweet['user']['screen_name']; ?>">@<?php echo $tweet['user']['screen_name']; ?></a>
                                   <?php if( is_rtl() ) { ?>
                                   <time><?php _e(' ago', 'framework'); _e(' ','framework'); echo human_time_diff( strtotime($tweet['created_at']), current_time('timestamp') ); ?></time>
                                   <?php } else { ?>
                                   <time><?php echo human_time_diff( strtotime($tweet['created_at']), current_time('timestamp') );  _e(' ago', 'framework'); ?></time>
                                   <?php } ?>
								  </span>
                                   <a class="twiter-follow" href="https://twitter.com/intent/follow?screen_name=<?php echo $tweet['user']['screen_name']; ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600');return false"><?php _e('Follow', 'framework'); ?></a>
					</div> <!--head-->
                                   <div class="twiter-tweet">
					<?php echo $txt; ?>
				   </div>
                                   <ul class="twiter-buttons">
                                        <li class="replay"><a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?in_reply_to=' . $tweet_id ); ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600');return false"><?php _e('Reply', 'framework'); ?></a></li>
                                        <li class="retweet"><a href="<?php echo esc_url( 'https://twitter.com/intent/retweet?tweet_id=' . $tweet_id ); ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600');return false"><?php _e('Retweet', 'framework'); ?></a></li>
                                        <li class="favorite"><a href="<?php echo esc_url( 'https://twitter.com/intent/favorite?tweet_id=' . $tweet_id ); ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600');return false"><?php _e('Favorite', 'framework'); ?></a></li>
                                   </ul>
                                </li>
				<?php 
				if (++$i == $count) break;
				}
				}
				?>

                            </ul>
	<?php } ?>
<?php

		/* After widget (defined by themes). */
		echo $after_widget;

	$output = ob_get_contents();
    ob_end_clean();
    set_transient($this->id, $output, 60*60*24);
}

    echo $output;  


	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['style'] = $new_instance['style'];
		$instance['username'] = $new_instance['username'];	
		delete_transient('mom_twitter_widget_'.$instance['username']);
			$this->invalidate_widget_cache();

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Twitter','framework'),
			'style' => '',
			'username' => 'momizat',
			'count' => 5
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat">
		<option value="" <?php selected($instance['style'], ''); ?>><?php _e('Default', 'framework'); ?></option>
		<option value="minimum" <?php selected($instance['style'], 'minimum'); ?>><?php _e('Minimum', 'framework'); ?></option>
		</select>
		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Name:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of tweets:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>

   <?php 
}


	/**
	 * Find links and create the hyperlinks
	 */
	private function mom_tweets_hyperlinks($text) {
	    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a target='_blank' href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a target='_blank' href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);

	    // match name@address
	    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a target='_blank' href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace('/([\.|\,|\:|\Á|\À|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a target='_blank' href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	    return $text;
	}

	/**
	 * Find twitter usernames and link to them
	 */
	private function mom_tweets_twitter_users($text) {
	       $text = preg_replace('/([\.|\,|\:|\Á|\À|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a target='_blank' href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	       return $text;
	}

        /**
         * Encode single quotes in your tweets
         */
        private function mom_tweets_encode_tweet($text) {
                $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
                return $text;
        }

	public function invalidate_widget_cache()
	{
		delete_transient( $this->id );
	} 

} //end class