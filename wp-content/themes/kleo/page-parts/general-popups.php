<!-- Modal Login form -->
<div id="kleo-login-modal" class="kleo-form-modal main-color mfp-hide">
  <div class="row">
    <div class="col-sm-12 text-center">

      <?php do_action('kleo_before_login_form');?>

        <div class="kleo-pop-title-wrap main-color">
            <h3 class="kleo-pop-title"><?php esc_html_e( "Log in with your credentials", "kleo_framework" ); ?></h3>

            <?php if(get_option('users_can_register')) : ?>

                <p>
                    <em><?php esc_html_e( "or", 'kleo_framework' );?></em>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php if (function_exists('bp_is_active')) bp_signup_page(); else echo get_bloginfo('url')."/wp-login.php?action=register"; ?>" class="new-account">
                        <?php esc_html_e( "Create an account", "kleo_framework" ); ?>
                    </a>
                </p>

            <?php endif; ?>
        </div>

        <form action="<?php echo wp_login_url(apply_filters('kleo_modal_login_redirect', '')  ); ?>" id="login_form" name="login_form" method="post" class="kleo-form-signin">
            <?php wp_nonce_field( 'kleo-ajax-login-nonce', 'security' ); ?>
            <input type="text" id="username" autofocus required name="log" class="form-control" value="" placeholder="<?php esc_html_e( "Username", 'kleo_framework' );?>">
            <input type="password" id="password" required value="" name="pwd" class="form-control" placeholder="<?php esc_html_e( "Password", 'kleo_framework' );?>">
            <div id="kleo-login-result"></div>
            <button class="btn btn-lg btn-default btn-block" type="submit"><?php esc_html_e( "Sign in", "kleo_framework" ); ?></button>
            <label class="checkbox pull-left">
              <input id="rememberme" name="rememberme" type="checkbox" value="forever"> <?php esc_html_e( "Remember me", "kleo_framework" ); ?>
            </label>
            <a href="#kleo-lostpass-modal" class="kleo-show-lostpass kleo-other-action pull-right"><?php esc_html_e( 'Lost your password?' );?></a>
            <span class="clearfix"></span>

            <?php do_action('kleo_after_login_form');?>

        </form>

    </div>
  </div>
</div><!-- END Modal Login form -->



<!-- Modal Lost Password form -->
<div id="kleo-lostpass-modal" class="kleo-form-modal main-color mfp-hide">
  <div class="row">
    <div class="col-sm-12 text-center">
      <div class="kleo-pop-title-wrap alternate-color">
        <h3 class="kleo-pop-title"><?php esc_html_e( "Forgot your details?", "kleo_framework" ); ?></h3>
      </div>

      <?php do_action('kleo_before_lostpass_form');?>

      <form id="forgot_form" name="forgot_form" action="" method="post" class="kleo-form-signin">
        <?php wp_nonce_field( 'kleo-ajax-login-nonce', 'security' ); ?>
        <input type="text" id="forgot-email" autofocus required  name="user_login" class="form-control" placeholder="<?php esc_html_e("Username or Email",'kleo_framework');?>">
        <div id="kleo-lost-result"></div>
        <button class="btn btn-lg btn-default btn-block" type="submit"><?php esc_html_e( "Reset Password", "kleo_framework" ); ?></button>
        <a href="#kleo-login-modal" class="kleo-show-login kleo-other-action pull-right"><?php esc_html_e( 'I remember my details', "kleo_framework" );?></a>
        <span class="clearfix"></span>
      </form>

    </div>
  </div>
</div><!-- END Modal Lost Password form -->



<?php if(get_option('users_can_register')) : ?>
<!-- Modal Register form -->
<div id="kleo-register-modal" class="kleo-form-modal main-color mfp-hide">
    <div class="row">
        <div class="col-md-12 text-center">

            <?php do_action('kleo_before_register_form_modal'); ?>

            <div class="kleo-pop-title-wrap main-color">
                <h3 class="kleo-pop-title"><?php esc_html_e("Create Account", "kleo_framework"); ?></h3>
            </div>

            <form id="register_form" class="kleo-form-register" action="<?php if (function_exists('bp_is_active')) bp_signup_page(); else echo get_bloginfo('url')."/wp-login.php?action=register"; ?>" name="signup_form" method="post">
                <div class="row">
                <?php if (function_exists( 'bp_is_active' )) { ?>
                    <div class="col-sm-6">
                        <input type="text" id="reg-username" name="signup_username" class="form-control" required placeholder="<?php _e("Username", 'kleo_framework');?>">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="fullname" name="field_1" class="form-control" required placeholder="<?php _e("Your full name", 'kleo_framework');?>">
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-12">
                        <input type="text" id="reg-email" name="signup_email" class="form-control" required placeholder="<?php _e("Your email", 'kleo_framework');?>">
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-6">
                        <input type="password" id="reg-password" name="signup_password" class="form-control" required placeholder="<?php _e("Desired password", 'kleo_framework');?>">
                    </div>
                    <div class="col-sm-6">
                        <input type="password" id="confirm_password" name="signup_password_confirm" class="form-control" required placeholder="<?php _e("Confirm password", 'kleo_framework');?>">
                    </div>
                    <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="1" />
                    <?php wp_nonce_field( 'bp_new_signup' ); ?>
                <?php } else { ?>
                    <div class="col-sm-12">
                        <input type="text" id="reg-username" name="user_login" class="form-control" required placeholder="<?php _e("Username", 'kleo_framework');?>">
                    </div>
                    <div class="col-sm-12">
                        <input type="text" id="reg-email" name="user_email" class="form-control" required placeholder="<?php _e("Your email", 'kleo_framework');?>">
                    </div>
                <?php } ?>
                </div>
                <button class="btn btn-lg btn-default btn-block" name="signup_submit" type="submit"><?php esc_html_e("Register", "kleo_framework"); ?></button>
                <span class="clearfix"></span>
            </form>

        </div>
    </div>
</div><!-- END Modal Register form -->
<?php endif; ?>