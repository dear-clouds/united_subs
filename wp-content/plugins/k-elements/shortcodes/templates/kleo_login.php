<?php
/**
 * Login / Lost Password Forms shortcode
 * [kleo_login show="login|lostpass" login_title="Log in with your credentials" lostpass_title="Forgot your details?" login_link="#|url" lostpass_link="#|url" register_url="hide|url"]
 *
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 4.0
 */

$show = $login_title = $lostpass_title = $login_link = $lostpass_link = $register_link = $show_for_users = $el_class = '';

extract( shortcode_atts( array(
    'show'      => 'login', // or lostpass ( default form to show )
    'login_title' => __( "Log in with your credentials", "k-elements" ),
    'lostpass_title' => __( "Forgot your details?", "k-elements" ),
    'login_link' => '#',
    'lostpass_link' => '#',
    'register_link' => '',
    'style' => 'white',
    'input_size' => 'normal',
    'show_for_users' => '',
    'el_class' => '',
), $atts ) );

if ( is_user_logged_in() ) {
    $show_content = false;

    if ( $show_for_users != '' ) {
        $show_content = true;
    }
} else {
    $show_content = true;
}

if( $show_content ) {

    ob_start();

    if( $register_link == '' ){
        $register_link = function_exists('bp_is_active') ? bp_get_signup_page() : get_bloginfo('url') . "/wp-login.php?action=register";
    }

    $el_class = ( $el_class != '' ) ? 'kleo-login-lostpass ' . esc_attr( $el_class ) : 'kleo-login-lostpass';

    $el_class .= ' kleo-register-inline';
    $el_class .= ' kleo-register-style-' . esc_attr( $style );
    $el_class .= ' kleo-register-size-' . esc_attr( $input_size );

    $output_inside = '';

    ?>
    <div class="row">
        <div class="col-sm-12 text-center">

            <!-- Login Form -->
            <div class="login-form-inline" <?php if ($show == 'lostpass') {
                echo 'style="display:none;"';
            } ?>>
                <?php if ($register_link != 'hide') { ?>
                    <?php do_action('kleo_before_login_form'); ?>
                <?php } ?>
                <div class="kleo-pop-title-wrap">
                    <?php if ($login_title != '') { ?><h3 class="kleo-pop-title"><?php echo esc_html($login_title); ?></h3><?php } ?>
                    <?php if (get_option('users_can_register') && $register_link != 'hide') : ?>
                        <p>
                            <em><?php esc_html_e("or", 'k-elements'); ?></em>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo esc_url($register_link); ?>" class="new-account">
                                <?php esc_html_e("Create an account", "k-elements"); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
                <form action="<?php echo wp_login_url(apply_filters('kleo_modal_login_redirect', '')); ?>" id="login_form" name="login_form" method="post" class="kleo-form-signin">
                    <?php wp_nonce_field('kleo-ajax-login-nonce', 'security'); ?>
                    <input type="text" id="username" autofocus required name="log" class="form-control" value="" placeholder="<?php esc_html_e("Username", 'k-elements'); ?>">
                    <input type="password" id="password" required value="" name="pwd" class="form-control" placeholder="<?php esc_html_e("Password", 'k-elements'); ?>">
                    <div id="kleo-login-result"></div>
                    <button class="btn btn-lg btn-default btn-block" type="submit"><?php esc_html_e("Sign in", "k-elements"); ?></button>
                    <label class="checkbox pull-left">
                        <input id="rememberme" name="rememberme" type="checkbox" value="forever"> <?php esc_html_e("Remember me", "k-elements"); ?>
                    </label>
                    <a href="<?php echo esc_url($lostpass_link); ?>" class="<?php if ($lostpass_link == '#') { echo 'kleo-lostpass-switch'; } ?> kleo-other-action pull-right"><?php esc_html_e('Lost your password?'); ?></a>
                    <span class="clearfix"></span>
                    <?php do_action('kleo_after_login_form'); ?>
                </form>
            </div>
            <!-- End Login Form -->

            <!-- Lost Password Form -->
            <div class="lostpass-form-inline" <?php if ($show == 'login') { echo 'style="display:none;"'; } ?>>
                <div class="kleo-pop-title-wrap">
                    <?php if ($login_title != '') { ?><h3 class="kleo-pop-title"><?php echo esc_html($lostpass_title); ?></h3><?php } ?>
                </div>
                <?php do_action('kleo_before_lostpass_form'); ?>
                <form id="forgot_form" name="forgot_form" action="" method="post" class="kleo-form-signin">
                    <?php wp_nonce_field('kleo-ajax-login-nonce', 'security'); ?>
                    <input type="text" id="forgot-email" autofocus required name="user_login" class="form-control" placeholder="<?php esc_html_e("Username or Email", 'k-elements'); ?>">
                    <div id="kleo-lost-result"></div>
                    <button class="btn btn-lg btn-default btn-block" type="submit"><?php esc_html_e("Reset Password", "k-elements"); ?></button>
                    <a href="<?php echo esc_url($login_link); ?>" class="<?php if ($login_link == '#') { echo 'kleo-login-switch'; } ?> kleo-other-action pull-right"><?php esc_html_e('I remember my details', "k-elements"); ?></a>
                    <span class="clearfix"></span>
                </form>
            </div>
            <!-- End Lost Password Form -->

        </div>
    </div>
    <?php

    $output_inside = ob_get_clean();
    $output .= "\n\t" . "<div class=\"{$el_class}\">{$output_inside}</div>";

}