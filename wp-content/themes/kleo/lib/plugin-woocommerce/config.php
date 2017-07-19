<?php
/**
 * @package WordPress
 * @subpackage KLEO
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since 1.4
 */

// Load WooCommerce custom stylsheet
if (! is_admin()) {
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) < 0 ) {
		define( 'WOOCOMMERCE_USE_CSS', false );
	}
	add_action( 'wp_enqueue_scripts', 'kleo_load_woocommerce_css', 20 );
}

if ( ! function_exists( 'kleo_load_woocommerce_css' ) ) {
	function kleo_load_woocommerce_css () {
		wp_deregister_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-layout');
		wp_deregister_style('woocommerce-smallscreen');
		wp_dequeue_style('woocommerce-smallscreen');
		wp_deregister_style('woocommerce-general');
		wp_dequeue_style('woocommerce-general');
		wp_register_style( 'kleo-woocommerce', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce.css' );
		wp_enqueue_style( 'kleo-woocommerce' );
	}
}

//de-register PrettyPhoto - we will use our own
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'woocommerce_prettyPhoto_css' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
}

if ( ! function_exists( 'checked_environment' ) ) 
{
	// Check WooCommerce is installed first
	add_action('plugins_loaded', 'checked_environment');

	function checked_environment() 
	{
		if (!class_exists('woocommerce')) wp_die('WooCommerce must be installed');
	}
}


/* Admin scripts */

if (is_admin()) {
	//remove backend options by removing them from the config array
	add_filter('woocommerce_general_settings','kleo_woocommerce_general_settings_filter');
	add_filter('woocommerce_page_settings','kleo_woocommerce_general_settings_filter');
	add_filter('woocommerce_catalog_settings','kleo_woocommerce_general_settings_filter');
	add_filter('woocommerce_inventory_settings','kleo_woocommerce_general_settings_filter');
	add_filter('woocommerce_shipping_settings','kleo_woocommerce_general_settings_filter');
	add_filter('woocommerce_tax_settings','kleo_woocommerce_general_settings_filter');

	function kleo_woocommerce_general_settings_filter($options)
	{
		$remove   = array('woocommerce_enable_lightbox', 'woocommerce_frontend_css');

		foreach ($options as $key => $option)
		{
			if( isset($option['id']) && in_array($option['id'], $remove) ) 
			{  
				unset($options[$key]); 
			}
		}

		return $options;
	}

	// add product meta boxes
	add_filter('kleo_meta_boxes', 'kleo_woo_product_meta');
	
	function kleo_woo_product_meta($meta_boxes) {
		$prefix = '_kleo_';
		$meta_boxes[] = array(
			'id'         => 'theme_product',
			'title'      => 'Theme Product settings',
			'pages'      => array( 'product' ), // Post type
			'context'    => 'normal',
			'priority'   => 'default',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => 'Top bar status',
					'desc' => 'Enable/disable site top bar',
					'id'   => $prefix . 'topbar_status',
					'type' => 'select',
					'options' => array(
							array('value' => '', 'name' => 'Default'),
							array('value' => '1', 'name' => 'Visible'),
							array('value' => '0', 'name' => 'Hidden')
						),
					'value' => ''
				),
				array(
					'name' => 'Hide Header',
					'desc' => 'Check to hide whole header area',
					'id'   => $prefix . 'hide_header',
					'type' => 'checkbox',
					'value' => '1'
				),
				array(
					'name' => 'Hide Footer',
					'desc' => 'Check to hide whole footer area',
					'id'   => $prefix . 'hide_footer',
					'type' => 'checkbox',
					'value' => '1'
				),
				array(
					'name' => 'Hide Socket area',
					'desc' => 'Check to hide the area after footer that contains copyright info.',
					'id'   => $prefix . 'hide_socket',
					'type' => 'checkbox',
					'value' => '1'
				),
				array(
					'name' => 'Custom Logo',
					'desc' => 'Use a custom logo for this page only',
					'id'   => $prefix . 'logo',
					'type' => 'file',
				),
				array(
					'name' => 'Custom Logo Retina',
					'desc' => 'Use a custom retina logo for this page only',
					'id'   => $prefix . 'logo_retina',
					'type' => 'file',
				),
				array(
					'name' => 'Transparent Main menu',
					'desc' => 'Check to have Main menu background transparent.',
					'id'   => $prefix . 'transparent_menu',
					'type' => 'checkbox',
					'value' => '1'
				),


				array(
					'name' => 'Hide the title',
					'desc' => 'Check to hide the title when displaying the post/page',
					'id'   => $prefix . 'title_checkbox',
					'type' => 'checkbox',
					'value' => '1'
				),
				array(
					'name' => 'Breadcrumb',
					'desc' => '',
					'id'   => $prefix . 'hide_breadcrumb',
					'type' => 'select',
					'options' => array(
							array('value' => '', 'name' => 'Default'),
							array('value' => '0', 'name' => 'Visible'),
							array('value' => '1', 'name' => 'Hidden')
						),
					'value' => ''
				),
				array(
					'name' => 'Hide information',
					'desc' => 'Check to hide contact info in title section',
					'id'   => $prefix . 'hide_info',
					'type' => 'checkbox',
					'value' => '1'
				)

			),
		);
		return $meta_boxes;
	}
	
} //end is_admin()



// Remove WC sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

//remove single product short description - excerpt
if( sq_option( 'woo_show_excerpt_single' , 0 ) == 0 ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
}


//Single product data tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35 );

//Single product sharing
$enabled_posts = sq_option('blog_share_types', array('post', 'product'));
if( sq_option( 'blog_social_share', 1 ) == 1 && in_array('product', (array)$enabled_posts) ) {
    add_action('woocommerce_share', 'kleo_social_share', 10);
}

//sale badge
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash' );

//catalog mode 
if ( sq_option( 'woo_catalog' , '0' ) == '1' ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
	remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
	remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
	remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_add_to_cart', 30 );
	
	//disable prices
	if ( sq_option( 'woo_disable_prices' , '0' ) == '1' ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_price', 10 );
	}
}


//Category list change product count format
add_filter( 'woocommerce_subcategory_count_html', 'kleo_woo_cat_count', 10, 2);
function kleo_woo_cat_count( $count, $category ) {
	return ' <mark class="count">' . $category->count . ' ' .  __( 'Products', 'woocommerce' ) .  '</mark>';
}

/**
 * Adds required Woocommerce classes to body element
 * @param array $classes
 * @return array
 * @since 1.0
 */
function kleo_woo_body_classes($classes = '') {
	
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		$classes[] = 'kleo-shop-cols-' . sq_option( 'woo_shop_columns', '3' );
	}
	
	return $classes;
	
}
add_filter('body_class','kleo_woo_body_classes');



// WooCommerce layout overrides
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'kleo_woocommerce_before_content' ) ) 
{
	// WooCommerce layout overrides
	add_action( 'woocommerce_before_main_content', 'kleo_woocommerce_before_content', 10 );
	function kleo_woocommerce_before_content() {
		//title section
		$title_arr = array();
		$shop_id = wc_get_page_id( 'shop' );

        $title_arr['show_title'] = true;

        //hide breadcrumb?
        $title_arr['show_breadcrumb'] = true;
        if( sq_option( 'breadcrumb_status', 1 ) == 0 ) {
            $title_arr['show_breadcrumb'] = false;
        }
		
		if (is_shop()) {
			$title_arr = kleo_prepare_title( $shop_id );
		}
		elseif ( is_product() ) {
			$title_arr = kleo_prepare_title();
		}
	
		if (sq_option('title_location', 'breadcrumb') == 'main') {
			$title_arr['show_title'] = false;
		}
		else {
			//title
			if(is_shop()) {
				$title = get_option('woocommerce_shop_page_title');
			}
			if( $shop_id && $shop_id != -1 ) {
				if( empty( $title ) ) {
					$title = get_the_title( $shop_id );
				}
			}
			if( is_product_category() || is_product_tag() ) {
				global $wp_query;
				$tax = $wp_query->get_queried_object();
				$title = $tax->name;
			}
		}

		if( ! isset( $title ) ) {
			$title  = __("Shop",'kleo_framework');
		}

		$title_arr['title'] = $title;
		$title_arr['link'] = '';
		if ( ( isset($title_arr['show_breadcrumb']) && $title_arr['show_breadcrumb'] ) || isset( $title_arr['extra'] ) || $title_arr['show_title'] ) {
			echo kleo_title_section($title_arr);
		}

		remove_action('kleo_before_main_content', 'kleo_title_main_content');
		if ( sq_option('title_location', 'breadcrumb') == 'breadcrumb' || get_cfield( 'title_checkbox', $shop_id ) == 1 ) {
			add_filter('woocommerce_show_page_title',  '__return_false');
		}
		get_template_part('page-parts/general-before-wrap');
	}
}

if ( ! function_exists( 'kleo_woocommerce_after_content' ) ) 
{
	// WooCommerce layout overrides
	add_action( 'woocommerce_after_main_content', 'kleo_woocommerce_after_content', 20 );
	function kleo_woocommerce_after_content() 
	{
        get_template_part('page-parts/general-after-wrap');
	}
}

//Remove breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );


function kleo_woo_breadcrumb_data(){
	ob_start();
	woocommerce_breadcrumb(array(
		'delimiter' => '<span class="sep"></span>',
		'wrap_before' => '<div class="kleo_framework breadcrumb kleo-custom-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
		'wrap_after'  => '</div>',
	));
	$breadcrumb = ob_get_clean();
	return $breadcrumb;
}

function kleo_woo_breadcrumb_replace(){
	if(is_woocommerce()) {
		add_filter('kleo_breadcrumb_data', 'kleo_woo_breadcrumb_data');
	}
}
add_filter('wp', 'kleo_woo_breadcrumb_replace');


//Change page layout to match theme options settings
add_filter('kleo_page_layout', 'kleo_woo_change_layout');

function kleo_woo_change_layout($layout) {
	global $kleo_config;
	
	if (is_woocommerce()) {
		$shop_id = wc_get_page_id( 'shop' );
		$shop_template = get_post_meta( $shop_id, '_wp_page_template', true );
		
		if ( is_shop() && $shop_id && $shop_template && $shop_template != 'default'
						&& isset( $kleo_config['tpl_map'][$shop_template] ) ) {
			
			$layout = $kleo_config['tpl_map'][$shop_template];
			
		}
		elseif ( is_product() && get_cfield('post_layout') && get_cfield('post_layout') != 'default') {
			$layout = get_cfield('post_layout');
		}
		elseif( (is_product_category() || is_product_tag()) && sq_option('woo_cat_sidebar', 'default') != 'default' ) {
			$layout = sq_option('woo_cat_sidebar', 'default');
		}
		else {
			//switch to the general set in Theme options
			$woo_template = sq_option('woo_sidebar', 'default');
			if ( $woo_template != 'default' ) {
				$layout = $woo_template;
			}
		}
		
		//change default sidebar with Shop sidebar
		add_filter('kleo_sidebar_name', create_function('', 'return "shop-1";'));
	}
	
	return $layout;
}

/***************************************************
:: Add custom HTML to top header page set from Page edit
 ***************************************************/

add_action('kleo_before_main', 'kleo_shop_header', 8);

function kleo_shop_header() {

    if ( ! is_shop() ) {
        return;
    }

    $shop_id = wc_get_page_id( 'shop' );
    if ( ! $shop_id ) {
        return;
    }

    $page_header = get_cfield( 'header_content', $shop_id );
    if( $page_header != '' ) {
        echo '<section class="kleo-shop-header container-wrap main-color">';
        echo do_shortcode( html_entity_decode( $page_header ) );
        echo '</section>';
    }
}



/***************************************************
:: Add custom HTML to bottom page set from Page edit
 ***************************************************/

add_action( 'kleo_after_main_content', 'kleo_woo_bottom_content', 12 );

function kleo_woo_bottom_content() {

    if ( ! is_shop() ) {
        return;
    }

    $shop_id = wc_get_page_id( 'shop' );
    if ( ! $shop_id ) {
        return;
    }

    $page_bottom = get_cfield( 'bottom_content', $shop_id );
    if( $page_bottom != '' ) {
        echo '<div class="kleo-page-bottom">';
        echo do_shortcode( html_entity_decode( $page_bottom ) );
        echo '</div>';
    }
}



// Change columns in product loop
if ( ! function_exists( 'loop_columns' ) ) 
{
	function loop_columns() 
	{
		return sq_option( 'woo_shop_columns', 3 );
	}

	add_filter( 'loop_shop_columns', 'loop_columns' );
}
// Number of products per page
$woo_per_page = sq_option('woo_shop_products', 15);
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $woo_per_page . ';' ) );

// Change columns in related products output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'kleo_woocommerce_output_related_products', 20 );

if ( ! function_exists( 'kleo_woocommerce_output_related_products' ) ) 
{
	function kleo_woocommerce_output_related_products() 
	{
		$items = sq_option( 'woo_related_columns', 3 );
		woocommerce_related_products( array('posts_per_page' => $items, 'columns' => $items ) );
	}
}

// Change columns in upsell products output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'kleo_woocommerce_upsell_display', 20 );

if ( ! function_exists( 'kleo_woocommerce_upsell_display' ) ) 
{
	function kleo_woocommerce_upsell_display() 
	{
		$items = sq_option( 'woo_upsell_columns', 3 );
		 woocommerce_upsell_display( $items, $items );
	}
}

// Change columns in upsell cross-sales output
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_cart_collaterals', 'kleo_woocommerce_cross_sell_display' );

if ( ! function_exists( 'kleo_woocommerce_cross_sell_display' ) ) 
{
	function kleo_woocommerce_cross_sell_display() 
	{
		$items = sq_option( 'woo_cross_columns', 3 );
		 woocommerce_cross_sell_display( $items, $items );
	}
}


//cart.php template
if ( version_compare( WOOCOMMERCE_VERSION, '2.3.8', '>=' ) ) {
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);
}


/***************************************************
:: Product loop badges
***************************************************/

// On sale wrapper
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'kleo_woo_loop_badges', 10 );
add_filter( 'woocommerce_sale_flash', 'kleo_woo_sale_flash', 10, 3 );

function kleo_woo_sale_flash( $data, $post, $product ) {
	$output = '<span class="kleo-sale-flash">' . $data . '</span>';
    if ( sq_option( 'woo_percentage_badge', 0 ) == 1 ) {

        if ($product->is_on_sale() && $product->product_type == 'variable') {

            $available_variations = $product->get_available_variations();
            $max_percentage = 0;
            for ($i = 0; $i < count($available_variations); ++$i) {
                $variation_id = $available_variations[$i]['variation_id'];
                $variable_product1 = new WC_Product_Variation($variation_id);
                $regular_price = $variable_product1->regular_price;
                $sales_price = $variable_product1->sale_price;
                if( $sales_price && $sales_price != '' ) {
                    $partial_percentage = (($regular_price - $sales_price) / $regular_price) * 100;
                    if ($partial_percentage > $max_percentage) {
                        $max_percentage = $partial_percentage;
                    }
                }
            }
            $percentage = round( $max_percentage );
        }
        elseif($product->is_on_sale() && $product->product_type == 'simple') {
            $percentage = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
        }
        elseif($product->is_on_sale() && $product->product_type == 'external') {
            $percentage = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
        }

        $output = '<span class="onsale percentage-badge">' . __( 'SAVE NOW', 'kleo_framework' ) . '<br>' .
        '<span class="big">' . $percentage . '%</span></span>';
    }

    return $output;
}

if (! function_exists('kleo_woo_loop_badges')) {
	function kleo_woo_loop_badges() {
		global $product, $post;
		if (kleo_woo_out_of_stock()) {

			echo '<span class="out-of-stock-badge">' . __('Out of stock', 'woocommerce') . '</span>';

		} else if ($product->is_on_sale()) {

			wc_get_template('loop/sale-flash.php');

		} else if (!$product->get_price() and sq_option('woo_free_badge', 1) == 1) {

			echo '<span class="free-badge">' . __('Free', 'woocommerce') . '</span>';

		} else if (sq_option('woo_new_badge', 1) == 1) {

			$postdate = get_the_time('Y-m-d');            // Post date
			$postdatestamp = strtotime($postdate);            // Timestamped post date
			$newness = sq_option('woo_new_days', 7);    // Number of days to treat a product as new

			if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) {
				echo '<span class="new-badge">' . __('New', 'kleo_framework') . '</span>';
			}

		}
	}
}

function kleo_woo_out_of_stock() {
	global $post;
	$post_id = $post->ID;
	$stock_status = get_post_meta($post_id, '_stock_status',true);

	if ($stock_status == 'outofstock') {
	return true;
	} else {
	return false;
	}
}



/***************************************************
:: Product images
***************************************************/

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'kleo_woo_thumb_image', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'kleo_woo_first_image', 11 );

function kleo_woo_thumb_image() {
		echo '<div class="kleo-woo-image kleo-woo-front-image">' . woocommerce_get_product_thumbnail() . '</div>';
}
function kleo_woo_first_image() {
	if (kleo_woo_get_first_image() != '') {
		echo '<div class="kleo-woo-image kleo-woo-back-image">' . kleo_woo_get_first_image() . '</div>';
	}
}

function kleo_woo_get_first_image() {
	
	global $product, $post;
	if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {

		$image = '';
		$attachment_ids = $product->get_gallery_attachment_ids();
		$img_count = 0;

		if ($attachment_ids) {
			foreach ( $attachment_ids as $attachment_id ) {

				if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true ) )
					continue;

				$image = wp_get_attachment_image( $attachment_id, 'shop_catalog' );

				$img_count++;

				if ($img_count == 1) break;

			}
		}
	} else {

		$attachments = get_posts( array(
			'post_type' 	=> 'attachment',
			'numberposts' 	=> -1,
			'post_status' 	=> null,
			'post_parent' 	=> $post->ID,
			'post__not_in'	=> array( get_post_thumbnail_id() ),
			'post_mime_type'=> 'image',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC'
		) );

		$img_count = 0;

		if ($attachments) {
			foreach ( $attachments as $attachment ) {

				if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 )
					continue;

				$image = wp_get_attachment_image( $attachment->ID, 'shop_catalog' );	

				$img_count++;

				if ($img_count == 1) break;

			}

		}
	}
	
	return $image;
}



/***************************************************
:: Wishlist
***************************************************/

add_action( 'woocommerce_before_shop_loop_item', 'kleo_woo_wishlist', 11 );

function kleo_woo_wishlist() {
	if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		}
}

add_action( 'yith_wcwl_after_wishlist_share', 'kleo_woo_wishlist_share');

function kleo_woo_wishlist_share() {
	global $yith_wcwl;
	if( get_option( 'yith_wcwl_share_fb' ) == 'yes' || get_option( 'yith_wcwl_share_twitter' ) == 'yes' || get_option( 'yith_wcwl_share_pinterest' ) == 'yes'  || get_option( 'yith_wcwl_share_googleplus' ) == 'yes'  || get_option( 'yith_wcwl_share_email' ) == 'yes') {
			$url  = $yith_wcwl->get_wishlist_url();
			$url .= get_option( 'permalink-structure' ) != '' ? '&amp;user_id=' : '?user_id=';
			$url .= get_current_user_id();
			$normal_url = $url;
			$url = urlencode( $url );
			$title = urlencode( get_option( 'yith_wcwl_socials_title' ) );
			$twitter_summary = str_replace( '%wishlist_url%', '', get_option( 'yith_wcwl_socials_text' ) );
			$summary = urlencode( str_replace( '%wishlist_url%', $normal_url, get_option( 'yith_wcwl_socials_text' ) ) );
			$imageurl = urlencode( get_option( 'yith_wcwl_socials_image_url' ) );

			$html  = '<div class="share-links kleo-wishlist-share">';
			$html .= apply_filters( 'yith_wcwl_socials_share_title', '<div class="hr-title hr-full"><abbr>' . __("Social share", "kleo_framework") . '</abbr></div>' );


			if( get_option( 'yith_wcwl_share_fb' ) == 'yes' )
			{ $html .= '<span class="kleo-facebook"><a target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $url . '&amp;p[summary]=' . $summary . '&amp;p[images][0]=' . $imageurl . '" title="' . __( 'Facebook', 'yit' ) . '"><i class="icon-facebook"></i></a></span>'; }

			if( get_option( 'yith_wcwl_share_twitter' ) == 'yes' )
			{ $html .= '<span class="kleo-twitter"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . $url . '&amp;text=' . $twitter_summary . '" title="' . __( 'Twitter', 'yit' ) . '"><i class="icon-twitter"></i></a></span>'; }

			if( get_option( 'yith_wcwl_share_pinterest' ) == 'yes' )
			{ $html .= '<span class="kleo-pinterest"><a target="_blank" class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . $url . '&amp;description=' . $summary . '&media=' . $imageurl . '" onclick="window.open(this.href); return false;"><i class="icon-pinterest-circled"></i></a></span>'; }

			if( get_option( 'yith_wcwl_share_googleplus' ) == 'yes' )
			{ $html .= '<span class="kleo-googleplus"><a target="_blank" class="googleplus" href="https://plus.google.com/share?url=' . $url . '&amp;title="' . $title . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="icon-gplus"></i></a></span>'; }

			if( get_option( 'yith_wcwl_share_email' ) == 'yes' )
			{ $html .= '<span class="kleo-mail"><a target="_blank" class="post_share_email" href="mailto:?subject=' . $title . '&body='. $url . '"><i class="icon-mail"></i></a></span>'; }

			$html .= '</div>';
			
			echo $html;
	}
	
}


/***************************************************
:: Quick view
***************************************************/

add_action( 'woocommerce_after_shop_loop_item', 'kleo_woo_quickview_button', 20 );

function kleo_woo_quickview_button() {
	echo kleo_woo_get_quickview_button();
}
	function kleo_woo_get_quickview_button( $post_id = null, $tooltip = null ) {
		if (! $post_id) {
			global $post;
			$post_id = $post->ID;
		}
		if ( $tooltip === true ) {
			$tooltip_data = ' data-toggle="tooltip" data-placement="top" data-title="' . __( "Quick View", "kleo_framework" ) . '" data-container="body"';
		}
		else {
			$tooltip_data = '';
		}
		return '<div class="quick-view hover-tip"' . $tooltip_data . ' data-prod="' . $post_id . '">' . __( 'Quick View','kleo_framework' ) . '</div>';
	}

// Quickview Ajax 
add_action('wp_ajax_woo_quickview', 'kleo_woo_quickview');
add_action('wp_ajax_nopriv_woo_quickview', 'kleo_woo_quickview');

function kleo_woo_quickview() {
	global $post, $product, $woocommerce;
	
	$prod_id =  $_POST["product"];
	$post = get_post( $prod_id );
	$product = get_product( $prod_id );
	
	ob_start();
	woocommerce_get_template( 'content-single-product-modal.php');
	$output = ob_get_contents();
	ob_end_clean();
	
	echo $output;
	die();
}

if ( ! function_exists( 'kleo_social_share' ) ) {
	function kleo_social_share() {
	?>

		<div class="share-links">
			<div class="hr-title hr-full"><abbr><?php _e("Social share", "kleo_framework"); ?></abbr></div>

			<?php if  ( sq_option( 'blog_social_share_facebook', 1 ) ) :  ?>
				<span class="kleo-facebook">
                <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="post_share_facebook"
                   onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;">
                    <i class="icon-facebook"></i>
                </a>
            </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_twitter', 1 ) ) :  ?>
				<span class="kleo-twitter">
                <a href="https://twitter.com/share?url=<?php the_permalink(); ?>" class="post_share_twitter"
                   onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;">
                    <i class="icon-twitter"></i>
                </a>
            </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_googleplus', 1 ) ) :  ?>
				<span class="kleo-googleplus">
                <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                   onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                    <i class="icon-gplus"></i>
                </a>
            </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_pinterest', 1 ) ) :  ?>
				<span class="kleo-pinterest">
                <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if (function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo strip_tags(get_the_title()); ?>"
                   onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                    <i class="icon-pinterest-circled"></i>
                </a>
            </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_linkedin', 0 ) ) :  ?>
				<span class="kleo-linkedin">
                    <a href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>" class="post_share_linkedin"
                       onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                        <i class="icon-linkedin"></i>
                    </a>
                </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_whatsapp', 0 ) ) :  ?>
				<span class="kleo-whatsapp visible-xs-inline visible-sm-inline">
                <a href="whatsapp://send?text=<?php the_permalink(); ?>" data-action="share/whatsapp/share">
                    <i class="icon-whatsapp"></i>
                </a>
            </span>
			<?php endif; ?>

			<?php if  ( sq_option( 'blog_social_share_mail', 1 ) ) :  ?>
				<span class="kleo-mail">
                <a href="mailto:?subject=<?php echo strip_tags(get_the_title()); ?>&body=<?php the_permalink(); ?>" class="post_share_email">
                    <i class="icon-mail"></i>
                </a>
            </span>
			<?php endif; ?>
		</div>

	<?php
	}
}


add_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_modal_summary', 'woocommerce_template_single_meta', 40 );

$enabled_posts = sq_option('blog_share_types', array('post', 'product'));
if( sq_option( 'blog_social_share', 1 ) == 1 && in_array('product', (array)$enabled_posts) ) {
    add_action( 'woocommerce_single_product_modal_summary', 'kleo_social_share', 50 );
}



/***************************************************
:: Prev/Next products
***************************************************/

if ( ! function_exists( 'kleo_product_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Kleo 1.0
 *
 * @return void
 */
function kleo_product_nav( $same_cat = false ) {
	
	if ( ! is_product() ) {
		return;
	}
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( $same_cat, '', true );
	$next     = get_adjacent_post( $same_cat, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	
	<nav class="pagination-sticky product-navigation" role="navigation">
		<?php
		if ( is_attachment() ) :
			previous_post_link( '%link', __( '<span id="older-nav">Go back</span>', 'kleo_framework' ) );
		else :
			$prev_img = get_the_post_thumbnail( $previous->ID, 'thumbnail' );
			$next_img = get_the_post_thumbnail( $next->ID, 'thumbnail' );
			$prev_img = $prev_img ? '<span class="nav-image">' . $prev_img . '</span>' : '';
			$next_img = $next_img ? '<span class="nav-image">' . $next_img . '</span>' : '';
			previous_post_link( '%link', '<span id="older-nav">' . $prev_img . '<span class="outter-title"><span class="entry-title">' . get_the_title( $previous->ID ) . '</span></span></span>', $same_cat );
			next_post_link( '%link', '<span id="newer-nav">' . $next_img . '<span class="outter-title"><span class="entry-title">' . get_the_title( $next->ID ) . '</span></span></span>', $same_cat );
		endif;
		?>
	</nav><!-- .navigation -->
	
	<?php
}
endif;
if ( sq_option( 'woo_product_navigation', 1 ) == 1 ) :
    add_action('kleo_after_main', 'kleo_product_nav', 11);
endif;


/***************************************************
:: Header menu cart
***************************************************/

if ( sq_option( 'woo_cart_location', 'primary' ) != 'off' )
{
	add_filter( 'wp_nav_menu_items', 'kleo_woo_header_cart', 9, 2 );
}

if(!function_exists('kleo_woo_header_cart'))
{
	/**
	 * Add search to menu
	 * @param string $items
	 * @param oject $args
	 * @return string
	 */
	function kleo_woo_header_cart ( $items, $args )
	{
		$cart_location = sq_option( 'woo_cart_location', 'primary' );
		
	    if ( $args->theme_location == $cart_location )
	    {
	        $items .= kleo_woo_get_mini_cart();
	    }
	    return $items;
	}
}



/* ADD TO CART HEADER RELOAD */ 
if (!function_exists('kleo_woo_header_cart_fragment')) {
	function kleo_woo_header_cart_fragment( $fragments ) {
		
		$output = kleo_woo_get_mini_cart();
		$fragments['.kleo-toggle-menu.shop-drop'] = $output;
		
		$fragments['.cart-contents.mheader'] = kleo_woo_get_mobile_icon();
		
		return $fragments;
		
	}
	add_filter('add_to_cart_fragments', 'kleo_woo_header_cart_fragment'); 
}



if (!function_exists('kleo_woo_get_mini_cart')) {
	function kleo_woo_get_mini_cart( $just_inner = false ) {

		global $woocommerce;
		
		$cart_output = "";
		$cart_total = $woocommerce->cart->get_cart_total();
		$cart_count = $woocommerce->cart->cart_contents_count;
		$cart_count_text = kleo_product_items_text($cart_count);
		
		$cart_has_items = '';
		if ($cart_count != "0") {
			$cart_has_items = ' has-products';
		}
		
		if ( ! $just_inner ) {
		$cart_output .= '<li class="menu-item kleo-toggle-menu shop-drop">'
						. '<a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__("View Cart", "woocommerce").'" style="line-height: normal;">'
							. '<span class="cart-items' . $cart_has_items . '"><i class="icon icon-basket-full-alt"></i> ';

                             if ( $cart_count != "0" ) {
                                $cart_output .= "<span class='kleo-notifications new-alert'>" . $cart_count . "</span>";
                             }

                            $cart_output .= '</span> <span class="caret"></span>'
						. '</a>'
						. '<ul class="kleo-toggle-submenu">';
		}
		
		$cart_output .=  '<li>'                                
			. '<div class="kleo-minicart">';
		
		if ( $cart_count != "0" ) {

			$cart_output .= '<div class="minicart-header">'.$cart_count_text.' '.__('in the shopping cart', 'kleo_framework').'</div>';

			$cart_output .= '<div class="minicart-contents">';

			foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {

				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$cart_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					$product_title       = $cart_product->get_title();
					$product_short_title = ( strlen( $product_title ) > 25 ) ? substr( $product_title, 0, 22 ) . '...' : $product_title;
					$product_short_title = apply_filters( 'woocommerce_cart_item_name', $product_short_title, $cart_item, $cart_item_key );

					$thumbnail        = apply_filters( 'woocommerce_cart_item_thumbnail', $cart_product->get_image(), $cart_item, $cart_item_key );
					$product_price    = apply_filters( 'woocommerce_cart_item_price', woocommerce_price( $cart_product->get_price() ), $cart_item, $cart_item_key );
					$product_quantity = apply_filters( 'woocommerce_cart_item_quantity', $cart_item['quantity'], $cart_item_key, $cart_item );

					if ( $cart_product->exists() && $cart_item['quantity'] > 0 ) {
						$cart_output .= '<div class="cart-product clearfix">';
						$cart_output .= '<figure><a class="cart-product-img" href="' . get_permalink( $cart_item['product_id'] ) . '">' . $thumbnail . '</a></figure>';
						$cart_output .= '<div class="cart-product-details">';
						$cart_output .= '<div class="cart-product-title"><a href="' . get_permalink( $cart_item['product_id'] ) . '">' . $product_short_title . '</a></div>';
						$cart_output .= '<div class="cart-product-price">' . __( "Price", "woocommerce" ) . ' ' . $product_price . '</div>';
						$cart_output .= '<div class="cart-product-quantity">' . __( 'Quantity', 'woocommerce' ) . ' ' . $product_quantity . '</div>';
						$cart_output .= '</div>';
						$cart_output .= kleo_woo_get_quickview_button( $cart_item['product_id'], false );

						$cart_output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						//$cart_output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );

						$cart_output .= '</div>';
					}
				}
			}

			$cart_output .= '</div>';
			
			$cart_output .= '<div class="minicart-total-checkout">' . __( 'Cart Subtotal', 'kleo_framework' ) . ' ' . $cart_total . '</div>';

			$cart_output .= '<div class="minicart-buttons">';

			if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {

				$cart_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_cart_url() );
				$checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );

				$cart_output .= '<a class="btn btn-default" href="'.esc_url( $cart_url ).'"><span class="text">'. __('View Cart', 'woocommerce').'</span></a>';
				$cart_output .= '<a class="btn btn-highlight checkout-button" href="'.esc_url( $checkout_url ).'"><span class="text">'.__('Proceed to Checkout', 'woocommerce').'</span></a>';

			} else {

				$cart_output .= '<a class="btn btn-default" href="'.esc_url( $woocommerce->cart->get_cart_url() ).'"><span class="text">'. __('View Cart', 'woocommerce').'</span></a>';
				$cart_output .= '<a class="btn btn-highlight" href="'. esc_url( $woocommerce->cart->get_checkout_url() ).'"><span class="text">'.__( 'Proceed to Checkout', 'woocommerce' ).'</span></a>';

			}

			$cart_output .= '</div>';

		} else {

			$cart_output .= '<div class="minicart-header">' . __('Your shopping bag is empty.','kleo_framework') . '</div>';                                 

			$shop_page_url = "";
			if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
				$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
			} else {
				$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
			}

			$cart_output .= '<div class="minicart-buttons">';

			$cart_output .= '<a class="btn btn-default kleo-go-shop" href="'.esc_url( $shop_page_url ).'"><span class="text">'.__('Go to the shop', 'kleo_framework').'</span></a>';

			$cart_output .= '</div>';

		}

		$cart_output .= '</div>'
							. '</li>';
		
		if ( ! $just_inner ) {
			$cart_output .= '</ul>'
							. '</li>';
		}

		return $cart_output;
	}
}



function kleo_product_items_text($count) {

	$product_item_text = "";

		if ( $count > 1 ) {
				$product_item_text = str_replace('%', number_format_i18n($count), __('% items', 'kleo_framework'));
			} elseif ( $count == 0 ) {
				$product_item_text = __('0 items', 'kleo_framework');
			} else {
				$product_item_text = __('1 item', 'kleo_framework');
			}

			return $product_item_text;

}



/* Mobile cart icons */
function kleo_woo_get_mobile_icon() {
	global $woocommerce;
	$cart_count = $woocommerce->cart->cart_contents_count;
	$cart_has_items = '';
	$output = '';
	
	if ($cart_count != "0") {
		$cart_has_items = ' has-products';
	}
	
	$output .= '<a class="cart-contents mheader" href="'.$woocommerce->cart->get_cart_url().'" title="'.__("View Cart", "woocommerce").'">'
		. '<span class="cart-items' . $cart_has_items . '"><i class="icon icon-basket-full-alt"></i> ';

	if ($cart_count != "0") { 
		$output .= "<span>" . $cart_count . "</span>"; 
	}
	
	$output .= '</span></a>';
	
	return $output;
}
	function kleo_woo_mobile_icon() {
		echo kleo_woo_get_mobile_icon();
	}

if ( sq_option('woo_mobile_cart', 1) == 1 ) {
	add_action( 'kleo_mobile_header_icons', 'kleo_woo_mobile_icon' );
}



/* Remove items by AJAX */
add_action('wp_ajax_kleo_woo_rem_item', 'kleo_woo_remove_item');
add_action('wp_ajax_nopriv_kleo_woo_rem_item', 'kleo_woo_remove_item');

function kleo_woo_remove_item() {
	
	global $woocommerce;
	$response = array();
	
	if ( ! isset( $_GET['kleo_item'] ) && ! isset( $_GET['_wpnonce'] ) ) {
		exit;
	}
	WC()->cart->set_quantity( $_GET['kleo_item'], 0 );
	
	$cart_count = $woocommerce->cart->cart_contents_count;
	$response['count'] = $cart_count != 0 ? $cart_count : "";
	$response['cart'] = kleo_woo_get_mini_cart( true );
	
	//widget cart update
	ob_start();
	woocommerce_mini_cart();
	$mini_cart = ob_get_clean();
	$response['widget'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';	
	
	echo json_encode( $response );
	exit;
}



if (!function_exists('kleo_checkout_steps')) {
	/**
	 * Print Woocommerce Checkout steps
	 */
	function kleo_checkout_steps() {
	?>

		<div class="checkout-steps">
			<span class="step-cart"><a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php _e('Shopping Cart', 'kleo_framework'); ?></a></span>   
				<i class="icon icon-angle-right"></i>    
				<span class="step-checkout"><?php _e('Checkout details', 'kleo_framework'); ?></span>  
				<i class="icon icon-angle-right"></i>  
				<span class="step-complete"><?php _e('Order Complete', 'kleo_framework'); ?></span>
		</div>

	<?php
	}
}

add_action('woocommerce_before_cart', 'kleo_checkout_steps');
add_action('woocommerce_before_checkout_page', 'kleo_checkout_steps');



/***************************************************
:: Custom main menu select for each page
 ***************************************************/
function kleo_woo_set_custom_menu( $args = '' ) {

    $shop_id = wc_get_page_id( 'shop' );

    if (is_shop()) {

        $menuslug = get_cfield( 'page_menu', $shop_id );

        if( ! empty( $menuslug ) && $menuslug != 'default' && is_nav_menu( $menuslug ) ) {
            $args['menu'] = $menuslug;
        }

    }

    return $args;
} // END function kleo_set_custom_menu($args = '')
add_filter('wp_nav_menu_args', 'kleo_woo_set_custom_menu', 11);


/* Append dynamic CSS */
function kleo_woo_dynamic_css() {
	$h1 = sq_option('font_h1');
	$extra_style = '';
    $extra_style .= '.percentage-badge { color: ' . sq_option( 'woo_percent_color', '#fff' ) . ' !important; background: ' . sq_option( 'woo_percent_bg', '#000' ) . ' !important; }';
	$extra_style .= 'body.single-product span.page-title { font-family: ' . $h1['font-family'] . ' !important; font-weight: ' . $h1['font-weight'] . ' !important; display:block; font-size: 26px; line-height: 34px; margin: 0; }';
	return $extra_style;
}
add_filter( 'kleo_add_dynamic_style', 'kleo_woo_dynamic_css' );

function kleo_dynamic_alternate_func($output, $section){
	$output .= 'body.single-product span.page-title { color: '.$section['headings'].'; }';
	return $output;
}
add_filter( 'kleo_dynamic_alternate', 'kleo_dynamic_alternate_func', 10, 2 );


/* Visual composer integration */

if( defined('WPB_VC_VERSION') && version_compare( WPB_VC_VERSION, '4.4' ) < 0 ) {

/**** Order Tracking ***/

vc_map( array(
		"name" => "Order Tracking",
		"base" => "woocommerce_order_tracking",
		"icon" => "icon-wpb-woocommerce_order_tracking",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/*** Product price/cart button ***/
	
vc_map( array(
		"name" => "Add to cart",
		"base" => "add_to_cart",
		"icon" => "icon-wpb-add_to_cart",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "ID",
				"param_name" => "id",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKU",
				"param_name" => "sku",
				"description" => ""
			)
		)
) );

/*** Product by SKU/ID ***/
	
vc_map( array(
		"name" => "Product by SKU/ID",
		"base" => "product",
		"icon" => "icon-wpb-product",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "ID",
				"param_name" => "id",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKU",
				"param_name" => "sku",
				"description" => ""
			)
		)
) );


/*** Products by SKU/ID ***/
	
vc_map( array(
		"name" => "Products by SKU/ID",
		"base" => "products",
		"icon" => "icon-wpb-products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "IDS",
				"param_name" => "ids",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKUS",
				"param_name" => "skus",
				"description" => ""
			)
		)
) );

/*** Product categories ***/
	
vc_map( array(
		"name" => "Product categories",
		"base" => "product_categories",
		"icon" => "icon-wpb-product_categories",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"description" => ""
			)
		)
) );

/*** Products by category slug ***/
	
vc_map( array(
		"name" => "Products by category slug",
		"base" => "product_category",
		"icon" => "icon-wpb-product_category",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			)
		)
) );

/*** Recent products ***/
	
vc_map( array(
		"name" => "Recent products",
		"base" => "recent_products",
		"icon" => "icon-wpb-recent_products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			),
		)
) );

/*** Featured products ***/
	
vc_map( array(
		"name" => "Featured products",
		"base" => "featured_products",
		"icon" => "icon-wpb-featured_products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "orderby",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			),
		)
) );

/**** Shop Messages ***/

vc_map( array(
		"name" => "Shop Messages",
		"base" => "woocommerce_messages",
		"icon" => "icon-wpb-woocommerce_messages",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

}

/***************************************************
:: WooCommerce My Account Buddypress Integration
 ***************************************************/

if ( function_exists( 'bp_is_active' ) && is_user_logged_in() && sq_option( 'woo_buddypress_menus' , 1 ) == 1 ) {
	// Add the Orders tab to BuddyPress profile
	add_action( 'bp_setup_nav', 'kleo_woo_profile_nav_orders' , 301 );
	function kleo_woo_profile_nav_orders() {
		global $bp;
		bp_core_new_nav_item(
			array(
				'name' => __('Orders', 'woocommerce'),
				'slug' => 'orders',
				'position' => 21,
				'show_for_displayed_user' => false,
				'screen_function' => 'bp_woo_orders_screen',
				'default_subnav_slug' => 'my-orders',
			));
	}

	// Add submenus to Orders tab
	add_action( 'bp_setup_nav', 'kleo_woo_order_submenus' , 302 );
	function kleo_woo_order_submenus() {
		global $bp;
		bp_core_new_subnav_item(
			array(
				'name' => __('My Orders', 'kleo_framework'),
				'slug' => 'my-orders',
				'parent_url' => $bp->loggedin_user->domain  . $bp->bp_nav['orders']['slug'] . '/',
				'parent_slug' => $bp->bp_nav['orders']['slug'],
				'position' => 10,
				'show_for_displayed_user' => false,
				'screen_function' => 'kleo_woo_orders_screen',
			));

		bp_core_new_subnav_item(
			array(
				'name' => __('My Downloads', 'kleo_framework'),
				'slug' => 'downloads',
				'parent_url' => $bp->loggedin_user->domain  . $bp->bp_nav['orders']['slug'] . '/',
				'parent_slug' => $bp->bp_nav['orders']['slug'],
				'position' => 20,
				'show_for_displayed_user' => false,
				'screen_function' => 'kleo_woo_downloads_screen'
			));
	}

	// Load My Orders template
	function kleo_woo_orders_screen() {
		add_action( 'bp_template_content', 'kleo_woo_orders_screen_content' );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	// Display My Orders screen
	function kleo_woo_orders_screen_content() {
		echo '<div class="woocommerce">';
        wc_get_template( 'myaccount/my-orders.php' );
		echo '</div>';
	}

	// Load My Downloads template
	function kleo_woo_downloads_screen() {
		add_action( 'bp_template_content', 'kleo_woo_downloads_screen_content' );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	// Display My Downloads screen
	function kleo_woo_downloads_screen_content() {
		echo '<div class="woocommerce">';
		wc_get_template( 'myaccount/my-downloads.php' );
		echo '</div>';
	}

	// Add account settings into profile settings

	// Add address sub menu to settings menu
	add_action( 'bp_setup_nav', 'kleo_woo_address_submenu' , 302 );
	function kleo_woo_address_submenu() {
		global $bp;
		bp_core_new_subnav_item(
			array(
				'name' => __('My Addresses', 'woocommerce'),
				'slug' => 'my-address',
				'parent_url' => $bp->loggedin_user->domain  . $bp->bp_nav['settings']['slug'] . '/',
				'parent_slug' => $bp->bp_nav['settings']['slug'],
				'position' => 15,
				'show_for_displayed_user' => false,
				'screen_function' => 'kleo_woo_address_screen',
			));
	}

	// Load address template
	function kleo_woo_address_screen() {
		add_action( 'bp_template_content', 'kleo_woo_address_screen_content' );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	// Load address screen
	function kleo_woo_address_screen_content() {
		echo '<div class="woocommerce">';

        wc_get_template( 'myaccount/form-edit-address.php', array(
			'load_address' 	=> ''
		) );
		echo '</div>';
	}

	//Remove Settings > General screen and replace with woo account edit screen
	//add_action( 'bp_setup_nav', 'kleo_remove_general_settings' , 301 );
	function kleo_remove_general_settings() {
		bp_core_remove_subnav_item( 'settings', 'general' );
	}

	//Change default subnav for settings
	//add_action('bp_setup_nav', 'kleo_change_settings_subnav', 5);
	function kleo_change_settings_subnav() {
		$args = array(
			'parent_slug' => 'settings',
			'screen_function' => 'bp_woo_edit_account_screen',
			'subnav_slug' => 'account'
		);
		bp_core_new_nav_default($args);
	}

	// Add edit account sub menu
	//add_action( 'bp_setup_nav', 'kleo_woo_edit_account_submenu' , 302 );
	function kleo_woo_edit_account_submenu() {
		global $bp;
		bp_core_new_subnav_item(
			array(
				'name' => __('Account', 'kleo_framework'),
				'slug' => 'account',
				'parent_url' => $bp->loggedin_user->domain  . $bp->bp_nav['settings']['slug'] . '/',
				'parent_slug' => $bp->bp_nav['settings']['slug'],
				'position' => 10,
				'show_for_displayed_user' => false,
				'screen_function' => 'kleo_woo_edit_account_screen',
			));
	}

	// Load account template
	function kleo_woo_edit_account_screen() {
		add_action( 'bp_template_content', 'kleo_woo_edit_account_screen_content' );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	// Display edit account screen
	function kleo_woo_edit_account_screen_content() {
		echo '<div class="woocommerce">';
		wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );
		echo '</div>';

	}

	// Make sure we stay in Buddypress profile after edits
	add_action( 'woocommerce_customer_save_address', 'kleo_save_address_bp_redirect' );
	function kleo_save_address_bp_redirect() {
		global $bp;
		wp_safe_redirect( $bp->loggedin_user->domain . $bp->settings->slug . '/my-address/' );
		exit;
	}

	//add_action( 'woocommerce_save_account_details', 'kleo_save_account_bp_redirect' );
	function kleo_save_account_bp_redirect() {
		global $bp;
		wp_safe_redirect( $bp->loggedin_user->domain . $bp->settings->slug . '/account/' );
		exit;
	}

	// Add button on order detail screen to return to order list
	add_action('woocommerce_view_order', 'kleo_return_to_bp_order_list');
	function kleo_return_to_bp_order_list() { ?>
		<?php global $bp; ?>
		<a href="<?php echo $bp->loggedin_user->domain . 'orders/'; ?>" title="<?php _e('View All Orders','kleo_framework'); ?>" class="button"><?php _e('View All Orders','kleo_framework'); ?></a>
	<?php }

} else {

	// Add button on order detail screen to return to order list
	add_action('woocommerce_view_order', 'kleo_return_to_wc_order_list');
	function kleo_return_to_wc_order_list()
	{ ?>
		<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
		   title="<?php _e('View All Orders', 'kleo_framework'); ?>"
		   class="button"><?php _e('My Account', 'kleo_framework'); ?></a>
	<?php
	}
}


/* Compatibility with Woocommerce < 2.4 */
if ( ! function_exists( 'wc_dropdown_variation_attribute_options' ) ) {

	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param array $args
	 * @since 2.4.0
	 */
	function wc_dropdown_variation_attribute_options( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'options'          => false,
			'attribute'        => false,
			'product'          => false,
			'selected' 	       => false,
			'name'             => '',
			'id'               => '',
			'class'            => '',
			'show_option_none' => __( 'Choose an option', 'woocommerce' )
		) );

		$options   = $args['options'];
		$product   = $args['product'];
		$attribute = $args['attribute'];
		$name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class     = $args['class'];

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

		if ( $args['show_option_none'] ) {
			echo '<option value="">' . esc_html( $args['show_option_none'] ) . '</option>';
		}

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
				}
			}
		}

		echo '</select>';
	}
}



if ( ! function_exists( 'woocommerce_single_variation' ) ) {

	add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );

	/**
	 * Output placeholders for the single variation.
	 */
	function woocommerce_single_variation() {
		echo '<div class="single_variation"></div>';
	}
}

if ( ! function_exists( 'woocommerce_single_variation_add_to_cart_button' ) ) {

	add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );

	/**
	 * Output the add to cart button for variations.
	 */
	function woocommerce_single_variation_add_to_cart_button() {
		global $product;
		?>
		<div class="variations_button">
			<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
			<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />
		</div>
		<?php
	}
}

function kleo_title_args_singular_product( $args ){
	if( is_singular( 'product' ) ){
		$args['heading'] = 'span';
	}
	return $args;
}
add_filter('kleo_title_args', 'kleo_title_args_singular_product');

/* Trigger the reviews tab when clicking on the reviews starts */
function kleo_woocommerce_wp_footer(){
	if( is_singular('product') ){
		echo '<script>jQuery(document).ready(function(){ jQuery(\'a[href="#reviews"]\').on("click", function(){ jQuery(\'a[href="#reviews_tab"]\').trigger("click"); return false; }); });</script>';
	}
}
add_action( 'wp_footer', 'kleo_woocommerce_wp_footer' );


/* Remove product loop link wrapper */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


/* Srcset fix for variations */
add_filter('woocommerce_available_variation', 'sq_remove_img_srcset_variations');

function sq_remove_img_srcset_variations( $attr ) {
	if (! empty($attr)) {
		unset($attr['image_srcset']);
		unset($attr['image_sizes']);
	}

	return $attr;
}