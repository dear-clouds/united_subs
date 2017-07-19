<?php
        $lang = '';
        if(defined('ICL_LANGUAGE_CODE')) {
            $lang = ICL_LANGUAGE_CODE;
        }
        if (function_exists('qtrans_getLanguage')) {
            $lang = qtrans_getLanguage();
        }

            if ( is_user_logged_in() ) {
                $user = 'u';
            } else {
                $user = 'v';
            }
?>
<div class="top-bar"><!--topbar-->
    <div class="inner"><!--inner-->
<?php
if(mom_option('today_date')) {
$date_format = mom_option('today_date_format');
?>
<div class="today_date">
<p><?php  echo date_i18n( $date_format , strtotime("11/15-1976") ); ?></p>
</div>
<?php } ?>

            <?php if(mom_option('tb_left_content') == 'custom') {
    echo do_shortcode(mom_option('tb_custom_text'));
} elseif (mom_option('tb_left_content') == 'social') { ?>
    <ul class="top-social-icon left">
	<?php get_template_part( 'framework/includes/social' ); ?>
    </ul>
<?php } else { ?>
    <?php if ( has_nav_menu( 'topnav' ) ) {
      $top_menu_query = get_transient( 'top_menu_query'.get_queried_object_id().$lang.$user );
if( $top_menu_query === false ) {
$top_menu_query = wp_nav_menu( array( 'container' => 'ul' , 'menu_class' => 'top-menu', 'theme_location' => 'topnav', 'walker' => new mom_custom_Walker(), 'echo' => 0));

set_transient( 'top_menu_query'.get_queried_object_id().$lang.$user, $top_menu_query, 60*60*24 );
}
echo $top_menu_query;
	?>
    <div class="mom_visibility_device device-top-menu-wrap mobile-menu">
      <div class="top-menu-holder"><i class="fa-icon-align-justify mh-icon"></i></div>
     </div>

    <?php } else { ?> <i class="menu-message"><?php _e('Select your Top Menu from wp menus', 'framework'); ?></i> <?php } ?>
<?php } ?>

<div class="top-bar-right">
<?php if(mom_option('tb_right_content') == 'custom') {
    echo do_shortcode(mom_option('tb_right_custom_text'));
} elseif (mom_option('tb_right_content') == 'menu') { ?>
    <?php if ( has_nav_menu( 'topnav' ) ) {
      $top_menu_query_right = get_transient( 'top_menu_query_right'.get_queried_object_id().$lang.$user );
if( $top_menu_query_right === false ) {
$top_menu_query_right = wp_nav_menu( array( 'container' => 'ul' , 'menu_class' => 'top-menu', 'theme_location' => 'topnav', 'walker' => new mom_custom_Walker(), 'echo' => 0));

set_transient( 'top_menu_query_right'.get_queried_object_id().$lang.$user, $top_menu_query_right, 60*60*24 );
}
echo $top_menu_query_right;

      ?>
    <div class="mom_visibility_device device-top-menu-wrap mobile-menu">
      <div class="top-menu-holder"><i class="fa-icon-align-justify mh-icon"></i></div>
     </div>

    <?php } else { ?> <i class="menu-message"><?php _e('Select your Top Menu from wp menus', 'framework'); ?></i> <?php } ?>
<?php } else { ?>
    <ul class="top-social-icon">
	  <?php get_template_part( 'framework/includes/social' );
  	if(mom_option('tb_search_disable')) { ?>
    	<li class="top-search"><a href="#"></a>
        <div class="search-dropdown">
          <form class="mom-search-form" method="get" action="<?php echo home_url(); ?>/">
              <input type="text" id="tb-search" class="sf" name="s" placeholder="<?php _e('Enter keywords and press enter', 'framework') ?>" required="" autocomplete="off">
            <?php if(mom_option('ajax_search_disable')) { ?><span class="sf-loading"><img src="<?php echo MOM_IMG; ?>/ajax-search-nav.png" alt="search" width="16" height="16"></span><?php } ?>
            <?php if(defined('ICL_LANGUAGE_CODE')) { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/><?php } ?>
          </form>
          <?php if(mom_option('ajax_search_disable')) { ?>
          <div class="ajax-search-results"></div>
          <?php } ?>
        </div>
      </li>
  	<?php } ?>
    <?php if (function_exists('mom_bn_cart_button') && mom_option('topbar_cart') == true) { echo mom_bn_cart_button(); }; ?>
    </ul>
<?php } ?>
</div>

        </div><!--inner-->
    </div><!--topbar-->
