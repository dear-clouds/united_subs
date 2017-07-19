<?php
/**
 * Admin menu page customization
 * @author SeventQueen
 */

if (!class_exists('Walker_Nav_Menu_Edit')) {
	require_once(ABSPATH . 'wp-admin/includes/nav-menu.php');
}


class kleo_custom_menu {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	function __construct() {

		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'kleo_add_custom_nav_fields' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'kleo_update_custom_nav_fields'), 10, 3 );
		
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'kleo_edit_walker'), 10, 2 );

	} // end constructor
	
	

	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kleo_add_custom_nav_fields( $menu_item ) {
	
	    $menu_item->mega = get_post_meta( $menu_item->ID, '_menu_item_mega', true );
        $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
        $menu_item->iconpos = get_post_meta( $menu_item->ID, '_menu_item_iconpos', true );
	    return $menu_item;
	    
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kleo_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	
	    // Check if  mega element is properly sent
	    if ( isset( $_REQUEST['menu-item-mega'] ) && is_array( $_REQUEST['menu-item-mega']) && isset( $_REQUEST['menu-item-mega'][$menu_item_db_id] ) ) {
	        $mega_value = $_REQUEST['menu-item-mega'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_mega', $mega_value );
	    } else {
            update_post_meta( $menu_item_db_id, '_menu_item_mega', null );
        }

        // Check if  icons element is properly sent
        if ( isset( $_REQUEST['menu-item-icon'] ) && is_array( $_REQUEST['menu-item-icon']) && isset( $_REQUEST['menu-item-icon'][$menu_item_db_id] ) ) {
            $icon_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_icon', null );
        }

        // Check if icon position element is properly sent
        if ( isset( $_REQUEST['menu-item-iconpos'] ) && is_array( $_REQUEST['menu-item-iconpos']) && isset( $_REQUEST['menu-item-iconpos'][$menu_item_db_id] ) ) {
            $iconpos_value = $_REQUEST['menu-item-iconpos'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_iconpos', $iconpos_value );
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_iconpos', null );
        }

	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kleo_edit_walker($walker,$menu_id = null) {
	
    return 'Kleo_Walker_Nav_Menu_Edit';
	    
	}

}

if ( !class_exists('Kleo_Walker_Nav_Menu_Edit') ) {
	/**
	 * 
	 * Create HTML list of nav menu input items.
	 *
	 * @package WordPress
	 * @since 3.0.0
	 * @uses Walker_Nav_Menu
	 */
	class Kleo_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit  {
		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
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
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			parent::start_el( $output, $item, $depth, $args, $id );

			$item_id = esc_attr( $item->ID );
            $to_add = '';

            $icon_opts = '';

            foreach ( kleo_icons_array() as $icon ) {
                $selected_icon = $item->icon == $icon ? ' selected="selected"' : '';
                $icon_opts .= '<option value="' . $icon . '"' . $selected_icon . '>' . $icon . '</option> ';
            }


            $to_add .= '<p class="menu-item-icons">'
                . '<label for="edit-menu-item-icons-' . $item_id . '">'
                . __( 'Choose icon', 'kleo_framework' )
                . ' <select id="edit-menu-item-icon-'. $item_id . '" name="menu-item-icon[' . $item_id . ']">'
                . $icon_opts
                . '</select>'
                . ' <select id="edit-menu-item-iconpos-'. $item_id . '" name="menu-item-iconpos[' . $item_id . ']">'
                . '<option value="">' . __( 'Before title', 'kleo_framework' ) . '</option>'
                . '<option' . ( $item->iconpos == 'after' ? ' selected="selected"' : '' ) . ' value="after">' . __( 'After title', 'kleo_framework' ) . '</option>'
                . '<option ' . ( $item->iconpos == 'icon' ? ' selected="selected"' : '' ) . ' value="icon">' . __( 'Just the icon', 'kleo_framework' ) . '</option>'
                . '</select>'
                . '</label>'
                . '</p>';

            if ($depth == 0) {
                $to_add .= '<p class="menu-item-mega">
                        <label for="edit-menu-item-mega-'. $item_id .'">
                                <input type="checkbox" id="edit-menu-item-mega-'. $item_id . '" value="yes" name="menu-item-mega[' . $item_id . ']"'. ( $item->mega == 'yes' ? 'checked="checked"' : '' ) .' />'
                                . __( 'Enable Mega Menu for child items.', 'kleo_framework' )
                        . '</label>
                    </p>';
            }

            ob_start();
            // action for other plugins
            do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );

            $to_add .= ob_get_clean();

			$output = str_replace('<label for="edit-menu-item-target-'.$item_id.'">', '</p>' . $to_add . '<p class="field-link-target description"><label for="edit-menu-item-target-'.$item_id.'">', $output);

		}
	}
}
// instantiate the custom menu class
$GLOBALS['kleo_custom_menu'] = new kleo_custom_menu();
