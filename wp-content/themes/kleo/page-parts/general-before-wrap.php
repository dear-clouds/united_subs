<?php
/**
 * Before content wrap
 * Used in all templates
 */
?>
<?php
$main_tpl_classes = apply_filters('kleo_main_template_classes', '');

if (kleo_has_shortcode('kleo_bp_')) {
	$section_id = 'id="buddypress" ';
}	else {
	$section_id = '';
}

$container = apply_filters('kleo_main_container_class','container');

/**
 * Before main content - action
 */
do_action('kleo_before_content');

?>

<section class="container-wrap main-color">
	<div id="main-container" class="<?php echo $container; ?>">
		<?php if($container == 'container') { ?><div class="row"> <?php } ?>

			<div <?php echo $section_id;?>class="template-page <?php echo $main_tpl_classes; ?>">
				<div class="wrap-content">
					
				<?php
				/**
				 * Before main content - action
				 */
				do_action('kleo_before_main_content');
				?>