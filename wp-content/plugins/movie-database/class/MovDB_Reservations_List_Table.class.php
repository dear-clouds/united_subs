<?php

if (!class_exists('WP_List_Table')) {
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Erzeugt die Tabelle mit Filmen.
 *
 * Übernimmt die Datenselektion, Sortierung und Filterung sowie die Paginierung.
 */
class MovDB_Reservations_List_Table extends WP_List_Table
{
	/**
	 * Diese internen Variablen werden bei der Berechnung der Daten nach und nach befüllt.
	 * Es gibt je eine Methode, um diese Werte von außen abzurufen. Sie werden benötigt,
	 * um die Kategorie-Auswahl über der Tabelle zu befüllen.
	 */
	var $items_total = 0;
	var $items_priority_high = 0;
	var $items_priority_normal = 0;
	var $items_priority_low = 0;
	
	/**
	 * Legt die Anzahl der Datensätze pro Seite fest.
	 */
	var $records_per_page = 30;
	
	
	/** ************************************************************************
	* REQUIRED. Set up a constructor that references the parent constructor. We 
	* use the parent reference to set some default configs.
	***************************************************************************/
	function __construct ()
	{
		global $status, $page;
		    
		parent::__construct(
			array(
				'singular'  => 'reservation',  // singular name of the listed records
				'plural'    => 'reservations', // plural name of the listed records
				'ajax'      => false      // does this table support ajax?
			)
		);
	}
	
	
	/** ************************************************************************
	* Recommended. This method is called when the parent class can't find a method
	* specifically build for a given column. Generally, it's recommended to include
	* one method for each column you want to render, keeping your package class
	* neat and organized. For example, if the class needs to process a column
	* named 'title', it would first see if a method named $this->column_title() 
	* exists - if it does, that method will be used. If it doesn't, this one will
	* be used. Generally, you should try to use custom column methods as much as 
	* possible. 
	* 
	* Since we have defined a column_title() method later on, this method doesn't
	* need to concern itself with any column with a name of 'title'. Instead, it
	* needs to handle everything else.
	* 
	* For more detailed insight into how columns are handled, take a look at 
	* WP_List_Table::single_row_columns()
	* 
	* @param array $item A singular item (one full row's worth of data)
	* @param array $column_name The name/slug of the column to be processed
	* @return string Text or HTML to be placed inside the column <td>
	**************************************************************************/
	function column_default ($item, $column_name)
	{
		switch($column_name)
		{
			case 'title':
			case 'source':
			case 'priority':
				return $item[$column_name];
				
			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}
	
	
	/** ************************************************************************
	* Recommended. This is a custom column method and is responsible for what
	* is rendered in any column with a name/slug of 'title'. Every time the class
	* needs to render a column, it first looks for a method named 
	* column_{$column_title} - if it exists, that method is run. If it doesn't
	* exist, column_default() is called instead.
	* 
	* This example also illustrates how to implement rollover actions. Actions
	* should be an associative array formatted as 'slug'=>'link html' - and you
	* will need to generate the URLs yourself. You could even ensure the links
	* 
	* 
	* @see WP_List_Table::::single_row_columns()
	* @param array $item A singular item (one full row's worth of data)
	* @return string Text to be placed inside the column <td> (movie title only)
	**************************************************************************/
	function column_title ($item)
	{
		//Build row actions
		$actions = array(
			'edit'       => sprintf('<a href="?page=%2$s&action=%3$s&reservation=%4$s">%1$s</a>',
				/*$1%s*/ __('Edit', 'movdb'),
				/*$2%s*/ $_REQUEST['page'],
				/*$3%s*/ 'edit',
				/*$4%s*/ $item['id']
			),
			'delete'     => sprintf('<a href="?page=%2$s&action=%3$s&reservation=%4$s">%1$s</a>',
				/*$1%s*/ __('Delete', 'movdb'),
				/*$2%s*/ $_REQUEST['page'],
				/*$3%s*/ 'delete',
				/*$4%s*/ $item['id']
			),
			'edit_movie' => sprintf('<a href="?page=%2$s&action=%3$s&movie=%4$s">%1$s</a>',
				/*$1%s*/ __('Edit movie', 'movdb'),
				/*$2%s*/ 'movdb_movies_page',
				/*$3%s*/ 'edit',
				/*$4%s*/ $item['movie']
			),
			'screenings' => sprintf('<a href="?page=%3$s&movies=%5$s">%1$s</a> (<a href="?page=%3$s&action=%4$s&movie=%5$s">%2$s</a>)',
				/*$1%s*/ __('Screenings', 'movdb'),
				/*$2%s*/ '+',
				/*$3%s*/ 'movdb_screenings_page',
				/*$4%s*/ 'add',
				/*$5%s*/ $item['movie']
			),
			'sources'    => sprintf('<a href="?page=%3$s&movies=%5$s">%1$s</a> (<a href="?page=%3$s&action=%4$s&movie=%5$s">%2$s</a>)',
				/*$1%s*/ __('Sources', 'movdb'),
				/*$2%s*/ '+',
				/*$3%s*/ 'movdb_sources_page',
				/*$4%s*/ 'add',
				/*$5%s*/ $item['movie']
			),
		);
		
		$content = $item['title'];

		if (!empty($item['version'])) {
			$content .= ' <span class="version">(' . $item['version'] . ')</span>';
		}

		$content .= ' <span class="record-id">(' . $item['movie'] . ')</span>';
		$content .= $this->row_actions($actions);

		return $content;
	}
	
	/**
	 * Formatiert die Spalte "Bezugsquelle".
	 */
	function column_source ($item)
	{
		$source = $item['source'];
		
		if (empty($source)) {
			$source = '–';
		}
		
		return sprintf('%1$s <span class="record-id">(%2$s)</span>',
			/*$1%s*/ $source,
			/*$2%s*/ $item['id']
		);
	}
	
	/**
	 * Formatiert die Spalte "Priorität".
	 */
	function column_priority ($item)
	{
		return movdb_format_reservation_priority($item['priority']);
	}
	
	/** ************************************************************************
	* REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
	* is given special treatment when columns are processed. It ALWAYS needs to
	* have it's own method.
	* 
	* @see WP_List_Table::::single_row_columns()
	* @param array $item A singular item (one full row's worth of data)
	* @return string Text to be placed inside the column <td> (movie title only)
	**************************************************************************/
	function column_cb ($item)
	{
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  // Let's simply repurpose the table's singular label ("movie")
			/*$2%s*/ $item['movie']             // The value of the checkbox should be the record's id
		);
	}
	
	
	/** ************************************************************************
	* REQUIRED! This method dictates the table's columns and titles. This should
	* return an array where the key is the column slug (and class) and the value 
	* is the column's title text. If you need a checkbox for bulk actions, refer
	* to the $columns array below.
	* 
	* The 'cb' column is treated differently than the rest. If including a checkbox
	* column in your table you must create a column_cb() method. If you don't need
	* bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
	* 
	* @see WP_List_Table::::single_row_columns()
	* @return array An associative array containing column information: 'slugs'=>'Visible Titles'
	**************************************************************************/
	function get_columns ()
	{
		return array(
			'cb'               => '<input type="checkbox" />', //Render a checkbox instead of text
			'title'            => __('Title', 'movdb'),
			'source'           => __('Possible source', 'movdb'),
			'priority'         => __('Priority', 'movdb')
		);
	}
	
	/** ************************************************************************
	* Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
	* you will need to register it here. This should return an array where the 
	* key is the column that needs to be sortable, and the value is db column to 
	* sort by. Often, the key and value will be the same, but this is not always
	* the case (as the value is a column name from the database, not the list table).
	* 
	* This method merely defines which columns should be sortable and makes them
	* clickable - it does not handle the actual sorting. You still need to detect
	* the ORDERBY and ORDER querystring variables within prepare_items() and sort
	* your data accordingly (usually by modifying your query).
	* 
	* @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
	**************************************************************************/
	function get_sortable_columns ()
	{
		return array(
			'title'         => array('title_sort', true), // true means it's already sorted
			'source'        => array('source', false),
			'priority'      => array('priority', false)
		);
	}
	
	
	/** ************************************************************************
	* Optional. If you need to include bulk actions in your list table, this is
	* the place to define them. Bulk actions are an associative array in the format
	* 'slug'=>'Visible Title'
	* 
	* If this method returns an empty value, no bulk action will be rendered. If
	* you specify any bulk actions, the bulk actions box will be rendered with
	* the table automatically on display().
	* 
	* Also note that list tables are not automatically wrapped in <form> elements,
	* so you will need to create those manually in order for bulk actions to function.
	* 
	* @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
	**************************************************************************/
	function get_bulk_actions ()
	{
		return array(
			'show_screenings' => __('Show screenings', 'movdb'),
			'show_sources'    => __('Show sources', 'movdb')
		);
	}
	
	
	/** ************************************************************************
	* Optional. You can handle your bulk actions anywhere or anyhow you prefer.
	* For this example package, we will handle it in the class to keep things
	* clean and organized.
	* 
	* @see $this->prepare_items()
	**************************************************************************/
	function process_bulk_action ()
	{
		switch ($this->current_action())
		{
			case 'show_screenings':
				movdb_redirect(admin_url('admin.php?page=movdb_screenings_page&movies=' . implode(',', $_REQUEST['source'])));
				exit;
				
			case 'show_sources':
				movdb_redirect(admin_url('admin.php?page=movdb_sources_page&movies=' . implode(',', $_REQUEST['source'])));
				exit;
		}
	}
	
	
	/** ************************************************************************
	* REQUIRED! This is where you prepare your data for display. This method will
	* usually be used to query the database, sort and filter the data, and generally
	* get it ready to be displayed. At a minimum, we should set $this->items and
	* $this->set_pagination_args(), although the following properties and methods
	* are frequently interacted with here...
	* 
	* @global WPDB $wpdb
	* @uses $this->_column_headers
	* @uses $this->items
	* @uses $this->get_columns()
	* @uses $this->get_sortable_columns()
	* @uses $this->get_pagenum()
	* @uses $this->set_pagination_args()
	**************************************************************************/
	function prepare_items ()
	{
		global $wpdb;
		
		/**
		* REQUIRED. Now we need to define our column headers. This includes a complete
		* array of columns to be displayed (slugs & titles), a list of columns
		* to keep hidden, and a list of columns that are sortable. Each of these
		* can be defined in another method (as we've done here) before being
		* used to build the value for our _column_headers property.
		*/
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		
		/**
		* REQUIRED. Finally, we build an array to be used by the class for column 
		* headers. The $this->_column_headers property takes an array which contains
		* 3 other arrays. One for all columns, one for hidden columns, and one
		* for sortable columns.
		*/
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		/**
		* Optional. You can handle your bulk actions however you see fit. In this
		* case, we'll handle them within our package just to keep things clean.
		*/
		$this->process_bulk_action();
		
		
		$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title_sort'; // if no sort, set default here
		$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; // if no order, default to asc
		
		$query  = 'select rsv.id, rsv.movie, mov.title, mov.org_title, mov.short_title, mov.version, rsv.source, rsv.priority, ';
		$query .= 'trim(replace(replace(replace(replace(mov.title, "Der", ""), "Die", ""), "Das", ""), "The", "")) as title_sort ';
		$query .= 'from ' . $wpdb->prefix . 'movdb_reservations rsv ';
		$query .= 'left outer join ' . $wpdb->prefix . 'movdb_movies mov on mov.id = rsv.movie ';
		
		if (isset($_REQUEST['movies'])) {
			$movies = explode(',', $_REQUEST['movies']);
			$query .= 'where mov.id in (' . implode(', ', $movies) . ') ';
		} else if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {
			$search = $_REQUEST['s'];
			$query .= 'where mov.title like "%' . $search . '%" or mov.org_title like "%' . $search . '%" or mov.short_title like "%' . $search . '%" or rsv.source like "%' . $search . '%" ';
		}
		
		$query .= 'order by '. $orderby . ' ' .$order;
		//var_dump($query);
		
		$rawdata = $wpdb->get_results($query, 'ARRAY_A');
		$data = array();
		
		foreach ($rawdata as $record)
		{
			$this->items_total++;
			
			if ($record['priority'] == 'high') {
				$this->items_priority_high++;
			}
			
			if ($record['priority'] == 'normal') {
				$this->items_priority_normal++;
			}
			
			if ($record['priority'] == 'low') {
				$this->items_priority_low++;
			}
			
			// Filterkriterien anwenden und Datensatz ggfl. überspringen
			
			if ($this->get_current_filter() == 'priority_high') {
				if ($record['priority'] != 'high') {
					continue;
				}
			}
			
			if ($this->get_current_filter() == 'priority_normal') {
				if ($record['priority'] != 'normal') {
					continue;
				}
			}
			
			if ($this->get_current_filter() == 'priority_low') {
				if ($record['priority'] != 'low') {
					continue;
				}
			}
			
			$data[] = $record;
		}
		
		$current_item_count = count($data);
		$current_page = $this->get_pagenum();
		
		/**
		* The WP_List_Table class does not handle pagination for us, so we need
		* to ensure that the data is trimmed to only the current page. We can use
		* array_slice() to 
		*/
		$data = array_slice($data, (($current_page - 1) * $this->records_per_page), $this->records_per_page);
		
		/**
		* REQUIRED. Now we can add our *sorted* data to the items property, where 
		* it can be used by the rest of the class.
		*/
		$this->items = $data;
		
		/**
		* REQUIRED. We also have to register our pagination options & calculations.
		*/
		$this->set_pagination_args(
			array(
				'total_items' => $current_item_count,                                // calculate the total number of items
				'per_page'    => $this->records_per_page,                            // determine how many items to show on a page
				'total_pages' => ceil($current_item_count / $this->records_per_page) // calculate the total number of pages
			)
		);
	}
	
	/**
	 * Gibt die Gesamtzahl der Quellen in der Datenbank zurück.
	 */
	function get_items_total ()
	{
		return $this->items_total;
	}
	
	/**
	 * Gibt die Anzahl der Wünsche mit hoher Priorität zurück.
	 */
	function get_items_priority_high ()
	{
		return $this->items_priority_high;
	}
	
	/**
	 * Gibt die Anzahl der Wünsche mit normaler Priorität zurück.
	 */
	function get_items_priority_normal ()
	{
		return $this->items_priority_normal;
	}
	
	/**
	 * Gibt die Anzahl der Wünsche mit niedriger Priorität zurück.
	 */
	function get_items_priority_low ()
	{
		return $this->items_priority_low;
	}
	
	/**
	 * Gibt die aktive Filtereinstellung zurück oder false, wenn kein Filter aktiv ist.
	 */
	function get_current_filter ()
	{
		if (!isset($_REQUEST['reservation_filter'])) {
			return false;
		}
		
		return $_REQUEST['reservation_filter'];
	}
}