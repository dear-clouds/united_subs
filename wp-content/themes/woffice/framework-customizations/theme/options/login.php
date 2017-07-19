<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/*We search for the login page*/
$login_page = get_page_by_title( 'Login' );
if (!empty($login_page)){
	$default_login = array($login_page->ID);
}
else {
	$default_login = array();
}
global $wp_roles;
$tt_roles = array();
foreach ($wp_roles->roles as $key=>$value){
    $tt_roles[$key] = $value['name'];
}
$tt_roles_tmp = $tt_roles;
$tt_roles_tmp_without_admins = $tt_roles;
unset($tt_roles_tmp_without_admins['administrator']);
unset($tt_roles_tmp_without_admins['super_admin']);

$options = array(
	'login' => array(
		'title'   => __( 'Login / Register', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'login-box' => array(
				'title'   => __( 'Login options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'login_custom'    => array(
						'label' => __( 'Custom Login Page', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('That is going to replace the login page from Wordpress with the new one from Woffice -> IMPORTANT! The page as to be named LOGIN please.','woffice'),
					),
					'login_page' => array(
						'type'  => 'multi-select',
					    'label' => __( 'Login page', 'woffice' ),
					    'desc'  => __( 'This is the login page, it needs the Template fields to be set as "LOGIN".', 'woffice' ),
					    'population' => 'posts',
					    'value' => $default_login,
					    'limit' => 1,
					    'help'  => __('Just select the page\'s name here', 'woffice'),
       					'source' => 'page',
					),
					'login_text' => array(
						'type'  => 'wp-editor',
					    'label' => __( 'Welcome Message', 'woffice' ),
					    'desc'  => __( 'Above the login form', 'woffice' ),
					    'tinymce' => false,
					    'media_buttons' => false,
					    'teeny' => false,
					    'wpautop' => false,
					    'editor_css' => '',
					    'reinit' => false,
					),
					'login_background_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#444',
					    'label'  => __('Background color', 'woffice'),
						'desc' => __('This is the background color and the image will be over it.','woffice')
					),
					'login_background_image' => array(
						'label' => __( 'Background Image', 'woffice' ),
						'desc'  => __( 'Large Image on fullscreen.', 'woffice' ),
						'type'  => 'upload'
					),
					'login_background_opacity' => array(
						'label' => __( 'Image Opacity', 'woffice' ),
						'type'  => 'slider',
						'properties' => array(
					        'min' => 0,
					        'max' => 1,
					        'step' => 0.1,
					    ),
						'value' => '0.5',
						'desc' => __('This is the opacity of the image over the background color','woffice'),
						'help' => __('A number between 0 - 1, if you choose 0 it will becomes hidden.','woffice')
					),
					'login_logo_image' => array(
						'label' => __( 'Logo Image', 'woffice' ),
						'desc'  => __( 'Just your logo as a PNG file', 'woffice' ),
						'type'  => 'upload'
					),
					'login_logo_image_width' => array(
						'label' => __( 'Logo Width', 'woffice' ),
						'type'  => 'short-text',
						'value' => '',
						'desc' => __('This is the width of your logo in the login page, no "px" please. If you leave this empty will be used the original image size. Image will mantein proportion','woffice'),
					),
					/*'login_logo_image_height' => array(
						'label' => __( 'Logo Height', 'woffice' ),
						'type'  => 'short-text',
						'value' => '60',
						'desc' => __('This is the height of your logo in the login page, no "px" please.','woffice'),
					),*/
					'login_wordpress'  => array(
						'label' => __( 'Show Wordpress Logo', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'yep',
					),
					'login_rest_password'    => array(
						'label' => __( 'Show reset password link', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('If you select Yep, we will add a link to the "reset password" Wordpress page, so the visitor can get a new password.','woffice'),
					),
					'aft_login'	=> array(
						'label' => __( 'After login ?', 'woffice' ),
						'type'         => 'select',
						'choices' => array(
				        	'custom' => __('Custom URL', 'woffice'),
				        	'previous' => __('Previous URL', 'woffice'),
				        	'home' => __('Homepage', 'woffice'),
						),
						'value'        => 'home',
					),
					'custom_redirect_url'	=> array(
						'label' => __( 'Custom URL', 'woffice' ),
						'type'         => 'text',
						'desc' => __('If you select Custom URL above.','woffice'),
					),
				),
			),
			'register-box' => array(
				'title'   => __( 'Registers Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'register_message' => array(
						'label' => __( 'Register message', 'woffice' ),
						'type'  => 'text',
						'value' => 'If you don\'t have any account yet, you can register now.',
						'desc' => __('This is the text displayed before the Register button if the anyone can register in the Wordpress settings.','woffice'),
					),
                    'register_new_user_email'  => array(
                        'label' => __( 'Send Email on registration ?', 'woffice' ),
                        'type'         => 'switch',
                        'right-choice' => array(
                            'value' => 'yep',
                            'label' => __( 'Yep', 'woffice' )
                        ),
                        'left-choice'  => array(
                            'value' => 'nope',
                            'label' => __( 'nope', 'woffice' )
                        ),
                        'value'        => 'nope',
                        'desc' => __('When an user complete the registration, send an email to the user with a confirmation about the registration process','woffice'),

                    ),
					'register_buddypress'  => array(
						'label' => __( 'Buddypress Xprofile fields ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('Do you want to see the Buddypress Xprofile fields from the "Base" displayed on the register form ? Thus, you can add as many field as you like.','woffice'),

					),
					'register_role'  => array(
						'label' => __( 'Role field in the form', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('Do you want to see the Role field in the registration form ? Of course, "administrator" is not in the option.','woffice'),

					),
                    'roles_excluded_in_the_form'    => array(
                        'label' => __( 'Exclude roles from the form', 'woffice' ),
                        'desc'  => __( 'Do you want to exclude some roles from the register form? Admin and Super Admin are already excluded.', 'woffice' ),
                        'type'         => 'multi-select',
                        'choices'      => $tt_roles_tmp_without_admins
                    ),
					'register_captcha'  => array(
						'label' => __( 'Captcha on Register form ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('Do you want to see a captcha on the register page, if you select "yep" please fill the fields below.','woffice'),
					),
					'register_captcha_question' => array(
						'label' => __( 'Captcha Question', 'woffice' ),
						'type'  => 'text',
						'value' => '4 + 4',
						'desc' => __('A question that humans can reply but not robots.','woffice'),
					),
					'register_captcha_answer' => array(
						'label' => __( 'Captcha Answer', 'woffice' ),
						'type'  => 'text',
						'value' => '8',
						'desc' => __('The answer of the question above.','woffice'),
					),
					'register_pmp'  => array(
						'label' => __( 'Paid Membership Pro', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('Do you want to redirect the user to your Levels page when the user clicks on the "Register" button. This page needs to be public and excluded from the redirection process.','woffice'),

					),
					'register_custom_domain_array' => array(
						'label' => __( 'Allow only a certain Email domain to register.', 'woffice' ),
						'type'  => 'addable-option',
						'option' => array( 'type' => 'text' ),
						'add-button-text' => __('Add', 'woffice'),
						'sortable' => true,
						'desc' => __('We will check if that domain is in the email address in order to register to the site. Example : gmail.com','woffice'),
					),
				),
			),
			'recaptcha-box' => array(
				'title'   => __( 'Recaptcha Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'recatpcha_enable'  => array(
						'label' => __( 'Google ReCaptcha on Register form ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'nope', 'woffice' )
						),
						'value'        => 'nope',
						'desc' => __('Do you want to see a Recaptcha2 checkbox on the register page, if you select "yep" please fill the fields below. Very first thing you need to do is register your website on Google recaptcha to do that click :','woffice'). '<a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>',
					),
					'recatpcha_key_site' => array(
						'label' => __( 'Recaptcha Site Key', 'woffice' ),
						'type'  => 'text',
						'desc' => __('When you register your site on Google\'s website, you\'ll have 2 keys, a secret key and a site key.','woffice'),
					),
					'recatpcha_key_secret' => array(
						'label' => __( 'Recaptcha Secret Key', 'woffice' ),
						'type'  => 'text',
						'desc' => __('When you register your site on Google\'s website, you\'ll have 2 keys, a secret key and a site key.','woffice'),
					),
				),
			),
		)
	)
);