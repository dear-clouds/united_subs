<?php

// Run all hooks and filters after theme is loaded
add_action('after_setup_theme', 'kleo_geodir_init', 999);
function kleo_geodir_init(){
// Add specific class in Geo Directory pages

    // Main wrapper open / close
    remove_action('geodir_wrapper_open', 'geodir_action_wrapper_open', 10);
    add_action('geodir_wrapper_open', 'kleo_geodir_action_wrapper_open', 9);
    remove_action('geodir_wrapper_close', 'geodir_action_wrapper_close', 10);
    add_action('geodir_wrapper_close', 'kleo_geodir_action_wrapper_close', 9);

    // Remove GeoDirectory home page breadcrumbs
    remove_action('geodir_home_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_location_before_main_content', 'geodir_breadcrumb', 20);

    // Remove GeoDirectory listing page title and breadcrumbs
    remove_action('geodir_listings_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_listings_page_title', 'geodir_action_listings_title', 10);

    // Remove GeoDirectory details page title and breadcrumbs
    remove_action('geodir_detail_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_details_main_content', 'geodir_action_page_title', 20);

    // Remove GeoDirectory search page title and breadcrumbs
    remove_action('geodir_search_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_search_page_title', 'geodir_action_search_page_title', 10);

    // Remove GeoDirectory author page title and breadcrumbs
    remove_action('geodir_author_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_author_page_title', 'geodir_action_author_page_title', 10);

    remove_action('geodir_add_listing_page_title', 'geodir_action_add_listing_page_title', 10);

}


// Add specific class in Geo Directory pages
add_action('wp', 'kleo_geodir_body_class_init', 999);
function kleo_geodir_body_class_init(){
    if(function_exists('geodir_is_geodir_page')){
        if(geodir_is_geodir_page() || is_page(get_option('geodir_location_page'))){
            add_filter('body_class', 'kleo_geodir_body_class');
            function kleo_geodir_body_class($classes){
                $classes[] = 'kleo-geodir';
                return $classes;
            }
        }
    }
}

// Main wrapper open
function kleo_geodir_action_wrapper_open(){
    kleo_switch_layout('no');
    get_template_part('page-parts/general-title-section');
    get_template_part('page-parts/general-before-wrap');
}

// Main wrapper close
function kleo_geodir_action_wrapper_close(){
    get_template_part('page-parts/general-after-wrap');
}

// Add GeoDirectory styling
add_action( 'wp_enqueue_scripts', 'kleo_geodir_css', 999 );
function kleo_geodir_css(){
    wp_register_style( 'kleo-geodir', trailingslashit( get_template_directory_uri() ) . 'lib/plugin-geodirectory/kleo-geodir.css', array(), KLEO_THEME_VERSION, 'all' );
    wp_enqueue_style( 'kleo-geodir' );
}

add_filter('geodir_location_switcher_menu_li_class', 'kleo_geodir_menu_li_class', 10, 1);
add_filter('geodir_menu_li_class', 'kleo_geodir_menu_li_class', 10, 1);
function kleo_geodir_menu_li_class( $class ){
    if ( strpos( $class, 'menu-item-has-children' ) !== false || strpos( $class, 'gd-location-switcher' ) !== false ) {
        $class .= " kleo-gd-dropdown dropdown ";
    }
    return $class;
}

add_filter('geodir_location_switcher_menu_sub_ul_class', 'kleo_geodir_sub_menu_ul_class', 10, 1);
add_filter('geodir_sub_menu_ul_class', 'kleo_geodir_sub_menu_ul_class', 10, 1);
function kleo_geodir_sub_menu_ul_class( $class ){
    $class .= " dropdown-menu ";
    return $class;
}


add_action('wp_footer', 'kleo_geodir_wp_footer');
function kleo_geodir_wp_footer(){
    ?>
    <script>
        jQuery(document).ready(function(){
            jQuery('.kleo-gd-dropdown > a').addClass('js-activated').append('<span class="caret"></span>');
        });
    </script>
    <?php
}

add_action('geodir_article_close','kleo_geodir_social_share');
function kleo_geodir_social_share() {
    get_template_part( 'page-parts/posts-social-share' );
}

function kleo_geodir_breadcrumb_separator(){
    return '<span class="sep"></span>';
}
add_filter('geodir_breadcrumb_separator', 'kleo_geodir_breadcrumb_separator');

function kleo_geodir_breadcrumb_data(){
    ob_start();
    geodir_breadcrumb();
    $breadcrumb = ob_get_clean();
    $breadcrumb = str_replace('<div class="geodir-breadcrumb clearfix">', '<div class="kleo_framework breadcrumb kleo-custom-breadcrumb">', $breadcrumb);
    $breadcrumb = str_replace('<ul id="breadcrumbs"><li>', '', $breadcrumb);
    $breadcrumb = str_replace('</li></ul>', '', $breadcrumb);
    return $breadcrumb;
}

function kleo_geodir_breadcrumb_replace(){
    if(geodir_is_geodir_page() || is_page(get_option('geodir_location_page'))) {
        add_filter('kleo_breadcrumb_data', 'kleo_geodir_breadcrumb_data');
    }
}
add_filter('wp', 'kleo_geodir_breadcrumb_replace');
