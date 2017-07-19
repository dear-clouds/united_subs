<?php
/**
 * Boss shortcodes
 *
 * @package Boss
 */

/**
 * This is the file that contains all the shortcodes logic
 */


/**
 * Shortcode Generator Class
 */

new Shortcode_Tinymce();

class Shortcode_Tinymce
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'bboss_shortcode_button'));
        add_action('admin_footer', array($this, 'bboss_shortcodes_dialog'));
    }

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function bboss_shortcode_button()
    {
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
        {
            add_filter( 'mce_external_plugins', array($this, 'bboss_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'bboss_register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin script array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function bboss_add_buttons( $plugin_array )
    {
        global $tinymce_version;

        if(version_compare($tinymce_version[0], 4, ">="))
        {
             $plugin_array['pushortcodes'] = get_template_directory_uri() . '/buddyboss-inc/buddyboss-shortcodes/admin/shortcode-tinymce-button.js';
        }
        else
        {
             $plugin_array['pushortcodes'] = get_template_directory_uri() . '/buddyboss-inc/buddyboss-shortcodes/admin/shortcode-tinymce-button-old-wp.js';
        }


        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function bboss_register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'pushortcodes' );
        return $buttons;
    }

    /**
     * Add shortcode form to page
     *
     */

    public function bboss_shortcodes_dialog() {

		global $hook_suffix;

		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
			return;
		}

        /**
         * Assign the Boss version to a var
         */
        $theme 		    = wp_get_theme( 'boss' );
        $boss_version   = $theme['Version'];

        wp_enqueue_style('admin-style', get_template_directory_uri() . '/buddyboss-inc/buddyboss-shortcodes/admin/admin-style.css', array(), $boss_version );
        wp_enqueue_script('jquery-ui-dialog');

        echo '<div class="shortcodes_dialog">';
            ?>

            <!-- OPEN -->
            <form name="swiftframework_shortcode_form" action="#">

                <!-- OPEN #shortcode_wrap -->
                <div id="shortcode_wrap">

                    <!-- CLOSE #shortcode_panel -->
                    <div id="shortcode_panel" class="current">
                        <div class="option ">
                           <div class="title-description">
                                <div class="title">
                                    <h4 class="heading"><?php _e('Select a shortcode','boss' ); ?></h4>
                                    <div><?php _e('Choose a shortcode from the list.','boss' ); ?></div>
                                </div>
                            </div>
                            <div class="controls with-desc">
                                <div class="select-overlay ">
                                    <select class="select  input" name="shortcode-select" id="shortcode-select">
                                        <option id="0" value="0" selected="selected"><?php _e('Select a shortcode','boss' ); ?></option>
                                        <option id="shortcode-accordion" value="shortcode-accordion"><?php _e('Accordion','boss' ); ?></option>
                                        <option id="shortcode-button" value="shortcode-button"><?php _e('Button','boss' ); ?></option>
                                        <option id="shortcode-buttons-group" value="shortcode-buttons-group"><?php _e('Buttons Group','boss' ); ?></option>
                                        <option id="shortcode-dropdown" value="shortcode-dropdown"><?php _e('Dropdown','boss' ); ?></option>
                                        <option id="shortcode-progress-bar" value="shortcode-progress-bar"><?php _e('Progress Bar','boss' ); ?></option>
                                        <option id="shortcode-tabs" value="shortcode-tabs"><?php _e('Tabs','boss' ); ?></option>
                                        <option id="shortcode-tooltip" value="shortcode-tooltip"><?php _e('Tooltip','boss' ); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="shortcode-accordion">
                            <h3><?php _e('Accordion','boss' ); ?></h3>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Number of accordion elements','boss' ); ?></h4>
                                        <div><?php _e('Enter the number of accordion elements.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                      <input class="input " name="accordion-size" id="accordion-size" type="text">
                                </div>
                            </div>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Default opened element','boss' ); ?></h4>
                                        <div><?php _e('Enter the number (1, 2, 3, etc.) of the accordion element to open first. If you want them all closed leave this blank.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                      <input class="input " name="accordion-open" id="accordion-open" type="text">
                                </div>
                            </div>
                        </div>
                         <!-- /#shortcode-accordion -->

                        <div id="shortcode-tabs">
                            <h3><?php _e('Tabs','boss' ); ?></h3>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Number of tabs','boss' ); ?></h4>
                                        <div><?php _e('Enter the number of tabs.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                      <input class="input " name="tabs-size" id="tabs-size" type="text">
                                </div>
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Style','boss' ); ?></h4>
                                        <div><?php _e('Choose style.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                    <select class="select input"  id="tabs-style">
                                      <option id="default" value="default"><?php _e('Default', 'boss' ); ?></option>
                                      <option id="wide" value="long"><?php _e('Long', 'boss' ); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                         <!-- /#shortcode-tabs -->

                        <div id="shortcode-progress-bar">
                            <h3><?php _e('Progress Bar','boss' ); ?></h3>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Size','boss' ); ?></h4>
                                        <div><?php _e('Choose size.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                    <select class="select  input"  id="progress-bar-size">
                                      <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                      <option id="wide" value="wide"><?php _e('Wide','boss' ); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Style','boss' ); ?></h4>
                                        <div><?php _e('Choose style.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                    <select class="select  input"  id="progress-bar-style">
                                      <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                      <option id="striped" value="striped"><?php _e('Striped','boss' ); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="option">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Title','boss' ); ?></h4>
                                        <div><?php _e('The text that appears above the progress bar.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                      <input class="input " name="progress-bar-title" id="progress-bar-title" type="text">
                                </div>
                            </div>
                            <div class="option">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Percent','boss' ); ?></h4>
                                        <div><?php _e('Don\'t enter "%", just the number e.g. "30".','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                      <input class="input " name="progress-bar-percent" id="progress-bar-percent" type="text">
                                </div>
                            </div>
                            <div class="option ">
                                <div class="title-description">
                                    <div class="title">
                                        <h4 class="heading"><?php _e('Color','boss' ); ?></h4>
                                        <div><?php _e('Default is the main site color.','boss' ); ?></div>
                                    </div>
                                </div>
                                <div class="controls with-desc">
                                    <select class="select  input"  id="progress-bar-color">
                                      <option id="blue" value="blue"><?php _e('Default','boss' ); ?></option>
                                      <option id="red" value="red"><?php _e('Red','boss' ); ?></option>
                                      <option id="green" value="green"><?php _e('Green','boss' ); ?></option>
                                      <option id="yellow" value="yellow"><?php _e('Yellow','boss' ); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                         <!-- /#shortcode-progress-bar -->

                          <div id="shortcode-button">
                                  <h3><?php _e('Button','boss' ); ?></h3>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button label','boss' ); ?></h4>
                                            <div><?php _e('The text that appears on your button.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <input class="input " name="button-text" id="button-text" type="text">
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button link','boss' ); ?></h4>
                                            <div><?php _e('Where should your button link to?','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                        <input class="input " name="button-url" id="button-url" type="text">
                                        <select class="select  input"  id="button-target">
                                          <option id="true" value="true"><?php _e('New window','boss' ); ?></option>
                                          <option id="false" value="false"><?php _e('Same window','boss' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button size','boss' ); ?></h4>
                                            <div><?php _e('Choose the size of your button here.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                        <select class="select  input" name="button-size" id="button-size">
                                          <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                          <option id="long" value="long"><?php _e('Long','boss' ); ?></option>
                                          <option id="large" value="large"><?php _e('Large','boss' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button FontAwesome icon','boss' ); ?></h4>

                                            <div><?php _e('Enter class <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <input class="input " name="button-icon" id="button-icon" type="text">
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button type','boss' ); ?></h4>
                                            <div><?php _e('Choose button type.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                        <select class="select  input" name="button-type" id="button-type">
                                          <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                          <option id="success" value="success"><?php _e('Success','boss' ); ?></option>
                                          <option id="warning" value="warning"><?php _e('Warning','boss' ); ?></option>
                                          <option id="danger" value="danger"><?php _e('Danger','boss' ); ?></option>
                                          <option id="inverse" value="inverse"><?php _e('Inverse','boss' ); ?></option>
                                          <option id="shadow" value="shadow"><?php _e('Shadow','boss' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Button bottom margin','boss' ); ?></h4>
                                            <div><?php _e('Don\'t enter "px", just the number e.g. "30".','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <input class="input " name="button-button-margin" id="button-bottom-margin" type="text">
                                    </div>
                                </div>
                            </div>
                            <!-- /#shortcode-button -->

                            <div id="shortcode-buttons-group">
                                <h3>Buttons Group</h3>
                                <div class="option ">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Number of buttons','boss' ); ?></h4>
                                            <div><?php _e('Enter the number of buttons.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <input class="input " name="buttons-group-size" id="buttons-group-size" type="text">
                                    </div>
                                </div>
                                <div class="option ">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Group type','boss' ); ?></h4>
                                            <div><?php _e('Type of buttons.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                        <select class="select  input" name="buttons-group-type" id="buttons-group-type">
                                          <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                          <option id="inverse" value="inverse"><?php _e('Inverse','boss' ); ?></option>
                                          <option id="shadow" value="shadow"><?php _e('Shadow','boss' ); ?></option>
                                          <option id="social" value="social"><?php _e('Social','boss' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="option">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Group bottom margin','boss' ); ?></h4>
                                            <div><?php _e('Don\'t enter "px", just the number e.g. "30".','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <input class="input " name="buttons-group-margin" id="buttons-group-margin" type="text">
                                    </div>
                                </div>
                            </div>
                             <!-- /#shortcode-buttons-group -->

                            <div id="shortcode-dropdown">
                                <h3>Dropdown</h3>
                                <div class="option ">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Unordered List','boss' ); ?></h4>
                                            <div><?php _e('Example:<br /><br />&lt;ul&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item one&lt;/li&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item with dropdowns:&lt;/li&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;ul&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;Subitem 1&lt;/li&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;Subitem 2&lt;/li&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;/ul&gt;<br />&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;Final list item&lt;/li&gt;<br />&lt;/ul&gt;','boss' ); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <textarea class="input testc default-textarea" name="dropdown-ul" id="dropdown-ul" cols="8" rows="8"></textarea>
                                    </div>
                                </div>
                                <div class="option ">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Style','boss' ); ?></h4>
                                            <div><?php _e('Choose style.','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                        <select class="select  input" name="dropdown-style" id="dropdown-style">
                                          <option id="default" value="default"><?php _e('Default','boss' ); ?></option>
                                          <option id="dark" value="dark"><?php _e('Dark','boss' ); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <!-- /#shortcode-dropdown -->

                            <div id="shortcode-tooltip">
                                <h3>Tooltip</h3>
                                <div class="option ">
                                    <div class="title-description">
                                        <div class="title">
                                            <h4 class="heading"><?php _e('Tooltip text goes in title attribute','boss' ); ?></h4>
                                            <div><?php _e('Ex:<br /><br />&lt;span title="Tooltip text"&gt;This becomes a tooltip&lt;/span&gt;','boss' ); ?></div>
                                        </div>
                                    </div>
                                    <div class="controls with-desc">
                                          <textarea class="input testc default-textarea" name="tooltip-content" id="tooltip-content" cols="8" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                             <!-- /#shortcode-tooltip -->


                        <div class="buttons clearfix">
                            <a href="#" id="insert-short" class="inactive button button-primary button-large" disabled="disabled"><?php _e('Insert shortcode','boss');?></a>
                        </div>

                    <!-- CLOSE #shortcode_panel -->
                    </div>

                <!-- CLOSE #shortcode_wrap -->
                </div>

            <!-- CLOSE  -->
            </form>

        <?php

        echo '</div>';
    }
}


/*--------------------------------------------------------------------------------------------------
	Buttons
--------------------------------------------------------------------------------------------------*/
/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_buttons( $atts, $content=null ) {
	/*
        example: [button size="long" url="#" open_new_tab="false" text="Button Text" icon="fa-arrows" type="inverse" bottom_margin="15"]
    */
    extract(shortcode_atts(
        array('size' => '', //default, long, large
              'url' => '#',
              'open_new_tab' => 'true',
              'text' => '',
              'icon' => '', //Font Awesome icon class (http://fortawesome.github.io/Font-Awesome/icons/)
              'type' => '',  //default, success, warning, danger, inverse, shadow
              'bottom_margin' => ''
             ), $atts));

	$target = ($open_new_tab == 'true') ? 'target="_blank"' : null;
    $icon_html = ($icon)?'<i class="fa '.$icon.'"></i>':null;
    $style = '';

    if($bottom_margin) {
        $style .= 'style="margin-bottom:';
        $style .= $bottom_margin;
        $style .= 'px"';
    }

    return '<a class="btn '.$type.' '.$size.'" '. $target .'  '. $style .'  href="' . $url . '">'.$icon_html.' '. $text . '</a>';

}

add_shortcode('button', 'buddyboss_shortcode_buttons');

/*--------------------------------------------------------------------------------------------------
	Button Group
--------------------------------------------------------------------------------------------------*/
/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_button_group( $atts, $content=null ) {
	/*
        example: [button_group type="inverse" bottom_margin="15"][/button_group]
    */
    extract(shortcode_atts(
        array("size" => '',
              'type' => '', //default, inverse, shadow, social
              'bottom_margin' => ''
             ), $atts));

    $style = '';

    if($bottom_margin) {
        $style .= 'style="margin-bottom:';
        $style .= $bottom_margin;
        $style .= 'px"';
    }

    return '<div class="btn-group '.$type.' '.$size.'" '. $style .'>'.do_shortcode($content) . '</div>';

}

add_shortcode('button_group', 'buddyboss_shortcode_button_group');

/*--------------------------------------------------------------------------------------------------
	Accordion
--------------------------------------------------------------------------------------------------*/
/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_accordion( $atts, $content = null ) {
	/*
        example: [accordion open="1"][accordion_element title="Title"] Content [/accordion_element][/accordion]
    */
    extract(shortcode_atts(
    array("open" => 'false' //false, 1, 2, ...
         ), $atts));

    if(is_numeric($open)) {
        $open--;
    }

	$return = '<div class="accordion" data-open='.$open.'>';
    $return .= do_shortcode($content);
    $return .= '</div>';

	return $return;

}

/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */

function buddyboss_shortcode_accordion_element( $atts, $content = null ) {

    extract(shortcode_atts(array(
		"title" => ''
	), $atts));

    $return = '<h3>'.$title.'</h3>';
    $return .= '<div>';
        $return .= '<div class="inner">';
            $return .= do_shortcode($content);
        $return .= '</div>';
    $return .= '</div>';

	return $return;

}

add_shortcode('accordion', 'buddyboss_shortcode_accordion');
add_shortcode('accordion_element', 'buddyboss_shortcode_accordion_element');

/*--------------------------------------------------------------------------------------------------
	Tabs
--------------------------------------------------------------------------------------------------*/
/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
$tabs_divs = '';

function buddyboss_shortcode_tabs($atts, $content = null ) {

    /*
        example: [tabs style=""]  [tab id="some_id1" title="TAB_NAME"] CONTENT1 [/tab]  [tab id="some_id2" title="TAB_NAME"] CONTENT2 [/tab]  [tab id="some_id3" title="TAB_NAME"] CONTENT3 [/tab][/tabs]
    */

    extract(shortcode_atts(array(
        'style' => '' // default, long
    ), $atts));

    global $tabs_divs;

    $tabs_divs = '';

    $output = '<div class="tabs">';
    $output.='<ul class="btn-group inverse '.$style.'">'.do_shortcode($content).'</ul>';
    $output.= $tabs_divs;
    $output.= '</div>';

    return $output;
}

/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_tab($atts, $content = null) {
    global $tabs_divs;

    extract(shortcode_atts(array(
        'id' => '',
        'title' => '',
    ), $atts));

    if(empty($id))
        $id = 'side-tab'.rand(100,999);

    $output = '
        <li class="btn">
            <a href="#'.$id.'">'.$title.'</a>
        </li>
    ';

    $tabs_divs.= '<div id="'.$id.'">'.$content.'</div>';

    return $output;
}

add_shortcode('tabs', 'buddyboss_shortcode_tabs');
add_shortcode('tab', 'buddyboss_shortcode_tab');


/*--------------------------------------------------------------------------------------------------
	Progress Bar
--------------------------------------------------------------------------------------------------*/

/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_progress_bar($atts, $content = null) {
    /*
        example: [progress_bar size="wide" style="striped" title="Title" percent="30" color="red"]
    */
    extract(shortcode_atts(array(
        'size' => '', // default, wide
        'style' => '', // default, striped
        'title' => '',
        'percent' => '', // nubmer, between 0 and 100
        'color' => 'blue', // blue, red, green, yellow
    ), $atts));

    $output = '<div class="progressbar-wrap '.$size.' '.$color.' '.$style.'">';
    $output .= '<p class="title">'.$title.'</p><p class="percent">'.$percent.'%</p>';
    $output .= '<div class="progressbar" data-progress="'.$percent.'">';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('progress_bar', 'buddyboss_shortcode_progress_bar');

/*--------------------------------------------------------------------------------------------------
	Dropdown
--------------------------------------------------------------------------------------------------*/

/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_dropdown($atts, $content = null) {
    /*
        example: [dropdown style="dark"]<ul><li>item1</li><li>item2</li></ul>[/dropdown]
    */
    extract(shortcode_atts(array(
        'style' => '', // default, dark
    ), $atts));

    $output = '<div class="menu-dropdown '.$style.'">'.$content.'</div>';

    return $output;
}

add_shortcode('dropdown', 'buddyboss_shortcode_dropdown');

/*--------------------------------------------------------------------------------------------------
	Tooltip
--------------------------------------------------------------------------------------------------*/

/**
 * @since Boss 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_tooltip($atts, $content = null) {
    /*
        example: [tooltip]<a href="" title="Tootip">Tooltip</a>[/tooltip]]
    */

    $output = '<span class="tooltip">'.$content.'</span>';

    return $output;
}

add_shortcode('tooltip', 'buddyboss_shortcode_tooltip');

/*--------------------------------------------------------------------------------------------------
	Checked list
--------------------------------------------------------------------------------------------------*/

/**
 * @since Boss 2.0.2
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function buddyboss_shortcode_checklist($atts, $content = null) {
    /*
        example: [checklist]<ul></ul>[/checklist]
    */
    extract(shortcode_atts(array(
        'uncheck' => false, // false, true
    ), $atts));

    $class = ($uncheck)?'unchecked':'checked';

    $output = '<div class="checklist '.$class.'">'.$content.'</div>';

    return $output;
}

add_shortcode('checklist', 'buddyboss_shortcode_checklist');

?>
