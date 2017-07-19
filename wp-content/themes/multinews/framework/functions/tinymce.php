<?php
//Tinymce
function mom_tinymce_script() {
      global $pagenow, $typenow;
  if (empty($typenow) && !empty($_GET['post'])) {
    $post = get_post($_GET['post']);
    $typenow = $post->post_type;
  }
    if ($pagenow=='post-new.php' OR $pagenow=='post.php' OR $pagenow=='admin.php') { 
global $wpdb;
$cats = get_terms("category");
$formats = get_theme_support( 'post-formats' );
$ads = get_posts('post_type=ads&posts_per_page=-1');

$faces = array('abel', 'arial');
if ($pagenow=='post-new.php' OR $pagenow=='post.php') {
      $the_id = get_the_ID();  
} else {
    $the_id = '';  
}


?>
<script type="text/javascript">
post_id = '<?php echo $the_id; ?>';
mom_url = '<?php echo get_template_directory_uri(); ?>';
$cats = '<?php 
        echo '<option value="">Select Category ...</option>';
        foreach ( $cats as $cat ) {
        echo '<option value="'.$cat->term_id.'">' . esc_attr($cat->name) . '</option>';
        }
?>';

$formats = '<?php 
        foreach ( $formats[0] as $format ) {
        echo '<option value="'.$format.'">' . esc_attr($format) . '</option>';
        }
?>';
$faces = '<?php 
        foreach ( $faces as $key => $face ) {
        echo '<option value="'.$key.'">' . esc_attr($face) . '</option>';
        }
?>';

$ads = '<?php 
foreach($ads as $item) {
        echo '<option value="'.$item->ID.'">' . esc_attr($item->post_title) . '</option>';
        }
    ?>';
</script>
<?php
}
}
add_action( 'in_admin_footer', 'mom_tinymce_script' );