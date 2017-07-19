<?php

class WikiTagsWidget extends WP_Widget {
    
    /**
     * @var		string	$translation_domain	Translation domain
     */
    var $translation_domain = 'wiki';
    
    function __construct() {
	$widget_ops = array( 'description' => __('Display Wiki Tags', $this->translation_domain) );
        $control_ops = array( 'title' => __('Wiki Tags', $this->translation_domain), 'hierarchical' => 'yes' );
        
	parent::WP_Widget( 'incsub_wiki_tags', __('Wiki Tags', $this->translation_domain), $widget_ops, $control_ops );
    }
    
    function widget($args, $instance) {
	global $wpdb, $current_site, $post, $wiki_tree;
	
	extract($args);
	
	$options = $instance;
	
	$title = apply_filters('widget_title', empty($instance['title']) ? __('Wiki Tags', $this->translation_domain) : $instance['title'], $instance, $this->id_base);
	
	?>
	<?php echo $before_widget; ?>
	<?php echo $before_title . $title . $after_title; ?>
	<ul>
	    <?php echo wp_list_categories('taxonomy=incsub_wiki_tag&title_li='); ?>
	</ul>
        <?php echo $after_widget; ?>
	<?php
    }
    
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => __('Wiki Tags', $this->translation_domain) ) );
        $instance['title'] = strip_tags($new_instance['title']);
	
        return $instance;
    }
    
    function form($instance) {
	$instance = wp_parse_args( (array) $instance, array( 'title' => __('Wiki Tags', $this->translation_domain) ) );
        $options = array('title' => strip_tags($instance['title']) );
	
	?>
	<div style="text-align:left">
            <label for="<?php echo $this->get_field_id('title'); ?>" style="line-height:35px;display:block;"><?php _e('Title', $this->translation_domain); ?>:<br />
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $options['title']; ?>" type="text" style="width:95%;" />
            </label>
	    <input type="hidden" name="wiki-submit" id="wiki-submit" value="1" />
	</div>
	<?php
    }
}

