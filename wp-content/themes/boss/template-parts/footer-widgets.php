<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>

	<div class="footer-inner-top">
		<div class="footer-inner widget-area">

			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div><!-- .footer-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div><!-- .footer-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div><!-- .footer-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div><!-- .footer-widget -->
			<?php endif; ?>

		</div><!-- .footer-inner -->
	</div><!-- .footer-inner-top -->

<?php endif; ?>