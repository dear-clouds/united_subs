<?php get_header(); ?>
<div class="main-container author-page timeline"><!--container-->
<?php if(mom_option('breadcrumb') != 0) { ?>
	 <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
       <?php mom_breadcrumb(); ?>
        <?php the_title(); ?>
    </div>
    <?php } ?>
<div class="full-main-content" role="main">
<div class="site-content page-wrap">
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
                        <div class="entry-attachment">
<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
                        <p class="attachment"><a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
                        </p>
<?php else : ?>
                        <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
<?php endif; ?>
                        </div>

<?php endwhile; ?>

<?php endif; ?>
</div>
	</div>
</div>
</div><!-- wrap -->
<?php get_footer(); ?>