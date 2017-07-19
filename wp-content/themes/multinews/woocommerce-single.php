<?php get_header(); ?>
<?php 
global $post;
$pagebreadcrumb = get_post_meta($post->ID, 'mom_hide_breadcrumb', true);
$icon = get_post_meta($post->ID, 'mom_page_icon', true);
?>
    <div class="inner">
    	<?php if(mom_option('breadcrumb') != 0) { ?>
		 <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
            <div class="crumb-icon"><i class="enotype-icon-cart"></i></div>
            <?php woocommerce_breadcrumb(); ?>
        </div>
        <?php } else { ?>
			<span class="mom-page-title"><h1><?php woocommerce_page_title(); ?></h1></span>
		<?php } ?>

	<div class="main_container fullwidth">
        <div class="base-box page-wrap">
			<?php woocommerce_content(); ?>
        </div> <!-- base box -->
            <div class="clear"></div>
</div> <!--main container-->            
</div> <!--main inner-->
            
<?php get_footer(); ?>