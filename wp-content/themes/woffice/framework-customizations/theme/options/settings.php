<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

$options = array(
	fw()->theme->get_options( 'general' ),
	fw()->theme->get_options( 'styling' ),
	fw()->theme->get_options( 'header' ),
	fw()->theme->get_options( 'menu' ),
	fw()->theme->get_options( 'page-title' ),
	fw()->theme->get_options( 'dashboard' ),
	fw()->theme->get_options( 'sidebar' ),
	fw()->theme->get_options( 'footer' ),
	fw()->theme->get_options( 'buddypress' ),
	fw()->theme->get_options( 'posts' ),
	fw()->theme->get_options( 'news' ),
	fw()->theme->get_options( 'login' ),
	fw()->theme->get_options( 'custom-css' ),
);
