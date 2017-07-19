<footer class="footer clearfix">
    <div class="inner">

        <?php $footer_layout = mom_option('foot_layout'); if ( $footer_layout == 'third') { ?>
            <div class="footer-widget one_third">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
            </div><!-- End third col -->
            <div class="footer-widget one_third">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
            </div><!-- End third col -->
            <div class="footer-widget one_third last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
             </div><!-- End third col -->
        <?php } elseif ($footer_layout == 'one') { ?>
        	<div class="footer-widget one-full">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
        	</div>
        <?php } elseif ($footer_layout == 'one_half') { ?>
                    <div class="footer-widget one_half">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_half last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>
        <?php } elseif ($footer_layout == 'fourth') { ?>
                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fourth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>
        <?php } elseif ($footer_layout == 'fifth') { ?>
                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_fifth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer5')){ }else { ?>
            <?php } ?>
                    </div>
        <?php } elseif ($footer_layout == 'sixth') { ?>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer5')){ }else { ?>
            <?php } ?>
                    </div>
                    <div class="footer-widget one_sixth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer6')){ }else { ?>
            <?php } ?>
                    </div>

        <?php } elseif ($footer_layout == 'half_twop') { ?>
                    <div class="footer-widget one_half">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fourth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>
        
        <?php } elseif ($footer_layout == 'twop_half') { ?>
                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fourth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_half last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

        <?php } elseif ($footer_layout == 'half_threep') { ?>
                    <div class="footer-widget one_half">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>
        <?php } elseif ($footer_layout == 'threep_half') { ?>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_half last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>

        <?php } elseif ($footer_layout == 'third_threep') { ?>
                    <div class="footer-widget one_third">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fifth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>


        <?php } elseif ($footer_layout == 'threep_third') { ?>

                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_fifth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>
                    
                    <div class="footer-widget one_third last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>

        <?php } elseif ($footer_layout == 'third_fourp') { ?>
                    <div class="footer-widget one_third">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer5')){ }else { ?>
            <?php } ?>
                    </div>


        <?php } elseif ($footer_layout == 'fourp_third') { ?>
                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer1')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer2')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer3')){ }else { ?>
            <?php } ?>
                    </div>

                    <div class="footer-widget one_sixth">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer4')){ }else { ?>
            <?php } ?>
                    </div>
        
        <div class="footer-widget one_third last">
            <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('footer5')){ }else { ?>
            <?php } ?>
                    </div>

        <?php } ?>
        
    </div>
</footer>