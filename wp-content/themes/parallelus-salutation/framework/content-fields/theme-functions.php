<?php


function content_fields($key, $before = '', $after = '', $content_filter = false) {
	$value = get_meta($key);
	if (!$value) return false;
	echo $before;
	if ($content_filter) echo apply_filters('the_content', $value);
	else echo $value;
	echo $after;
	return true;
}


/*
**  get_box (  )
**
*/
function get_box  ($name, $args = array()) {
	global $content_fields;

    global $post;
    $html = '';
    $nl = "\n";

	// Get our fields
	$content_fields = $content_fields->get_objects(array('_plugin_saved', '_plugin'));

	// Parse args
	$defaults = array('format' => 'ul', 'div' => '', 'show' => '', 'title' => '');
	$args = wp_parse_args($args, $defaults);

	if (!is_array($content_fields)) return '<!-- No More Fields are defined -->';
	if (!array_key_exists($name, $content_fields)) return "<!-- The box name '$name' does not exist! -->";

	// Make sure we've got someting to display
	$something = false;
	foreach ((array) $content_fields[$name]['field'] as $field) 
		if (get_post_meta($post->ID, $field['key'], true)) $something = true;
	if (!$something) return "<!-- Nothing to display for '$name' -->";

	// Iterate through our meta fields and generat some html
	for ($i=0; $i < count($content_fields[$name]['field']); $i++) {
		$key = $content_fields[$name]['field'][$i]['key'];
		$title = $content_fields[$name]['field'][$i]['title'];		

		// Set up the list
		if ($i == 0) {
			if ($args['div']) $html .= '<div id="' . $args['div'] .'">' . $nl;
			if ($args['format']) {
				$caption = ($args['title']) ? ($args['title']) : $name;
				$html .= '<h3 class="meta_widget_header">' . $caption . '</h3>' . $nl;
				$html .= '<' . $args['format'] . '>' . $nl;
			}
		}
		// Does this field qualify for being shown?
		$show = false;
		if (is_array($args['show'])) {
			for ($k = 0; $k < count($args['show']); $k++) 
				if ($args['show'][$k] == $key)
					$show =  true;
		} else if (!$args['show'] || ($args['show'] == $key)) $show = true;

		$value = get_post_meta($post->ID, $key, true);

		if ($show && $value) {

			// Amost the same as 'the_content' filter
			$value = preg_replace("/\n/", "<br />", $value);
			$value = wptexturize($value);
			$value = convert_chars($value);
			
			$style_li = ' class="meta_' . $key . '_ul"';
			$style_dt = ' class="meta_' . $key . '_dt"';
			$style_dd = ' class="meta_' . $key . '_dd"';
			if ($args['format'] == 'ul') $html .= "<li ${style_li}>" . $value . '</li>' . $nl;
			else if ($args['format'] == 'dl') $html .= "<dt ${style_dt}>" . $title . "</dt><dd ${style_dd}>" . $value . '</dd>' . $nl;
			else if ($args['format'] == 'p') $html .= $value . $nl;
			else $html .= $value . $nl;
		}
		// Close the list and the optional div
		if ($i == count($content_fields[$name]['field']) - 1) {
			if ($args['format']) $html .= '</' . $args['format'] . '>' . $nl;
			if ($args['div']) $html .= '</div>' . $nl;
		}
	}
    echo $html;
}

/*
**   get_meta ( )
**
*/
function get_meta ($meta, $id = '') {	
	global $post;
	if(is_object($post)) {
		if ($id) $meta = get_post_meta($id, $meta, true);
		else {
			$id = (get_the_id()) ? get_the_id() : $post->ID;
			$meta = get_post_meta($id, $meta, true);
		}
	} else
		$meta = '';

	return $meta;
}
function meta ($meta, $id = '') { echo get_meta($meta, $id); }


/*
**    content_fields_template_action ()
**
**    Remplate action to get content of a box.
*/
function content_fields_template_action ($title, $options = array()) {
	get_box($title, $options);
}

add_action('content_fields', 'content_fields_template_action', 10, 2);

/*
// I'm duplicating this function here - it's in the admin object too. 
function mf_get_boxes() {
	global $content_fields_boxes, $content_fields;

	$content_fields = $content_fields->get_data() ; //get_option('content_fields_boxes');

	if (!is_array($content_fields)) $content_fields = array();
	if (!is_array($content_fields_boxes)) $content_fields_boxes = array();
		
	foreach (array_keys($content_fields_boxes) as $key)
		$content_fields[$key] = $content_fields_boxes[$key];
		return $content_fields;
	}	
*/
?>