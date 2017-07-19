<?php
/*
 Plugin Name: Movie Database
 Plugin URI: http://www.heimkino-praxis.com/movie-database/
 Description: Adds a movie database to WordPress. You can manage your movie collection and show everyone, which movies you were watching recently.
 Version: 1.0.6
 Author: Bert Kößler <bert@heimkino-praxis.com>
 Author URI: http://www.heimkino-praxis.com/
 License: GPLv2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('MOVDB_DEBUG', false);

require_once('main-page.php');
require_once('movies-page.php');
require_once('reservations-page.php');
require_once('screenings-page.php');
require_once('sources-page.php');
require_once('views-page.php');
require_once('class/MovDB_DeletableSources_List_Table.class.php');
require_once('class/MovDB_Movies_List_Table.class.php');
require_once('class/MovDB_Screenings_List_Table.class.php');
require_once('class/MovDB_Sources_List_Table.class.php');
require_once('class/MovDB_Reservations_List_Table.class.php');
require_once('class/MovDB_View.class.php');
require_once('class/MovDB_LastScreenings_View.class.php');
require_once('class/MovDB_Recommendations_View.class.php');
require_once('class/MovDB_SeenUnrated_View.class.php');
require_once('class/MovDB_Statistics.class.php');
require_once('class/MovDB_SuggestionsBest_List_Table.class.php');
require_once('class/MovDB_SuggestionsNotSeen_List_Table.class.php');
require_once('class/MovDB_Widget.class.php');

register_activation_hook(__FILE__, 'movdb_install');

add_action('admin_menu', 'movdb_admin_menu');
add_action('admin_head', 'movdb_admin_head');
add_action('wp_ajax_movdb_movie_search', 'movdb_ajax_movie_search');
add_action('wp_dashboard_setup', 'movdb_wp_dashboard_setup');
add_action('wp_enqueue_scripts', 'movdb_frontend_scripts');
add_action('admin_enqueue_scripts', 'movdb_backend_scripts' );
add_action('wp_head', 'movdb_page_head');
add_action('widgets_init', 'movdb_register_widgets');
add_action('after_setup_theme', 'movdb_plugin_setup');

function movdb_plugin_setup ()
{
    load_plugin_textdomain('movdb', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}

// Frontend CSS
function movdb_page_head ()
{
	$url = plugin_dir_url(__FILE__);
	echo '<link type="text/css" rel="stylesheet" href="' . $url . 'styles/page.css' . (MOVDB_DEBUG ? '?v=' . time() : '') . '" />';
}

// Frontend JavaScript
function movdb_frontend_scripts ()
{
	$url = plugin_dir_url(__FILE__);
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('movdb_page_script', $url . 'scripts/page.js' . (MOVDB_DEBUG ? '?v=' . time() : ''), array('jquery'));
	
	wp_enqueue_style('dashicons');
}

function movdb_backend_scripts ()
{
	$url = plugin_dir_url(__FILE__);
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('movdb_admin_script', $url . 'scripts/admin.js' . (MOVDB_DEBUG ? '?v=' . time() : ''), array('jquery'));
	wp_enqueue_script('movdb_page_script', $url . 'scripts/page.js' . (MOVDB_DEBUG ? '?v=' . time() : ''), array('jquery'));
	
	wp_localize_script('movdb_admin_script', 'movdb_l10n', array(
		'wikiUrl' => __('https://en.wikipedia.org/wiki/', 'movdb'),
		'copyFilename' => __('Copy filename:', 'movdb')
	));
}

// Widgets
function movdb_register_widgets ()
{
	register_widget('MovDB_Widget');
}

// Admin CSS + JavaScript
function movdb_admin_head ()
{
	$url = plugin_dir_url(__FILE__);
	
	echo '<link rel="stylesheet" type="text/css" href="' . $url . 'styles/admin.css' . (MOVDB_DEBUG ? '?v=' . time() : '') . '" />' . "\n";
	echo '<link rel="stylesheet" type="text/css" href="' . $url . 'styles/page.css' . (MOVDB_DEBUG ? '?v=' . time() : '') . '" />' . "\n";
}

// Dashboard Widget
function movdb_wp_dashboard_setup ()
{
	global $wp_meta_boxes;
	wp_add_dashboard_widget('movdb_dashboard_widget', __('Movie Database', 'movdb'), 'movdb_dashboard_widget');
}

/**
 * Erzeugt das Dashboard-Widget für die Filmdatenbank.
 */
function movdb_dashboard_widget ()
{
	?>
	<div class="movdb-inside">
	<?php
	
	$view = new MovDB_LastScreenings_View();
	$view->prepare_items();
	$view->display();
	
	?>
	</div>
	<?php
}

function movdb_install ()
{
	global $wpdb;
	
	// Infos zum Anlegen von Datenbanken mit Plugins
	// http://codex.wordpress.org/Creating_Tables_with_Plugins
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	// movies table
	$table_name = $wpdb->prefix . 'movdb_movies';
	
	$query = "CREATE TABLE $table_name (
		id INT(10) NOT NULL AUTO_INCREMENT COMMENT 'Die ID des Films.',
		title VARCHAR(128) NOT NULL DEFAULT '0' COMMENT 'Der deutsche Titel des Films.',
		org_title VARCHAR(128) NULL DEFAULT NULL COMMENT 'Der Originaltitel des Films.',
		short_title VARCHAR(64) NULL DEFAULT NULL COMMENT 'Ein kurzer Titel für die Ausgabe.',
		version VARCHAR(64) NULL DEFAULT NULL COMMENT 'Die Version des Films (zum Beispiel Extended Cut)',
		series VARCHAR(64) NULL DEFAULT NULL COMMENT 'Der Name der Filmreihe, wenn es Fortsetzungen zu einem Film gibt.',
		part TINYINT(2) NULL DEFAULT NULL COMMENT 'Der Teil der Filmreihe, wenn der Film Teil mehrerer Filme ist.',
		year SMALLINT(6) NULL DEFAULT NULL COMMENT 'Das Jahr, in dem der Film produziert oder veröffentlicht wurde.',
		rating TINYINT(2) NOT NULL DEFAULT '0' COMMENT 'Bewertung des Films von 1 bis 10 (0 = nicht bewertet)',
		approx_seen_formerly TINYINT(4) NOT NULL DEFAULT '0' COMMENT 'Gibt an, wie oft ich diesen Film ungefähr gesehen habe, bevor diese Datenbank geführt wurde.',
		PRIMARY KEY  (id)
	);";
	
	dbDelta($query);
	
	$rows_affected = $wpdb->insert(
		$table_name,
		array (
			'id' => 1,
			'title' => 'Sucker Punch',
			'org_title' => 'Sucker Punch',
			'year' => 2011,
			'rating' => 10
		)
	);
	
	// screenings table
	$table_name = $wpdb->prefix . 'movdb_screenings';
	
	$query = "CREATE TABLE $table_name (
		id INT(10) NOT NULL AUTO_INCREMENT COMMENT 'Die ID der Vorführung.',
		movie INT(10) NOT NULL DEFAULT '0' COMMENT 'Der Film, der vorgeführt wurde.',
		source INT(10) NULL DEFAULT NULL COMMENT 'Die Quelle, von der der Film vorgeführt wurde.',
		date DATE NOT NULL COMMENT 'Das Datum der Vorführung.',
		guests VARCHAR(255) NULL DEFAULT NULL COMMENT 'Gäste, die bei der Vorstellung anwesend waren (Namen durch Komma getrennt)',
		video_3d ENUM('true','false') NOT NULL DEFAULT 'false' COMMENT 'Gibt an, ob der Film in 3D gesehen wurde.',
		frontend_visible ENUM('true','false') NOT NULL DEFAULT 'true' COMMENT 'Gibt an, ob die Vorstellung im WordPress-Frontend angezeigt wird.',
		PRIMARY KEY  (id)
	);";
	
	dbDelta($query);
	
	$rows_affected = $wpdb->insert(
		$table_name,
		array (
			'id' => 1,
			'movie' => 1,
			'date' => current_time('mysql')
		)
	);
	
	// sources table
	$table_name = $wpdb->prefix . 'movdb_sources';
	
	$query = "CREATE TABLE $table_name (
		id INT(10) NOT NULL AUTO_INCREMENT COMMENT 'Die ID der Reservierung.',
		movie INT(10) NOT NULL DEFAULT '0' COMMENT 'Der Film, der reserviert wird.',
		type ENUM('dvd','blu-ray','file') NOT NULL DEFAULT 'file' COMMENT 'Der Typ der Filmquelle (Art des Datenträgers oder Format).',
		audio_quality TINYINT(2) NULL DEFAULT NULL COMMENT 'Die Tonqualität der Quelle (0 = nicht festgelegt)',
		video_quality TINYINT(2) NULL DEFAULT NULL COMMENT 'Die Bildqualität der Quelle (0 = nicht festgelegt)',
		video_3d ENUM('true','false') NOT NULL DEFAULT 'false' COMMENT 'Gibt an, ob der Film über 3D verfügt.',
		audience_capable ENUM('true','false') NULL DEFAULT NULL COMMENT 'Gibt an, ob die Qualität der Quelle ausreicht, um den Film vor Publikum vorzuführen.',
		frontend_visible ENUM('true','false') NOT NULL DEFAULT 'true' COMMENT 'Gibt an, ob die Quelle im WordPress-Frontend angezeigt wird.',
		PRIMARY KEY  (id)
	);";
	
	dbDelta($query);
	
	$rows_affected = $wpdb->insert(
		$table_name,
		array (
			'id' => 1,
			'movie' => 1,
			'type' => 'blu-ray',
			'audience_capable' => 'true'
		)
	);
	
	// reservations table
	$table_name = $wpdb->prefix . 'movdb_reservations';
	
	$query = "CREATE TABLE $table_name (
		id INT(10) NOT NULL AUTO_INCREMENT COMMENT 'Die ID der Quelle.',
		movie INT(10) NOT NULL DEFAULT '0' COMMENT 'Der Film, den die Quelle zeigt.',
		source VARCHAR(255) NULL DEFAULT NULL COMMENT 'Eine mögliche Quelle, von der der Film bezogen werden könnte.', 
		priority ENUM('high','normal','low') NOT NULL DEFAULT 'normal' COMMENT 'Die Priorität, mit der der Film gesehen werden sollte.',
		PRIMARY KEY  (id)
	);";
	
	dbDelta($query);
	
	$rows_affected = $wpdb->insert(
		$table_name,
		array (
			'id' => 1,
			'movie' => 1,
			'source' => __('buy', 'movdb'),
			'priority' => 'high'
		)
	);
	
	add_option('movdb_db_version', '1.0');
}

function movdb_admin_menu ()
{
	add_menu_page(__('Movie Database', 'movdb'), __('Movie Database', 'movdb'), 10, 'movdb_main_page', null, 'dashicons-editor-video', 30);
	
	add_submenu_page('movdb_main_page', __('Survey', 'movdb'),     __('Survey', 'movdb'),     10, 'movdb_main_page',         'movdb_main_page');
	add_submenu_page('movdb_main_page', __('Movies', 'movdb'),     __('Movies', 'movdb'),     10, 'movdb_movies_page',       'movdb_movies_page');
	add_submenu_page('movdb_main_page', __('Screenings', 'movdb'), __('Screenings', 'movdb'), 10, 'movdb_screenings_page',   'movdb_screenings_page');
	add_submenu_page('movdb_main_page', __('Sources', 'movdb'),    __('Sources', 'movdb'),    10, 'movdb_sources_page',      'movdb_sources_page');
	add_submenu_page('movdb_main_page', __('Wishlist', 'movdb'),   __('Wishlist', 'movdb'),   10, 'movdb_reservations_page', 'movdb_reservations_page');
	add_submenu_page('movdb_main_page', __('Views', 'movdb'),      __('Views', 'movdb'),      10, 'movdb_views_page',        'movdb_views_page');
	
	add_dashboard_page(__('Movies', 'movdb'), __('Movies', 'movdb'), 10, 'movdb_main_page', 'movdb_main_page');
}

function movdb_redirect ($url)
{
	?>
	<script type="text/javascript">
	window.location = '<?php echo $url; ?>';
	</script>
	<?php
}

/**
 * Erstellt aus dem in der Datenbank gespeicherten Wert im Feld "screenings.guests"
 * ein Array, das die einzelnen Namen der Gäste enthält.
 *
 * @param string $guest_string Der Wert des Datenbankfelds.
 * @return array Ein Array mit den Namen der Gäste.
 */
function movdb_guest_array ($guest_string)
{
	$guests = explode(',', trim($guest_string));
	
	if (count($guests) == 1 && empty($guests[0])) {
		return array();
	}
	
	for ($i = 0; $i < count($guests); $i++) {
		$guests[$i] = trim($guests[$i]);
	}
	
	return $guests;
}

/**
 * Formatiert die Gäste einer Vorstellung als lesbare Zeichenkette.
 *
 * Vor dem Namen des letzten Gastes wird bei Bedarf "und" eingefügt.
 *
 * @param mixed $guests Die Namen der Gäste als Array oder als Wert des Datenbankfelds.
 * @return string Die formatierte Zeichenkette.
 */
function movdb_format_guests ($guests)
{
	if (!is_array($guests)) {
		$guests = movdb_guest_array($guests);
	}
	
	if (count($guests) == 0) {
		return '–';
	}
	
	for ($i = 0; $i < count($guests); $i++)
	{
		if (strpos($guests[$i], '@') > 0) {
			$guests[$i] = substr($guests[$i], 0, strpos($guests[$i], '@'));
		}
	}
	
	if (count($guests) == 1) {
		return $guests[0];
	}
	
	$chunks = array_chunk($guests, count($guests) - 1);
	return implode(', ', $chunks[0]) . ' ' . __('and', 'movdb') . ' ' . $chunks[1][0];
}

function movdb_format_rating ($value = 0)
{
	if ($value < 0) {
		$value = 0;
	}
	
	if ($value > 10) {
		$value = 10;
	}
	
	if ($value == 0) {
		$result = '–';
	}
	else {
		$result = $value / 2;
		
		if ($result == 0.5) {
			$result = '½';
		} else if ($result - floor($result) == 0.5) {
			$result = floor($result) . ' ½';
		}
	}
	
	return '<var class="movdb-rating" data-value="' . $value . '">' . $result . '</var>';
}

function movdb_format_source_type ($type)
{
	switch ($type)
	{
		case 'blu-ray':
			return __('Blu-ray', 'movdb');
		case 'dvd':
			return __('DVD', 'movdb');
		case 'file':
			return __('File', 'movdb');
		default:
			return strtoupper($type);
	}
}

function movdb_format_reservation_priority ($priority)
{
	switch ($priority)
	{
		case 'high':
			return __('high', 'movdb');
		case 'low':
			return __('low', 'movdb');
		default:
			return __('normal', 'movdb');
	}
}

/**
 * Findet alle Quellen eines Films und gibt sie zurück.
 * 
 * @param int $movie_id Die ID des Films, dessen Quellen gesucht werden.
 * @return array Ein Array der Quellen.
 */
function movdb_find_movie_sources ($movie_id)
{
	global $wpdb;
	
	$query = 'SELECT id, type, video_3d FROM ' . $wpdb->prefix . 'movdb_sources WHERE movie = %d';
	//var_dump($query);
	
	$results = $wpdb->get_results(
		$wpdb->prepare($query, intval($movie_id)),
		ARRAY_A
	);
	
	return $results;
}

/**
 * Erzeugt Selectbox-Optionen für alle Quellen eines Films.
 * 
 * @param int $movie_id Die ID des Films, dessen Quellen gesucht werden.
 * @param int $selected_source Die vorausgewählte Quelle, oder null, wenn keine Quelle ausgewählt sein soll.
 * @return array Ein Array, dessen Schlüssel die IDs und dessen Werte die Optionen sind.
 */
function movdb_create_movie_sources_options ($movie_id, $selected_source = null)
{
	$results = movdb_find_movie_sources($movie_id);
	
	$options = array();
	
	foreach ($results as $result)
	{
		$options[$result['id']] = sprintf(
			'<option value="%1$s" %3$s>%2$s</option>',
			/*%1$s*/ $result['id'],
			/*%2$s*/ movdb_format_source_type($result['type']) . ($result['video_3d'] == 'true' ? ' (3D)' : ''),
			/*%3$s*/ $result['id'] == $selected_source ? 'selected="selected"' : ''
		);
	}
	
	return $options;
}

?>