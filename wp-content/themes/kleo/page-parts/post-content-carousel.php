<?php
/** 
 * Single item Post carousel
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

global $kleo_config;
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(array("post-item col-sm-4")); ?>>
	<article>

	<?php 
	$kleo_post_format = get_post_format();

    /* For portfolio post type */
    if ( get_post_type() == 'portfolio' ) {
        if ( get_cfield( 'media_type' ) && get_cfield( 'media_type' ) != '' ) {
            $media_type = get_cfield( 'media_type' );
            switch ( $media_type ) {
                case 'slider':
                    $kleo_post_format = 'gallery';
                    break;

                case 'video':
                case 'hosted_video':
                    $kleo_post_format = 'video';
                    break;
            }
        }
    }

	switch ($kleo_post_format) {

		case 'video':
			//oEmbed video
			$video = get_cfield('embed');
			// video bg self hosted
			$bg_video_args = array();
			$k_video = '';

			if (get_cfield('video_mp4') ) {
				$bg_video_args['mp4'] = get_cfield('video_mp4');
			}
			if (get_cfield('video_ogv') ) {
				$bg_video_args['ogv'] = get_cfield('video_ogv');
			}
			if (get_cfield('video_webm') ) {
				$bg_video_args['webm'] = get_cfield('video_webm');
			}

			if ( !empty($bg_video_args) ) {
				$attr_strings = array(
						'preload="none"'
				);

				$k_video .= '<div class="kleo-video-wrap"><video ' . join( ' ', $attr_strings ) . ' controls="controls" class="kleo-video" style="width: 100%; height: 100%;">';

				$source = '<source type="%s" src="%s" />';
				foreach ( $bg_video_args as $video_type=>$video_src ) {
					$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
					$k_video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );
				}

				$k_video .= '</video></div>';

				echo $k_video;
			}
			// oEmbed
			elseif (!empty($video)) {
				global $wp_embed;
                echo '<div class="kleo-video-embed">';
				echo apply_filters('kleo_oembed_video', $video);
                echo '</div>';
			}
			break;

		case 'audio':

			$audio = get_cfield('audio');
			if(!empty($audio)) {
				?>
				<div class="post-audio">
					<audio preload="none" class="kleo-audio" id="audio_<?php the_id();?>" style="width:100%;" src="<?php echo $audio; ?>"></audio>
				</div>
				<?php
			}
			break;

		case 'gallery':

			$slides = get_cfield('slider');
			echo '<div class="kleo-banner-slider">'
				.'<div class="kleo-banner-items modal-gallery">';
			if ( $slides ) {
				foreach( $slides as $slide ) {
					if ( $slide ) {
						$image = aq_resize( $slide, $kleo_config['post_gallery_img_width'], $kleo_config['post_gallery_img_height'], true, true, true );
						//small hack for non-hosted images
						if (! $image ) {
							$image = $slide;
						}
						if( $image ) {
							echo '<article>
								<a href="'. $slide .'" data-rel="modalPhoto[inner-gallery]">
									<img src="'.$image.'" alt="'. get_the_title() .'">'
									.kleo_get_img_overlay()
								.'</a>
							</article>';
						}
					}
				}
			}

			echo '</div>'
				. '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
				. '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
				. '<div class="kleo-banner-features-pager carousel-pager"></div>'
				.'</div>';

			break;

		case 'image':
		default:
			
			if ( kleo_get_post_thumbnail_url() != '' ) {
				echo '<div class="post-image">';
				$img_url = kleo_get_post_thumbnail_url();
				$image = aq_resize( $img_url, $kleo_config['post_gallery_img_width'], $kleo_config['post_gallery_img_height'], true, true, true );
				if( $image ) {
					echo '<a href="'. get_permalink() .'" class="element-wrap">'
						. '<img src="'.$image.'" alt="'. get_the_title() .'">'
						. kleo_get_img_overlay()
						. '</a>';	
				}
				echo '</div><!--end post-image-->';
			}
			
			break;
	}
	?>

		<div class="entry-content">
			<h4 class="post-title entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>

            <span class="post-meta hidden hide">
                <?php kleo_entry_meta();?>
            </span>

			<?php if (kleo_excerpt() != '<p></p>') : ?>
				<hr>
				<div class="entry-summary">
					<?php echo kleo_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>
		</div><!--end post-info-->

	</article>
</li>