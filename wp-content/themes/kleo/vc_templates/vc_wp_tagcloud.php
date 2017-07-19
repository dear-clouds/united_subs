<?php
$output = $title = $el_class = $taxonomy = $context = '';
extract( shortcode_atts( array(
	'title' => __( 'Tags' ),
	'taxonomy' => 'post_tag',
	'context' => 'all_posts',
	'el_class' => ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

$output = '<div class="vc_wp_tagcloud wpb_content_element' . $el_class . '">';
$type = 'WP_Widget_Tag_Cloud';
$args = array();


$no_tags =  false;
 if ( $taxonomy == 'post_tag' && $context == 'single_post' ) {
	global $post, $tag_ids;
	$tag_ids = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
	if ( !empty( $tag_ids ) ) {
        $my_func = create_function('', 'global $tag_ids; return array("taxonomy" => "post_tag", "include" => $tag_ids);');
        add_filter( 'widget_tag_cloud_args', $my_func );
    } else {
		$no_tags = true;
	}
}

if ( $no_tags ) {
	echo __( "No tags defined", "kleo_framework" );
} else {
	ob_start();
	the_widget( $type, $atts, $args );
	$output .= ob_get_clean();
	
	$output .= '</div>' . $this->endBlockComment( 'vc_wp_tagcloud' ) . "\n";
	
	echo $output;

    if ( isset( $my_func ) ) {
        remove_filter( 'widget_tag_cloud_args', $my_func );
    }
}