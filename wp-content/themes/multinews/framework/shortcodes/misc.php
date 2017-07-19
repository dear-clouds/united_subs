<?php
//Google Maps  
function mom_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '680',
      "height" => '400',
      "src" => 'https://maps.google.com/?ll=37.0625,-95.677068&spn=48.555061,94.570313&t=m&z=4'
   ), $atts));
   return '<div class="mom_map"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed"></iframe></div>';
}
add_shortcode("google_map", "mom_googleMaps");
//Advanced Google Maps
// Thanks to : http://www.9bitstudios.com/2013/09/create-a-google-maps-shortcode-in-wordpress/
function mom_google_map($atts, $content=null) {
   extract(shortcode_atts(array(
    'height' => '440px',
    'width' => '', //container width, full
    'lat'  => '',
    'long' => '',
    'color' => '',
    'zoom' => '13',
    'pan' => 'false',
    'controls' => 'false',
    'marker_icon' => '', //custom marker image
    'marker_title' => '',
    'marker_animation' => 'DROP',// DROP, BOUNCE
    'marker_info' => '' // temporary stopped
    
    ), $atts));
    ob_start();
    $rndn = rand(1, 1000);
    $map_id = 'mom_google_map_'.$rndn;
    if ($color != '') {
   $sat = -30;
    } else {
   $sat = 0;
    }

    $marker_animation = strtoupper($marker_animation);
    wp_enqueue_script('googlemaps');
?>
<div id="<?php echo $map_id; ?>" class="mom_google_map google-maps <?php echo $width; ?>" style="height: <?php echo $height; ?>px;" data-lat="<?php echo $lat; ?>" data-long="<?php echo $long; ?>" data-color="<?php echo $color; ?>" data-zoom="<?php echo $zoom; ?>" data-pan="<?php echo $pan; ?>" data-controls="<?php echo $controls; ?>" data-marker_icon="<?php echo $marker_icon; ?>" data-marker_title="<?php echo $marker_title; ?>" data-marker_animation="<?php echo $marker_animation; ?>" data-sat="<?php echo $sat; ?>" data-marker_info="<?php echo $marker_info; ?>"></div>
<?php
   $output = ob_get_contents();
   ob_end_clean();
   return $output;
}
add_shortcode('g_map', 'mom_google_map');

//Gap
function mom_gap($atts, $content = null) {
   extract(shortcode_atts(array(
      "height" => 40,
   ), $atts));
   return '<div class="clear" style="height:'.$height.'px;"></div>';
}
add_shortcode("gap", "mom_gap");
//contact Wrap
function mom_contact_wrap($atts, $content = null) {
   extract(shortcode_atts(array(
      "style" => '',
   ), $atts));
   return '<div class="mom_contac_wrap contact_form_style'.$style.'">'.do_shortcode($content).'</div>';
}
add_shortcode("contact_wrap", "mom_contact_wrap");
//Animation
function mom_animation($atts, $content = null) {
   extract(shortcode_atts(array(
      "animation" => '',
      "duration" => '',
      "delay" => '',
      "iteration" => '',
   ), $atts));
   if (!empty($duration)) {
      $duration = '-webkit-animation-duration: '.$duration.'s;-moz-animation-duration: '.$duration.'s;-o-animation-duration: '.$duration.'s;animation-duration: '.$duration.'s;';
   }
   if (!empty($delay)) {
      $delay = '-webkit-animation-delay: '.$delay.'s;-moz-animation-delay: '.$delay.'s;-o-animation-delay: '.$delay.'s;animation-delay: '.$delay.'s;';
   }
   $iteration_count = '';
   if (!empty($iteration)) {
      if ($iteration == -1 ) {$iteration = 'infinite';}
      $iteration_count = '-webkit-animation-iteration-count: '.$iteration.';-moz-animation-iteration-count: '.$iteration.';-o-animation-iteration-count: '.$iteration.';animation-iteration-count: '.$iteration.';';
   }

   return '<div class="animator animated" style="'.$duration.$delay.$iteration_count.'" data-animate="'.$animation.'">'.do_shortcode($content).'</div>';
}
add_shortcode("animate", "mom_animation");

function mom_visibility_shortcode($atts, $content = null) {
   extract(shortcode_atts(array(
      "visible_on" => '', // desktop, devices (tablets/mobile), tablets, mobiles
   ), $atts));
   $visible_on = 'mom_visibility_'.$visible_on;
   return '<div class="'.$visible_on.'">'.do_shortcode($content).'</div>';

}
add_shortcode("visibility", "mom_visibility_shortcode");
//pop-up shortcode
function mom_popup_shortcode($atts, $content = null) {
   extract(shortcode_atts(array(
      "popup_delay" => '0',
      "popup_timeout" => '',
      "popup_width" => '500',
      "popup_height" => '300',
      "animationclass" => 'afadein',
      "background_color" => '#fff',
      "background_image" => '',
      "padding" => '15',
      "font_color" => '',
      "close_button" => 'true',
      "close_inside" => 'true',
      "close_bg_click" => 'true',
   ), $atts));

   ob_start();
   //$visible_on = 'mom_visibility_'.$visible_on;
   if($popup_width != '') {
      $popup_width = 'width:'.$popup_width.'px;';
   } else { $popup_width = ''; }

   if($popup_height != '') {
      $popup_height = 'height:'.$popup_height.'px;';
   } else { $popup_height = ''; }

   if($background_color != '') {
      $background_color = 'background-color:'.$background_color.';';
   } else { $background_color = ''; }
   
   if($background_image != '') {
      $background_image = 'background-image: url('.$background_image.');background-position:center;background-size: cover;';
   } else { $background_image = ''; }

   if($padding != '') {
      $padding = 'padding:'.$padding.'px;';
   } else { $padding = ''; }

   if($font_color != '') {
      $font_color = 'color:'.$font_color.';';
   } else { $font_color = ''; }
   ?>
   <div id="mom_popup" class="mom_popup mfp-hide" style="<?php echo $background_image; ?><?php echo $background_color; ?><?php echo $popup_width; ?><?php echo $popup_height; ?><?php echo $padding; ?><?php echo $font_color; ?>"><?php echo do_shortcode($content); ?></div>
    <script>
    jQuery(document).ready(function($) {
          setTimeout(function() {
              $.magnificPopup.open({ 
                mainClass: '<?php echo $animationclass; ?>',
                removalDelay: 300, 
                items: {
                  src:'#mom_popup',
                },
                type:"inline",
                closeBtnInside: <?php echo $close_inside; ?>,
                closeOnContentClick: false,
                closeOnBgClick: <?php echo $close_bg_click; ?>,
                showCloseBtn: <?php echo $close_button; ?>,
              });
          }, <?php echo $popup_delay; ?>);
      <?php if($popup_timeout != '' ){ ?>
          setTimeout(function() {
              $.magnificPopup.close();
          }, <?php echo $popup_delay+$popup_timeout; ?>);
      <?php } ?>
    });
    </script>
   <?php
   $output = ob_get_contents();
   ob_end_clean();
   return $output;
}
add_shortcode("pop-up", "mom_popup_shortcode");
//table
function mom_table($atts, $content = null) {
   extract(shortcode_atts(array(
      "class" => '',
   ), $atts));
   return '<div class="mom_table '.$class.'">'.do_shortcode($content).'</div>';
}
add_shortcode("table", "mom_table");
//private content
function mom_private( $atts = null, $content = null ) {
     extract(shortcode_atts( array( 
      'class' => '' 
      ), $atts, 'private' ));
    return ( current_user_can( 'publish_posts' ) ) ? '<div class="mom-private' . $class . '"><div class="mom-private-shell">' . do_shortcode( $content ) . '</div></div>' : '';
  }
add_shortcode("private", "mom_private");
//document shortcode
function mom_document( $atts = null, $content = null ) {
  $atts = shortcode_atts( array(
      'url'        => '',
      'file'       => null, // 3.x
      'width'      => 600,
      'height'     => 400,
      'responsive' => 'yes',
      'class'      => ''
    ), $atts, 'document' );
  if ( $atts['file'] !== null ) $atts['url'] = $atts['file'];
  return '<div class="mom-document ' . $atts['class'] . '"><iframe src="http://docs.google.com/viewer?embedded=true&url=' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '"></iframe></div>';
 }
 add_shortcode("document", "mom_document");
 //private content for members
function mom_members( $atts = null, $content = null ) {
  $atts = shortcode_atts( array(
      'message'    => __( 'This content is for registered users only. Please %login%.', 'framework' ),
      'color'      => '#ffcc00',
      'style'      => null, // 3.x
      'login_text' => __( 'login', 'theme' ),
      'login_url'  => wp_login_url(),
      'login'      => null, // 3.x
      'class'      => ''
    ), $atts, 'members' );
  if ( $atts['style'] !== null ) $atts['color'] = str_replace( array( '0', '1', '2' ), array( '#fff', '#FFFF29', '#1F9AFF' ), $atts['style'] );
  // Check feed
  if ( is_feed() ) return;
  // Check authorization
  if ( !is_user_logged_in() ) {
    if ( $atts['login'] !== null && $atts['login'] == '0' ) return; // 3.x
    // Prepare login link
    $login = '<a href="' . esc_attr( $atts['login_url'] ) . '">' . $atts['login_text'] . '</a>';
    mom_su_query_asset( 'css', 'mom-su-other-shortcodes' );
    return '<div class="mom-members" style="background-color:' . mom_su_hex_shift( $atts['color'], 'lighter', 50 ) . ';border-color:' .mom_su_hex_shift( $atts['color'], 'darker', 20 ) . ';color:' .mom_su_hex_shift( $atts['color'], 'darker', 60 ) . '">' . str_replace( '%login%', $login, mom_su_scattr( $atts['message'] ) ) . '</div>';
  }
  // Return original content
  else return do_shortcode( $content );
 }
 add_shortcode("members", "mom_members");
 //feed

if ( !function_exists('base_rss_feed') ) {
  function base_rss_feed($limit = 5, $url = '', $date = '', $descs = '', $cache_time = 1800)
  {
    include_once ABSPATH . WPINC . '/feed.php';
    add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', "return $cache_time;" ) );
    $rss = fetch_feed($url);
     if ( !is_wp_error( $rss ) ) {
       $maxitems = $rss->get_item_quantity($limit);
      $rss_items = $rss->get_items(0, $maxitems);
       $i = 0;
      $total_entries = count($rss_items);
       $html = "";
      foreach ($rss_items as $item) {
          $i++;
          if( $total_entries == $i ) {
          $last = " last";
          } else {
            $last = "";
          }
          $title = $item->get_title();
          $link = $item->get_permalink();
          $desc = $item->get_description();
          $date_posted = $item->get_date('F j, Y');
          $html .= "<div class='mom-feed-item $last'>";
          $html .= "<h3><a href='$link'>$title</a></h3>";
          if($date != 'no') {
          $html .= "<div class='entry-meta'><i class='momizat-icon-calendar'></i>$date_posted</div>";
          }
          if($descs != 'no') {
          $html .= "$desc";
          }
          $html .= "</div>";
      }
      $html .= "";
    } else {
     $html = "An error occurred while parsing your RSS feed. Check that it's a valid XML file.";
    }
  return $html;
  }
}
/** Define [rss] shortcode */
if( function_exists('base_rss_feed') && !function_exists('base_rss_shortcode') ) {
  function base_rss_shortcode($atts) {
    extract(shortcode_atts(array(
      'limit' => '10',
      'url' => 'http://wordpress.org/news/feed/',
      'date' => '',
      'descs' => ''
    ), $atts));
    
    $content = base_rss_feed($limit, $url, $date, $descs);
    return $content;
  }
  add_shortcode("feed", "base_rss_shortcode");
}

//Google Adsenes 
function mom_google_adsense($atts, $content = null) {  
   extract(shortcode_atts(array(
      "client_id" => 'ca-pub-0124769903883498',
      "slot_id" => '1270879422',
      "width" => '728',
      "height" => '90',
   ), $atts));
    ob_start();
?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:<?php echo $width ?>px;height:<?php echo $height ?>px"
     data-ad-client="<?php echo $client_id ?>"
     data-ad-slot="<?php echo $slot_id ?>"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;

}  

add_shortcode('mom_adsense', 'mom_google_adsense');