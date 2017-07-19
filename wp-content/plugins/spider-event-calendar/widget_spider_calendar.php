<?php
if (!class_exists('WP_Widget')) {
  return;
}
class spider_calendar extends WP_Widget {
  // Constructor //
  function __construct(){
    $widget_ops = array(
      'classname' => 'spider_calendar',
      'description' => 'Spider Calendar is a highly configurable product which allows you to have multiple organized events.'
    );
    $control_ops = array('id_base' => 'spider_calendar'); // Widget Control Settings.
    parent::__construct('spider_calendar', 'Spider Calendar', $widget_ops, $control_ops); // Create the widget.
  }

  // Extract Args //
  function widget($args, $instance) {
    extract($args);
    $title = $instance['title'];
    $id = $instance['calendar'];
    $theme = (($instance['theme']) ? $instance['theme'] : 1);
    $default_view = (isset($instance['default_view']) && $instance['default_view'] != '') ? $instance['default_view'] : 'month';
    $view = ((isset($instance['view_0']) && $instance['view_0'] != '') ? $instance['view_0'] . ',' : '');
    $view .= ((isset($instance['view_1']) && $instance['view_1'] != '') ? $instance['view_1'] . ',' : '');
    $view .= ((isset($instance['view_2']) && $instance['view_2'] != '') ? $instance['view_2'] . ',' : '');
    $view .= ((isset($instance['view_3']) && $instance['view_3'] != '') ? $instance['view_3'] . ',' : '');
    if ($view == '') {
      $view = 'month,';
    }
    // Before widget //
    echo $before_widget;
    // Title of widget //
    if ($title) {
      echo $before_title . $title . $after_title;
    }
    // Widget output //
    if ($id) {
      global $wpdb;
      $calendar_widget = 1;
      if (!$wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "spidercalendar_widget_theme WHERE id='%d'", $theme))) {
        echo "Spider Calendar Widget Theme not Found please reinstall plugin.";
      }
      else {
        echo Spider_calendar_big_front_end($id, $theme, $default_view, $view, $calendar_widget);
      }
    }
    // After widget //
    echo $after_widget;
  }

  // Update Settings //
  function update($new_instance, $old_instance) {
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['calendar'] = $new_instance['calendar'];
    $instance['theme'] = $new_instance['theme'];
    $instance['default_view'] = $new_instance['default_view'];
    $instance['view_0'] = $new_instance['view_0'];
    $instance['view_1'] = $new_instance['view_1'];
    $instance['view_2'] = $new_instance['view_2'];
    $instance['view_3'] = $new_instance['view_3'];
    return $instance;
  }

  // Widget Control Panel //
  function form($instance) {
    global $wpdb;
    $defaults = array(
      'title' => 'Events',
      'calendar' => '0',
      'theme' => '0',
      'default_view' => 'month',
      'view_0' => 'month',
      'view_1' => '',
      'view_2' => '',
      'view_3' => '',
    );
    $instance = wp_parse_args((array)$instance, $defaults);
    $all_clendars = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_calendar');
    $all_themes = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme');
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>"/>
    </p>
    <table width="100%" class="paramlist admintable" cellspacing="1">
      <tbody>
        <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size:10px" for="<?php echo $this->get_field_id('calendar'); ?>" class="hasTip">Select Calendar:</label>
            </span>
          </td>
          <td class="paramlist_value">
            <select name="<?php echo $this->get_field_name('calendar'); ?>" id="<?php echo $this->get_field_id('calendar'); ?>" style="font-size:10px;width:120px;" class="inputbox">
              <option value="0">Select Calendar</option>
              <?php
              $sp_calendar = count($all_clendars);
              for ($i = 0; $i < $sp_calendar; $i++) {
                ?>
              <option value="<?php echo $all_clendars[$i]->id; ?>" <?php if ($instance['calendar'] == $all_clendars[$i]->id) echo  'selected="selected"'; ?>><?php echo $all_clendars[$i]->title ?></option>
              <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size:10px" for="<?php echo $this->get_field_id('theme'); ?>" class="hasTip">Select Theme:</label>
            </span>
          </td>
          <td class="paramlist_value">
            <select name="<?php echo $this->get_field_name('theme'); ?>" id="<?php echo $this->get_field_id('theme'); ?>" style="font-size:10px; width:120px;" class="inputbox">
              <option value="0">Select Theme</option>
              <?php
              $sp_theme = count($all_themes);
              for ($i = 0; $i < $sp_theme; $i++) {
                ?>
              <option value="<?php echo $all_themes[$i]->id; ?>" <?php if ($instance['theme'] == $all_themes[$i]->id) echo 'selected="selected"'; ?>><?php echo $all_themes[$i]->title; ?></option>
                <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class="key"><label for="<?php echo $this->get_field_id('default_view'); ?>">Default View:</label></td>
          <td>
            <select id="<?php echo $this->get_field_id('default_view'); ?>" name="<?php echo $this->get_field_name('default_view'); ?>" style="font-size:10px; width:120px;">
              <option value="month" <?php if ($instance['default_view'] == 'month') echo 'selected="selected"'; ?>>Month</option>
              <option value="list" <?php if ($instance['default_view'] == 'list') echo 'selected="selected"'; ?>>List</option>
              <option value="week" <?php if ($instance['default_view'] == 'week') echo 'selected="selected"'; ?>>Week</option>
              <option value="day" <?php if ($instance['default_view'] == 'day') echo 'selected="selected"'; ?>>Day</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="key"><label for="<?php echo $this->get_field_id('view_0'); ?>">Select Views:</label></td>
          <td>
            <input type="checkbox" id="<?php echo $this->get_field_id('view_0'); ?>" name="<?php echo $this->get_field_name('view_0'); ?>" <?php if ($instance['view_0'] == 'month') echo 'checked="checked"'; ?> value="month" style="width:30px;">Month
            <input type="checkbox" id="<?php echo $this->get_field_id('view_1'); ?>" name="<?php echo $this->get_field_name('view_1'); ?>" <?php if ($instance['view_1'] == 'list') echo 'checked="checked"'; ?> value="list" style="width:30px;">List
            <input type="checkbox" id="<?php echo $this->get_field_id('view_2'); ?>" name="<?php echo $this->get_field_name('view_2'); ?>" <?php if ($instance['view_2'] == 'week') echo 'checked="checked"'; ?> value="week" style="width:30px;">Week
            <input type="checkbox" id="<?php echo $this->get_field_id('view_3'); ?>" name="<?php echo $this->get_field_name('view_3'); ?>" <?php if ($instance['view_3'] == 'day') echo 'checked="checked"'; ?> value="day" style="width:30px;">Day
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }
}

add_action('widgets_init', create_function('', 'return register_widget("spider_calendar");'));
?>