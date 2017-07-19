<?php

class mom_su_Vote {

	function __construct() {
		add_action( 'load-plugins.php', array( __CLASS__, 'init' ) );
		add_action( 'wp_ajax_mom_su_vote',  array( __CLASS__, 'vote' ) );
	}

	public static function init() {
		mom_shortcodes_ultimate::timestamp();
		$vote = get_option( 'mom_su_vote' );
		$timeout = time() > ( get_option( 'mom_su_installed' ) + 60*60*24*3 );
		if ( in_array( $vote, array( 'yes', 'no', 'tweet' ) ) || !$timeout ) return;
		add_action( 'in_admin_footer', array( __CLASS__, 'message' ) );
		add_action( 'admin_head',      array( __CLASS__, 'register' ) );
		add_action( 'admin_footer',    array( __CLASS__, 'enqueue' ) );
	}

	public static function register() {
		wp_register_style( 'mom-su-vote', plugins_url( 'assets/css/vote.css', mom_su_PLUGIN_FILE ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_script( 'mom-su-vote', plugins_url( 'assets/js/vote.js', mom_su_PLUGIN_FILE ), array( 'jquery' ), mom_su_PLUGIN_VERSION, true );
	}

	public static function enqueue() {
		wp_enqueue_style( 'mom-su-vote' );
		wp_enqueue_script( 'mom-su-vote' );
	}

	public static function vote() {
		$vote = sanitize_key( $_GET['vote'] );
		if ( !is_user_logged_in() || !in_array( $vote, array( 'yes', 'no', 'later', 'tweet' ) ) ) die( 'error' );
		update_option( 'mom_su_vote', $vote );
		if ( $vote === 'later' ) update_option( 'mom_su_installed', time() );
		die( 'OK: ' . $vote );
	}

	public static function message() {
?>
		<div class="mom-su-vote" style="display:none">
			<div class="mom-su-vote-wrap">
				<div class="mom-su-vote-gravatar"><a href="http://profiles.wordpress.org/gn_themes" target="_blank"><img src="http://www.gravatar.com/avatar/54fda46c150e45d18d105b9185017aea.png" alt="<?php _e( 'Vladimir Anokhin', 'theme' ); ?>" width="50" height="50"></a></div>
				<div class="mom-su-vote-message">
					<p><?php _e( 'Hello, my name is Vladimir Anokhin, and I am developer of plugin <b>Shortcodes Ultimate</b>.<br>If you like this plugin, please write a few words about it at the wordpress.org or twitter. It will help other people find this useful plugin more quickly.<br><b>Thank you!</b>', 'theme' ); ?></p>
					<p>
						<a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=mom_su_vote&amp;vote=yes" class="mom-su-vote-action button button-small button-primary" data-action="http://wordpress.org/support/view/plugin-reviews/mom-shortcodes-ultimate?rate=5#postform"><?php _e( 'Rate plugin', 'theme' ); ?></a>
						<a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=mom_su_vote&amp;vote=tweet" class="mom-su-vote-action button button-small" data-action="http://twitter.com/share?url=http://bit.ly/1blZb7u&amp;text=<?php echo urlencode( __( 'Shortcodes Ultimate - must have WordPress plugin #shortcodesultimate', 'theme' ) ); ?>"><?php _e( 'Tweet', 'theme' ); ?></a>
						<a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=mom_su_vote&amp;vote=no" class="mom-su-vote-action button button-small"><?php _e( 'No, thanks', 'theme' ); ?></a>
						<span><?php _e( 'or', 'theme' ); ?></span>
						<a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=mom_su_vote&amp;vote=later" class="mom-su-vote-action button button-small"><?php _e( 'Remind me later', 'theme' ); ?></a>
					</p>
				</div>
				<div class="mom-su-vote-clear"></div>
			</div>
		</div>
		<?php
	}
}

new mom_su_Vote;
