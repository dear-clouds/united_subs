<style type="text/css">
	.has-right-sidebar .inner-sidebar { display: none; }
	.has-right-sidebar #post-body-content { margin-right: 0; }
	#theme-framework .layout-widget select { width: 100%; }
</style>
<script type="text/javascript">


	// activate toolbar features (delete, expand/collapse, etc...)
	function attachToolbarBehavior(selector, id) {
		
		$item = jQuery(selector + ':not(.new-item)');
		
		// Add show/hide toggle
		$item.children().children('.collapse').mousedown(function (e) {
			e.stopPropagation();    
		})
		.click( function() {
			jQuery(this).parent().next()//.children('div[class$="-content"]')
			.slideToggle( 'fast', function() { 
				if (jQuery(this).css('display') === 'none') {
					jQuery(this).parent().addClass('isCollapsed');
				} else {
					jQuery(this).parent().removeClass('isCollapsed');
				}
			});
			return false;
		});
		
		// Delete widget button
		jQuery(selector + ':not(.new-item)').children().children('.remove').mousedown(function (e) {
			e.stopPropagation();    
		}).click(function () {
			if(confirm('Remove this item from the layout?')) {
				$this = jQuery(this).closest(id);
				$this.animate({
					opacity: 0
				},function () {
					$this.slideUp(function () {
						jQuery(this).remove();
					});
				});
			}
			return false;
		});
	}
	

// generate unique ID
function getID() {
	d = new Date();
	return d.valueOf();
}

// create sortable items on layout
function makeSortable() {
	jQuery('.column').sortable({
		items: 'li.layout-widget',
		connectWith: '.column', 
		handle: '.layout-widget-head',
		placeholder: 'layout-widget-placeholder',
		forcePlaceholderSize: true,
		revert: 300,
		delay: 100,
		opacity: 0.6,
		containment: 'document',
		start: function (e,ui) {
			jQuery(ui.helper).addClass('dragging');
		},
		stop: function (e,ui) {
			jQuery(ui.item).css({width:''}).removeClass('dragging');
			jQuery('.column').sortable('refresh');
	
			// if new item add behaviors
			if (ui.item.hasClass("new-item")) {
				ui.item.removeClass("new-item"); // remove class to mark new item
				newID = 'item_' + getID();
				ui.item.attr('id',newID); // set id for item 
				attachToolbarBehavior('#'+newID, '#'+newID); // init behaviors (delete, etc.)
			}
		},
		over: function(event, ui) {
			ColumnHeightFix(); // adjust column heights as items are moved
		}
	});
}



// Quick styling fix. Makes column min-width equal tallest column.
function ColumnHeightFix() {
	jQuery('.layout-container-content').each( function() {
		$this = jQuery(this).children('ul');
		var oldHeight = $this.height();
		var newHeight = 0;
		$this.css('min-height','44px').each( function() {
			if ( newHeight < jQuery(this).height() ) newHeight = jQuery(this).height();
			if (newHeight < 44) newHeight = 44;
		}).css('min-height', oldHeight + 'px').animate({
			'min-height': newHeight + 'px'}, 
			80, // speed (80 is REALLY FAST!)
			function () { }
		);

	});
}

// Get layout structure and data prepared for saving
function serialize() {
	var sections = new Object;
	jQuery('#LayoutContainer .layout-container-content').each( function(index) {
		var columns = [];
		jQuery(this).children('ul').each( function(x) {
			var c = jQuery(this).attr('rel');
			var items = [];
			jQuery(this).children('li').each( function(n) {
				 items[n] = jQuery(this).find(':input').serializeArray(); 
			});
			columns[x] = { 'class':c, 'items':items };
		});
		sections['container_'+index] = columns;
	});

	var output = decodeURIComponent(jQuery.param(sections));
	jQuery("input[name='layout_fields']").val(output);
};


jQuery(document).ready(function($) {
	
	// create sortable layout containers
	jQuery('#LayoutContainer').sortable({
		items: '.layout-container', 
		connectWith: '#LayoutContainer', 
		handle: '.layout-container-head', 
		forcePlaceholderSize: true,
		revert: 300,
		delay: 100,
		opacity: 0.6,
		containment: '#LayoutContainer',
		start: function (e,ui) {
			jQuery(ui.helper).addClass('dragging');
		},
		stop: function (e,ui) {
			// if new item add behaviors
			if (ui.item.hasClass("new-item")) {
				ui.item.removeClass("new-item"); // remove class to mark new item
				newID = 'item_' + getID();
				ui.item.attr('id',newID); // set id for item 
				attachToolbarBehavior('#'+newID, '#'+newID); // init behaviors (delete, etc.)
			}
			// reload sortables to make columns droppable
			makeSortable();
		}
	});
	
	// initialize draggin new items to layout
	jQuery( "#ItemTray .layout-widget" ).draggable({
		handle: '.layout-widget-head',
		connectToSortable: ".column",
		helper: "clone",
		revert: "invalid",
		start: function (e,ui) {
			jQuery(ui.helper).addClass('dragging');
		},
		stop: function (e,ui) {
			ColumnHeightFix(); // adjust column heights as items are moved
		}
	
	});
	jQuery( "#ItemTray .layout-container" ).draggable({
		handle: '.layout-container-head', 
		connectToSortable: '#LayoutContainer', 
		helper: "clone",
		revert: "invalid",
		start: function (e,ui) {
			jQuery(ui.helper).addClass('dragging');
		},
		stop: function (e,ui) { }
	});	
	
	// activate the sortable item areas
	makeSortable();

	// initialize for the existing layout items
	attachToolbarBehavior('li.layout-widget', '.layout-widget');
	attachToolbarBehavior('.layout-container', '.layout-container');

	// Fix column heights
	ColumnHeightFix();
	
	// catch form submit and run serialize function
	jQuery("form").submit(function() {
		
		// get the layout date into the form
		serialize();

		// basic validation to prevent data loss
		if ( jQuery("input[name='label']").val() == '' ) {
			alert('<?php _e('Please enter a name for the "Layout title"', THEME_NAME); ?>'); 
			return false;
		}
		if ( jQuery("input[name='key']").val() == '' ) {
			alert('<?php _e('Please enter an ID for the "Layout key"', THEME_NAME); ?>'); 
			return false;
		}
		
		// no problems, so...
		return true;
	});	


});

</script> 
<?php

$keys = $layout_admin->keys;

// Setup header and footer lists
$page_headers = $layout_admin->get_val('page_headers', '_plugin');
$page_headers_saved = $layout_admin->get_val('page_headers', '_plugin_saved');
$page_headers = array_merge((array)$page_headers_saved, (array)$page_headers);

$page_footers = $layout_admin->get_val('page_footers', '_plugin');
$page_footers_saved = $layout_admin->get_val('page_footers', '_plugin_saved');
$page_footers = array_merge((array)$page_footers_saved, (array)$page_footers);

$sidebar_data = $GLOBALS['sidebar_admin']->load_objects();
$sidebars = array_merge(
	isset($sidebar_data['_plugin_saved']['sidebars'])? (array) $sidebar_data['_plugin_saved']['sidebars'] : array(), 
	isset($sidebar_data['_plugin']['sidebars'])? (array) $sidebar_data['_plugin']['sidebars'] : array()
);



// Static content drop down (static blocks and pages)
$select_static_content['-'] = ''; // blank divider between pages and blocks
$content_blocks = $layout_admin->get_posts(false, true, 'static_block', 'post_name');
if (!empty($content_blocks)) {
	//$select_static_content['--'] = '--- STATIC BLOCKS ---'; // blank divider between pages and blocks
	foreach ($content_blocks as $key => $value) {
		$select_static_content[$key] = __('Static Block: ', THEME_NAME) . $value;
	}
}
$content_pages = $layout_admin->get_pages(false, true);
if (!empty($content_pages)) {
	$select_static_content['---'] = '---'; // blank divider between pages and blocks
	foreach ($content_pages as $key => $value) {
		$select_static_content[$key] = __('Page: ', THEME_NAME) . $value;
	}
}

$select_header = array('' => __('None (theme default)', THEME_NAME));
foreach ($page_headers as $header) {
	if (!empty($header)) $select_header[$header['key']] = $header['label'];
}
$select_footer = array('' => __('None (theme default)', THEME_NAME));
foreach ($page_footers as $footer) {
	if (!empty($footer)) $select_footer[$footer['key']] = $footer['label'];
}
$select_sidebar = array();
foreach ($sidebars as $item) {
	if (!empty($item)) $select_sidebar[$item['key']] = $item['label'];
}

// Set up the navigation
if (!($navtext = $layout_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
$layout_admin->navigation_bar(array(__('Layout', THEME_NAME) . ': ' . $navtext));

echo '<p>' . __('Create a new content layout for your site.', THEME_NAME) . '</p>';

$form_link = array('navigation' => 'layouts', 'action_keys' => $keys, 'action' => 'save');
$layout_admin->settings_form_header($form_link);

?>

<div class="meta-box-sortables metabox-holder" style="width: 79%">
	<div class="postbox">
		<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Layout Options', THEME_NAME); ?></span></h3>
		<div class="inside">
			<table class="form-table">
			<?php
				$comment = __('The name shown when selecting a template.', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$row = array(__('Layout title', THEME_NAME) . $required, $layout_admin->settings_input('label') . $comment);
				$layout_admin->setting_row($row);
			
				$comment = __('A unique ID not currently in use by any other layouts.', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$row = array(__('Layout key (unique identifier)', THEME_NAME) . $required, $layout_admin->settings_input('key') . $comment);
				$layout_admin->setting_row($row);
		
				$comment = __('Select a header from the "Page Headers" to use with this layout', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$select = $select_header;
				$row = array(__('Header', THEME_NAME) . $required, $layout_admin->settings_select('header', $select));
				$layout_admin->setting_row($row);
		
				$comment = __('Select a footer from the "Page Footers" to use with this layout', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$select = $select_footer;
				$row = array(__('Footer', THEME_NAME) . $required, $layout_admin->settings_select('footer', $select));
				$layout_admin->setting_row($row);
		
				// Skin
				$skins = $layout_admin->get_skin_css();
				$skins[''] = '';
				asort($skins);
				$select = $skins;
				$comment = __('You can optionally select a different skin for this layout, overriding the default theme skin.', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$row = array(__('Skin override', THEME_NAME), $layout_admin->settings_select('skin', $select) . $comment );
				$layout_admin->setting_row($row);
			?>
			</table>
		</div>
	</div>
</div>

<?php 

// Hidden field for storing layout container information
echo $layout_admin->settings_hidden('layout_fields'); 

// Save button
$layout_admin->settings_save_button(__('Save Layout', THEME_NAME), 'button-primary'); 

?>
<br />

<?php

// Container descriptions
$sidebar_desc = __('Select a sidebar to display. To create additional sidebars go to "Design Settings &gt; Sidebars"', THEME_NAME);
$divider_desc = __('Inserts a horizontal divider between layout sections.', THEME_NAME);
$static_content_desc = __('Select a page to pull the content from to be displayed for this area of the layout. This content will remain constant across all pages/posts using this layout.', THEME_NAME);
$default_content_desc = __('This area will display the main content for the current page/post being displayed. You should only include this area once for each layout.', THEME_NAME);
?>

<div id="LayoutContainer">
	<?php
		// Look up layout settings
		$layout = $layout_admin->get_val('layout_fields');
		if (!empty($layout)) {

			// no problems so far, start creating the layout containers
			$fields = $layout;
			
			// loop through the containers
			$f = 1;
			foreach ((array) $fields as $container) {
				echo 	'<div class="layout-container">'.
							'<div class="layout-container-head">'.
								'<h3>Container</h3>'.
								'<a href="#" class="remove toolbarBtn">Delete</a>'.
								'<a href="#" class="collapse toolbarBtn">Collapse</a>'.
								'<a href="#" class="options toolbarBtn">Options</a>'.
							'</div>'.
							'<div class="layout-container-content">';

				// loop through the columns in each container
				$c = 1;
				foreach ((array) $container as $column) {
					// set container class
					$columnClass = $column['class'];
					echo '<ul class="column '. $columnClass .'" rel="'. $columnClass .'">';

					// loop through content items in each column
						// each item can have multiple content blocks
						$items = isset($column['items'])? $column['items'] : array();
						for($n = 0; $n < count($items); ++$n) {
							
							$controls = '<a href="#" class="remove toolbarBtn">Delete</a>
										<a href="#" class="collapse toolbarBtn">Collapse</a>
										<a href="#" class="options toolbarBtn">Options</a>';
							if (!empty($items[$n])) {
								switch($items[$n][0]['name']) {	// logic isn't perfect becaues it only tests the first inupt for this item to get the name. 
									case 'sidebar':
										$title = 'Sidebar';
										$color = 'sidebar-widget color-gray-dark'; // color-green';
										$description = $sidebar_desc;
										$inputs = $layout_admin->settings_select('sidebar', $select_sidebar, $items[$n][0]['value']);
										break;
									case 'divider':
										$title = 'Divider';
										$color = 'divider-widget color-gray-dark'; // color-yellow';
										$description = $divider_desc;
										$inputs = '<input type="hidden" name="divider" value="standard" />';
										break;
									case 'breadcrumbs':
										$title = 'Breadcrumbs';
										$color = 'breadcrumbs-widget color-gray-dark'; // color-orange';
										$inputs = '<input type="hidden" name="breadcrumbs" value="standard" />';
										break;
									case 'content-static':
										$title = 'Static Content';
										$color = 'content-static-widget color-gray-dark'; // color-gray';
										$description = $static_content_desc;
										$inputs = $layout_admin->settings_select('content-static', $select_static_content,  $items[$n][0]['value']);
										break;
									case 'content-default':
										$title = 'Default Content';
										$color = 'content-default-widget color-gray-dark'; //'content-default-widget color-blue';
										$description = $default_content_desc;
										$inputs = '<input type="hidden" name="content-default" value="default" />';
										break;
									default:	
										// this shouldn't happen
								}

								echo	'<li class="layout-widget '. $color .'">'.
											'<div class="layout-widget-head">'.
												'<h3>'. $title .'</h3>'.
												$controls .
											'</div>'.
											'<div class="layout-widget-content">'.
												'<p>'. $description .'</p>'.
												$inputs .
											'</div>'.
										'</li>';
							}
							
						}
					echo '</ul>';
					$c++;
				}
				echo 		'<div style="clear:both;"></div>'.
						'</div>'.
					'</div>';
				$f++;
			}

		}
	?>
	<div style="clear:both;"></div>
</div> <!-- end #LayoutContainer -->



<div id="ItemTray">

	<h4>Page Elements</h4>
	<ul>
		<li class="layout-widget sidebar-widget color-gray-dark isCollapsed new-item">
			<div class="layout-widget-head">
				<h3>Sidebar</h3>
				<a href="#" class="remove toolbarBtn">Delete</a>
				<a href="#" class="collapse toolbarBtn">Collapse</a>
				<a href="#" class="options toolbarBtn">Options</a>
			</div>
			<div class="layout-widget-content">
				<p><?php echo $sidebar_desc; ?></p>
				<?php echo $layout_admin->settings_select('sidebar', $select_sidebar); ?>
			</div>
		</li>
		<li class="layout-widget divider-widget color-gray-dark isCollapsed new-item">  
			<div class="layout-widget-head">
				<h3>Divider</h3>
				<a href="#" class="remove toolbarBtn">Delete</a>
				<a href="#" class="collapse toolbarBtn">Collapse</a>
				<a href="#" class="options toolbarBtn">Options</a>
			</div>
			<div class="layout-widget-content">
				<p><?php echo $divider_desc; ?></p>
				<input type="hidden" name="divider" value="standard" />
			</div>
		</li>
		<!--<li class="layout-widget breadcrumbs-widget color-gray-dark isCollapsed new-item">  
			<div class="layout-widget-head">
				<h3>Breadcrumbs</h3>
				<a href="#" class="remove toolbarBtn">Delete</a>
				<a href="#" class="collapse toolbarBtn">Collapse</a>
				<a href="#" class="options toolbarBtn">Options</a>
			</div>
			<div class="layout-widget-content">
				<input type="hidden" name="breadcrumbs" value="standard" />
			</div>
		</li>-->
		<li class="layout-widget content-static-widget color-gray-dark isCollapsed new-item">  
			<div class="layout-widget-head">
				<h3>Static Content</h3>
				<a href="#" class="remove toolbarBtn">Delete</a>
				<a href="#" class="collapse toolbarBtn">Collapse</a>
				<a href="#" class="options toolbarBtn">Options</a>
			</div>
			<div class="layout-widget-content">
				<p><?php echo $static_content_desc; ?></p>
				<?php echo $layout_admin->settings_select('content-static', $select_static_content); ?>
				<!--<select name="content-static">
					<option value="123">Page 1</option>
					<option value="8521">Another Page</option>
					<option value="951">Page 123</option>
					<option value="761">And another page</option>
					<option value="359">last page</option>
				</select>-->
			</div>
		</li>
		<li class="layout-widget content-default-widget color-gray-dark isCollapsed new-item">  
			<div class="layout-widget-head">
				<h3>Default Content</h3>
				<a href="#" class="remove toolbarBtn">Delete</a>
				<a href="#" class="collapse toolbarBtn">Collapse</a>
				<a href="#" class="options toolbarBtn">Options</a>
			</div>
			<div class="layout-widget-content">
				<p><?php echo $default_content_desc; ?></p>
				<input type="hidden" name="content-default" value="default" />
			</div>
		</li>
	</ul>
	
	<h4>Content Containers</h4>

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>Full Width Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-1" rel="col-1-1"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/2 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-2" rel="col-1-2"></ul>
			<ul class="column col-1-2" rel="col-1-2"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/3 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-3" rel="col-1-3"></ul>
			<ul class="column col-1-3" rel="col-1-3"></ul>
			<ul class="column col-1-3" rel="col-1-3"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/3 - 2/3 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-3" rel="col-1-3"></ul>
			<ul class="column col-2-3" rel="col-2-3"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>2/3 - 1/3 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-2-3" rel="col-2-3"></ul>
			<ul class="column col-1-3" rel="col-1-3"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/4 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>3/4 - 1/4 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-3-4" rel="col-3-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/4 - 3/4 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-3-4" rel="col-3-4"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>1/2 - 1/4 - 1/4</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-2" rel="col-1-2"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3> 1/4 - 1/2 - 1/4</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-2" rel="col-1-2"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->
	<div style="clear:both;"></div>

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3> 1/4 - 1/4 - 1/2</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-4" rel="col-1-4"></ul>
			<ul class="column col-1-2" rel="col-1-2"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>2/5 - 3/5 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-2-5" rel="col-2-5"></ul>
			<ul class="column col-3-5" rel="col-3-5"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->

	<div class="layout-container new-item">
		<div class="layout-container-head">
			<h3>3/5 - 2/5 Container</h3>
			<a href="#" class="remove toolbarBtn">Delete</a>
			<a href="#" class="collapse toolbarBtn">Collapse</a>
			<a href="#" class="options toolbarBtn">Options</a>
		</div>
		<div class="layout-container-content">
			<ul class="column col-3-5" rel="col-3-5"></ul>
			<ul class="column col-2-5" rel="col-2-5"></ul>
			<div style="clear:both;"></div>
		</div>
	</div> <!-- end .layout-container -->
		
</div>

<div class="hr" style="clear:both;"></div>

<br /><br />
