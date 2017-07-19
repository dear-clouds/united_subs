<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package Kleo
 * @subpackage Twenty_Fourteen
 * @since Kleo 1.0
 */
?>

<?php
$post_class = 'clearfix';
if( is_single() && get_cfield( 'centered_text' ) == 1 ) { $post_class .= ' text-center'; }
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class( array( $post_class ) ); ?>>

	<?php if ( !is_single() ) : ?>
	<h2 class="article-title entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'kleo_framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>
	<?php endif; // is_single() ?>

	<?php if(kleo_postmeta_enabled()): ?>
		<div class="article-meta">
			<span class="post-meta">
				<?php kleo_entry_meta();?>
			</span>
			<?php edit_post_link( __( 'Edit', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!--end article-meta-->
	<?php endif;?>

	<?php 
	if( kleo_postmedia_enabled() ) : ?>

		<div class="article-media">
		 <?php 
		 //oEmbed video
		 $video = get_cfield('embed');
		// video bg self hosted
		$bg_video_args = array();
		$k_video = '';
		
		if ( get_cfield('video_mp4') ) {
			$bg_video_args['mp4'] = get_cfield('video_mp4');
		}
		if ( get_cfield('video_ogv') ) {
			$bg_video_args['ogv'] = get_cfield('video_ogv');
		}
		if ( get_cfield('video_webm') ) {
			$bg_video_args['webm'] = get_cfield('video_webm');
		}
		
		if ( !empty($bg_video_args) ) {
			$attr_strings = array(
					'preload="none"'
			);
            if (get_cfield( 'video_poster' ) ) {
                $attr_strings[] = 'poster="' . get_cfield( 'video_poster' ) . '"';
            }

			$k_video .= '<div class="kleo-video-wrap"><video ' . join( ' ', $attr_strings ) . ' controls="controls" class="kleo-video" style="height: 100%; width: 100%;">';

			$source = '<source type="%s" src="%s" />';
			foreach ( $bg_video_args as $video_type => $video_src ) {
				$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
				$k_video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );
			}

			$k_video .= '</video></div>';
			
			echo $k_video;
		}
		// oEmbed
		elseif (!empty($video)) {
			global $wp_embed;
			echo apply_filters('kleo_oembed_video', $video); 
		}
		?>
			
		</div><!--end article-media-->

	<?php endif; ?>


	<div class="article-content">
	<?php if ( !is_single() ) : // Only display Excerpts for Search ?>

			<?php echo kleo_excerpt(50); ?>
            <p class="kleo-continue"><a class="btn btn-default" href="<?php the_permalink()?>"><?php _e("Continue reading", 'kleo_framework');?></a></p>

	<?php else : ?>

		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'kleo_framework' ), 'after' => '</div>' ) ); ?>

	<?php endif; ?>
	</div><!--end article-content-->
	
</article>
<!-- End  Article -->