<?php

class rhc_single_og {
	function __construct(){
		add_action('wp_head', array( &$this, 'wp_head' ), 1 );
	}
	
	function wp_head(){
		if( is_singular() ){
			$this->handle_og_meta();
		}
	}
	
	function handle_og_meta(){
		global $post;
		if( is_object( $post ) && property_exists( $post, 'ID' ) ){
			echo sprintf('<meta property="og:title" content="%s" />'."\n",
							esc_attr( apply_filters( 'rhc_og_title', $post->post_title, $post ) )
						);
						
			echo sprintf('<meta property="og:description" content="%s" />'."\n",
							esc_attr( apply_filters( 'rhc_og_description', $post->post_excerpt, $post )  )
						);
						
			//og:image
			$custom = 'rhc_tooltip_image';
			$attachment_id = get_post_meta( $post->ID, $custom, true);
			if( intval($attachment_id)>0 && $image_src=wp_get_attachment_image_src( $attachment_id, 'full', 0 ) ){	
				if( isset( $image_src[0] ) ){
					$image = '';
					$image.= sprintf('<meta property="og:image:url" content="%s" />'."\n",
						esc_attr( $image_src[0] )
					);
					if( is_numeric($image_src[1]) && $image_src[1] > 0 ){
						$image.= sprintf('<meta property="og:image:width" content="%s" />'."\n",
							$image_src[1]
						);
					}
					if( is_numeric($image_src[2]) && $image_src[2] > 0 ){
						$image.= sprintf('<meta property="og:image:height" content="%s" />'."\n",
							$image_src[2]
						);
					}
					echo $image."\n";
				}
			}
		}
	}
}

?>