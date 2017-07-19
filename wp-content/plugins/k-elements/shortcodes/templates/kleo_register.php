<?php
/**
 * Register Form shortcode
 * [kleo_register register_title="Create Account" show_for_users=""]
 *
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 4.0
 */

$style = $el_class = $input_size = $register_title = $show_for_users = $bp_plugins_hook = '';

extract( shortcode_atts( array(
    'register_title' => __( "Create Account", "k-elements" ),
    'style' => 'white',
    'input_size' => 'normal',
    'show_for_users' => '',
    'bp_plugins_hook' => '',
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

if( $show_content && get_option('users_can_register') ) {

    ob_start();

    $register_link = function_exists('bp_is_active') ? bp_get_signup_page() : get_bloginfo('url') . "/wp-login.php?action=register";

    $el_class = ( $el_class != '' ) ? 'kleo-register-inline ' . esc_attr( $el_class ) : 'kleo-register-inline';
    $el_class .= ' kleo-register-style-' . esc_attr( $style );
    $el_class .= ' kleo-register-size-' . esc_attr( $input_size );

    $output_inside = '';

    ?>
    <div class="row">
        <div class="col-md-12 text-center">

            <?php do_action('kleo_before_register_form_modal'); ?>

            <?php if( $register_title != '' ){ ?>
            <div class="kleo-pop-title-wrap">
                <h3 class="kleo-pop-title"><?php echo esc_html($register_title); ?></h3>
            </div>
            <?php } ?>

            <form id="register_form" class="kleo-form-register" action="<?php echo esc_url($register_link); ?>" name="signup_form" method="post">
                <div class="row">
                    <?php if (function_exists( 'bp_is_active' )) { ?>
                        <div class="col-sm-6 first-col">
                            <input type="text" id="reg-username" name="signup_username" class="form-control" required placeholder="<?php _e("Username", 'k-elements');?>">
                        </div>
                        <div class="col-sm-6 last-col">
                            <input type="text" id="fullname" name="field_1" class="form-control" required placeholder="<?php _e("Your full name", 'k-elements');?>">
                        </div>
                        <div class="clear"></div>
                        <div class="col-sm-12">
                            <input type="text" id="reg-email" name="signup_email" class="form-control" required placeholder="<?php _e("Your email", 'k-elements');?>">
                        </div>
                        <div class="clear"></div>
                        <div class="col-sm-6 first-col">
                            <input type="password" id="reg-password" name="signup_password" class="form-control" required placeholder="<?php _e("Desired password", 'k-elements');?>">
                        </div>
                        <div class="col-sm-6 last-col">
                            <input type="password" id="confirm_password" name="signup_password_confirm" class="form-control" required placeholder="<?php _e("Confirm password", 'k-elements');?>">
                        </div>
                        <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="1" />
                        <?php wp_nonce_field( 'bp_new_signup' ); ?>
                    <?php } else { ?>
                        <div class="col-sm-12">
                            <input type="text" id="reg-username" name="user_login" class="form-control" required placeholder="<?php _e("Username", 'k-elements');?>">
                        </div>
                        <div class="col-sm-12">
                            <input type="text" id="reg-email" name="user_email" class="form-control" required placeholder="<?php _e("Your email", 'k-elements');?>">
                        </div>
                    <?php } ?>
                </div>

                <?php
                if ( $bp_plugins_hook != 'no' ) {
                    do_action( 'bp_before_registration_submit_buttons' );
                }
                ?>

                <button class="btn btn-lg btn-default btn-block" name="signup_submit" type="submit"><?php esc_html_e("Register", "k-elements"); ?></button>
                <span class="clearfix"></span>
            </form>

        </div>
    </div>
    <?php

    $output_inside = ob_get_clean();
    $output .= "\n\t" . "<div class=\"{$el_class}\">{$output_inside}</div>";

}