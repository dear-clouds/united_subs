<?php
function woffice_sort_objects_by_name($a, $b) {
    return strcmp($a->name, $b->name);
}

function woffice_sort_objects_by_post_title($a, $b) {
    return strcmp($a->post_title, $b->post_title);
}

/**
 * Get the content of a string between two substrings
 * @param string $string
 * @param string$start
 * @param string $end
 * @return string
 */
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
 * Check if the current user is an administrator
 * @return bool
 */
function woffice_current_is_admin() {
    return (current_user_can('administrator')) ? true : false;
}

if(!class_exists('woffice_get_children_count')) {
    /**
     * Return the number of posts inside a category (recursively)
     *
     * @param $category_id
     * @param $taxonomy
     * @return int
     */
    function woffice_get_children_count($category_id, $taxonomy, $excluded = array()){
        $cat = get_category($category_id);
        $count = (int) $cat->count;
        $args = array(
            'child_of' => $category_id,
            'exclude' => $excluded
        );
        $tax_terms = get_terms($taxonomy,$args);
        foreach ($tax_terms as $tax_term) {
            $count += $tax_term->count ;
        }
        return $count;
    }
}

if(!function_exists('woffice_send_user_registration_email')) {
    /**
     * Send an email to registered user that confirm the complete registration
     *
     * @param $user_id Id of registered user
     */
    function woffice_send_user_registration_email($user_id){

        $register_new_user_email = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('register_new_user_email') : '';
        $login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : '';
        if($register_new_user_email != 'yep' || $login_custom != 'yep')
            return;

        $site_name = get_option( 'blogname' );
        $admin_email = get_option( 'admin_email' );

        $user = get_userdata( $user_id );

        //Body
        $message = sprintf(esc_html__( 'Your registration on %s is completed.', 'woffice' ), $site_name) . "\r\n\r\n";
        $message .= esc_html__('Login url:', 'woffice'). ' ' . wp_login_url()."\r\n";
        $message .= esc_html__('Username:', 'woffice') . ' ' . $user->user_login ."\r\n";
        $message .= esc_html__('Password: The password choosen during the registration');

        $message = apply_filters( 'woffice_user_registration_message_body', $message );

        //Subject
        $subject = esc_html__( 'Your registration is completed', 'woffice' );
        $subject = apply_filters( 'woffice_user_registration_message_subject', $subject );

        //Headers
        $headers = array(
            "From: \"{$site_name}\" <{$admin_email}>\n",
            "Content-Type: text/plain; charset=\"" . get_option( 'blog_charset' ) . "\"\n",
        );
        $headers = apply_filters( 'woffice_user_registration_message_headers', $headers );

        wp_mail( $user->user_email, $subject, $message, $headers );
    }
}

if(!function_exists('woffice_get_name_to_display')) {
    /**
     * Get the name to user name to display according with Woffice Buddypress Settings
     * @param null|object|int $user
     * @return string
     */
    function woffice_get_name_to_display($user = null)
    {
        if (is_null($user)) {
            $user_info = wp_get_current_user(array('fields' => array('ID', 'user_firstname', 'user_login', 'user_nicename', 'display_name')));
        } elseif (is_object($user)) {
            $user_info = $user;
        } elseif (is_numeric($user)) {
            $user_info = get_userdata($user);
        }

        $buddy_directory_name = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('buddy_directory_name') : '';
        return ($buddy_directory_name == "name" && !empty($user_info->user_firstname)) ? $user_info->user_firstname : $user_info->user_login;
    }
}

if(!function_exists('woffice_get_navigation_state')) {
    /**
     * Return the state of the navigation default state. Return true if it is showed and false if it is hidden
     * @return bool
     */
    function woffice_get_navigation_state() {
        $menu_default = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('menu_default') : '';
        $nav_opened_state = (isset($_COOKIE['Woffice_nav_position']) && $_COOKIE['Woffice_nav_position'] == 'navigation-hidden' || $menu_default == "close") ? false : true;
        return $nav_opened_state;
    }
}

if(!function_exists('woffice_get_navigation_class')) {
    /**
     * Return the class for the navigation default state. It compare the cookies and the them options
     * @return string
     */
    function woffice_get_navigation_class() {
        $nav_opened_state = woffice_get_navigation_state();
        return (!$nav_opened_state) ? ' navigation-hidden ' : '';
    }
}


if(!function_exists('woffice_display_wiki_subcategories')) {
    /**
     * Display the wiki subcategories of a given category
     *
     * @param $category_id
     * @param $enable_wiki_accordion
     * @param $wiki_sortbylike
     */
    function woffice_display_wiki_subcategories($category_id, $enable_wiki_accordion, $wiki_sortbylike)
    {
        // We check for excluded categories
        $wiki_excluded_categories = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('wiki_excluded_categories') : '';
        /*If it's not a child only*/
        $wiki_excluded_categories_ready = (!empty($wiki_excluded_categories)) ? $wiki_excluded_categories : array();

        $child_categories = get_categories(array(
            'type' => 'wiki',
            'taxonomy' => 'wiki-category',
            'parent' => $category_id,
            'exclude' => $wiki_excluded_categories_ready
        ));
        if (!empty($child_categories)) {
            foreach ($child_categories as $category_child) {

                if ($enable_wiki_accordion) {
                    echo '<li class="sub-category"><span data-toggle="collapse" data-target="#' . $category_child->slug . '" expanded="false" aria-controls="' . $category_child->slug . '">' . esc_html($category_child->name) . ' (' . woffice_get_children_count($category_child->term_id, 'wiki-category', $wiki_excluded_categories_ready) . ')</span>
                 <ul id="' . $category_child->slug . '" class="list-styled list-wiki collapse" aria-expanded="false">';
                } else {
                    echo '<li class="sub-category"><span>' . esc_html($category_child->name) . ' (' . woffice_get_children_count($category_child->term_id, 'wiki-category', $wiki_excluded_categories_ready) . ')</span>
                 <ul class="list-styled list-wiki ">';
                }

                woffice_display_wiki_subcategories($category_child->term_id, $enable_wiki_accordion, $wiki_sortbylike);
                $wiki_termchildren = get_term_children($category_child->term_id, 'wiki-category');
                $wiki_query_childes = new WP_Query(
                    array(
                        'post_type' => 'wiki',
                        'showposts' => '-1',
                        'orderby' => 'post_title',
                        'order' => 'ASC',
                        'tax_query' =>
                            array('relation' => 'AND',
                                array('taxonomy' => 'wiki-category',
                                    'field' => 'slug',
                                    'terms' => $category_child->slug,
                                    'operator' => 'IN'
                                ),
                                array('taxonomy' => 'wiki-category',
                                    'field' => 'id',
                                    'terms' => $wiki_termchildren,
                                    'operator' => 'NOT IN'
                                ),
                                array('taxonomy' => 'wiki-category',
                                    'field' => 'id',
                                    'terms' => $wiki_excluded_categories_ready,
                                    'operator' => 'NOT IN'
                                )
                            )
                    )
                );
                $wiki_array = array();
                while ($wiki_query_childes->have_posts()) : $wiki_query_childes->the_post();

                    /*WE DISPLAY IT*/
                    if (woffice_is_user_allowed_wiki()) {
                        $likes = woffice_get_wiki_likes(get_the_id());
                        $likes_display = (!empty($likes)) ? $likes : '';
                        $featured_wiki = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'featured_wiki') : '';
                        $featured_wiki_class = ($featured_wiki) ? 'featured' : '';
                        if ($wiki_sortbylike) {
                            $like = get_string_between($likes_display, '</i> ', '</span>');
                            array_push($wiki_array, array(
                                    'string' => '<li><a href="' . get_the_permalink() . '" rel="bookmark" class="' . $featured_wiki_class . '">' . get_the_title() . $likes_display . '</a></li>',
                                    'likes' => (!empty($like)) ? (int)$like : 0
                                )
                            );
                        } else {
                            echo '<li><a href="' . get_the_permalink() . '" rel="bookmark" class="' . $featured_wiki_class . '">' . get_the_title() . $likes_display . '</a></li>';
                        }

                    }

                endwhile;
                if ($wiki_sortbylike) {
                    usort($wiki_array, 'woffice_sort_objects_by_likes');
                    foreach ($wiki_array as $wiki) {
                        echo $wiki['string'];
                    }
                }
                wp_reset_postdata();


                echo '</ul></li>';

            }
        }

    }
}