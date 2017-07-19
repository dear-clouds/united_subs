<?php

function movdb_reservations_page ()
{
	switch ($_REQUEST['action'])
	{
		case 'add':
			movdb_reservations_page_action_add();
			break;
			
		case 'edit':
			movdb_reservations_page_action_edit();
			break;
			
		case 'delete':
			movdb_reservations_page_action_delete();
			break;
			
		default:
			movdb_reservations_page_main();
			break;
	}
}

function movdb_reservations_page_main ()
{
	$reservationsTable = new MovDB_Reservations_List_Table();
	$reservationsTable->prepare_items();
	
	$filter = $reservationsTable->get_current_filter();
	
	?>
	<div class="wrap">
		<h1><?php _e('Wishlist', 'movdb'); ?> <a class="add-new-h2" href="admin.php?page=movdb_reservations_page&action=add"><?php _e('Add', 'movdb'); ?></a></h1>
		
		<ul class="subsubsub movdb-category">
			<li class="all">
				<a class="<?php echo ($filter == 'all' || $filter == false) ? 'current' : ''; ?>" href="admin.php?page=movdb_reservations_page&reservation_filter=all">
					<?php _e('All', 'movdb'); ?>
					<span class="count">(<?php echo $reservationsTable->get_items_total(); ?>)</span>
				</a>
				|
			</li>
			<li class="priority-high">
				<a class="<?php echo ($filter == 'priority_high') ? 'current' : ''; ?>" href="admin.php?page=movdb_reservations_page&reservation_filter=priority_high">
					<?php _e('high priority', 'movdb'); ?>
					<span class="count">(<?php echo $reservationsTable->get_items_priority_high(); ?>)</span>
				</a>
				|
			</li>
			<li class="priority-normal">
				<a class="<?php echo ($filter == 'priority_normal') ? 'current' : ''; ?>" href="admin.php?page=movdb_reservations_page&reservation_filter=priority_normal">
					<?php _e('normal priority', 'movdb'); ?>
					<span class="count">(<?php echo $reservationsTable->get_items_priority_normal(); ?>)</span>
				</a>
				|
			</li>
			<li class="priority-low">
				<a class="<?php echo ($filter == 'priority_low') ? 'current' : ''; ?>" href="admin.php?page=movdb_reservations_page&reservation_filter=priority_low">
					<?php _e('low priority', 'movdb'); ?>
					<span class="count">(<?php echo $reservationsTable->get_items_priority_low(); ?>)</span>
				</a>
			</li>
		</ul>
		<form id="reservations-filter" method="get" action="">
			<?php $reservationsTable->search_box(__('Search wishes', 'movdb'), 'reservation_query'); ?>
			
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $reservationsTable->display(); ?>
		
		</form>
		
	</div>
	<?php
}

function movdb_reservations_page_action_add ()
{
	$inserted = movdb_reservations_page_handle_edit_form();
	
	if ($inserted) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_reservations_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Add New Wish', 'movdb'); ?></h1>
		<?php
		
		movdb_reservations_page_create_edit_form();
		
		?>
	</div>
	<?php
}

function movdb_reservations_page_action_edit ()
{
	global $wpdb;
	
	$reservation_id = intval($_REQUEST['reservation']);
	
	$updated = movdb_reservations_page_handle_edit_form($reservation_id);
	
	if ($updated) {
		if (!empty($_REQUEST['gotopage'])) {
			movdb_redirect($_REQUEST['gotopage']);
		} else {
			movdb_reservations_page_main();
		}
		return;
	}
	
	?>
	<div class="wrap">
		<h1><?php _e('Edit Wish', 'movdb'); ?></h1>
		<?php
		
		$query = 'SELECT res.*, mov.title FROM ' . $wpdb->prefix . 'movdb_reservations res ' .
		         'JOIN ' . $wpdb->prefix . 'movdb_movies mov ON res.movie = mov.id ' .
		         'WHERE res.id = %d';
		//var_dump($query);
		
		$result = $wpdb->get_row(
			$wpdb->prepare($query, $reservation_id),
			ARRAY_A
		);
		
		movdb_reservations_page_create_edit_form($result);
		
		?>
	</div>
	<?php
}

function movdb_reservations_page_create_edit_form ($args = null)
{
	if ($args === null)
	{
		$args = array (
			'movie' => '',
			'title' => '',
			'source' => '',
			'priority' => 'normal'
		);
	}
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
	$id = isset($_REQUEST['reservation']) ? ('&reservation=' . $_REQUEST['reservation']) : '';
	
	$gotopage = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'movdb_main_page') ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_REFERER'];
	
	?>
	<form id="reservation-edit" class="movdb-form" method="post" action="<?php echo admin_url('admin.php?page=movdb_reservations_page&action=' . $action . $id); ?>">
		<fieldset>
			<legend><?php _e('Wish', 'movdb'); ?></legend>
			<ul>
				<li>
					<label for="movie"><?php _e('Movie', 'movdb'); ?></label>
					<input type="number" min="1" id="movie" name="movie" value="<?php echo $args['movie']; ?>" data-title="<?php echo htmlspecialchars($args['title']); ?>" />
				</li>
				<li>
					<label for="source"><?php _e('Possible source', 'movdb'); ?></label>
					<input type="text" id="source" name="source" value="<?php echo $args['source']; ?>" />
				</li>
				<li>
					<label for="priority"><?php _e('Priority', 'movdb'); ?></label>
					<select id="priority" name="priority">
						<option value="high" <?php echo $args['priority'] == 'high' ? 'selected' : ''; ?>><?php _e('high', 'movdb'); ?></option>
						<option value="normal"<?php echo $args['priority'] == 'normal' ? 'selected' : ''; ?>><?php _e('normal', 'movdb'); ?></option>
						<option value="low"<?php echo $args['priority'] == 'low' ? 'selected' : ''; ?>><?php _e('low', 'movdb'); ?></option>
					</select>
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

function movdb_reservations_page_handle_edit_form ($id = null)
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
	
	$table = $wpdb->prefix . 'movdb_reservations';
	
	$data = array (
		'movie' => $_POST['movie'],
		'source' => stripslashes($_POST['source']),
		'priority' => $_POST['priority']
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

function movdb_reservations_page_action_delete ()
{
	global $wpdb;
	
	$reservation_id = intval($_REQUEST['reservation']);
	
	$wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'movdb_reservations WHERE id = %d', $reservation_id));
	
	movdb_redirect($_SERVER['HTTP_REFERER']);
}

?>