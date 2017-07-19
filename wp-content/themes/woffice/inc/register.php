<?php 
/**
 * CUSTOM REGISTER
 * @internal
 * http://designmodo.com/wordpress-custom-registration/
 * CC Agbonghama Collins
 */

if(!class_exists('Woffice_registration_form')) {
    class Woffice_registration_form
    {

        private $username;
        private $email;
        private $password;
        private $website;
        private $first_name;
        private $last_name;
        private $nickname;

        function __construct()
        {
            add_shortcode('woffice_registration_form', array($this, 'shortcode'));
        }


        public function registration_form()
        {

            ?>

            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']) . '#register-form'; ?>"
                  id="register-form">
                <div class="login-form">
                    <div class="form-group">
                        <input name="reg_name" type="text" class="login-field"
                               value="<?php echo(isset($_POST['reg_name']) ? $_POST['reg_name'] : null); ?>"
                               placeholder="<?php _e("Username", "woffice"); ?>" id="reg-name" required/>
                        <label class="login-field-icon fui-user" for="reg-name"></label>
                    </div>

                    <div class="form-group">
                        <input name="reg_email" type="email" class="login-field"
                               value="<?php echo(isset($_POST['reg_email']) ? $_POST['reg_email'] : null); ?>"
                               placeholder="<?php _e("Email", "woffice"); ?>" id="reg-email" required/>
                        <label class="login-field-icon fui-mail" for="reg-email"></label>
                    </div>

                    <div class="form-group">
                        <input name="reg_password" type="password" class="login-field"
                               value="<?php echo(isset($_POST['reg_password']) ? $_POST['reg_password'] : null); ?>"
                               placeholder="<?php _e("Password", "woffice"); ?>" id="reg-pass" required/>
                        <label class="login-field-icon fui-lock" for="reg-pass"></label>
                    </div>

                    <div class="form-group">
                        <input name="reg_fname" type="text" class="login-field"
                               value="<?php echo(isset($_POST['reg_fname']) ? $_POST['reg_fname'] : null); ?>"
                               placeholder="<?php _e("First Name", "woffice"); ?>" id="reg-fname"/>
                        <label class="login-field-icon fui-user" for="reg-fname"></label>
                    </div>

                    <div class="form-group">
                        <input name="reg_lname" type="text" class="login-field"
                               value="<?php echo(isset($_POST['reg_lname']) ? $_POST['reg_lname'] : null); ?>"
                               placeholder="<?php _e("Last Name", "woffice"); ?>" id="reg-lname"/>
                        <label class="login-field-icon fui-user" for="reg-lname"></label>
                    </div>
                    <?php
                    /*
                     * ROLE FIELD
                    */
                    $register_role = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_role') : '';
                    $excluded_roles = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('roles_excluded_in_the_form') : '';
                    if ($register_role == "yep") {
                        /* Roles array ready for options */
                        global $wp_roles;
                        $tt_roles = array();
                        $excluded_summed = array_unique(array_merge($excluded_roles, array('administrator', 'super_admin')), SORT_REGULAR);
                        foreach ($wp_roles->roles as $key => $value) {
                            if (!in_array($key, $excluded_summed)) {
                                $tt_roles[$key] = $value['name'];
                            }
                        }
                        $tt_roles_tmp = array('nope' => __("Default", "woffice")) + $tt_roles;
                        /* End */
                        ?>
                        <div class="form-group">
                            <label class="login-field-icon fui-role"
                                   for="reg-role"><?php _e("Role", "woffice"); ?></label>

                            <select name="reg_role" class="login-field">
                                <?php foreach ($tt_roles_tmp as $key => $role) {
                                    printf('<option value="%s">%s</option>', esc_attr($key), esc_html($role));
                                } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <?php
                    /*
                     * We display the Xprofile fields
                     */
                    $register_buddypress = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_buddypress') : '';
                    if ($register_buddypress == "yep") {
                        if (bp_is_active('xprofile')) : ?>

                            <h4><?php _e('Profile Details', 'woffice'); ?></h4>

                            <?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
                            <?php if (bp_is_active('xprofile')) : if (bp_has_profile(array('profile_group_id' => 1, 'fetch_field_data' => false))) : while (bp_profile_groups()) : bp_the_profile_group(); ?>
                                <?php while (bp_profile_fields()) : bp_the_profile_field(); ?>

                                    <div class="form-group">
                                        <?php
                                        $field_type = bp_xprofile_create_field_type(bp_get_the_profile_field_type());
                                        $field_type->edit_field_html();
                                        ?>
                                    </div>


                                <?php endwhile; ?>

                                <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids"
                                       value="<?php bp_the_profile_field_ids(); ?>"/>

                            <?php endwhile; endif; endif; ?>

                        <?php endif;
                    } ?>


                    <?php
                    /*
                     * Built-In Captcha code
                     */
                    $register_captcha = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_captcha') : '';
                    if ($register_captcha == "yep") {
                        $register_captcha_question = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_captcha_question') : '';
                        ?>
                        <div class="form-group">
                            <input name="reg_captcha" type="text" class="login-field"
                                   value="<?php echo(isset($_POST['reg_captcha']) ? $_POST['reg_captcha'] : null); ?>"
                                   placeholder="<?php echo esc_attr($register_captcha_question); ?>" id="reg_captcha" required/>
                            <label class="login-field-icon fui-user" for="reg_captcha"></label>
                        </div>
                        <?php

                    }
                    ?>

                    <input class="btn btn-default" type="submit" name="reg_submit"
                           value="<?php _e('Register', 'woffice'); ?>"/>

                    <?php
                    /*
                     * ReCaptcha code
                     */
                    $recatpcha_enable = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('recatpcha_enable') : '';
                    if ($recatpcha_enable == "yep") { ?>
                        <?php // We check for the keys :
                        $recatpcha_key_site = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('recatpcha_key_site') : '';
                        $recatpcha_key_secret = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('recatpcha_key_secret') : '';
                        if (!empty($recatpcha_key_site) && !empty($recatpcha_key_secret)) { ?>
                            <div class="g-recaptcha" data-sitekey="<?php echo $recatpcha_key_site; ?>"></div>
                        <?php } else {
                            _e('One of the key is missing so the Recaptcha API is not established.', 'woffice');
                        } ?>
                    <?php } ?>
            </form>

            <?php
        }

        function validation()
        {

            if (empty($this->username) || empty($this->password) || empty($this->email)) {
                return new WP_Error('field', __('Required form field is missing', 'woffice'));
            }

            if (strlen($this->username) < 4) {
                return new WP_Error('username_length', __('Username too short. At least 4 characters is required', 'woffice'));
            }

            if (strlen($this->password) < 5) {
                return new WP_Error('password', __('Password length must be greater than 5', 'woffice'));
            }

            if (!is_email($this->email)) {
                return new WP_Error('email_invalid', __('Email is not valid', 'woffice'));
            }

            if (email_exists($this->email)) {
                return new WP_Error('email', __('Email Already in use', 'woffice'));
            }
            
            // Check for custom domain : 
            $register_custom_domain_array = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_custom_domain_array') : '';
            if (!empty($register_custom_domain_array)) {
	            // get email domain : 
	            $email_array  = explode('@',$this->email);
				$email_domain = $email_array[1];
				
				if (!in_array($email_domain, $register_custom_domain_array)) {
					return new WP_Error('email', __('Email domain is incorrect', 'woffice'));
				}
            }

            if (!empty($website)) {
                if (!filter_var($this->website, FILTER_VALIDATE_URL)) {
                    return new WP_Error('website', __('Website is not a valid URL', 'woffice'));
                }
            }

            $details = array(
                'Username' => $this->username
            );

            foreach ($details as $field => $detail) {
                if (!validate_username($detail)) {
                    return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
                }
            }

            /* Captcha Check */
            $register_captcha = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_captcha') : '';
            if ($register_captcha == "yep") {
                $register_captcha_answer = fw_get_db_settings_option('register_captcha_answer');
                if ($_POST["reg_captcha"] === '' || $register_captcha_answer != $_POST["reg_captcha"]) {
                    return new WP_Error('captcha', __('Sorry, the captcha is not valid.', 'woffice'));
                }

            }

            /* Xprofile Fields : for required fields */
            $register_buddypress = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_buddypress') : '';
            if ($register_buddypress == "yep") {
                /* We add the xprofile fields */
                if (bp_is_active('xprofile')) :
                    if (bp_has_profile(array('profile_group_id' => 1, 'fetch_field_data' => false))) :
                        while (bp_profile_groups()) : bp_the_profile_group();
                            while (bp_profile_fields()) : bp_the_profile_field();

                                // We check if it's required :
                                if (bp_get_the_profile_field_is_required() == "1") {
                                    $field = bp_get_the_profile_field_input_name();
                                    $value = $_POST[$field];
                                    // If it's empty & required we throw the error
                                    if (empty($value)) {
                                        return new WP_Error($field, __('Sorry, this fields is required', 'woffice') . ': ' . bp_get_the_profile_field_name());
                                    }

                                }

                            endwhile;
                        endwhile;
                    endif;
                endif;
            }


        }

        function registration()
        {

            /* We first check for the roles */
            $register_role = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_role') : '';
            $default_role = get_option('default_role');
            if (isset($_POST["reg_role"]) && $_POST["reg_role"] != "nope" && $register_role == "yep") {
                $role = $_POST["reg_role"];
            } else {
                $role = $default_role;
            }

            $userdata = array(
                'user_login' => esc_attr($this->username),
                'user_email' => esc_attr($this->email),
                'user_pass' => esc_attr($this->password),
                'first_name' => esc_attr($this->first_name),
                'last_name' => esc_attr($this->last_name),
                'role' => esc_attr($role)
            );

            if (is_wp_error($this->validation())) {

                $color_notifications = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('color_notifications') : '';
                echo '<div class="infobox fa-exclamation-triangle" style="background-color: ' . $color_notifications . ';">';
                echo '<strong>' . $this->validation()->get_error_message() . '</strong>';
                echo '</div>';

            } else {

                $register_user = wp_insert_user($userdata);

                /* Triggering Buddypress actions if enabled */
                if (function_exists('bp_is_active') && bp_is_active('notifications')) {
                   $user_id = $register_user;
                   do_action('bp_core_activated_user', $user_id);
                }

                if (!is_wp_error($register_user)) {

                    //Send an email to registered user
                    woffice_send_user_registration_email($user_id);

                    $color_notifications_green = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('color_notifications_green') : '';
                    echo '<div id="success-register" class="infobox fa-check-circle-o" style="background-color: ' . $color_notifications_green . ';">';
                    if(class_exists('pw_new_user_approve')) {
                        echo '<strong>' . __('Registration complete. Please wait for approval. ', 'woffice') . '</strong>';
                    } else {
                        echo '<strong>' . __('Registration complete. You can now ', 'woffice') . ' <a href="' . wp_login_url() . '">' . __('Sign In', 'woffice') . '</a></strong>';
                    }
                    echo '</div>';

                    $register_buddypress = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('register_buddypress') : '';
                    if ($register_buddypress == "yep") {
                        /* We add the xprofile fields */
                        if (bp_is_active('xprofile')) :
                            if (bp_has_profile(array('profile_group_id' => 1, 'fetch_field_data' => false))) :
                                while (bp_profile_groups()) : bp_the_profile_group();
                                    while (bp_profile_fields()) : bp_the_profile_field();

                                        $field = bp_get_the_profile_field_input_name();

                                        /* We manage the fields types here */
                                        if ('datebox' == bp_get_the_profile_field_type()) {
                                            if (isset($_POST[$field . "_day"]) && isset($_POST[$field . "_month"]) && isset($_POST[$field . "_year"])) {
                                                $day_r = $_POST[$field . "_day"];
                                                $month_r = $_POST[$field . "_month"];
                                                $year_r = $_POST[$field . "_year"];
                                            }
                                            $date = date('Y-m-d H:i:s', strtotime($day_r . $month_r . $year_r));
                                            $value = $date;
                                        } else {
                                            $value = $_POST[$field];
                                        }

                                        if (!empty($value)) {
                                            $value_ready = $value;
                                            $field_id = bp_get_the_profile_field_id();
                                            $save = xprofile_set_field_data($field_id, $register_user, $value_ready);
                                            /* DEBUG *
                                            fw_print($save);
                                            */
                                        }

                                    endwhile;
                                endwhile;
                            endif;
                        endif;
                    }

                } else {
                    $color_notifications = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('color_notifications') : '';
                    echo '<div class="infobox fa-exclamation-triangle" style="background-color: ' . $color_notifications . ';">';
                    echo '<strong>' . $register_user->get_error_message() . '</strong>';
                    echo '</div>';
                }

            }

        }

        function recaptchaCheck()
        {
            /* Google ReCaptcha Check */
            $recatpcha_enable = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('recatpcha_enable') : '';
            if ($recatpcha_enable == "yep") {

                // We check the post variable
                if (isset($_POST['g-recaptcha-response'])) {
                    $re_captcha = $_POST['g-recaptcha-response'];
                }

                // If it exists
                if (!$re_captcha) {
                    return new WP_Error('captcha', __('Sorry, the captcha is empty.', 'woffice'));
                    $this->validation();
                }

                // API check
                $recatpcha_key_secret = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('recatpcha_key_secret') : '';
                // make a GET request to the Google reCAPTCHA Server
                $request_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recatpcha_key_secret . '&response=' . esc_attr($re_captcha) . '&remoteip=' . $_SERVER['REMOTE_ADDR'];

                $request_recaptcha = wp_remote_get($request_url);
                if (is_array($request_recaptcha) && array_key_exists('body', $request_recaptcha)) {
                    $response_php = json_decode($request_recaptcha["body"], true);
                } else {
                    $response_php["success"] = false;
                }
                //return new WP_Error('captcha', fw_print($request_recaptcha));

                // The response check
                if ($response_php["success"] != true) {
                    return new WP_Error('captcha', __('Sorry, the captcha is not valid.', 'woffice'));
                    //return new WP_Error('captcha', $request_url);
                }

            }
        }

        function shortcode()
        {

            ob_start();

            if (isset($_POST['reg_submit']) && $_POST['reg_submit']) {
                $this->username = $_POST['reg_name'];
                $this->email = $_POST['reg_email'];
                $this->password = $_POST['reg_password'];
                $this->first_name = $_POST['reg_fname'];
                $this->last_name = $_POST['reg_lname'];


                // We check for captcha error
                $return_captcha = $this->recaptchaCheck();
                if (is_wp_error($return_captcha)) {
                    /*Error Dislay*/
                    $color_notifications = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('color_notifications') : '';
                    echo '<div class="infobox fa-exclamation-triangle" style="background-color: ' . $color_notifications . ';">';
                    echo '<strong>' . $return_captcha->get_error_message() . '</strong>';
                    echo '</div>';
                } // If no error
                else {
                    // We check other fields
                    $this->validation();
                    // We register
                    $this->registration();
                }

            }

            $this->registration_form();
            return ob_get_clean();
        }

    }
}
new Woffice_registration_form;
