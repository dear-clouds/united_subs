<?php
/**
 * Live preview page
 */  
ob_start(); 
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
include_once( $path_to_wp . '/wp-load.php' );
if ( !defined( 'WP_USE_THEMES' ) ) {
	define( 'WP_USE_THEMES' , false );
	$id = !empty( $_GET['id'] ) ? (int)$_GET['id'] : NULL;	
} else {
	$id = !empty( $_GET['go_pricing_preview_id'] ) ? (int)$_GET['go_pricing_preview_id'] : NULL;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php 
$instance = GW_GoPricing::instance();
wp_head();
?>
<style>
@import url(//fonts.googleapis.com/css?family=Open+Sans:700,600,400);
@font-face {
    font-family: 'gopricing';
    src:
		url('data:application/font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMg8SDJsAAAC8AAAAYGNtYXAP5eFpAAABHAAAAFRnYXNwAAAAEAAAAXAAAAAIZ2x5ZuObk7AAAAF4AAABBGhlYWQIscuAAAACfAAAADZoaGVhB7kDxgAAArQAAAAkaG10eAoAAAkAAALYAAAAFGxvY2EAKACWAAAC7AAAAAxtYXhwAAkARAAAAvgAAAAgbmFtZZlKCfsAAAMYAAABhnBvc3QAAwAAAAAEoAAAACAAAwMAAZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADwcQPA/8AAQAPAAEAAAAABAAAAAAAAAAAAAAAgAAAAAAADAAAAAwAAABwAAQADAAAAHAADAAEAAAAcAAQAOAAAAAoACAACAAIAAQAg8HH//f//AAAAAAAg8HH//f//AAH/4w+TAAMAAQAAAAAAAAAAAAAAAQAB//8ADwABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAAAQAAAAAAAAAAAAIAADc5AQAAAAADAAkAAAP3A7cAFAApAEEAACU1NCcmKwEiBwYdARQXFjsBMjc2NScTNCcmKwEiBwYVExQXFjsBMjc2NwMBFgcGBwYjISInJicmNwE2NzYzMhcWFwJJBQYHbgcGBQUGB24HBgUBCgUIBn4GCAUJBgYIaggFBQEIAbcUFQoRERP8khMREQoVFAG3ChERFBQREQqlbQgFBgYFCG0IBQYGBQjWAQYHBAYGBAj++wYEAwMEBgIW/NskJBEJCgoJESQkAyURCwoKCxEAAAEAAAABAADRPWN3Xw889QALBAAAAAAA0s5DZgAAAADSzkNmAAAAAAP3A7cAAAAIAAIAAAAAAAAAAQAAA8D/wAAABAAAAAAAA/cAAQAAAAAAAAAAAAAAAAAAAAUEAAAAAAAAAAAAAAACAAAABAAACQAAAAAACgAUAB4AggABAAAABQBCAAMAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEABwAAAAEAAAAAAAIABwBgAAEAAAAAAAMABwA2AAEAAAAAAAQABwB1AAEAAAAAAAUACwAVAAEAAAAAAAYABwBLAAEAAAAAAAoAGgCKAAMAAQQJAAEADgAHAAMAAQQJAAIADgBnAAMAAQQJAAMADgA9AAMAAQQJAAQADgB8AAMAAQQJAAUAFgAgAAMAAQQJAAYADgBSAAMAAQQJAAoANACkaWNvbW9vbgBpAGMAbwBtAG8AbwBuVmVyc2lvbiAxLjAAVgBlAHIAcwBpAG8AbgAgADEALgAwaWNvbW9vbgBpAGMAbwBtAG8AbwBuaWNvbW9vbgBpAGMAbwBtAG8AbwBuUmVndWxhcgBSAGUAZwB1AGwAYQByaWNvbW9vbgBpAGMAbwBtAG8AbwBuRm9udCBnZW5lcmF0ZWQgYnkgSWNvTW9vbi4ARgBvAG4AdAAgAGcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAuAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==') format('truetype'),
		url('data:application/font-woff;charset=utf-8;base64,d09GRgABAAAAAAUMAAsAAAAABMAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABPUy8yAAABCAAAAGAAAABgDxIMm2NtYXAAAAFoAAAAVAAAAFQP5eFpZ2FzcAAAAbwAAAAIAAAACAAAABBnbHlmAAABxAAAAQQAAAEE45uTsGhlYWQAAALIAAAANgAAADYIscuAaGhlYQAAAwAAAAAkAAAAJAe5A8ZobXR4AAADJAAAABQAAAAUCgAACWxvY2EAAAM4AAAADAAAAAwAKACWbWF4cAAAA0QAAAAgAAAAIAAJAERuYW1lAAADZAAAAYYAAAGGmUoJ+3Bvc3QAAATsAAAAIAAAACAAAwAAAAMDAAGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAQAAA8HEDwP/AAEADwABAAAAAAQAAAAAAAAAAAAAAIAAAAAAAAwAAAAMAAAAcAAEAAwAAABwAAwABAAAAHAAEADgAAAAKAAgAAgACAAEAIPBx//3//wAAAAAAIPBx//3//wAB/+MPkwADAAEAAAAAAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAAAwAJAAAD9wO3ABQAKQBBAAAlNTQnJisBIgcGHQEUFxY7ATI3NjUnEzQnJisBIgcGFRMUFxY7ATI3NjcDARYHBgcGIyEiJyYnJjcBNjc2MzIXFhcCSQUGB24HBgUFBgduBwYFAQoFCAZ+BggFCQYGCGoIBQUBCAG3FBUKERET/JITEREKFRQBtwoRERQUEREKpW0IBQYGBQhtCAUGBgUI1gEGBwQGBgQI/vsGBAMDBAYCFvzbJCQRCQoKCREkJAMlEQsKCgsRAAABAAAAAQAA0T1jd18PPPUACwQAAAAAANLOQ2YAAAAA0s5DZgAAAAAD9wO3AAAACAACAAAAAAAAAAEAAAPA/8AAAAQAAAAAAAP3AAEAAAAAAAAAAAAAAAAAAAAFBAAAAAAAAAAAAAAAAgAAAAQAAAkAAAAAAAoAFAAeAIIAAQAAAAUAQgADAAAAAAACAAAAAAAAAAAAAAAAAAAAAAAAAA4ArgABAAAAAAABAAcAAAABAAAAAAACAAcAYAABAAAAAAADAAcANgABAAAAAAAEAAcAdQABAAAAAAAFAAsAFQABAAAAAAAGAAcASwABAAAAAAAKABoAigADAAEECQABAA4ABwADAAEECQACAA4AZwADAAEECQADAA4APQADAAEECQAEAA4AfAADAAEECQAFABYAIAADAAEECQAGAA4AUgADAAEECQAKADQApGljb21vb24AaQBjAG8AbQBvAG8AblZlcnNpb24gMS4wAFYAZQByAHMAaQBvAG4AIAAxAC4AMGljb21vb24AaQBjAG8AbQBvAG8Abmljb21vb24AaQBjAG8AbQBvAG8AblJlZ3VsYXIAUgBlAGcAdQBsAGEAcmljb21vb24AaQBjAG8AbQBvAG8AbkZvbnQgZ2VuZXJhdGVkIGJ5IEljb01vb24uAEYAbwBuAHQAIABnAGUAbgBlAHIAYQB0AGUAZAAgAGIAeQAgAEkAYwBvAE0AbwBvAG4ALgAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=') format('woff');
    font-weight: normal;
    font-style: normal;
}

.icon-exclamation-triangle {
    font-family: 'gopricing' !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.icon-exclamation-triangle:before { content: "\f071"; }

html {
	background:#fff;
	display:table;	
	height:100%;
	width:100%;
}

body { 
	background:transparent !important;
	display:table-cell !important;
	font:14px/20px 'Open Sans', sans-serif;	
	height:auto !important;
	margin:0 !important;	
	overflow-x:hidden !important;
    overflow-y:scroll !important;
	padding:25px 40px 20px !important;
	vertical-align:middle;
}
body:before,
body:after { display:none !important; }

#go-pricing-preview { margin:0 auto; }
#go-pricing-forbidden {
	font-size:14px;
	height:50px;
	line-height:50px;
	text-align:center;	
}
#go-pricing-forbidden .icon-exclamation-triangle {
	color:#fa5541;
	font-size:20px;	
	margin-right:7px;
	position:relative;
	top:3px;	
}
#go-pricing-preview .gw-go { margin-bottom:0 !important; }
</style>
<script>
;(function($, window, undefined){
	'use strict'
	$(window).load(window.parent.initPreview);
})(jQuery, window);
</script>
</head>
<body>
<?php
if ( !is_user_logged_in() || is_null( $id ) || empty( $_GET['nonce'] ) || ( !empty( $_GET['nonce'] ) &&  wp_verify_nonce( $_GET['nonce'], $instance['plugin_base'] . '-preview' ) === false ) ) :
	?>
	<div id="go-pricing-forbidden"><span class="icon-exclamation-triangle"></span><?php _e( 'Oops, Forbidden!', 'go_pricing_textdomain' ); ?></div>
	<?php 
else :
?>
<div id="go-pricing-preview"><?php echo do_shortcode( '[go_pricing postid="' . $id . '" margin_bottom="0" preview="true"]' ); ?></div>
<?php 
endif;
wp_footer(); 
?>
</body>
</html>
<?php 
$html = ob_get_clean();
header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset', 'UTF-8' ) );
echo $html;
ob_end_flush();
?>
