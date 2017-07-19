<?php

class Kleo_Walker_Nav_Menu_Edit extends Boom_Walker_Nav_Menu_Edit  {
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

		$to_add = '<p class="menu-item-mega">
				<label for="edit-menu-item-mega-'. $item_id .'">
						<input type="checkbox" id="edit-menu-item-mega-'. $item_id . '" value="yes" name="menu-item-mega[' . $item_id . ']"'. ( $item->mega == 'yes' ? 'checked="checked"' : '' ) .' />'
						. __( 'Enable Mega Menu for child items.', 'kleo_framework' )
				. '</label>
			</p>';

		if ($depth !== 0) {
			$to_add = '';
		}

		$output = str_replace('<label for="edit-menu-item-target-'.$item_id.'">', '</p>' . $to_add . '<p class="field-link-target description"><label for="edit-menu-item-target-'.$item_id.'">', $output);

	}
}