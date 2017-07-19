<?php

function movdb_views_page ()
{
	$tab = isset ( $_GET['tab'] ) ? $_GET['tab'] : 'suggestions-best';
	
	?>
	<div class="wrap">
		<?php
		
		movdb_views_page_tabs($tab);
		
		switch ($tab)
		{
			case 'suggestions-notseen' :
				movdb_views_page_suggestions_notseen();
				break;
				
			case 'suggestions-best' :
				movdb_views_page_suggestions_best();
				break;
				
			case 'deletable' :
				movdb_views_page_deletable_sources();
				break;
		}
		
		?>
	</div>
	<?php
}

function movdb_views_page_tabs ($current = 'suggestions-best')
{
	$tabs = array(
		'suggestions-best' => __('Best Movies', 'movdb'),
		'suggestions-notseen' => __('Not Yet Seen', 'movdb'),
		'deletable' => __('Low Quality Sources', 'movdb')
	);

	echo '<h2 class="nav-tab-wrapper">';
	
	foreach ($tabs as $tab => $name) {
		$class = ($tab == $current) ? ' nav-tab-active' : '';
		echo '<a class="nav-tab' . $class . '" href="?page=movdb_views_page&tab=' . $tab . '">' . $name . '</a>';
	}
	
	echo '</h2>';
}

function movdb_views_page_suggestions_notseen ()
{
	$moviesTable = new MovDB_SuggestionsNotSeen_List_Table();
	$moviesTable->prepare_items();
	
	?>
	<form id="movies-filter" method="get" action="">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<input type="hidden" name="tab" value="suggestions-notseen" />
		<?php $moviesTable->display(); ?>
	</form>
	<?php
}

function movdb_views_page_suggestions_best ()
{
	$moviesTable = new MovDB_SuggestionsBest_List_Table();
	$moviesTable->prepare_items();
	
	?>
	<form id="movies-filter" method="get" action="">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<input type="hidden" name="tab" value="suggestions-best" />
		<?php $moviesTable->display(); ?>
	</form>
	<?php
}

function movdb_views_page_deletable_sources ()
{
	$moviesTable = new MovDB_DeletableSources_List_Table();
	$moviesTable->prepare_items();
	
	?>
	<form id="movies-filter" method="get" action="">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<input type="hidden" name="tab" value="deletable" />
		<?php $moviesTable->display(); ?>
	</form>
	<?php
}

?>