<?php

function movdb_main_page ()
{
	?>
	<div class="wrap">
		<h1><?php _e('Movie Database', 'movdb'); ?></h1>
		
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						
						<?php movdb_main_page_add_screening(); ?>
						
						<?php movdb_main_page_seen_unrated(); ?>
						
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<div class="meta-box-sortables">
						
						<?php movdb_main_page_statistic(); ?>
						
					</div>
				</div>
				<div id="postbox-container-3" class="postbox-container">
					<div class="meta-box-sortables">
						
						<?php movdb_main_page_last_screenings(); ?>
						
					</div>
				</div>
				<div id="postbox-container-4" class="postbox-container">
					<div class="meta-box-sortables">
						
						<?php movdb_main_page_recommendations(); ?>
						
					</div>
				</div>
			</div>
			
			<div class="clear"></div>
			
		</div>
		
	</div>
	<?php
}

function movdb_main_page_add_screening ()
{
	?>
	<div class="postbox" id="movdb_quick_screening_widget">
		<h2 class="hndle"><span><?php _e('Add Screening', 'movdb'); ?></span></h2>
		<div class="inside movdb-inside">
		<?php
		
		movdb_screenings_page_create_edit_form(null, true);
		
		?>
		</div>
	</div>
	<?php
}

function movdb_main_page_seen_unrated ()
{
	$view = new MovDB_SeenUnrated_View();
	$view->prepare_items();
	
	?>
	<div class="postbox" id="movdb_seen_unrated_widget">
		<h2 class="hndle"><span><?php _e('Seen but not yet rated', 'movdb'); ?></span></h2>
		<div class="inside movdb-inside">
		<?php
		
		$view->display();
		
		?>
		</div>
	</div>
	<?php
}

function movdb_main_page_statistic ()
{
	$view = new MovDB_Statistics();
	$view->prepare_items();
	
	?>
	<div class="postbox" id="movdb_statistics_widget">
		<h2 class="hndle"><span><?php _e('Statistics', 'movdb'); ?></span></h2>
		<div class="inside movdb-inside">
		<?php
		
		$view->display();
		
		?>
		</div>
	</div>
	<?php
}

function movdb_main_page_last_screenings ()
{
	$view = new MovDB_LastScreenings_View();
	$view->prepare_items();
	
	?>
	<div class="postbox" id="movdb_last_screenings_widget">
		<h2 class="hndle"><span><?php _e('Latest Screenings', 'movdb'); ?></span></h2>
		<div class="inside movdb-inside">
		<?php
		
		$view->display();
		
		?>
		</div>
	</div>
	<?php
}

function movdb_main_page_recommendations ()
{
	$view = new MovDB_Recommendations_View();
	$view->prepare_items();
	
	?>
	<div class="postbox" id="movdb_recommendations_widget">
		<h2 class="hndle"><span><?php _e('Proposals', 'movdb'); ?></span></h2>
		<div class="inside movdb-inside">
		<?php
		
		$view->display();
		
		?>
		</div>
	</div>
	<?php
}

?>