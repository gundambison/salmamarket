<?php


/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_custom_login_translate' );
function cloudfw_module_custom_login_translate( $map ) {

		$reset_password_template = __('Someone requested that the password be reset for the following account: %site_url%

Username: %username%

If this was a mistake, just ignore this email and nothing will happen.

To reset your password, visit the following address: %reset_url%','cloudfw');

	$map  -> option	 ( 'texts' )
		  -> sub     ( 'custom_login.widget.login.text', __('Login','cloudfw') )
		  -> sub     ( 'custom_login.widget.logged_in.text',  __('Hello %s!','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.username', __('Username','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.email', __('Email','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.username_or_email', __('Username or Email','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.password', __('Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.re-password', __('Re-enter password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.current_password', __('Current Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.new_password', __('New Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.renew_password', __('Confirm New Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.submit', __('Login','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.register', __('Register','cloudfw') )
		  -> sub     ( 'custom_login.widget.register_new_user.text', __('Register New User','cloudfw') )
		  -> sub     ( 'custom_login.widget.lost_password.text', __('Lost Password?','cloudfw') )
		  -> sub     ( 'custom_login.widget.rememberme.text', __('Remember me','cloudfw') )
		  -> sub     ( 'custom_login.widget.go_back_login.text', __('Go back to the login page','cloudfw') )
		  -> sub     ( 'custom_login.widget.logout.text', __('Logout','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.reset_password', __('Reset Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.form.change_password', __('Change Password','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.username_required', __('Username is required.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.password_required', __('Password is required.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.user_not_found', __('A user could not be found with this email address.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.enter_username', __('Please enter a username.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.invalid_char_in_username', __('This username is invalid because it uses illegal characters. Please enter a valid username.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.username_already_exists', __('This username is already registered, please choose another one.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.type_email_address', __('Please type your e-mail address.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.email_incorrect', __('The email address isn&#8217;t correct.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.email_exists', __('This email is already registered, please choose another one.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.password_required_register', __('Password is required.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.password_reenter', __('Re-enter your password.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.passwords_dont_match', __('Passwords do not match.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.couldnt_register', __('Couldn&#8217;t register you&hellip; please contact us if you continue to have problems.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.enter_username_or_email', __('Enter a username or e-mail address.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.enter_current_password', __('Please enter your current password.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.current_password_not_correct', __('Your current password is not correct.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.there_is_no_user', __('There is no user registered with that email address.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.invalid_username_or_email', __('Invalid username or e-mail.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.pass_reset_not_allowed_for_user', __('Password reset is not allowed for this user','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.enter_password', __('Please enter a password.','cloudfw') )
		  -> sub     ( 'custom_login.widget.errors.invalid_key', __('Your password reset key is not valid.','cloudfw') )
		  -> sub     ( 'custom_login.widget.messages.check_your_comfirmation_email', __('Check your e-mail for the confirmation link.','cloudfw') )
		  -> sub     ( 'custom_login.widget.messages.password_has_been_reset', __('Your password has been reset.','cloudfw') )
		  -> sub     ( 'custom_login.widget.messages.password_has_been_changed', __('Your password has been changed.','cloudfw') )
		  -> sub     ( 'custom_login.widget.messages.password_will_be_emailed', __('A password will be e-mailed to you.','cloudfw') )
		  -> sub     ( 'custom_login.widget.messages.register_successful', __('Registration Succesful','cloudfw') )

          -> sub  	 ( 'custom_login.widget.email_templates.reset_password_title', __('[%s] Password Reset','cloudfw') )
          -> sub  	 ( 'custom_login.widget.email_templates.reset_password', $reset_password_template )
	;

	return $map;
}

add_filter( 'cloudfw_wpml_register', 'cloudfw_module_custom_login_translate_wpml_registers' );
function cloudfw_module_custom_login_translate_wpml_registers( $map ) {
	cloudfw_reset_raw_options_map();

	cloudfw_translate_register( 'custom_login.widget.login.text' );
	cloudfw_translate_register( 'custom_login.widget.logged_in.text' );
	cloudfw_translate_register( 'custom_login.widget.form.username' );
	cloudfw_translate_register( 'custom_login.widget.form.email' );
	cloudfw_translate_register( 'custom_login.widget.form.username_or_email' );
	cloudfw_translate_register( 'custom_login.widget.form.password' );
	cloudfw_translate_register( 'custom_login.widget.form.current_password' );
	cloudfw_translate_register( 'custom_login.widget.form.new_password' );
	cloudfw_translate_register( 'custom_login.widget.form.renew_password' );
	cloudfw_translate_register( 'custom_login.widget.form.re-password' );
	cloudfw_translate_register( 'custom_login.widget.form.submit' );
	cloudfw_translate_register( 'custom_login.widget.form.register' );
	cloudfw_translate_register( 'custom_login.widget.register_new_user.text' );
	cloudfw_translate_register( 'custom_login.widget.lost_password.text' );
	cloudfw_translate_register( 'custom_login.widget.rememberme.text' );
	cloudfw_translate_register( 'custom_login.widget.go_back_login.text' );
	cloudfw_translate_register( 'custom_login.widget.logout.text' );
	cloudfw_translate_register( 'custom_login.widget.form.reset_password' );
	cloudfw_translate_register( 'custom_login.widget.form.change_password' );
	cloudfw_translate_register( 'custom_login.widget.errors.username_required' );
	cloudfw_translate_register( 'custom_login.widget.errors.password_required' );
	cloudfw_translate_register( 'custom_login.widget.errors.user_not_found' );
	cloudfw_translate_register( 'custom_login.widget.errors.enter_username' );
	cloudfw_translate_register( 'custom_login.widget.errors.invalid_char_in_username' );
	cloudfw_translate_register( 'custom_login.widget.errors.username_already_exists' );
	cloudfw_translate_register( 'custom_login.widget.errors.type_email_address' );
	cloudfw_translate_register( 'custom_login.widget.errors.email_incorrect' );
	cloudfw_translate_register( 'custom_login.widget.errors.email_exists' );
	cloudfw_translate_register( 'custom_login.widget.errors.password_required_register' );
	cloudfw_translate_register( 'custom_login.widget.errors.password_reenter' );
	cloudfw_translate_register( 'custom_login.widget.errors.passwords_dont_match' );
	cloudfw_translate_register( 'custom_login.widget.errors.couldnt_register' );
	cloudfw_translate_register( 'custom_login.widget.errors.enter_username_or_email' );
	cloudfw_translate_register( 'custom_login.widget.errors.enter_current_password' );
	cloudfw_translate_register( 'custom_login.widget.errors.current_password_not_correct' );
	cloudfw_translate_register( 'custom_login.widget.errors.there_is_no_user' );
	cloudfw_translate_register( 'custom_login.widget.errors.invalid_username_or_email' );
	cloudfw_translate_register( 'custom_login.widget.errors.pass_reset_not_allowed_for_user' );
	cloudfw_translate_register( 'custom_login.widget.errors.enter_password' );
	cloudfw_translate_register( 'custom_login.widget.errors.invalid_key' );
	cloudfw_translate_register( 'custom_login.widget.messages.check_your_comfirmation_email' );
	cloudfw_translate_register( 'custom_login.widget.messages.password_has_been_reset' );
	cloudfw_translate_register( 'custom_login.widget.messages.password_has_been_changed' );
	cloudfw_translate_register( 'custom_login.widget.messages.password_will_be_emailed' );
	cloudfw_translate_register( 'custom_login.widget.messages.register_successful' );
	cloudfw_translate_register( 'custom_login.widget.email_templates.reset_password_title' );
	cloudfw_translate_register( 'custom_login.widget.email_templates.reset_password' );
}

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_custom_login_translate' );
function cloudfw_module_option_custom_login_translate( $schemes ) {
	return cloudfw_add_option_scheme( 'translate',
		$schemes,

		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'translate_custom_login',
			'tab_title' =>	__('Custom Login Pages','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Custom Login Pages','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'custom_login.widget.login.text',
									'custom_login.widget.logged_in.text',
									'custom_login.widget.register_new_user.text',
									'custom_login.widget.lost_password.text',
									'custom_login.widget.rememberme.text',
									'custom_login.widget.go_back_login.text',
									'custom_login.widget.logout.text',

									'custom_login.widget.form.username',
									'custom_login.widget.form.email',
									'custom_login.widget.form.username_or_email',
									'custom_login.widget.form.password',
									'custom_login.widget.form.re-password',
									'custom_login.widget.form.current_password',
									'custom_login.widget.form.new_password',
									'custom_login.widget.form.renew_password',
									'custom_login.widget.form.submit' => __('It\'s for the submit button text','cloudfw'),
									'custom_login.widget.form.register' => __('It\'s for the submit button text','cloudfw'),
									'custom_login.widget.form.reset_password',
									'custom_login.widget.form.change_password',
								)
							)
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Errors and Messages','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'custom_login.widget.errors.username_required',
									'custom_login.widget.errors.enter_username',
									'custom_login.widget.errors.invalid_char_in_username',
									'custom_login.widget.errors.password_required',
									'custom_login.widget.errors.password_required_register',
									'custom_login.widget.errors.password_reenter',
									'custom_login.widget.errors.passwords_dont_match',
		  							'custom_login.widget.errors.enter_password',
									'custom_login.widget.errors.type_email_address',
									'custom_login.widget.errors.email_incorrect',
									'custom_login.widget.errors.email_exists',
									'custom_login.widget.errors.user_not_found',
									'custom_login.widget.errors.username_already_exists',
									'custom_login.widget.errors.couldnt_register',
		  							'custom_login.widget.errors.enter_username_or_email',
		  							'custom_login.widget.errors.enter_current_password',
		  							'custom_login.widget.errors.current_password_not_correct',
		  							'custom_login.widget.errors.invalid_username_or_email',
		  							'custom_login.widget.errors.there_is_no_user',
		  							'custom_login.widget.errors.pass_reset_not_allowed_for_user',
		  							'custom_login.widget.errors.invalid_key',
		  							'custom_login.widget.messages.register_successful',
		  							'custom_login.widget.messages.password_will_be_emailed',
									'custom_login.widget.messages.check_your_comfirmation_email',
		  							'custom_login.widget.messages.password_has_been_reset',
		  							'custom_login.widget.messages.password_has_been_changed',

								)
							)
						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Email Templates','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
		  							'custom_login.widget.email_templates.reset_password_title' => __('Subject for Reset Password Emails','cloudfw'),

								)
							)
						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Reset Password','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'textarea',
									'id'		=>	cloudfw_sanitize( PFIX.'_texts custom_login.widget.email_templates.reset_password' ),
									'value'		=>	cloudfw_get_option( 'texts',  'custom_login.widget.email_templates.reset_password' ),
									'width'		=>	600,
									'line'		=>	10,
								)

							)

						),

					)

				),

				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				),


			)

		)


	);

	return $schemes;
}