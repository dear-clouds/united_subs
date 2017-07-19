<?php

function movdb_screenings_page ()
{
	switch ($_REQUEST['action'])
	{
		case 'add':
			movdb_screenings_page_action_add();
			break;
			
		case 'edit':
			movdb_screenings_page_action_edit();
			break;
			
		case 'delete':
			movdb_screenings_page_action_delete();
			break;
			
		default:
			movdb_screenings_page_main();
			break;
	}
}

function movdb_screenings_page_main ()
{
	$screeningsTable = new MovDB_Screenings_List_Table();
	$screeningsTable->prepare_items();
	
	$filter = $screeningsTable->get_current_filter();
	
	?>
	<div class="wrap">
		<h1><?php _e('Screenings', 'movdb'); ?> <a class="add-new-h2" href="admin.php?page=movdb_screenings_page&action=add"><?php _e('Add', 'movdb'); ?></a></h1>
		
		<ul class="subsubsub movdb-category">
			<li class="all">
				<a class="<?php echo ($filter == 'all' || $filter == false) ? 'current' : ''; ?>" href="admin.php?page=movdb_screenings_page&screening_filter=all">
					<?php _e('All', 'movdb'); ?>
					<span class="count">(<?php echo $screeningsTable->get_items_total(); ?>)</span>
				</a>
				|
			</li>
			<li class="alone">
				<a class="<?php echo ($filter == 'alone') ? 'current' : ''; ?>" href="admin.php?page=movdb_screenings_page&screening_filter=alone">
					<?php _e('Seen alone', 'movdb'); ?>
					<span class="count">(<?php echo $screeningsTable->get_items_alone(); ?>)</span>
				</a>
				|
			</li>
			<li class="with-guests">
				<a class="<?php echo ($filter == 'with_guests') ? 'current' : ''; ?>" href="admin.php?page=movdb_screenings_page&screening_filter=with_guests">
					<?php _e('Seen with guests', 'movdb'); ?>
					<span class="count">(<?php echo $screeningsTable->get_items_with_guests(); ?>)</span>
				</a>
			</li>
		</ul>
		<form id="screenings-filter" method="get" action="">
			<?php $screeningsTable->search_box(__('Search screenings', 'movdb'), 'screening_query'); ?>
			
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $screeningsTable->display(); ?>
		
		</form>
		
	</div>
	<?php
}

function movdb_screenings_page_action_add ()
{
	$inserted = movdb_screenings_page_handle_edit_form();
	
	if ($inserted) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_screenings_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Add New Screening', 'movdb'); ?></h1>
		<?php
		
		movdb_screenings_page_create_edit_form();
		
		?>
	</div>
	<?php
}

function movdb_screenings_page_action_edit ()
{
	global $wpdb;
	
	$screening_id = intval($_REQUEST['screening']);
	
	$updated = movdb_screenings_page_handle_edit_form($screening_id);
	
	if ($updated) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_screenings_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Edit Screening', 'movdb'); ?></h1>
		<?php
		
		$query = 'SELECT scr.*, mov.title FROM ' . $wpdb->prefix . 'movdb_screenings scr ' .
		         'JOIN ' . $wpdb->prefix . 'movdb_movies mov ON scr.movie = mov.id ' .
		         'WHERE scr.id = %d';
		//var_dump($query);
		
		$result = $wpdb->get_row(
			$wpdb->prepare($query, $screening_id),
			ARRAY_A
		);
		
		movdb_screenings_page_create_edit_form($result);
		
		?>
	</div>
	<?php
}

function movdb_screenings_page_create_edit_form ($args = null, $isWidget = false)
{
	global $wpdb;
	
	if ($args === null)
	{
		if (isset($_REQUEST['movie']))
		{
			$query = 'SELECT id, title FROM ' . $wpdb->prefix . 'movdb_movies WHERE id = %d';
			//var_dump($query);
			
			$result = $wpdb->get_row(
				$wpdb->prepare($query, intval($_REQUEST['movie'])),
				ARRAY_A
			);
			
			$movie_id = $result['id'];
			$movie_title = $result['title'];
		}
		else {
			$movie_id = '';
			$movie_title = '';
		}
		
		$args = array (
			'movie' => $movie_id,
			'title' => $movie_title,
			'source' => null,
			'date' => date('Y-m-d'),
			'guests' => '',
			'video_3d' => 'false',
			'frontend_visible' => 'true'
		);
	}
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
	$id = isset($_REQUEST['screening']) ? ('&screening=' . $_REQUEST['screening']) : '';
	
	$gotopage = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'movdb_main_page') ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_REFERER'];
	
	if ($isWidget) {
		$labelType1 = 'label-top';
		$labelType2 = 'label-full';
	} else {
		$labelType1 = '';
		$labelType2 = 'label-right';
	}
	
	?>
	<form id="screening-edit" class="movdb-form" method="post" action="<?php echo admin_url('admin.php?page=movdb_screenings_page&action=' . $action . $id); ?>">
		<fieldset>
			<legend><?php _e('Screening', 'movdb'); ?></legend>
			<ul>
				<li class="<?php echo $labelType1; ?>">
					<label for="movie"><?php _e('Movie', 'movdb'); ?></label>
					<input type="number" min="1" id="movie" name="movie" value="<?php echo $args['movie']; ?>" data-title="<?php echo htmlspecialchars($args['title']); ?>" />
				</li>
				<li class="<?php echo $labelType1; ?>">
					<label for="date"><?php _e('Date', 'movdb'); ?></label>
					<input type="date" id="date" name="date" value="<?php echo $args['date']; ?>" />
				</li>
				<li class="<?php echo $labelType1; ?>">
					<label for="guests"><?php _e('Guests', 'movdb'); ?></label>
					<input type="text" id="guests" name="guests" value="<?php echo $args['guests']; ?>" />
				</li>
				<li class="<?php echo $labelType1; ?>">
					<label for="source"><?php _e('Source', 'movdb'); ?></label>
					<select name="source">
						<option value="null"><?php _e('unknown', 'movdb'); ?></option>
						<?php
						
						if (isset($_REQUEST['source'])) {
							$selected_source = $_REQUEST['source'];
						} else if (isset($args['source'])) {
							$selected_source = $args['source'];
						} else {
							$selected_source = null;
						}
						
						if (!empty($args['movie']))
						{
							echo '<option value="0" ' . ($selected_source == '0' ? 'selected="selected"' : '') . '>' . __('borrowed', 'movdb') . '</option>';
							
							$options = movdb_create_movie_sources_options($args['movie'], $selected_source);
							echo implode("\n", $options);
							//var_dump($options);
							if (!in_array($selected_source, array_keys($options)) && $selected_source > 0) {
								echo '<option value="' . $selected_source . '" selected="selected">' . __('no longer available source', 'movdb') . '</option>';
							}
						}
						else {
							echo '<option value="0">' . __('borrowed', 'movdb') . '</option>';
							echo '<option value="find" selected="selected">' . __('find automatically', 'movdb') . '</option>';
						}
						
						?>
					</select>
				</li>
				<li class="<?php echo $labelType2; ?>">
					<input type="checkbox" id="video_3d" name="video_3d" value="true" <?php echo $args['video_3d'] == 'true' ? 'checked' : ''; ?> />
					<label for="video_3d"><?php _e('3D', 'movdb'); ?></label>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend><?php _e('Options', 'movdb'); ?></legend>
			<ul>
				<li class="<?php echo $labelType2; ?>">
					<input type="checkbox" id="frontend_visible" name="frontend_visible" value="true" <?php echo $args['frontend_visible'] == 'true' ? 'checked' : ''; ?> />
					<label for="frontend_visible"><?php _e('Show on website', 'movdb'); ?></label>
				</li>
				<li class="<?php echo $labelType2; ?>">
					<input type="checkbox" id="delete_reservations" name="delete_reservations" value="true" checked="checked" />
					<label for="delete_reservations"><?php _e('Remove movie from wishlist', 'movdb'); ?></label>
				</li>
			</ul>
		</fieldset>
		<div>
			<input type="hidden" name="gotopage" value="<?php echo $gotopage; ?>" />
			<input type="submit" name="submitted" value="<?php _e('Save', 'movdb'); ?>" />
		</div>
	</form>
	<?php
}

function movdb_screenings_page_handle_edit_form ($id = null)
{
	global $wpdb;
	
	if (!isset($_POST['submitted'])) {
		return false;
	}
	
	if (empty($_POST['movie']) && !empty($_POST['movie_title']))
	{
		$query = 'INSERT INTO ' . $wpdb->prefix . 'movdb_movies (title) VALUES (%s)';
		$wpdb->query($wpdb->prepare($query, $_POST['movie_title']));
		
		$_POST['movie'] = $wpdb->insert_id;
	}
	
	if ($_POST['source'] == 'find')
	{
		$sources = movdb_find_movie_sources($_POST['movie']);
		
		if (count($sources) > 0) {
			$_POST['source'] = $sources[0]['id'];
		} else {
			$_POST['source'] = '0';
		}
	}
	
	$table = $wpdb->prefix . 'movdb_screenings';
	
	$data = array (
		'movie' => $_POST['movie'],
		'source' => (isset($_POST['source']) && $_POST['source'] != 'null') ? intval($_POST['source']) : null,
		'date' => $_POST['date'],
		'guests' => stripslashes($_POST['guests']),
		'video_3d' => isset($_POST['video_3d']) ? 'true' : 'false',
		'frontend_visible' => isset($_POST['frontend_visible']) ? 'true' : 'false'
	);
	
	$placeholders = array();
	$parameters = array();
	
	foreach ($data as $key => $value)
	{
		if ($value === null) {
			$placeholders[$key] = 'NULL';
			continue;
		}
		
		$placeholders[$key] = '%s';
		$parameters[] = $value;
	}
	
	if ($_REQUEST['action'] == 'add')
	{
		$query  = 'INSERT INTO ' . $table . ' ';
		$query .= '(' . implode(', ', array_keys($placeholders)) . ') ';
		$query .= 'VALUES (' . implode(', ', array_values($placeholders)) . ')';
	}
	else
	{
		$sets = array();
		
		foreach ($placeholders as $key => $value) {
			$sets[] = $key . ' = ' . $value;
		}
		
		$query  = 'UPDATE ' . $table . ' ';
		$query .= 'SET ' . implode(', ', $sets) . ' ';
		$query .= 'WHERE id = %d';
		
		$parameters[] = $id;
	}
	
	$wpdb->query($wpdb->prepare($query, $parameters));
	
	if (isset($_REQUEST['delete_reservations'])) {
		$wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'movdb_reservations WHERE movie = %d', $_POST['movie']));
	}
	
	return true;
}

function movdb_screenings_page_action_delete ()
{
	global $wpdb;
	
	$screening_id = intval($_REQUEST['screening']);
	
	$wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'movdb_screenings WHERE id = %d', $screening_id));
	
	movdb_redirect($_SERVER['HTTP_REFERER']);
}

?>