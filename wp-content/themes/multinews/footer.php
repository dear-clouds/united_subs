            <?php
            if(mom_option('widgets_footer') != 0) {
                if( function_exists('is_mobile') && is_mobile() && mom_option('hide_footer_in_mobiles') == 1 ){
                    // do nothing
                } else {
                    get_template_part( 'framework/includes/theme-footer' );
                }
            }
            ?>

            <?php if(mom_option('cat_footer_menu')) { ?>
            <div class="footer-menu clearfix">
                <div class="inner">
	                <?php if ( has_nav_menu( 'footer' ) ) {
$footer_menu_query = get_transient( 'footer_menu_query');
//$footer_menu_query = false;
if( $footer_menu_query === false ) {
    $footer_menu_query = wp_nav_menu( array('theme_location' => 'footer', 'walker' => new mom_custom_Walker(), 'container' => 'ul', 'menu_class' => 'footer_mega_menu', 'echo' => 0));
    set_transient( 'footer_menu_query', $footer_menu_query, 60*60*24 );
}
echo $footer_menu_query;

                    } else { ?> <i class="menu-message"><?php _e('Select your Footer Menu from wp menus', 'framework'); ?></i> <?php } ?>
                </div>
            </div>
            <?php } ?>

            <?php if(mom_option('bottom_footer')) { ?>
            <div class="footer-bottom" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
                <div class="inner">
                    <div class="alignright">


                        <?php
                        if(mom_option('copyright_menu')) {
                        if ( has_nav_menu( 'copyright' ) ) {
			    wp_nav_menu( array( 'menu_class' => 'footer-bottom-menu', 'theme_location' => 'copyright'));
			}
			}
			?>

                        <?php if(mom_option('footer_social')) { ?>
                        <ul class="footer-bottom-social">
                            <?php get_template_part( 'framework/includes/social' ); ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <div class="alignleft">

                        <?php if(mom_option('footer_logo')) { ?>
                        <div class="footer-logo">
                            <a itemprop="url" href="<?php echo esc_url(home_url()); ?>">
                            <?php if(mom_option('foot_retina_logo','url') != '') { ?>
                                <img src="<?php echo mom_option('foot_retina_logo','url'); ?>" width="<?php echo mom_option('foote_retina_logo_size','width'); ?>" height="<?php echo mom_option('foote_retina_logo_size','height'); ?>" alt="<?php bloginfo('name'); ?>">
                                <?php } else { ?>
                                <img src="<?php echo mom_option('foot_logo','url'); ?>" width="<?php echo mom_option('foot_logo','width'); ?>" height="<?php echo mom_option('foot_logo','height'); ?>" alt="<?php bloginfo('name'); ?>">
                            <?php } ?>
                            </a>
                        </div>
                        <?php } ?>

                        <div class="copyrights"><?php echo htmlspecialchars_decode(mom_option('footer-text')); ?></div>

                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(mom_option('scroll_top_bt')) { ?><a class="toup" href="#"><i class="enotype-icon-arrow-up6"></i></a><?php } ?>
        </div><!--fixed layout-->
    </div> <!-- wrap every thing -->
        <?php wp_footer(); ?>
	<?php echo mom_option('footer_script'); ?>

    </body>
</html>
