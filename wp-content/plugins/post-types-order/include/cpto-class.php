<?php

    class CPTO 
        {
            var $current_post_type = null;
            
            function __construct() 
                {
                    add_action( 'admin_init',                               array(&$this, 'registerFiles'), 11 );
                    add_action( 'admin_init',                               array(&$this, 'checkPost'), 10 );
                    add_action( 'admin_menu',                               array(&$this, 'addMenu') );
                    
                    //load archive drag&drop sorting dependencies
                    add_action( 'admin_enqueue_scripts',                    array(&$this, 'archiveDragDrop'), 10 );
                    
                    add_action( 'wp_ajax_update-custom-type-order',         array(&$this, 'saveAjaxOrder') );
                    add_action( 'wp_ajax_update-custom-type-order-archive', array(&$this, 'saveArchiveAjaxOrder') );
                }

            
            /**
            * Load archive drag&drop sorting dependencies
            * 
            * Since version 1.8.8
            */
            function archiveDragDrop()
                {
                    $options          =     cpt_get_options();
                    
                    //if functionality turned off, continue
                    if( $options['archive_drag_drop']   !=      '1')
                        return;
                    
                    //if adminsort turned off no need to continue
                    if( $options['adminsort']           !=      '1')
                        return;
                    
                    $screen = get_current_screen();
                        
                    //check if the right interface
                    if(!isset($screen->post_type)   ||  empty($screen->post_type))
                        return;
                        
                    //check if post type is sortable
                    if(isset($options['show_reorder_interfaces'][$screen->post_type]) && $options['show_reorder_interfaces'][$screen->post_type] != 'show')
                        return;
                    
                    //if is taxonomy term filter return
                    if(is_category()    ||  is_tax())
                        return;
                    
                    //return if use orderby columns
                    if (isset($_GET['orderby']) && $_GET['orderby'] !=  'menu_order')
                        return false;
                        
                    //return if post status filtering
                    if (isset($_GET['post_status']))
                        return false;
                        
                    //return if post author filtering
                    if (isset($_GET['author']))
                        return false;
                    
                    //load required dependencies
                    wp_enqueue_style('cpt-archive-dd', CPTURL . '/css/cpt-archive-dd.css');
                    
                    wp_enqueue_script('jquery');
                    wp_enqueue_script('jquery-ui-sortable');
                    wp_enqueue_script('cpt', CPTURL . '/js/cpt.js', array('jquery'));    
                    
                }    
            
            function registerFiles() 
                {
                    if ( $this->current_post_type != null ) 
                        {
                            wp_enqueue_script('jQuery');
                            wp_enqueue_script('jquery-ui-sortable');
                        }
                        
                    wp_register_style('CPTStyleSheets', CPTURL . '/css/cpt.css');
                    wp_enqueue_style( 'CPTStyleSheets');
                }
            
            function checkPost() 
                {
                    if ( isset($_GET['page']) && substr($_GET['page'], 0, 17) == 'order-post-types-' ) 
                        {
                            $this->current_post_type = get_post_type_object(str_replace( 'order-post-types-', '', $_GET['page'] ));
                            if ( $this->current_post_type == null) 
                                {
                                    wp_die('Invalid post type');
                                }
                        }
                }
            
            
            /**
            * Save the order set through separate interface
            * 
            */
            function saveAjaxOrder() 
                {
                    
                    set_time_limit(600);
                    
                    global $wpdb;
                    
                    parse_str($_POST['order'], $data);
                    
                    if (is_array($data))
                    foreach($data as $key => $values ) 
                        {
                            if ( $key == 'item' ) 
                                {
                                    foreach( $values as $position => $id ) 
                                        {
                                            $data = array('menu_order' => $position);
                                            $data = apply_filters('post-types-order_save-ajax-order', $data, $key, $id);
                                            
                                            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
                                        } 
                                } 
                            else 
                                {
                                    foreach( $values as $position => $id ) 
                                        {
                                            $data = array('menu_order' => $position, 'post_parent' => str_replace('item_', '', $key));
                                            $data = apply_filters('post-types-order_save-ajax-order', $data, $key, $id);
                                            
                                            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
                                        }
                                }
                        }
                }
                
                
            /**
            * Save the order set throgh the Archive 
            * 
            */
            function saveArchiveAjaxOrder()
                {
                    
                    set_time_limit(600);
                    
                    global $wpdb;
                    
                    $post_type  =   filter_var ( $_POST['post_type'], FILTER_SANITIZE_STRING);
                    $paged      =   filter_var ( $_POST['paged'], FILTER_SANITIZE_NUMBER_INT);
                    parse_str($_POST['order'], $data);
                    
                    if (!is_array($data)    ||  count($data)    <   1)
                        die();
                    
                    //retrieve a list of all objects
                    $mysql_query    =   $wpdb->prepare("SELECT ID FROM ". $wpdb->posts ." 
                                                            WHERE post_type = %s AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
                                                            ORDER BY menu_order, post_date DESC", $post_type);
                    $results        =   $wpdb->get_results($mysql_query);
                    
                    if (!is_array($results)    ||  count($results)    <   1)
                        die();
                    
                    //create the list of ID's
                    $objects_ids    =   array();
                    foreach($results    as  $result)
                        {
                            $objects_ids[]  =   $result->ID;   
                        }
                    
                    global $userdata;
                    $objects_per_page   =   get_user_meta($userdata->ID ,'edit_post_per_page', TRUE);
                    if(empty($objects_per_page))
                        $objects_per_page   =   20;
                    
                    $edit_start_at      =   $paged  *   $objects_per_page   -   $objects_per_page;
                    $index              =   0;
                    for($i  =   $edit_start_at; $i  <   ($edit_start_at +   $objects_per_page); $i++)
                        {
                            if(!isset($objects_ids[$i]))
                                break;
                                
                            $objects_ids[$i]    =   $data['post'][$index];
                            $index++;
                        }
                    
                    //update the menu_order within database
                    foreach( $objects_ids as $menu_order   =>  $id ) 
                        {
                            $data = array(
                                            'menu_order' => $menu_order
                                            );
                            $data = apply_filters('post-types-order_save-ajax-order', $data, $menu_order, $id);
                            
                            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
                        }
                                    
                }
            

            function addMenu() 
                {
                    global $userdata;
                    //put a menu for all custom_type
                    $post_types = get_post_types();
                    
                    $options          =     cpt_get_options();
                    //get the required user capability
                    $capability = '';
                    if(isset($options['capability']) && !empty($options['capability']))
                        {
                            $capability = $options['capability'];
                        }
                    else if (is_numeric($options['level']))
                        {
                            $capability = userdata_get_user_level();
                        }
                        else
                            {
                                $capability = 'install_plugins';  
                            }
                    
                    foreach( $post_types as $post_type_name ) 
                        {
                            if ($post_type_name == 'page')
                                continue;
                                
                            //ignore bbpress
                            if ($post_type_name == 'reply' || $post_type_name == 'topic')
                                continue;
                            
                            if(is_post_type_hierarchical($post_type_name))
                                continue;
                                
                            $post_type_data = get_post_type_object( $post_type_name );
                            if($post_type_data->show_ui === FALSE)
                                continue;
                                
                            if(isset($options['show_reorder_interfaces'][$post_type_name]) && $options['show_reorder_interfaces'][$post_type_name] != 'show')
                                continue;
                            
                            if ($post_type_name == 'post')
                                add_submenu_page('edit.php', __('Re-Order', 'post-types-order'), __('Re-Order', 'post-types-order'), $capability, 'order-post-types-'.$post_type_name, array(&$this, 'SortPage') );
                            elseif ($post_type_name == 'attachment') 
                                add_submenu_page('upload.php', __('Re-Order', 'post-types-order'), __('Re-Order', 'post-types-order'), $capability, 'order-post-types-'.$post_type_name, array(&$this, 'SortPage') ); 
                            else
                                {
                                    add_submenu_page('edit.php?post_type='.$post_type_name, __('Re-Order', 'post-types-order'), __('Re-Order', 'post-types-order'), $capability, 'order-post-types-'.$post_type_name, array(&$this, 'SortPage') );    
                                }
                        }
                }
            

            function SortPage() 
                {
                    ?>
                    <div id="cpto" class="wrap">
                        <div class="icon32" id="icon-edit"><br></div>
                        <h2><?php echo $this->current_post_type->labels->singular_name . ' -  '. __('Re-Order', 'post-types-order') ?></h2>

                        <?php cpt_info_box(); ?>  
                        
                        <div id="ajax-response"></div>
                        
                        <noscript>
                            <div class="error message">
                                <p><?php _e('This plugin can\'t work without javascript, because it\'s use drag and drop and AJAX.', 'post-types-order') ?></p>
                            </div>
                        </noscript>
                        
                        <div id="order-post-type">
                            <ul id="sortable">
                                <?php $this->listPages('hide_empty=0&title_li=&post_type='.$this->current_post_type->name); ?>
                            </ul>
                            
                            <div class="clear"></div>
                        </div>
                        
                        <p class="submit">
                            <a href="javascript: void(0)" id="save-order" class="button-primary"><?php _e('Update', 'post-types-order' ) ?></a>
                        </p>
                        
                        <script type="text/javascript">
                            jQuery(document).ready(function() {
                                jQuery("#sortable").sortable({
                                    'tolerance':'intersect',
                                    'cursor':'pointer',
                                    'items':'li',
                                    'placeholder':'placeholder',
                                    'nested': 'ul'
                                });
                                
                                jQuery("#sortable").disableSelection();
                                jQuery("#save-order").bind( "click", function() {
                                    
                                    jQuery("html, body").animate({ scrollTop: 0 }, "fast");
                                    
                                    jQuery.post( ajaxurl, { action:'update-custom-type-order', order:jQuery("#sortable").sortable("serialize") }, function() {
                                        jQuery("#ajax-response").html('<div class="message updated fade"><p><?php _e('Items Order Updated', 'post-types-order') ?></p></div>');
                                        jQuery("#ajax-response div").delay(3000).hide("slow");
                                    });
                                });
                            });
                        </script>
                        
                    </div>
                    <?php
                }

            function listPages($args = '') 
                {
                    $defaults = array(
                        'depth'             => -1, 
                        'show_date'         => '',
                        'date_format'       => get_option('date_format'),
                        'child_of'          => 0, 
                        'exclude'           => '',
                        'title_li'          => __('Pages'), 
                        'echo'              => 1,
                        'authors'           => '', 
                        'sort_column'       => 'menu_order',
                        'link_before'       => '', 
                        'link_after'        => '', 
                        'walker'            => '',
                        'post_status'       =>  'any' 
                    );

                    $r = wp_parse_args( $args, $defaults );
                    extract( $r, EXTR_SKIP );

                    $output = '';
                
                    $r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);
                    $exclude_array = ( $r['exclude'] ) ? explode(',', $r['exclude']) : array();
                    $r['exclude'] = implode( ',', apply_filters('wp_list_pages_excludes', $exclude_array) );

                    // Query pages.
                    $r['hierarchical'] = 0;
                    $args = array(
                                'sort_column'       =>  'menu_order',
                                'post_type'         =>  $post_type,
                                'posts_per_page'    => -1,
                                'post_status'       =>  'any',
                                'orderby'            => array(
                                                            'menu_order'    => 'ASC',
                                                            'post_date'     =>  'DESC'
                                                            )
                    );
                    
                    $the_query = new WP_Query($args);
                    $pages = $the_query->posts;

                    if ( !empty($pages) ) 
                        {
                            $output .= $this->walkTree($pages, $r['depth'], $r);
                        }

                    $output = apply_filters('wp_list_pages', $output, $r);

                    if ( $r['echo'] )
                        echo $output;
                    else
                        return $output;
                }
            
            function walkTree($pages, $depth, $r) 
                {
                    if ( empty($r['walker']) )
                        $walker = new Post_Types_Order_Walker;
                    else
                        $walker = $r['walker'];

                    $args = array($pages, $depth, $r);
                    return call_user_func_array(array(&$walker, 'walk'), $args);
                }
        }
   



?>