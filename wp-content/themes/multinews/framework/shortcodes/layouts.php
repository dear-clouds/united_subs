<?php
//Layout 
function mom_layout_row($atts, $content) {
   extract(shortcode_atts(array(
   ), $atts));
   return '<div class="mom_row">'.do_shortcode($content).'</div>';
}
add_shortcode("row", "mom_layout_row");

function mom_layout_content($atts, $content) {
   extract(shortcode_atts(array(
   ), $atts));
   return '<div class="main-left"><div class="main-content"  role="main">'.do_shortcode($content).'</div>';
}
add_shortcode("content", "mom_layout_content");

function mom_layout_layout($atts, $content) {
   extract(shortcode_atts(array(
   ), $atts));
   return '<div class="main-left"><div class="main-content"  role="main">'.do_shortcode($content).'</div>';
}
add_shortcode("layout", "mom_layout_layout");

function mom_layout_s_sidebar($atts, $content = null) {
   extract(shortcode_atts(array(
    'sidebar' => ''
   ), $atts));
          $swstyle = mom_option('swstyle');
          if( $swstyle == 'style2' ){
            $swclass = ' sws2';
          } else {
            $swclass = '';
          }
           $output =  '<aside class="secondary-sidebar'.$swclass.'" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
        ob_start();
        if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $sidebar ) ) {}
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= "</aside>";
        return $output;
}
add_shortcode("secondary_sidebar", "mom_layout_s_sidebar");

function mom_layout_sidebar($atts, $content = null) {
   extract(shortcode_atts(array(
    'sidebar' => ''
   ), $atts));
          $swstyle = mom_option('swstyle');
          if( $swstyle == 'style2' ){
            $swclass = ' sws2';
          } else {
            $swclass = '';
          }
           $output =  '</div><aside class="sidebar'.$swclass.'" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
        ob_start();
        if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $sidebar ) ) {}
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= "</aside>";
        return $output;
   }
add_shortcode("main_sidebar", "mom_layout_sidebar");