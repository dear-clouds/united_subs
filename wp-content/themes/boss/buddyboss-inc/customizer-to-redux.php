<?php 
add_action( 'admin_init', 'boss_maybe_import_customizer_to_redux', 99 );
function boss_maybe_import_customizer_to_redux(){
    if ( defined( 'DOING_AJAX' ) ){
        return;
    }

    if( !current_user_can( 'manage_options' ) )
        return;
    
    if( is_multisite() && is_network_admin() )
        return;
    
    /**
     * run the updater script if not done so already.
     */
    if( get_option( 'boss_migrated_to_redux' ) == '1.2.2' )
        return;
    
    boss_import_customizer_to_redux();
}

function boss_import_customizer_to_redux(){
    /**
     * What all to import:-
     * 
     * options: boss_title_color, boss_panel_logo_color, boss_layout_desktop, boss_layout_tablet, boss_layout_phone, boss_layout_switcher
     * boss_activity_infinite, boss_inputs, boss_search_instead, buddyboss_titlebar_position, buddyboss_panel_hide, buddyboss_panel_state
     * buddyboss_dashboard, buddyboss_adminbar, boss_cover_color, boss_cover_group_size, boss_cover_profile_size, boss_misc_profile_field_address, 
     * boss_layout_titlebar_bgcolor, boss_layout_mobiletitlebar_bgcolor, boss_layout_titlebar_color, boss_layout_mobiletitlebar_color, boss_layout_nobp_titlebar_bgcolor,
     * boss_layout_nobp_titlebar_color, boss_layout_nobp_titlebar_hover_color, boss_panel_color, boss_panel_title_color, boss_panel_open_icons_color, 
     * boss_panel_icons_color, boss_layout_body_color, boss_layout_footer_top_color, boss_layout_footer_bottom_bgcolor, boss_layout_footer_bottom_color,
     * boss_slideshow_font_color, boss_heading_font_color, boss_body_font_color, boss_links_pr_color, boss_links_color,
     * boss_scheme_select, 
     * foreach(buddyboss_get_user_social_array() as $key => $value) {
     *  'boss_show_profile_link_'.$key
     * }
     * 
     * theme mod: buddyboss_logo, buddyboss_small_logo, boss_font_charset, boss_site_title_font_family, boss_heading_font_family, boss_slideshow_font_family,
     * boss_body_font_family, boss_link_facebook, boss_link_twitter, boss_link_linkedin, boss_link_googleplus, boss_link_youtube,
     * boss_link_instagram, boss_link_pinterest, boss_link_email, boss_custom_css
     */
    
    $redux_data = array();
    //first a direct options match
    $direct_map_opts = array(
        'boss_title_color', 'boss_panel_logo_color', 'boss_layout_desktop', 'boss_layout_tablet', 'boss_layout_phone', 'boss_layout_switcher', 
        'boss_activity_infinite',   
        'boss_cover_color', 'boss_cover_group_size', 'boss_cover_profile_size', 
        'boss_misc_profile_field_address', 'boss_layout_titlebar_bgcolor', 'boss_layout_mobiletitlebar_bgcolor', 'boss_layout_titlebar_color', 
        'boss_layout_mobiletitlebar_color', 'boss_layout_nobp_titlebar_bgcolor', 'boss_layout_nobp_titlebar_color', 'boss_layout_nobp_titlebar_hover_color', 
        'boss_panel_color', 'boss_panel_title_color', 'boss_panel_open_icons_color', 'boss_panel_icons_color', 'boss_layout_body_color', 
        'boss_layout_footer_top_color', 'boss_layout_footer_bottom_bgcolor', 'boss_layout_footer_bottom_color', 'boss_slideshow_font_color', 
        'boss_heading_font_color', 'boss_body_font_color', 'boss_links_pr_color', 'boss_links_color', 'boss_scheme_select',
    );
    foreach( $direct_map_opts as $opt ){
        $redux_data[$opt] = get_option($opt);
        
        if( 'boss_scheme_select'==$opt && !$redux_data[$opt] ){
            $redux_data[$opt] = 'education';
        }
    }
    
    $direct_map_thememods = array( 'boss_custom_css' );
    foreach( $direct_map_thememods as $theme_mod ){
        $redux_data[$theme_mod] = get_theme_mod( $theme_mod );
        
        if( 'boss_custom_css'==$theme_mod && ! empty( $redux_data[$theme_mod] ) ) {
            $redux_data['custom_css'] = true;//switch on
        }
    }
    
    /**
     * These values (from old theme) have no counterpart in redux options!!
     */
    $missing_in_redux__thememod = array('boss_font_charset');
    
    //name changes - mapping
    $changed_map_opts = array(
        'buddyboss_titlebar_position'       => 'boss_titlebar_position',
        'buddyboss_titlebar_position_above' => 'boss_titlebar_position_above',
        'buddyboss_titlebar_position_below' => 'boss_titlebar_position_below',
        'buddyboss_titlebar_position_hide'  => 'boss_titlebar_position_hide',
        'buddyboss_panel_state'             => 'boss_panel_state',
    );
    foreach( $changed_map_opts as $old_opt=>$new_opt ){
        $redux_data[$new_opt] = get_option( $old_opt );
    }
    
    /**
     * logo in customizer - string value, containning url
     * logo in redux - [
     *  url : ../wp-content/uploads/2015/10/boss-large.png",
     *  id : 191,
     *  height : 80,
     *  width : 280,
     *  thumbnail : "../wp-content/uploads/2015/10/boss-large-150x80.png"
     * ]
     */
    $logo_opts_mapping = array(
        'buddyboss_logo'        => 'boss_logo',
        'buddyboss_small_logo'  => 'boss_small_logo',
    );
    foreach( $logo_opts_mapping as $theme_mod => $new_opt ){
        $old_logo_url = get_theme_mod( $theme_mod );
        if( $old_logo_url ){
            global $wpdb;
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid=%s LIMIT 1;", $old_logo_url ) );
            if( $attachment_id && !is_wp_error($attachment_id)){
                $logo = array(
                    'url'   => $old_logo_url,
                    'id'    => $attachment_id,
                );

                $attachment_meta = wp_get_attachment_metadata( $attachment_id );
                if( isset( $attachment_meta['width'] ) )
                    $logo['width'] = $attachment_meta['width'];

                if( isset( $attachment_meta['height'] ) )
                    $logo['height'] = $attachment_meta['height'];

                $image_thumb = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                if( isset( $image_thumb[0] ) )
                    $logo['thumbnail'] = $image_thumb[0];
                
                $redux_data[$new_opt] = $logo;
                
                //logo switches
                if( 'boss_logo'==$new_opt ){
                    $redux_data['logo_switch'] = true;//switch on
                }
                if( 'boss_small_logo'==$new_opt ){
                    $redux_data['mini_logo_switch'] = true;//switch on
                }
                
                //if big logo is uploaded, set custom login screen to on and use the big logo
                if( 'boss_logo'==$new_opt ){
                    $redux_data['boss_custom_login'] = true;//switch on
                    $redux_data['boss_admin_login_logo'] = $logo;
                }
            } 
        }
    }
    
    $default_fonts = buddyboss_customizer_default_fonts();
    /**
     * boss_site_title_font_family in customizer - string value e.g 'helvetica'
     * boss_site_title_font_family in redux - [
     *  font-family     : "Pacifico",
     *  font-options    : "",
     *  google          : "1",
     *  font-weight     : "400",
     *  font-style      : "",
     *  subsets         : "",
     *  font-size       : 30px,
     * ]
     */
    $fonts_mapping = array(
        'boss_site_title_font_family'   => 'boss_site_title_font_family',
        'boss_slideshow_font_family'    => 'boss_slide_title_font_options',
        'boss_body_font_family'         => 'boss_body_font_family',
        'boss_heading_font_family'      => 'boss_h1_font_options',
    );
    foreach( $fonts_mapping as $theme_mod => $new_opt ){
        if( ( $font_family = get_theme_mod( $theme_mod ) )!='' ){
            $font_family = isset( $default_fonts[$font_family] ) ? $default_fonts[$font_family] : $font_family;
            $font = array(
                'font-family'   => $font_family,
                'google'        => '1',
            );
            
            if( 'boss_heading_font_family' == $theme_mod ){
                $font['font-weight'] = '700';
                $redux_data['boss_h2_font_options'] = $font;
                $redux_data['boss_h3_font_options'] = $font;
                $redux_data['boss_h4_font_options'] = $font;
                $redux_data['boss_h5_font_options'] = $font;
            }
            
            $redux_data[$new_opt] = $font;
        }
    }
    
    /**
     * social links
     * customizer - theme mods - boss_link_facebook, boss_link_twitter, boss_link_linkedin, boss_link_googleplus, boss_link_youtube,
     * boss_link_instagram, boss_link_pinterest, boss_link_email
     * 
     * redux - boss_footer_social_links[
     *  facebook : ''
     *  twitter: ''
     *  linkedin:
     *  google-plus:
     *  youtube:
     *  instagram:
     *  pinterest:
     *  email:
     * ]
     */
    $boss_footer_social_links = array();
    $mapping = array(
        'boss_link_facebook'    => 'facebook',
        'boss_link_twitter'     => 'twitter',
        'boss_link_linkedin'    => 'linkedin',
        'boss_link_googleplus'  => 'google-plus',
        'boss_link_youtube'     => 'youtube',
        'boss_link_instagram'   => 'instagram',
        'boss_link_pinterest'   => 'pinterest',
        'boss_link_email'       => 'email',
    );
    foreach( $mapping as $theme_mod => $opt ){
        if( ( $value = get_theme_mod( $theme_mod ) ) != '' ){
            $boss_footer_social_links[$opt] = $value;
        }
    }
    $redux_data['boss_footer_social_links'] = $boss_footer_social_links;
    
    /**
     * social links 
     * customizer - options - foreach(buddyboss_get_user_social_array() as $key => $value) {
     *  'boss_show_profile_link_'.$key
     * }
     * 
     * redux - profile_social_media_links[
     *  foreach(buddyboss_get_user_social_array() as $key => $value) {
     *      $key
     *  }
     * ]
     */
    $profile_social_media_links = array();
    if( function_exists( 'buddyboss_get_user_social_array' ) ){
        global $wpdb;
        foreach( buddyboss_get_user_social_array() as $key => $label ){
            $value = true;
            //if set to false, the value in db is empty and for allowed ones, either the record in not present in options table
            //or options value is set to 1
            $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->options} WHERE option_name=%s", 'boss_show_profile_link_'.$key ) );
            if( !is_wp_error($row) && !empty( $row ) ){
                $value = $row->option_value;
            }
            
            $profile_social_media_links[$key] = $value;
        }
    }
    $redux_data['profile_social_media_links'] = $profile_social_media_links;

    $slides = boss_import_slide_cpt_to_redux();
    if( !empty( $slides ) ){
        $redux_data['boss_slider_switch'] = 1;//on
        $redux_data['boss_slides'] = $slides;
    }
    
    
    //previously saved setting, if any
    $boss_options = get_option( 'boss_options' );
    if( !empty( $boss_options ) && is_array( $boss_options ) ){
        $redux_data = wdw_merge_array_recursively( $redux_data, $boss_options );
    }


    /**
     * Now, true/false settings that we dont want to override by defaults
     */
    //name changes - mapping
    $changed_map_opts = array(
        'buddyboss_panel_hide'              => 'boss_panel_hide',
        'buddyboss_dashboard'               => 'boss_dashboard',
        'boss_adminbar '                    => 'boss_adminbar',
        'buddyboss_adminbar '               => 'boss_profile_adminbar',
        'boss_search_instead'               => 'boss_search_instead',
    );
    foreach( $changed_map_opts as $old_opt=>$new_opt ){
        $redux_data[$new_opt] = get_option( $old_opt );
        //convert boolean to string
        $redux_data[$new_opt] = $redux_data[$new_opt] && $redux_data[$new_opt] != 'false' ? '1' : '0';
    }

    //boss_inputs is reverse now( 'compatibiliy mode' is now 'Form Inputs JavaScript' )
    $redux_data['boss_inputs'] = get_option( 'boss_inputs' );
    if( $redux_data['boss_inputs'] && $redux_data['boss_inputs'] != 'false' ){
        $redux_data['boss_inputs'] = '0';
    } else {
        $redux_data['boss_inputs'] = '1';
    }

    /**
     * Finally update redux options.
     * And mark the migration complete
     */
    update_option( 'boss_options', $redux_data );
    update_option( 'boss_migrated_to_redux', '1.2.2' );
}

function boss_import_slide_cpt_to_redux(){
    /*
     * Import slides.
     * Customizer - custom posts
     * Redux - array[
            [
                'title' => 'some text',
                'description'   => 'some text',
                'button_text'   => 'some text',
                'url'           => 'http://..',
                'target'        => 1 or 0,
                'sort'          => xx,
                'attachment_id' => xx,
                'thumb'         => 'http://mydomain.com/wp-content/uploads/pic-150x150.jpg',
                'image'         => 'http://mydomain.com/wp-content/uploads/pic.jpg',
                'height'        => xxx,
                'width'         => xxx,
            ]
     ]
    */
    $slides = array();
    global $wpdb;
    $main_q = "SELECT * FROM {$wpdb->posts} WHERE post_type='buddyboss_slides' AND post_status='publish' ORDER BY post_date DESC;";
    $slider_posts = $wpdb->get_results( $main_q );

    if( !is_wp_error( $slider_posts ) && !empty( $slider_posts ) ){
        $counter = 0;

        foreach( $slider_posts as $slider_post ){
            $slide = array(
                'title'     => $slider_post->post_title,
                'sort'      => $counter,
            );

            $meta_keys_sliderfield = array(
                '_subtitle'     => 'description',
                '_text'         => 'button_text',
                '_url'          => 'url',
                '_target'       => 'target',
            );

            $slider_metas = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key IN ( '_subtitle', '_text', '_url', '_target' )", $slider_post->ID ) );
            if( !is_wp_error( $slider_metas ) && !empty( $slider_metas ) ){
                foreach( $slider_metas as $slider_meta ){
                    $slide[$meta_keys_sliderfield[$slider_meta->meta_key]] = $slider_meta->meta_value;
                }
            }

            $slide['target'] = isset( $slide['target'] ) && $slide['target'] == 'checked' ?  1 : 0;

            $slide['attachment_id'] = get_post_thumbnail_id( $slider_post->ID );
            if( $slide['attachment_id'] ){
                $image_thumb = wp_get_attachment_image_src( $slide['attachment_id'], 'thumbnail');
                if( isset( $image_thumb[0] ) )
                    $slide['thumb'] = $image_thumb[0];

                $image_full = wp_get_attachment_image_src( $slide['attachment_id'], 'full');
                if( isset( $image_full[0] ) )
                    $slide['image'] = $image_full[0];

                $attachment_meta = wp_get_attachment_metadata( $slide['attachment_id'] );

                if( isset( $attachment_meta['height'] ) )
                    $slide['height'] = $attachment_meta['height'];

                if( isset( $attachment_meta['width'] ) )
                    $slide['width'] = $attachment_meta['width'];
            }

            $slides[] = $slide;
            $counter++;
        }
    }

    return $slides;
}

if( !function_exists( 'wdw_merge_array_recursively' ) ):
/**
 * Merge given arrays, overriding $defaults array with values from $args array recursively.
 *
 * @param $args array
 * @param $defaults array
 *
 * @return array
 */
function wdw_merge_array_recursively( $args, $defaults ) {
    $merged = array();
    //first all values from args
    foreach( $args as $arg_key=>$arg_val ){
        if( is_array( $arg_val ) && array_key_exists( $arg_key, $defaults ) ){
            $merged[$arg_key] = wdw_merge_array_recursively( $arg_val, $defaults[$arg_key] );
        } else {
            if( empty( $arg_val ) && isset( $defaults[$arg_key] ) ){
                $merged[$arg_key] = $defaults[$arg_key];
            } else {
                $merged[$arg_key] = $arg_val;
            }
        }
    }

    //then all values from defaults
    foreach ( $defaults as $def_key=>$def_val ) {
        if ( !array_key_exists( $def_key, $merged ) ) {
            $merged[$def_key] = $def_val;
        }
    }

    return $merged;
}
endif;

if( !function_exists( 'buddyboss_customizer_default_fonts' ) ):
function buddyboss_customizer_default_fonts() {
	// Websafe font reference: http://www.w3schools.com/cssref/css_websafe_fonts.asp
	return array(
		'arial'     => 'Arial',
		'arimo'     => 'Arimo',
        'cabin'   => 'Cabin',
        'courier'   => 'Courier New',
        'georgia'   => 'Georgia',
		'helvetica' => 'Helvetica',
		'lato'      => 'Lato',
		'lucida'    => 'Lucida Sans Unicode',
		'montserrat'    => 'Montserrat',
        'opensans'  => 'Open Sans',
		'pacifico'  => 'Pacifico',
		'palatino'  => 'Palatino Linotype',
		'pt_sans'  => 'PT Sans',
		'raleway'  => 'Raleway',
		'source'  => 'Source Sans Pro',
        'tahoma'    => 'Tahoma',
		'times'     => 'Times New Roman',
        'trebuchet' => 'Trebuchet MS',
		'ubuntu'     => 'Ubuntu',
        'verdana'   => 'Verdana'
	);
}
endif;