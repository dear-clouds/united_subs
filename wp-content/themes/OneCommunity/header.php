<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="shortcut icon" href="<?php echo of_get_option('favicon_path', 'http://www.demo1.diaboliquedesign.com/4/favicon.gif' ); ?>" />
		<?php do_action( 'bp_head' ) ?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

		<?php
			if ( is_singular() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>

<!--[if IE 9]>
<style type="text/css">
nav ul ul { top:26px; }
</style>
<![endif]-->

<!--[if lt IE 9]>
<style type="text/css">
iframe, .video-container object, .video-container embed { width: auto!important; }
img { width: auto!important; height:auto; }
</style>
<![endif]-->

<script>
  document.createElement('header');
  document.createElement('section');
  document.createElement('article');
  document.createElement('aside');
  document.createElement('nav');
  document.createElement('footer');
</script>


<?php
$url = $_SERVER["REQUEST_URI"];
$isItGroup = strpos($url, 'group-avatar');

if ($isItGroup!==false) { ?>
<script>
		jQuery(window).load( function(){
			jQuery('#avatar-to-crop').Jcrop({
				onChange: showPreview,
				onSelect: showPreview,
				onSelect: updateCoords,
				aspectRatio: 1.48,
				setSelect: [ 0, 0, 139, 94 ]
			});
			updateCoords({x: 0, y: 0, w: 139, h: 94});
		});
</script>
<?php } ?>



<?php echo of_get_option('analytics', ' ' ); ?>

	</head>

	<body <?php body_class() ?> id="bp-default">

	<?php do_action( 'bp_before_header' ) ?>
	<div id="header-very-top">
	<nav>

			<?php
			wp_nav_menu( array(
			 'theme_location' => 'primary-menu',
			 'container' =>false,
			 'menu_class' => 'nav',
			 'echo' => true,
			 'before' => '',
			 'after' => '',
			 'link_before' => '',
			 'link_after' => '',
			 'depth' => 0,)
			);
			 ?>
	</nav>



	<div id="navigation-320">
	<form name="site-menu" action="" method="post">
		<?php
		wp_nav_menu_select(
    		array(
       			'theme_location' => 'select-menu'
    			)
		);
		?>
	</form>
	</div>


	<div id="top-bar-right">
	 	<?php echo do_shortcode('[wpdreams_ajaxsearchpro id=1]'); ?>
        	</div><!--top-bar-right ends-->

	</div><!-- #header-very-top -->

<div class="clear"></div>

<div id="main">

<header>

	<div id="header-left">
		<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php _e('Home', 'OneCommunity'); ?>"><img src="<?php echo of_get_option('logo_path', 'http://www.demo1.diaboliquedesign.com/4/logo.png' ); ?>" alt="<?php _e('Home', 'OneCommunity'); ?>" /></a></div>
	</div><!-- #header-left -->

<div id="header-right">
	<div id="header-right-1">
		<a class="tile tile-forum" href="<?php echo home_url(); ?>/<?php _e('forum', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-forum.png" alt="<?php _e('FORUM', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('FORUM', 'OneCommunity'); ?></span></a>
		<a class="tile tile-groups" href="<?php echo home_url(); ?>/<?php _e('groups', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-groups.png" alt="<?php _e('GROUPS', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('GROUPS', 'OneCommunity'); ?></span></a>
		<a class="tile tile-help" href="<?php echo home_url(); ?>/<?php _e('about-us', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-info.png" alt="<?php _e('ABOUT US', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('ABOUT US', 'OneCommunity'); ?></span></a>
		<a class="tile tile-activities" href="<?php echo home_url(); ?>/<?php _e('activity', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-activities.png" alt="<?php _e('ACTIVITY', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('ACTIVITY', 'OneCommunity'); ?></span></a>
	</div><!-- #header-right-1 -->

<div id="header-right-2">
<div class="tile2">
<?php
if ( function_exists( 'bp_is_active' ) ) {
if ( is_user_logged_in() ) : ?>
			<div id="tile-user">
				<div class="tile-avatar"><a href="<?php echo bp_loggedin_user_domain() ?>"><?php bp_loggedin_user_avatar( 'type=full&width=88&height=88' ) ?></a></div>

				<div class="tile-username"><?php _e('Hello', 'OneCommunity'); ?><br /><a href="<?php echo bp_loggedin_user_domain() ?>"><?php $theusername = bp_core_get_user_displayname( bp_loggedin_user_id() ); $getlength = strlen($theusername); $thelength = 14; echo mb_substr($theusername, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
				<div class="tile-logout"><a href="<?php echo wp_logout_url( bp_get_root_domain() ) ?>"><?php _e( 'Log Out', 'OneCommunity' ) ?></a></div>
				<a class="tile-messages" href="<?php echo bp_loggedin_user_domain() ?>messages"><?php echo messages_get_unread_count(); ?></a>
			</div>

		<?php else : ?>

			<div id="tile-user">
				<div class="tile-avatar"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/avatar.gif" alt="Avatar" width="88" height="88" /></div>
				<div class="tile-username"><?php _e('Hello', 'OneCommunity'); ?><br /><?php _e('Guest', 'OneCommunity'); ?></div>
				<span class="tile-title"><a href="<?php echo home_url(); ?>/<?php _e('login', 'OneCommunity'); ?>"><?php _e( 'Log In', 'OneCommunity' ); ?></a> <?php if ( bp_get_signup_allowed() ) : ?><span class="tile-register"><?php _e('or', 'OneCommunity'); ?>&nbsp;<a href="<?php echo home_url(); ?>/<?php _e('register', 'OneCommunity'); ?>"><?php _e('Sign Up', 'OneCommunity'); ?></a></span><?php endif; ?></span>
			</div>

	<?php endif;
}
?>
</div><!-- .tile2 -->

	<div class="header-right-2-bottom">
		<a class="tile tile-users" href="<?php echo home_url(); ?>/<?php _e('members', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-members.png" alt="<?php _e('MEMBERS', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('MEMBERS', 'OneCommunity'); ?></span></a>
		<a class="tile tile-blog" href="<?php echo home_url(); ?>/<?php _e('blog', 'OneCommunity'); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/tile-blog.png" alt="<?php _e('BLOG', 'OneCommunity'); ?>" /><span class="tile-title"><?php _e('BLOG', 'OneCommunity'); ?></span></a>
	</div><!-- .header-right-2-bottom -->
</div><!-- .header-right-2 -->
</div><!-- #header-right -->

<?php do_action( 'bp_header' ) ?>

</header>

<div id="container">