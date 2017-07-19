<?php
if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" ) {
    add_action('admin_menu', 'mom_mega_menu_style');
}

function mom_mega_menu_style()
{
                    wp_enqueue_style(  'mom_mega_menu_style', MOM_URI. '/framework/menus/admin_menu.css'); 
		    wp_enqueue_media();
		    wp_enqueue_style( 'wp-color-picker' );
                    wp_enqueue_script( 'wp-color-picker' );
                    wp_enqueue_script(  'mom_mega_menu', MOM_URI. '/framework/menus/admin_menu.js'); 
}

/**
 * @package nav-menu-custom-fields
 * @version 0.1.0
 */
/*
Plugin Name: Nav Menu Custom Fields
*/

/*
 * Saves new field to postmeta for navigation
 */
add_action('wp_update_nav_menu_item', 'custom_nav_update',10, 3);
function custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    if (isset($_REQUEST['menu-item-mtype']) ) {
        if ( is_array($_REQUEST['menu-item-mtype']) ) {
            $custom_value = $_REQUEST['menu-item-mtype'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_mtype', $custom_value );
        }
    }

    if (isset($_REQUEST['menu-item-mcats_layout']) ) {
        if ( is_array($_REQUEST['menu-item-mcats_layout']) ) {
            $custom_value = $_REQUEST['menu-item-mcats_layout'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_mcats_layout', $custom_value );
        }
    }

    if (isset($_REQUEST['menu-item-mcustom']) ) {
        if ( is_array($_REQUEST['menu-item-mcustom']) ) {
            $custom_value = $_REQUEST['menu-item-mcustom'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_mcustom', $custom_value );
        }
    }


    if (isset($_REQUEST['menu-item-micon']) ) {
        if ( is_array($_REQUEST['menu-item-micon']) ) {
            $icon_value = $_REQUEST['menu-item-micon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_micon', $icon_value );
        }
    }

    if (isset($_REQUEST['menu-item-mdisplay']) ) {
        if ( is_array($_REQUEST['menu-item-mdisplay']) ) {
            $icon_value = $_REQUEST['menu-item-mdisplay'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_mdisplay', $icon_value );
        }
    }
    
	if (isset($_REQUEST['menu-item-mcolor']) ) {
        if ( is_array($_REQUEST['menu-item-mcolor']) ) {
            $icon_value = $_REQUEST['menu-item-mcolor'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_mcolor', $icon_value );
        }
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */
add_filter( 'wp_setup_nav_menu_item','custom_nav_item' );
function custom_nav_item($menu_item) {
    $menu_item->mtype = get_post_meta( $menu_item->ID, '_menu_item_mtype', true );
    $menu_item->mcats_layout = get_post_meta( $menu_item->ID, '_menu_item_mcats_layout', true );
    $menu_item->mcustom = get_post_meta( $menu_item->ID, '_menu_item_mcustom', true );
    $menu_item->micon = get_post_meta( $menu_item->ID, '_menu_item_micon', true );
    $menu_item->mdisplay = get_post_meta( $menu_item->ID, '_menu_item_mdisplay', true );
    $menu_item->mcolor = get_post_meta( $menu_item->ID, '_menu_item_mcolor', true );   
    
    return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'custom_nav_edit_walker',10,2 );
function custom_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}

/**
 * Copied from Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
/**
 * @see Walker_Nav_Menu::start_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function start_lvl(&$output, $depth = 0, $args = Array()) {}

/**
 * @see Walker_Nav_Menu::end_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function end_lvl(&$output, $depth = 0, $args = Array()) {
}

/**
 * @see Walker::start_el()
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param object $item Menu item data object.
 * @param int $depth Depth of menu item. Used for padding.
 * @param object $args
 */
function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0) {
    global $_wp_nav_menu_max_depth;
    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        /* translators: %s: title of menu item which is invalid */
        $title = sprintf( __( '%s (Invalid)', 'framework' ), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        /* translators: %s: title of menu item in draft status */
        $title = sprintf( __('%s (Pending)', 'framework'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'framework'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item', 'framework' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL', 'framework' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label', 'framework' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute', 'framework' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab', 'framework' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)', 'framework' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)', 'framework' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description', 'framework' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'framework'); ?></span>
                </label>
            </p>        
            <?php
            /*
             * This is the added fields
             */
            ?>      
            <p class="field-mtype description description-wide">
                <label for="edit-menu-item-mtype-<?php echo $item_id; ?>">
                    <?php _e( 'Dropdown Menu Type', 'framework' ); ?><br />
                    <select id="edit-menu-item-mtype-<?php echo $item_id; ?>" class="widefat code edit-menu-item-mtype" name="menu-item-mtype[<?php echo $item_id; ?>]">
                        <option value="" <?php selected( $item->mtype, '' ); ?>><?php _e( 'Default', 'framework' ); ?></option>
                        <option value="mega" <?php selected( $item->mtype, 'mega' ); ?>><?php _e( 'Mega Menu', 'framework' ); ?></option>
                        <option value="cats" <?php selected( $item->mtype, 'cats' ); ?>><?php _e( 'Category Menu', 'framework' ); ?></option>
                        <option value="custom" <?php selected( $item->mtype, 'custom' ); ?>><?php _e( 'Custom Mega Menu', 'framework' ); ?></option>
                    </select>
                </label>
            </p>
            
            <p class="field-mcats_layout description description-wide hide">
                <label for="edit-menu-item-mcats_layout-<?php echo $item_id; ?>">
                    <?php _e( 'Ctaegories Posts layout', 'framework' ); ?><br />
                    <select id="edit-menu-item-mcats_layout-<?php echo $item_id; ?>" class="widefat code edit-menu-item-mcats_layout" name="menu-item-mcats_layout[<?php echo $item_id; ?>]">
                        <option value="" <?php selected( $item->mcats_layout, '' ); ?>><?php _e( 'Vertical', 'framework' ); ?></option>
                        <option value="horz" <?php selected( $item->mcats_layout, 'horz' ); ?>><?php _e( 'Horizontal', 'framework' ); ?></option>
                    </select>
                </label>
            </p>
            
            <p class="field-mcustom description description-wide hide">
                <label for="edit-menu-item-mcustom-<?php echo $item_id; ?>">
                    <?php _e( 'Custom Mega Menu Content', 'framework' ); ?><br />
                    <textarea id="edit-menu-item-mcustom-<?php echo $item_id; ?>" class="widefat edit-menu-item-mcustom" rows="3" cols="20" name="menu-item-mcustom[<?php echo $item_id; ?>]"><?php echo $item->mcustom; ?></textarea>
                    <small><?php _e('custom text, HTML or Shortcodes note: all items under this menu will disappear', 'framework'); ?></small>
                </label>
            </p>
            
            <p class="field-micon description description-wide">
                <label for="edit-menu-item-micon-<?php echo $item_id; ?>">
             
             <?php _e( 'Menu Item Icon', 'framework' ); ?><br />
		<div class="mom_icons_selector">
                        <a class="mom_select_icon_menu button" data-id="<?php echo $item_id; ?>"><?php _e('Select Icon','framework'); ?></a> <span class="or">or</span> <a class="mom_upload_icon_menu button simptip-position-top simptip-movable simptip-multiline" data-tooltip="<?php _e('Best Icon sizes is : 24px for icon only and 18px for icon with label', 'framework'); ?>" data-id="<?php echo $item_id; ?>"><?php _e('Upload Custom Icon','framework'); ?></a>

		<span class="mom_icon_prev"><i></i><a href="#" class="remove_icon enotype-icon-cross2" title="Remove Icon"></a></span>
</span>
                    <input type="hidden" id="edit-menu-item-micon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-micon mom_icon_holder" name="menu-item-micon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->micon ); ?>" \>
                </div>
                </label>
            </p>
                  
            <p class="field-mdisplay description description-wide">
                <label for="edit-menu-item-mdisplay-<?php echo $item_id; ?>">
                    <?php _e( 'Display', 'framework' ); ?><br />
                    <select id="edit-menu-item-mdisplay-<?php echo $item_id; ?>" class="widefat code edit-menu-item-mdisplay" name="menu-item-mdisplay[<?php echo $item_id; ?>]">
                        <option value="" <?php selected( $item->mdisplay, '' ); ?>><?php _e( 'All (label & icon)', 'framework' ); ?></option>
                        <option value="icon" <?php selected( $item->mdisplay, 'icon' ); ?>><?php _e( 'Icon Only', 'framework' ); ?></option>
                        <option value="none" <?php selected( $item->mdisplay, 'none' ); ?>><?php _e( 'None (hide icon and label)', 'framework' ); ?></option>
                    </select>
                </label>
            </p>
            
			<p class="field-mcolor description description-wide">
                <label for="edit-menu-item-mcolor-<?php echo $item_id; ?>">
                    <?php _e( 'Menu item Color', 'framework' ); ?><br />
                    <input type="text" id="edit-menu-item-mcolor-<?php echo $item_id; ?>" class="widefat mom-color-field edit-menu-item-mcolor" name="menu-item-mcolor[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->mcolor ); ?>" />
                <br><span class="description cat_only"><?php _e('don\'t use this field if you select main color from "category" or "page".', 'framework'); ?></span>

                </label>
            </p>
			
            <?php
            /*
             * end added field
             */
            ?>

                <?php 
                // This is the added section
                do_action( 'mom_menu_roles_custom_fields', $item_id, $item, $depth, $args );
                // end added section 
                ?>


             <p class="field-move hide-if-no-js description description-wide">
                    <label>
                            <span><?php _e( 'Move', 'framework' ); ?></span>
                            <a href="#" class="menus-move-up"><?php _e( 'Up one', 'framework' ); ?></a>
                            <a href="#" class="menus-move-down"><?php _e( 'Down one', 'framework' ); ?></a>
                            <a href="#" class="menus-move-left"></a>
                            <a href="#" class="menus-move-right"></a>
                            <a href="#" class="menus-move-top"><?php _e( 'To the top', 'framework' ); ?></a>
                    </label>
            </p>

            
            
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s', 'framework'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove', 'framework'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'framework'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php
    $output .= ob_get_clean();
    }
}

/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class mom_custom_walker extends Walker_Nav_Menu
{
        var $columns = 0;
        var $max_columns = 0;
        var $rows = 1;
        var $rowsCount = array();
        private $in_sub_menu = 0;
        
     
     
       /**
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            
            $output .= "\n$indent<ul class=\"sub-menu {locate_class}\">\n";
        }
        
        /**
         * @see Walker::end_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
            
            if($depth === 0) 
            {
                if($this->mom_mega == 'mega')
                {
                    $output = str_replace("{locate_class}", "mom_mega_wrap mom_mega_col_".$this->max_columns."", $output);
                    
                    foreach($this->rowsCount as $row => $columns)
                    {
                        $output = str_replace("{current_row_".$row."}", "mom_megamenu_columns_".$columns, $output);
                    }
                    
                    $this->columns = 0;
                    $this->max_columns = 0;
                    $this->rowsCount = array();
                    
                }
                else
                {
                    $output = str_replace("{locate_class}", "", $output);
                }
            }
        }    
    
    function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0)
      {
           global $wp_query;

        // Detect first child of submenu then add class active
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
           $class_names = $value = '';
           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $mega_class ='';
           if ($depth === 0 && $item->mtype === 'mega') {
            $mega_class = ' mom_mega';
           } elseif ($depth === 0 && $item->mtype === 'cats' && $item->object === 'category') {
            $mega_class = ' mom_mega_cats';
           } elseif ($depth === 0 && $item->mtype === 'custom') {
            $mega_class = ' mom_mega';
           }
        
        if ($depth === 1 && $this->mom_mega === 'mega') {
            $mega_class = ' mega_column mega_col_title';
        }
        
        $icon_class = '';
        if ($item->mdisplay == 'icon') {
            $icon_class = ' menu-item-iconsOnly';
        }
        
        if( $depth == 1 ) {
            if( ! $this->in_sub_menu ) {
                $mega_class .= ' active'; 
                $this->in_sub_menu = 1;
            }
        }
        if( $depth == 0 ) {
            $this->in_sub_menu = 0;
        }// End addition of active class for first item 




           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names.$mega_class.$icon_class." menu-item-depth-".$depth  ) . '"';
           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $prepend = '';
           $append = '';
           $description  = '';
           if($depth != 0)
           {
	           $description = $append = $prepend = "";
           }
           $menu_color = '';
            if($depth === 0)
            {   
                $this->mom_mega = get_post_meta( $item->ID, '_menu_item_mtype', true);
		$cl = $item->mcolor;
		if ($item->object == 'category') {
		    $cat_ID = $item->object_id;
		    $cat_data = get_option("category_".$cat_ID);
		    $cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;
		    if ($cat_color != '') {
			$cl = $cat_color;
		    }
		} elseif ($item->object == 'page') {
		    $page_color = get_post_meta($item->object_id, 'mom_page_color', true);
		    if ($page_color != '') {
			$cl = $page_color;
		    }
		}
                $menu_color  = '<span class="menu_bl" style="background:'.$cl.';"></span>';
            }
            if($depth === 1 && $this->mom_mega === 'mega')
            {
                $this->columns ++;
                

                $this->rowsCount[$this->rows] = $this->columns;
                
                if($this->max_columns < $this->columns) $this->max_columns = $this->columns;
                
                $title = apply_filters( 'the_title', $item->title, $item->ID );

                if($title != "-" && $title != '"-"')
                {
            //display
		$menu_icon = '';
                if ($item->mdisplay == 'icon') {
		    if (!empty( $item->micon )) {
			if (0 === strpos($item->micon, 'http')) {
			    $menu_icon = '<i class="icon_only img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
			} else {
                            $menu_icon  = '<i class="icon_only '.esc_attr( $item->micon ).'"></i>';
			}
		    }
$the_link = '<span class="icon_only_label">'.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after.'</span>';
                } elseif ($item->mdisplay == 'none') {
                        $menu_icon  = '';
                        $the_link = '';
                } else {
		    if (!empty( $item->micon )) {
			if (0 === strpos($item->micon, 'http')) {
			    $menu_icon = '<i class="img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
			} else {
                            $menu_icon  = '<i class="'.esc_attr( $item->micon ).'"></i>';
			}
		    }
		    $the_link = $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after;
                }

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $item_output = $args->before;
            if ($item->mdisplay != 'none') {
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $menu_icon.$the_link.$menu_color;
            $item_output .= '</a>';
            }
            $item_output .= $args->after;
                }
                
                $column_class  = ' {current_row_'.$this->rows.'}';
                
                if($this->columns == 1)
                {
                    $column_class  .= " mom_mega_first_column";
                }
            } else {

            //display
            		$menu_icon = '';

                if ($item->mdisplay == 'icon') {
		    if (!empty( $item->micon )) {
			if (0 === strpos($item->micon, 'http')) {
			    $menu_icon = '<i class="icon_only img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
			} else {
                            $menu_icon  = '<i class="icon_only '.esc_attr( $item->micon ).'"></i>';
			}

		    }
		    $the_link = '<span class="icon_only_label">'.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after.'</span>';
                } elseif ($item->mdisplay == 'none') {
                        $menu_icon  = '';
                        $the_link = '';
                } else {
		    if (!empty( $item->micon )) {
			if (0 === strpos($item->micon, 'http')) {
			    $menu_icon = '<i class="img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
			} else {
                            $menu_icon  = '<i class="'.esc_attr( $item->micon ).'"></i>';
			}
		    }
                        if ($depth !== 0 && empty( $item->micon ) && $this->mom_mega === 'mega') {
                            if (is_rtl()) {
                                $menu_icon = '<i class="enotype-icon-arrow-left6 mega_menu_arrow_holder"></i>';
                            } else {
                                $menu_icon = '<i class="enotype-icon-arrow-right6 mega_menu_arrow_holder"></i>';
                            }
                        }
                        $the_link = $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after;
                }
                

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            $item_output = $args->before;
            if ($item->mdisplay != 'none') {
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $menu_icon.$the_link.$menu_color;
            $item_output .= '</a>';
            }
            $item_output .= $args->after;
            }
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                        if( $depth == 0 && $item->object == 'category' ) {
                if ($item->mtype =='cats') {
                                    if ($item->mcats_layout == 'horz') {
                                        $layout_class = 'sub-mom-megamenu';
                                    } else {
                                        $layout_class = 'sub-mom-megamenu2';
                                    }
                    $output .= "<div class=\"mom-megamenu cats-mega-wrap\">\n";
                } 
            }
            if ($item->mtype =='custom') {
                    $output .= "<div class='mom_custom_mega mom_mega_wrap'>\n";
            }

    } // start el
    
function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if($depth==0 &&  $item->object == 'category'){
                if ($item->mtype =='cats') {
                                if ($item->mcats_layout == 'horz') {
                                    $layout_class = 'sub-mom-megamenu sub-cat-megamenu';
                                } else {
                                    $layout_class = 'sub-mom-megamenu2 sub-cat-megamenu';
                                }
			$output .= "<div class='".$layout_class."'>";
			
		for ($i=0; $i<count($item->children);$i++) {
			$child = $item->children[$i];
			$output .="<div class='".(($i===0)?'active':'')." mom-cat-latest' id='mom-mega-cat-".$child->ID."' data-id='".$child->object_id."' data-object='".$item->object."' data-layout='".$item->mcats_layout."'>";
			$output .="<ul id='mom-mega-ul-cat-".$child->ID."'>";
            if ($i == 0) {
                $output .= mom_mega_menu_cats_loop ($item->object, $item->mcats_layout, $child->object_id);
            }
			  $output .= "</ul>";
			  		$cl = $item->mcolor;
		if ($item->object == 'category') {
		    $cat_ID = $item->object_id;
		    $cat_data = get_option("category_".$cat_ID);
		    $cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;
		    if ($cat_color != '') {
			$cl = $cat_color;
		    }
		} elseif ($item->object == 'page') {
		    $page_color = get_post_meta($item->object_id, 'mom_page_color', true);
		    if ($page_color != '') {
			$cl = $page_color;
		    }
		}
			  if(is_rtl()) { 
				$output .= "<a style='background:".esc_attr( $cl )."' href='".$item->url."' title='".$item->attr_title."' class='view-all-link'>".__('View all', 'framework')."<i class='enotype-icon-arrow-left8'></i></a>";
			  } else {
				$output .= "<a style='background:".esc_attr( $cl )."' href='".$item->url."' title='".$item->attr_title."' class='view-all-link'>".__('View all', 'framework')."<i class='enotype-icon-arrow-right7'></i></a>";	 
			  }
			  $output .= "</div>";
			}
			
			$output .= "</div> \n</div>\n";
                                }
		}
		else{

		}
           if ($depth == 0 && $item->mtype =='custom') {
                    $output .= do_shortcode($item->mcustom);
                    $output .= "</div>\n";
            }
			if ($item->children) {
				$output .= "<i class='responsive-caret'></i>\n";
            }
		$output .= "</li>\n";
	}

    
} //end of walker class


add_filter( 'wp_nav_menu_objects', 'add_menu_child_items' );
function add_menu_child_items( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		$item->children = array();
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item'; 
	
			foreach ( $items as $citem ) {
				if ( $citem->menu_item_parent && $citem->menu_item_parent == $item->ID ) {
					$item->children[] = $citem;
				}
			}
		}
	}
	
	return $items;    
}

class mom_topmenu_custom_walker extends Walker_Nav_Menu {
    	function end_el( &$output, $item, $depth = 0, $args = array() ) {
            	if ($item->children) {
				$output .= "<i class='responsive-caret'></i>\n";
				}
            	$output .= "</li>\n";
            	
	}
}

// Ajax categories

add_action( 'wp_ajax_mmcl', 'mom_mega_menu_cats_loop' );  
add_action( 'wp_ajax_nopriv_mmcl', 'mom_mega_menu_cats_loop');

function mom_mega_menu_cats_loop ($object = '', $layout = '', $id = '') {
    if ($object == '') { $object = $_POST['object']; }
    if ($layout == '') {$layout = isset($_POST['layout']) ? $_POST['layout']: '';}
    if($id =='') {$id = $_POST['id'];}

    
	if ($layout == 'horz') {
	    $post_count = mom_option('cm_counter');
	    $sep = '';
	    $img_size = 'megamenu-thumb';
	} else {
	    $post_count = mom_option('cm_counter');
	    $sep = '-';
	    $img_size = 'megamenu-thumb';
	}

    $output = '';
    $r = new WP_Query( 	array( 
	    'posts_per_page'    => $post_count, 
	    'no_found_rows'         => true,
	    'cache_results' => false, 
	    'post_status'           => 'publish',
	    'post_type' =>     'post', 
	    'cat'              =>      $id
	)  );
    update_post_thumbnail_cache( $r );

      if ($r->have_posts()) :
		    while ( $r->have_posts() ) {
			$r->the_post();
			    $output.= "<li><figure><a href='".get_permalink()."' title='".get_the_title()."'><img src='".mom_post_image($img_size)."' alt='menu' width='112' height='75'></a></figure><h2><a href='".get_permalink()."' title='".get_the_title()."'> ".get_the_title()."</a></h2></li>";
			} 
		    // Reset the global $the_post as this query will have stomped on it
		    wp_reset_postdata();

	    endif;
    if (isset($_POST['id'])) {      
    echo $output;
    } else {
        return $output;
    }
  
    if (isset($_POST['id'])) {
    exit();
    }
}


//responsive custom walker
class mom_mobile_custom_walker extends mom_custom_walker
{
        function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0)
      {
           global $wp_query;

        // Detect first child of submenu then add class active
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
           $class_names = $value = '';
           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $mega_class ='';
           if ($depth === 0 && $item->mtype === 'mega') {
            $mega_class = ' mom_mega';
           } elseif ($depth === 0 && $item->mtype === 'cats' && $item->object === 'category') {
            $mega_class = ' mom_mega_cats';
           } elseif ($depth === 0 && $item->mtype === 'custom') {
            $mega_class = ' mom_mega';
           }
        
        if ($depth === 1 && $this->mom_mega === 'mega') {
            $mega_class = ' mega_column mega_col_title';
        }
        
        $icon_class = '';
        if ($item->mdisplay == 'icon') {
            $icon_class = ' menu-item-iconsOnly';
        }
        
        if( $depth == 1 ) {
            if( ! $this->in_sub_menu ) {
                $mega_class .= ' active'; 
                $this->in_sub_menu = 1;
            }
        }
        if( $depth == 0 ) {
            $this->in_sub_menu = 0;
        }// End addition of active class for first item 




           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names.$mega_class.$icon_class." menu-item-depth-".$depth  ) . '"';
           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $prepend = '';
           $append = '';
           $description  = '';
           if($depth != 0)
           {
               $description = $append = $prepend = "";
           }
           $menu_color = '';
            if($depth === 0)
            {   
                $this->mom_mega = get_post_meta( $item->ID, '_menu_item_mtype', true);
        $cl = $item->mcolor;
        if ($item->object == 'category') {
            $cat_ID = $item->object_id;
            $cat_data = get_option("category_".$cat_ID);
            $cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;
            if ($cat_color != '') {
            $cl = $cat_color;
            }
        } elseif ($item->object == 'page') {
            $page_color = get_post_meta($item->object_id, 'mom_page_color', true);
            if ($page_color != '') {
            $cl = $page_color;
            }
        }
                $menu_color  = '<span class="menu_bl" style="background:'.$cl.';"></span>';
            }
            if($depth === 1 && $this->mom_mega === 'mega')
            {
                $this->columns ++;
                

                $this->rowsCount[$this->rows] = $this->columns;
                
                if($this->max_columns < $this->columns) $this->max_columns = $this->columns;
                
                $title = apply_filters( 'the_title', $item->title, $item->ID );

                if($title != "-" && $title != '"-"')
                {
            //display
        $menu_icon = '';
                if ($item->mdisplay == 'icon') {
            if (!empty( $item->micon )) {
            if (0 === strpos($item->micon, 'http')) {
                $menu_icon = '<i class="icon_only img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
            } else {
                            $menu_icon  = '<i class="icon_only '.esc_attr( $item->micon ).'"></i>';
            }
            }
$the_link = '<span class="icon_only_label">'.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after.'</span>';
                } elseif ($item->mdisplay == 'none') {
                        $menu_icon  = '';
                        $the_link = '';
                } else {
            if (!empty( $item->micon )) {
            if (0 === strpos($item->micon, 'http')) {
                $menu_icon = '<i class="img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
            } else {
                            $menu_icon  = '<i class="'.esc_attr( $item->micon ).'"></i>';
            }
            }
            $the_link = $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after;
                }

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $item_output = $args->before;
            if ($item->mdisplay != 'none') {
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $menu_icon.$the_link.$menu_color;
            $item_output .= '</a>';
            }
            $item_output .= $args->after;
                }
                
                $column_class  = ' {current_row_'.$this->rows.'}';
                
                if($this->columns == 1)
                {
                    $column_class  .= " mom_mega_first_column";
                }
            } else {

            //display
                    $menu_icon = '';

                if ($item->mdisplay == 'icon') {
            if (!empty( $item->micon )) {
            if (0 === strpos($item->micon, 'http')) {
                $menu_icon = '<i class="icon_only img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
            } else {
                            $menu_icon  = '<i class="icon_only '.esc_attr( $item->micon ).'"></i>';
            }

            }
            $the_link = '<span class="icon_only_label">'.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after.'</span>';
                } elseif ($item->mdisplay == 'none') {
                        $menu_icon  = '';
                        $the_link = '';
                } else {
            if (!empty( $item->micon )) {
            if (0 === strpos($item->micon, 'http')) {
                $menu_icon = '<i class="img_icon" style="background-image: url('.esc_attr( $item->micon ).')"></i>';
            } else {
                            $menu_icon  = '<i class="'.esc_attr( $item->micon ).'"></i>';
            }
            }
                        if ($depth !== 0 && empty( $item->micon ) && $this->mom_mega === 'mega') {
                            if (is_rtl()) {
                                $menu_icon = '<i class="enotype-icon-arrow-left6 mega_menu_arrow_holder"></i>';
                            } else {
                                $menu_icon = '<i class="enotype-icon-arrow-right6 mega_menu_arrow_holder"></i>';
                            }
                        }
                        $the_link = $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.$args->link_after;
                }
                

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            $item_output = $args->before;
            if ($item->mdisplay != 'none') {
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $menu_icon.$the_link.$menu_color;
            $item_output .= '</a>';
            }
            $item_output .= $args->after;
            }
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                        if( $depth == 0 && $item->object == 'category' ) {
                if ($item->mtype =='cats') {
                                    if ($item->mcats_layout == 'horz') {
                                        $layout_class = 'sub-mom-megamenu';
                                    } else {
                                        $layout_class = 'sub-mom-megamenu2';
                                    }
                } 
            }
            if ($item->mtype =='custom') {
                    $output .= "<div class='mom_custom_mega mom_mega_wrap'>\n";
            }


    } // start el
    
    
function end_el( &$output, $item, $depth = 0, $args = array() ) {
           if ($depth == 0 && $item->mtype =='custom') {
                    $output .= do_shortcode($item->mcustom);
                    $output .= "</div>\n";
            }
            if ($item->children) {
                $output .= "<i class='responsive-caret'></i>\n";
            }
        $output .= "</li>\n";
}
    
} //end of walker class

// cashing menu
/*
Plugin Name: GWP Menu Cache
Plugin URI:
Description: A plugin to cache WordPress menus using the Transients API, based on this tutorial http://generatewp.com/?p=10473
Version: 1.0
Author: Ohad Raz
Author URI: http://generatewp.com
*/
/**
* mom_GWP_menu_cache
*/
class mom_GWP_menu_cache{
    /**
     * $cache_time
     * transient expiration time
     * @var int
     */
    public $cache_time = 43200; // 12 hours in seconds
    /**
     * $timer
     * simple timer to time the menu generation
     * @var time
     */
    public $timer;
     
    /**
     * __construct
     * class constructor will set the needed filter and action hooks
     *
     */
    function __construct(){
        global $wp_version;
        // only do all of this if WordPress version is 3.9+
        if ( version_compare( $wp_version, '3.9', '>=' ) ) {
 
            //show the menu from cache
            add_filter( 'pre_wp_nav_menu', array($this,'pre_wp_nav_menu'), 10, 2 );
            //store the menu in cache
            add_filter( 'wp_nav_menu', array($this,'wp_nav_menu'), 10, 2);
            //refresh on update
            add_action( 'wp_update_nav_menu', array($this,'wp_update_nav_menu'), 10, 1);
        }
    }
     
    /**
     * get_menu_key
     * Simple function to generate a unique id for the menu transient
     * based on the menu arguments and currently requested page.
     * @param  object $args     An object containing wp_nav_menu() arguments.
     * @return string
     */
    function get_menu_key($args){
        return 'MC-' . md5( serialize( $args ).serialize(get_queried_object()) );
    }
     
    /**
     * get_menu_transient
     * Simple function to get the menu transient based on menu arguments
     * @param  object $args     An object containing wp_nav_menu() arguments.
     * @return mixed            menu output if exists and valid else false.
     */
    function get_menu_transient($args){
        $key = $this->get_menu_key($args);
        return get_transient($key);
    }
  
 
  
    /**
     * pre_wp_nav_menu
     *
     * This is the magic filter that lets us short-circit the menu generation
     * if we find it in the cache so anything other then null returend will skip the menu generation.
     *
     * @param  string|null $nav_menu    Nav menu output to short-circuit with.
     * @param  object      $args        An object containing wp_nav_menu() arguments
     * @return string|null
     */
    function pre_wp_nav_menu($nav_menu, $args){
        $this->timer = microtime(true);
        $in_cache = $this->get_menu_transient($args);
        $last_updated = get_transient('MC-' . $args->theme_location . '-updated');
        if (isset($in_cache['data']) && isset($last_updated) &&  $last_updated < $in_cache['time'] ){
            return $in_cache['data'].'<!-- From menu cache in '.number_format( microtime(true) - $this->timer, 5 ).' seconds -->';
        }
        return $nav_menu;
    }
  
     
    /**
     * wp_nav_menu
     * store menu in cache
     * @param  string $nav      The HTML content for the navigation menu.
     * @param  object $args     An object containing wp_nav_menu() arguments
     * @return string           The HTML content for the navigation menu.
     */
    function wp_nav_menu( $nav, $args ) {
        $last_updated = get_transient('MC-' . $args->theme_location . '-updated');
        if( ! $last_updated ) {
            set_transient('MC-' . $args->theme_location . '-updated', time());
        }
        $key = $this->get_menu_key($args);
        $data = array('time' => time(), 'data' => $nav);
         
        set_transient( $key, $data ,$this->cache_time);
        return $nav.'<!-- Not From menu cache in '.number_format( microtime(true) - $this->timer, 5 ).' seconds -->';
    }
  
    /**
     * wp_update_nav_menu
     * refresh time on update to force refresh of cache
     * @param  int $menu_id
     * @return void
     */
    function wp_update_nav_menu($menu_id) {
        $locations = array_flip(get_nav_menu_locations());
  
        if( isset($locations[$menu_id]) ) {
            set_transient('MC-' . $locations[$menu_id] . '-updated', time());
        }
    }
  
}//end class

/****************************************************
        Menu items display roles

        Thank's to: https://wordpress.org/plugins/nav-menu-roles/
****************************************************/

    add_action('mom_menu_roles_custom_fields', 'mom_menu_roles_custom_fields', 10, 4);
    function mom_menu_roles_custom_fields( $item_id, $item, $depth, $args ) {
        global $wp_roles;

        /**
        * Pass the menu item to the filter function.
        * This change is suggested as it allows the use of information from the menu item (and
        * by extension the target object) to further customize what filters appear during menu
        * construction.
        */
        $display_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names, $item );


        /**
        * If no roles are being used, don't display the role selection radio buttons at all.
        * Unless something deliberately removes the WordPress roles from this list, nothing will
        * be functionally altered to the end user.
        * This change is suggested for the benefit of users constructing granular admin permissions
        * using extensive custom roles as it is an effective means of stopping admins with partial
        * permissions to the menu from accidentally removing all restrictions from a menu item to
        * which they do not have access.
        */
        if( ! $display_roles ) return;

        /* Get the roles saved for the post. */
        $roles = get_post_meta( $item->ID, '_nav_menu_role', true );

        // by default nothing is checked (will match "everyone" radio)
        $logged_in_out = '';

        // specific roles are saved as an array, so "in" or an array equals "in" is checked
        if( is_array( $roles ) || $roles == 'in' ){
            $logged_in_out = 'in';
        } else if ( $roles == 'out' ){
            $logged_in_out = 'out';
        }

        // the specific roles to check
        $checked_roles = is_array( $roles ) ? $roles : false;

        ?>

        <input type="hidden" name="nav-menu-role-nonce" value="<?php echo wp_create_nonce( 'nav-menu-nonce-name' ); ?>" />

        <div class="field-nav_menu_role nav_menu_logged_in_out_field description-wide" style="margin: 5px 0;">
            <span class="description"><?php _e( "Display Mode", 'nav-menu-roles' ); ?></span>
            <br />

            <input type="hidden" class="nav-menu-id" value="<?php echo $item->ID ;?>" />

            <div class="logged-input-holder" style="float: left; width: 35%;">
                <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_logged_in-for-<?php echo $item->ID ;?>" <?php checked( 'in', $logged_in_out ); ?> value="in" />
                <label for="nav_menu_logged_in-for-<?php echo $item->ID ;?>">
                    <?php _e( 'Logged In Users', 'nav-menu-roles'); ?>
                </label>
            </div>

            <div class="logged-input-holder" style="float: left; width: 35%;">
                <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_logged_out-for-<?php echo $item->ID ;?>" <?php checked( 'out', $logged_in_out ); ?> value="out" />
                <label for="nav_menu_logged_out-for-<?php echo $item->ID ;?>">
                    <?php _e( 'Logged Out Users', 'nav-menu-roles'); ?>
                </label>
            </div>

            <div class="logged-input-holder" style="float: left; width: 30%;">
                <input type="radio" class="nav-menu-logged-in-out" name="nav-menu-logged-in-out[<?php echo $item->ID ;?>]" id="nav_menu_by_role-for-<?php echo $item->ID ;?>" <?php checked( '', $logged_in_out ); ?> value="" />
                <label for="nav_menu_by_role-for-<?php echo $item->ID ;?>">
                    <?php _e( 'Everyone', 'nav-menu-roles'); ?>
                </label>
            </div>

        </div>

        <div class="field-nav_menu_role nav_menu_role_field description-wide" style="margin: 5px 0;">
            <span class="description"><?php _e( "Limit logged in users to specific roles", 'nav-menu-roles' ); ?></span>
            <br />

            <?php

            /* Loop through each of the available roles. */
            foreach ( $display_roles as $role => $name ) {

                /* If the role has been selected, make sure it's checked. */
                $checked = checked( true, ( is_array( $checked_roles ) && in_array( $role, $checked_roles ) ), false );
                
                ?>

                <div class="role-input-holder" style="float: left; width: 33.3%; margin: 2px 0;">
                <input type="checkbox" name="nav-menu-role[<?php echo $item->ID ;?>][<?php echo $role; ?>]" id="nav_menu_role-<?php echo $role; ?>-for-<?php echo $item->ID ;?>" <?php echo $checked; ?> value="<?php echo $role; ?>" />
                <label for="nav_menu_role-<?php echo $role; ?>-for-<?php echo $item->ID ;?>">
                <?php echo esc_html( $name ); ?>
                </label>
                </div>

        <?php } ?>

        </div>

        <?php 
    }

 add_action( 'wp_update_nav_menu_item', 'mom_nav_update', 10, 2 );
function mom_nav_update( $menu_id, $menu_item_db_id ) {
        global $wp_roles;

        $allowed_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names );

        // verify this came from our screen and with proper authorization.
        if ( ! isset( $_POST['nav-menu-role-nonce'] ) || ! wp_verify_nonce( $_POST['nav-menu-role-nonce'], 'nav-menu-nonce-name' ) )
            return;

        $saved_data = false;

        if ( isset( $_POST['nav-menu-logged-in-out'][$menu_item_db_id]  )  && $_POST['nav-menu-logged-in-out'][$menu_item_db_id] == 'in' && ! empty ( $_POST['nav-menu-role'][$menu_item_db_id] ) ) {
            $custom_roles = array();
            // only save allowed roles
            foreach( $_POST['nav-menu-role'][$menu_item_db_id] as $role ) {
                if ( array_key_exists ( $role, $allowed_roles ) ) $custom_roles[] = $role;
            }
            if ( ! empty ( $custom_roles ) ) $saved_data = $custom_roles;
        } else if ( isset( $_POST['nav-menu-logged-in-out'][$menu_item_db_id]  )  && in_array( $_POST['nav-menu-logged-in-out'][$menu_item_db_id], array( 'in', 'out' ) ) ) {
            $saved_data = $_POST['nav-menu-logged-in-out'][$menu_item_db_id];
        } 

        if ( $saved_data ) {
            update_post_meta( $menu_item_db_id, '_nav_menu_role', $saved_data );
        } else {
            delete_post_meta( $menu_item_db_id, '_nav_menu_role' );
        }
    }


    /**
    * Adds value of new field to $item object
    * is be passed to Walker_Nav_Menu_Edit_Custom
    * @since 1.0
    */
    add_filter( 'wp_setup_nav_menu_item', 'mom_setup_nav_item' );
    function mom_setup_nav_item( $menu_item ) {

        $roles = get_post_meta( $menu_item->ID, '_nav_menu_role', true );

        if ( ! empty( $roles ) ) {
            $menu_item->roles = $roles;
        }
        return $menu_item;
    }

    if ( ! is_admin() ) {
        add_filter( 'wp_get_nav_menu_items', 'mom_exclude_menu_items' );
    }

    /**
    * Exclude menu items via wp_get_nav_menu_items filter
    * this fixes plugin's incompatibility with theme's that use their own custom Walker
    * Thanks to Evan Stein @vanpop http://vanpop.com/
    * @since 1.2
    */
    function mom_exclude_menu_items( $items ) {

        $hide_children_of = array();

        // Iterate over the items to search and destroy
        foreach ( $items as $key => $item ) {

            $visible = true;

            // hide any item that is the child of a hidden item
            if( in_array( $item->menu_item_parent, $hide_children_of ) ){
                $visible = false;
                $hide_children_of[] = $item->ID; // for nested menus
            }

            // check any item that has NMR roles set
            if( $visible && isset( $item->roles ) ) {

                // check all logged in, all logged out, or role
                switch( $item->roles ) {
                    case 'in' :
                    $visible = is_user_logged_in() ? true : false;
                        break;
                    case 'out' :
                    $visible = ! is_user_logged_in() ? true : false;
                        break;
                    default:
                        $visible = false;
                        if ( is_array( $item->roles ) && ! empty( $item->roles ) ) {
                            foreach ( $item->roles as $role ) {
                                if ( current_user_can( $role ) ) 
                                    $visible = true;
                            }
                        }

                        break;
                }

            }

            // add filter to work with plugins that don't use traditional roles
            $visible = apply_filters( 'nav_menu_roles_item_visibility', $visible, $item );

            // unset non-visible item
            if ( ! $visible ) {
                $hide_children_of[] = $item->ID; // store ID of item 
                unset( $items[$key] ) ;
            }

        }

        return $items;
}
