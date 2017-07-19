<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
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
			<?php edit_post_link( esc_html__( 'Edit', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!--end article-meta-->
	<?php endif;?>

	<div class="article-content">
		<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kleo_framework' ), 'after' => '</div>' ) ); ?>
	</div><!--end article-content-->
	

</article>

<!-- End  Article -->