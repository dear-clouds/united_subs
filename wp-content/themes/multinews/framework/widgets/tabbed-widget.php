<?php

/*
 froked from : D4P Smashing Tabber (http://www.dev4press.com/plugins/)
*/

class mom_tabbed_widget extends WP_Widget {
    var $defaults = array(
        'title' => '',
        'sidebar' => '',
        'class' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        parent::__construct('MomizatTabber', __('Momizat - Tabbed Widget', 'framework'), array('description' => __('Sidebar into tabbed widget.', 'framework')));
    }

    public function widget($args, $instance) {
        add_filter('dynamic_sidebar_params', array(&$this, 'widget_sidebar_params'));

        extract($args, EXTR_SKIP);
$title = apply_filters('widget_title', $instance['title'] );


        echo $before_widget;
if ( $title )
            echo $before_title . $title . $after_title;

            if ($args['id'] != $instance['sidebar']) {
                ?>
                        <div class="main_tabs">
                            <ul class="widget-tabbed-header"></ul>
                            <div class="widget-tabbed-body">
                                <?php dynamic_sidebar($instance["sidebar"]); ?>
                            </div>
                        </div> <!--main tabs-->

            <?php
            } else {
                _e('Tabbed widget is not properly configured.', 'framework');
            }
        echo $after_widget;

        remove_filter('dynamic_sidebar_params', array(&$this, 'widget_sidebar_params'));
    }

    public function form($instance) {
        global $wp_registered_sidebars;
        $instance = wp_parse_args((array)$instance, $this->defaults);

        ?>        
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>
    
        <p><label>Sidebar:</label>
            <select style="background-color: white;" class="widefat d4p-tabber-sidebars" id="<?php echo $this->get_field_id('sidebar'); ?>" name="<?php echo $this->get_field_name('sidebar'); ?>">
                <?php

                foreach ($wp_registered_sidebars as $id => $sidebar) {
                    if ($id != 'wp_inactive_widgets') {
                        $selected = $instance['sidebar'] == $id ? ' selected="selected"' : '';
                        echo sprintf('<option value="%s"%s>%s</option>', $id, $selected, $sidebar['name']);
                    }
                }

                ?>
            </select><br/>
            <em><?php _e('Make sure not to select Sidebar holding this widget. If you do that, Tabber will not be visible.', 'framework'); ?></em>
        </p>
        <p><label><?php _e('CSS Class:', 'framework'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo $instance['class']; ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['sidebar'] = strip_tags(stripslashes($new_instance['sidebar']));
        $instance['class'] = strip_tags(stripslashes($new_instance['class']));

        return $instance;
    }

    public function widget_sidebar_params($params) {
        $params[0]['before_widget'] = '<div class="widget-tab">';
        $params[0]['after_widget'] = '</div>';
        $params[0]['before_title'] = '<a href="#" class="mom-tw-title"><span class="before"></span><span class="after"></span>';
        $params[0]['after_title'] = '</a>';

        return $params;
    }
}

//add_action('init', 'mom_tabbed_init');
add_action('widgets_init', 'mom_tabbed_widget_init');

function mom_tabbed_init() {
            global $wp_registered_sidebars;
            $n = count($wp_registered_sidebars);
    register_sidebar(array('name' => 'Tabbed Widget', 'id' => 'sidebar-' . ++$n,  'description' => 'Default Tabbed Widget sidebar, you can add you custom one with custom sidebars.'));
}

function mom_tabbed_widget_init() {
    register_widget('mom_tabbed_widget');
}

?>