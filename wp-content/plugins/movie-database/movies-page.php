<?php

function movdb_movies_page ()
{
	switch ($_REQUEST['action'])
	{
		case 'add':
			movdb_movies_page_action_add();
			break;
			
		case 'edit':
			movdb_movies_page_action_edit();
			break;
			
		default:
			movdb_movies_page_main();
			break;
	}
}

function movdb_movies_page_main ()
{
	$moviesTable = new MovDB_Movies_List_Table();
	$moviesTable->prepare_items();
	
	$filter = $moviesTable->get_current_filter();
	
	?>
	<div class="wrap">
		<h1><?php _e('Movies', 'movdb'); ?> <a class="add-new-h2" href="admin.php?page=movdb_movies_page&action=add"><?php _e('Add', 'movdb'); ?></a></h1>
		
		<ul class="subsubsub movdb-category">
			<li class="all">
				<a class="<?php echo ($filter == 'all' || $filter == false) ? 'current' : ''; ?>" href="admin.php?page=movdb_movies_page&movie_filter=all">
					<?php _e('All', 'movdb'); ?>
					<span class="count">(<?php echo $moviesTable->get_items_total(); ?>)</span>
				</a>
				|
			</li>
			<li class="with-source">
				<a class="<?php echo ($filter == 'with_source') ? 'current' : ''; ?>" href="admin.php?page=movdb_movies_page&movie_filter=with_source">
					<?php _e('With source', 'movdb'); ?>
					<span class="count">(<?php echo $moviesTable->get_items_with_source(); ?>)</span>
				</a>
				|
			</li>
			<li class="unseen">
				<a class="<?php echo ($filter == 'unseen') ? 'current' : ''; ?>" href="admin.php?page=movdb_movies_page&movie_filter=unseen">
					<?php _e('Unseen', 'movdb'); ?>
					<span class="count">(<?php echo $moviesTable->get_items_unseen(); ?>)</span>
				</a>
				|
			</li>
			<li class="unrated">
				<a class="<?php echo ($filter == 'unrated') ? 'current' : ''; ?>" href="admin.php?page=movdb_movies_page&movie_filter=unrated">
					<?php _e('Not yet rated', 'movdb'); ?>
					<span class="count">(<?php echo $moviesTable->get_items_unrated(); ?>)</span>
				</a>
			</li>
		</ul>
		<form id="movies-filter" method="get" action="">
			<?php $moviesTable->search_box(__('Search movies', 'movdb'), 'movie_query'); ?>
			
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $moviesTable->display(); ?>
		
		</form>
		
	</div>
	<?php
}

function movdb_movies_page_action_add ()
{
	$inserted = movdb_movies_page_handle_edit_form();
	
	if ($inserted) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_movies_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Add New Movie', 'movdb'); ?></h1>
		<?php
		
		movdb_movies_page_create_edit_form();
		
		?>
	</div>
	<?php
}

function movdb_movies_page_action_edit ()
{
	global $wpdb;
	
	$movie_id = intval($_REQUEST['movie']);
	
	$updated = movdb_movies_page_handle_edit_form($movie_id);
	
	if ($updated) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_movies_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Edit Movie', 'movdb'); ?></h1>
		<?php
		
		$result = $wpdb->get_row(
			$wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'movdb_movies WHERE id = %d', $movie_id),
			ARRAY_A
		);
		
		movdb_movies_page_create_edit_form($result);
		
		?>
	</div>
	<?php
}

function movdb_movies_page_create_edit_form ($args = null)
{
	if ($args === null)
	{
		$args = array (
			'title' => '',
			'org_title' => '',
			'short_title' => '',
			'version' => '',
			'series' => '',
			'part' => '',
			'year' => '',
			'rating' => '0',
			'approx_seen_formerly' => '0'
		);
	}
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
	$id = isset($_REQUEST['movie']) ? ('&movie=' . $_REQUEST['movie']) : '';
	
	$gotopage = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'movdb_main_page') ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_REFERER'];
	
	?>
	<form id="movie-edit" class="movdb-form" method="post" action="<?php echo admin_url('admin.php?page=movdb_movies_page&action=' . $action . $id); ?>">
		<fieldset>
			<legend><?php _e('Movie', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="title"><?php _e('Title', 'movdb'); ?></label>
					<input type="text" id="title" name="title" value="<?php echo $args['title']; ?>" />
				</li>
				<li>
					<label for="org_title"><?php _e('Original title', 'movdb'); ?></label>
					<input type="text" id="org_title" name="org_title" value="<?php echo $args['org_title']; ?>" />
				</li>
				<li>
					<label for="short_title"><?php _e('Short title', 'movdb'); ?></label>
					<input type="text" id="short_title" name="short_title" value="<?php echo $args['short_title']; ?>" />
				</li>
				<li>
					<label for="version"><?php _e('Version', 'movdb'); ?></label>
					<input type="text" id="version" name="version" value="<?php echo $args['version']; ?>" />
				</li>
				<li>
					<label for="year"><?php _e('Year', 'movdb'); ?></label>
					<input type="number" min="1900" max="2099" step="1" id="year" name="year" value="<?php echo $args['year']; ?>" />
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend><?php _e('Series', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="series"><?php _e('Series', 'movdb'); ?></label>
					<input type="text" id="series" name="series" value="<?php echo $args['series']; ?>" />
				</li>
				<li>
					<label for="part"><?php _e('Part', 'movdb'); ?></label>
					<input type="number" min="-100" max="100" step="1" id="part" name="part" value="<?php echo $args['part']; ?>" />
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend><?php _e('Personal data', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="rating"><?php _e('Rating', 'movdb'); ?></label>
					<input type="number" min="0" max="10" step="1" id="rating" class="movdb-rating" name="rating" value="<?php echo $args['rating']; ?>" />
				</li>
				<li>
					<label for="approx_seen_formerly"><?php _e('approx. seen', 'movdb'); ?></label>
					<input type="number" min="0" max="1000" step="1" id="approx_seen_formerly" name="approx_seen_formerly" value="<?php echo $args['approx_seen_formerly']; ?>" />
					× <?php _e('prior to the acquisition in this database', 'movdb'); ?>
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

function movdb_movies_page_handle_edit_form ($id = null)
{
	global $wpdb;
	
	if (!isset($_POST['submitted'])) {
		return false;
	}
	
	$table = $wpdb->prefix . 'movdb_movies';
	
	$data = array (
		'title' => stripslashes($_POST['title']),
		'org_title' => empty($_POST['org_title']) ? null : stripslashes($_POST['org_title']),
		'short_title' => empty($_POST['short_title']) ? null : stripslashes($_POST['short_title']),
		'version' => empty($_POST['version']) ? null : stripslashes($_POST['version']),
		'series' => empty($_POST['series']) ? null : stripslashes($_POST['series']),
		'part' => empty($_POST['part']) ? null : $_POST['part'],
		'year' => empty($_POST['year']) ? null : $_POST['year'],
		'rating' => empty($_POST['rating']) ? 0 : $_POST['rating'],
		'approx_seen_formerly' => empty($_POST['approx_seen_formerly']) ? 0 : $_POST['approx_seen_formerly']
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
	
	return true;
}

function movdb_ajax_movie_search()
{
	global $wpdb;

	$search_query = $_POST['query'];

	$query = 'SELECT id, title, org_title, version, year, ' .
	         'if(series is null or part is null, title, concat(series, " ", lpad(part, 5, "0"))) as series_sort, ' .
	         'least(least(if(instr(title, "' . $search_query . '") = 0, 1000, instr(title, "' . $search_query . '")), if(org_title is null, 1000, if(instr(org_title, "' . $search_query . '") = 0, 1000, instr(org_title, "' . $search_query . '")))), 2) as query_pos ' .
	         'FROM ' . $wpdb->prefix . 'movdb_movies ' .
	         'WHERE title like "%' . $search_query . '%" or org_title like "%' . $search_query . '%" ' .
	         'ORDER BY query_pos asc, series_sort asc';
	//var_dump($query);
	//die();
	
	$results = $wpdb->get_results($query, ARRAY_A);
	
	$output = array();
	
	foreach ($results as $result)
	{
		$item = array (
			'id' => $result['id'],
			'title' => $result['title']
		);
		
		if ($result['org_title'] != null) {
			$item['org_title'] = $result['org_title'];
		}
		
		if ($result['version'] != null) {
			$item['version'] = $result['version'];
		}
		
		if ($result['year'] != null) {
			$item['year'] = $result['year'];
		}
		
		$output[] = $item;
	}
	
	echo json_encode($output);

	die(); // this is required to return a proper result
}

?>