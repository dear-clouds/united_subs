<?php

function movdb_sources_page ()
{
	switch ($_REQUEST['action'])
	{
		case 'add':
			movdb_sources_page_action_add();
			break;
			
		case 'edit':
			movdb_sources_page_action_edit();
			break;
			
		case 'delete':
			movdb_sources_page_action_delete();
			break;
			
		default:
			movdb_sources_page_main();
			break;
	}
}

function movdb_sources_page_main ()
{
	$sourcesTable = new MovDB_Sources_List_Table();
	$sourcesTable->prepare_items();
	
	$filter = $sourcesTable->get_current_filter();
	
	?>
	<div class="wrap">
		<h1><?php _e('Sources', 'movdb'); ?> <a class="add-new-h2" href="admin.php?page=movdb_sources_page&action=add"><?php _e('Add', 'movdb'); ?></a></h1>
		
		<ul class="subsubsub movdb-category">
			<li class="all">
				<a class="<?php echo ($filter == 'all' || $filter == false) ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=all">
					<?php _e('All', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_total(); ?>)</span>
				</a>
				|
			</li>
			<li class="type-bluray">
				<a class="<?php echo ($filter == 'type_bluray') ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=type_bluray">
					<?php _e('Blu-ray', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_type_bluray(); ?>)</span>
				</a>
				|
			</li>
			<li class="type-dvd">
				<a class="<?php echo ($filter == 'type_dvd') ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=type_dvd">
					<?php _e('DVD', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_type_dvd(); ?>)</span>
				</a>
				|
			</li>
			<li class="type-file">
				<a class="<?php echo ($filter == 'type_file') ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=type_file">
					<?php _e('Files', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_type_file(); ?>)</span>
				</a>
				|
			</li>
			<li class="video-3d">
				<a class="<?php echo ($filter == 'video_3d') ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=video_3d">
					<?php _e('3D', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_video_3d(); ?>)</span>
				</a>
				|
			</li>
			<li class="audience-capable">
				<a class="<?php echo ($filter == 'audience_capable') ? 'current' : ''; ?>" href="admin.php?page=movdb_sources_page&source_filter=audience_capable">
					<?php _e('appropriate for audience', 'movdb'); ?>
					<span class="count">(<?php echo $sourcesTable->get_items_audience_capable(); ?>)</span>
				</a>
			</li>
		</ul>
		<form id="sources-filter" method="get" action="">
			<?php $sourcesTable->search_box(__('Search sources', 'movdb'), 'source_query'); ?>
			
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $sourcesTable->display(); ?>
		
		</form>
		
	</div>
	<?php
}

function movdb_sources_page_action_add ()
{
	$inserted = movdb_sources_page_handle_edit_form();
	
	if ($inserted) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_sources_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Add New Source', 'movdb'); ?></h1>
		<?php
		
		movdb_sources_page_create_edit_form();
		
		?>
	</div>
	<?php
}

function movdb_sources_page_action_edit ()
{
	global $wpdb;
	
	$source_id = intval($_REQUEST['source']);
	
	$updated = movdb_sources_page_handle_edit_form($source_id);
	
	if ($updated) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_sources_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Edit Source', 'movdb'); ?></h1>
		<?php
		
		$query = 'SELECT src.*, mov.title FROM ' . $wpdb->prefix . 'movdb_sources src ' .
		         'JOIN ' . $wpdb->prefix . 'movdb_movies mov ON src.movie = mov.id ' .
		         'WHERE src.id = %d';
		//var_dump($query);
		
		$result = $wpdb->get_row(
			$wpdb->prepare($query, $source_id),
			ARRAY_A
		);
		
		if ($result['audience_capable'] === null) {
			$result['audience_capable'] = 'null';
		}
		
		movdb_sources_page_create_edit_form($result);
		
		?>
	</div>
	<?php
}

function movdb_sources_page_create_edit_form ($args = null)
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
			'type' => 'file',
			'audio_quality' => '',
			'video_quality' => '',
			'video_3d' => 'false',
			'audience_capable' => 'null',
			'frontend_visible' => 'true'
		);
	}
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
	$id = isset($_REQUEST['source']) ? ('&source=' . $_REQUEST['source']) : '';
	
	$gotopage = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'movdb_main_page') ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_REFERER'];
	
	?>
	<form id="source-edit" class="movdb-form" method="post" action="<?php echo admin_url('admin.php?page=movdb_sources_page&action=' . $action . $id); ?>">
		<fieldset>
			<legend><?php _e('Source', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="movie"><?php _e('Movie', 'movdb'); ?></label>
					<input type="number" min="1" id="movie" name="movie" value="<?php echo $args['movie']; ?>" data-title="<?php echo htmlspecialchars($args['title']); ?>" />
				</li>
				<li>
					<label for="type"><?php _e('Type', 'movdb'); ?></label>
					<select id="type" name="type">
						<option value="blu-ray" <?php echo $args['type'] == 'blu-ray' ? 'selected' : ''; ?>><?php _e('Blu-ray', 'movdb'); ?></option>
						<option value="dvd"<?php echo $args['type'] == 'dvd' ? 'selected' : ''; ?>><?php _e('DVD', 'movdb'); ?></option>
						<option value="file"<?php echo $args['type'] == 'file' ? 'selected' : ''; ?>><?php _e('File', 'movdb'); ?></option>
					</select>
					<div id="movdb_file_warning">
						<?php _e('<strong>Attention!</strong> The possession of movies in the form of files is illegal in many cases.<br />Legal files might include <em>digital copies</em>, as they are available with many Blu-ray discs.', 'movdb'); ?>
					</div>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend><?php _e('Rating', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="audio_quality"><?php _e('Audio quality', 'movdb'); ?></label>
					<input type="number" min="0" max="10" step="1" id="audio_quality" class="movdb-rating" name="audio_quality" value="<?php echo $args['audio_quality']; ?>" />
				</li>
				<li>
					<label for="video_quality"><?php _e('Video quality', 'movdb'); ?></label>
					<input type="number" min="0" max="10" step="1" id="video_quality" class="movdb-rating" name="video_quality" value="<?php echo $args['video_quality']; ?>" />
				</li>
				<li class="label-right">
					<input type="checkbox" id="video_3d" name="video_3d" value="true" <?php echo $args['video_3d'] == 'true' ? 'checked' : ''; ?> />
					<label for="video_3d"><?php _e('3D', 'movdb'); ?></label>
				</li>
				<li class="label-right">
					<span class="label-group">
						<input type="radio" id="audience_capable_yes" name="audience_capable" value="true" <?php echo $args['audience_capable'] == 'true' ? 'checked' : ''; ?> />
						<label for="audience_capable_yes"><?php _e('appropriate for audience', 'movdb'); ?></label>
					</span>
					<span class="label-group">
						<input type="radio" id="audience_capable_no" name="audience_capable" value="false" <?php echo $args['audience_capable'] == 'false' ? 'checked' : ''; ?> />
						<label for="audience_capable_no"><?php _e('inappropriate', 'movdb'); ?></label>
					</span>
					<span class="label-group">
						<input type="radio" id="audience_capable_null" name="audience_capable" value="null" <?php echo (empty($args['audience_capable']) || $args['audience_capable'] == 'null') ? 'checked' : ''; ?> />
						<label for="audience_capable_null"><?php _e('not tested', 'movdb'); ?></label>
					</span>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend><?php _e('Options', 'movdb'); ?></legend>
			<ul>
				<li class="label-right">
					<input type="checkbox" id="frontend_visible" name="frontend_visible" value="true" <?php echo $args['frontend_visible'] == 'true' ? 'checked' : ''; ?> />
					<label for="frontend_visible"><?php _e('Show on website', 'movdb'); ?></label>
				</li>
				<li class="label-right">
					<input type="checkbox" id="delete_reservations" name="delete_reservations" value="true" />
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

function movdb_sources_page_handle_edit_form ($id = null)
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
	
	$table = $wpdb->prefix . 'movdb_sources';
	
	$data = array (
		'movie' => $_POST['movie'],
		'type' => $_POST['type'],
		'audio_quality' => empty($_POST['audio_quality']) ? null : $_POST['audio_quality'],
		'video_quality' => empty($_POST['video_quality']) ? null : $_POST['video_quality'],
		'video_3d' => isset($_POST['video_3d']) ? 'true' : 'false',
		'audience_capable' => (!isset($_POST['audience_capable']) || $_POST['audience_capable'] == 'null') ? null : $_POST['audience_capable'],
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

function movdb_sources_page_action_delete ()
{
	global $wpdb;
	
	$source_id = intval($_REQUEST['source']);
	
	$wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'movdb_sources WHERE id = %d', $source_id));
	
	movdb_redirect($_SERVER['HTTP_REFERER']);
}

?>