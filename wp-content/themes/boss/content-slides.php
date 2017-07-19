<?php
$slides = boss_get_option( 'boss_slides' );

if ( boss_get_option( 'boss_slider_switch' ) && is_array( $slides ) && !empty( $slides[ 0 ][ 'attachment_id' ] ) ) {
	?>

	<div class="bb-slider-container">
		<div class="bb-slider-wrapper">

			<?php
			foreach ( $slides as $slide ) {
				$slide_image_id	 = $slide[ 'attachment_id' ];
				$title			 = $slide[ 'title' ];
				$desc			 = $slide[ 'description' ];
				$button_text	 = $slide[ 'button_text' ];
				$target			 = $slide[ 'target' ];
				$url			 = $slide[ 'url' ];
				?>

				<div class="bb-slide">
					<?php
					if ( $slide_image_id ) {
						echo wp_get_attachment_image( $slide_image_id, 'buddyboss_slides', '', array( 'class' => 'boss-slide-img' ) );
					}
					?>

					<div class="slide_content">
						<div class="slide_content_wrap">
							<div class="inner">

								<!-- display Title -->
								<h4 class="title"><?php echo $title; ?></h4>

								<!-- display Description, if entered -->
								<?php
								if ( !empty( $desc ) ) {
									echo '<p class="description">' . esc_html( $desc ) . '</p>';
								}

								$target_window = $target ? ' target="_blank"' : '';

								if ( !empty( $url ) && !empty( $button_text ) ) :
									?>
									<p class="readmore">
										<a href="<?php echo esc_url( $url ); ?>"<?php echo $target_window; ?>><?php echo esc_html( $button_text ); ?></a>
									</p>
								<?php endif; ?>

							</div>
						</div>
					</div>

				</div>
				<?php
			}
			?>
		</div>

	</div><!-- /slider_container -->

	<script type="text/javascript">
	    jQuery( document ).ready( function () {

	        var $slider = $( '.bb-slider-wrapper' );

	        $slider.slick( {
	            dots: false,
	            infinite: true,
	            prevArrow: '<a class="slidePrev"></a>',
	            nextArrow: '<a class="slideNext"></a>',
	            speed: 500,
	            fade: true,
	            adaptiveHeight: true,
	            autoplay: true,
	            autoplaySpeed: 4500,
	            cssEase: 'linear'
	        } );

	        $( '#left-menu-toggle' ).on( 'click', function () {
	            setTimeout( function () {
	                $slider.slick( 'setPosition' );
	            }, 600 );
	            setTimeout( function () {
	                $slider.slick( 'slickNext' );
	            }, 1800 );
	        } );

	    } );

	</script>

	<?php
}