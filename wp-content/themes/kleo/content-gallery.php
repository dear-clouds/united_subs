<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<?php
$post_class = 'clearfix';
if( is_single() && get_cfield( 'centered_text' ) == 1 ) { $post_class .= ' text-center'; }
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array( $post_class )); ?>>

	<?php if ( ! is_single() ) : ?>
		<h2 class="article-title entry-title">
				<a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
	<?php endif;?>

	<?php if(kleo_postmeta_enabled()): ?>
		<div class="article-meta">
			<span class="post-meta">
				<?php kleo_entry_meta();?>
			</span>
			<?php edit_post_link( __( 'Edit', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!--end article-meta-->
	<?php endif;?>

	<?php 
	$slides = get_cfield('slider');
	if ( kleo_postmedia_enabled() && !empty( $slides ) ) 
	{
		echo '<div class="article-media kleo-banner-slider">'
			.'<div class="kleo-banner-items modal-gallery">';

		foreach($slides as $slide) {
			if ($slide) {
			echo '<article><a href="'.  $slide.'" data-rel="modalPhoto[inner-gallery]"><img src="'.$slide.'" alt="'. get_the_title() .'">'.kleo_get_img_overlay().'</a></article>';
			}
		}		

		echo '</div>'
			. '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
			. '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
			. '<div class="kleo-banner-features-pager carousel-pager"></div>'
			.'</div>';		
	}
	?>

	<div class="article-content">
	<?php if ( !is_single() ) : // Only display Excerpts for Search ?>

			<?php echo kleo_excerpt(50); ?>
            <p class="kleo-continue"><a class="btn btn-default" href="<?php the_permalink()?>"><?php esc_html_e("Continue reading", 'kleo_framework');?></a></p>

	<?php else : ?>

		<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kleo_framework' ), 'after' => '</div>' ) ); ?>

	<?php endif; ?>
					
	</div><!--end article-content-->

</article>
<!-- End  Article -->