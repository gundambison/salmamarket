<?php


/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_custom_login' );
function cloudfw_module_custom_login( $map ) {
    $map  -> option	 ( 'custom_login' )
          -> sub  	 ( 'onclick_action' )
          -> sub  	 ( 'top_level_custom_link' )
          -> sub  	 ( 'logged_in_menu_id' )
          -> sub  	 ( 'show_sub_level' )
          -> sub  	 ( 'show_avatar' )
          -> sub  	 ( 'show_lostpass_link' )
          -> sub  	 ( 'after_login', 'redirect_to_referer' )
          -> sub  	 ( 'after_login_custom_url' )
          -> sub  	 ( 'after_login_custom_page' )
    ;
          
    $map  -> option	 ( 'custom_login_button_color' )
          -> sub  	 ( 'login' )
          -> sub  	 ( 'login_side_panel' )
          -> sub  	 ( 'register' )
          -> sub  	 ( 'lost_pass' )
          -> sub  	 ( 'change_pass' )
    ;

    $map  -> option	 ( 'custom_register' )
          -> sub  	 ( 'user_passwords', 'via_user' )
          -> sub  	 ( 'after_registration', 'redirect_to_referer' )
          -> sub  	 ( 'after_registration_be_logged_in' )
          -> sub  	 ( 'after_registration_custom_page' )
          -> sub  	 ( 'after_registration_custom_url' )
    ;

    $map  -> option	 ( 'custom_logout' )
          -> sub  	 ( 'after_logout', 'redirect_to_login' )
          -> sub  	 ( 'after_logout_custom_url' )
          -> sub  	 ( 'after_logout_custom_page' )
    ;

    $map  -> option	 ( 'custom_login_pages' )
          -> sub  	 ( 'login' )
          -> sub  	 ( 'logout' )
          -> sub  	 ( 'register' )
          -> sub  	 ( 'lost-password' )
          -> sub  	 ( 'change-password' )
          -> sub  	 ( 'profile' )
    ;

	return $map;
}

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_custom_login' );
function cloudfw_module_option_custom_login( $schemes ) {
	return cloudfw_add_option_scheme( 'module',
		$schemes,

		 array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'custom_login',
			'tab_title' =>	__('Custom Login','cloudfw'),
			'form'  =>  array(
				'enable'    => true,
				'ajax'      => true,
				'shortcut'  => true,
			),
			'data'		=>	array(

				array(
					'type'			=>	'container',
					'title'			=>	__('Custom Login Pages','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=> 'message',
							'fill'		=> true,
							'color'		=> 'yellow',
							'title'		=>	__('Tips:','cloudfw'),
							'data'		=> __('You should create some pages with <strong>Custom Login Forms</strong> widget in the content composer. After creating your custom pages, you should link them with the related options below. Also, please have a look at the theme documentation - You will see some video tutorials to show you how to create custom login pages.','cloudfw'),

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Login Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages login' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'login' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Logout Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages logout' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'logout' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Registration Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages register' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'register' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Lost Password Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages lost-password' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'lost-password' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Change Password Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages change-password' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'change-password' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'condition'	=> false,
							'title'		=>	__('Profile Page','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login_pages profile' ),
									'value'		=>	cloudfw_get_option( 'custom_login_pages',  'profile' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Top Bar Login Widget Options','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Logged-Out Status','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=> 'module',
									'title'		=>	__('On click action for the login button in the topbar widget','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login onclick_action' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'onclick_action' ),
											'source'	=>	array(
												'NULL'		=>	__('Open the side panel with the login form','cloudfw'),
												'to_login'	=>	__('Go to the custom login page','cloudfw'),
											),
											'width'		=>	400,
										)

									)

								),

							)

						),


						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Logged-in Status','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=> 'module',
									'title'		=>	__('Custom Link for Top Level Button','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login top_level_custom_link' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'top_level_custom_link' ),
											'width'		=>	400,
											'holder'	=>	'http://',
											'desc'		=>	__('Variables:','cloudfw') . '<code>%username%</code> <code>%userid%</code>',
										)

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show User Avatar','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login show_avatar' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'show_avatar' ),
										), // #### element: 0

									)

								),


								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Lost Password Link in Login Form','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login show_lostpass_link' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'show_lostpass_link' ),
										), // #### element: 0

									)

								),


								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Sub Level Menu','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login show_sub_level' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'show_sub_level' ),
										), // #### element: 0

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Custom Sub Menu','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_custom_login logged_in_menu_id' ),
											'value'		=>	cloudfw_get_option( 'custom_login',  'logged_in_menu_id' ),
											'source'    =>  array(
												'type'          =>  'function',
												'function'      =>  'cloudfw_admin_get_all_menus',
											),
											'width'     =>  250,
											'action_link' =>    '<a target="_blank" href="'. admin_url('nav-menus.php') .'" class="cloudfw-ui-action-link cloudfw-tooltip"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i>'. __('Create Menu','cloudfw') .'</a>',
										), // #### element: 0

									)
								),

							)

						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Login Options','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=> 'module',
							'title'		=>	__('After Login','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login after_login' ),
									'value'		=>	cloudfw_get_option( 'custom_login',  'after_login' ),
									'source'	=>	array(
										'redirect_to_referer'     =>	__('Redirect to referer page','cloudfw'),
										'redirect_to_home_page'   =>	__('Redirect to homepage','cloudfw'),
										'redirect_to_custom_page' =>	__('Redirect to a Custom Page','cloudfw'),
										'redirect_to_custom_url'  =>	__('Redirect to a Custom URL','cloudfw'),
									),
									'width'		=>	400,
								)

							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'afterLoginOptions',
									'conditions'    => array(
										array( 'val' => 'redirect_to_custom_page', 'e' => '.afterLoginPage' ),
										array( 'val' => 'redirect_to_custom_url', 'e' => '.afterLoginURL' ),
									)
								),

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterLoginOptions afterLoginPage',
							'title'		=>	__('Custom Page to redirect after login','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login after_login_custom_page' ),
									'value'		=>	cloudfw_get_option( 'custom_login',  'after_login_custom_page' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterLoginOptions afterLoginURL',
							'title'		=>	__('Custom URL to redirect after login','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_login after_login_custom_url' ),
									'value'		=>	cloudfw_get_option( 'custom_login',  'after_login_custom_url' ),
									'width'		=>	400,
									'holder'	=>	'http://',
									'desc'		=>	__('Variables:','cloudfw') . '<code>%username%</code> <code>%userid%</code>' 

								)

							)

						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Logout Options','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=> 'module',
							'title'		=>	__('After Logout','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_logout after_logout' ),
									'value'		=>	cloudfw_get_option( 'custom_logout',  'after_logout' ),
									'source'	=>	array(
										'redirect_to_login'       =>	__('Redirect to login page','cloudfw'),
										'redirect_to_home_page'   =>	__('Redirect to homepage','cloudfw'),
										'redirect_to_custom_page' =>	__('Redirect to a Custom Page','cloudfw'),
										'redirect_to_custom_url'  =>	__('Redirect to a Custom URL','cloudfw'),
									),
									'width'		=>	400,
								)

							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'afterLogoutOptions',
									'conditions'    => array(
										array( 'val' => 'redirect_to_custom_page', 'e' => '.afterLogoutPage' ),
										array( 'val' => 'redirect_to_custom_url', 'e' => '.afterLogoutURL' ),
									)
								),

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterLogoutOptions afterLogoutPage',
							'title'		=>	__('Custom Page to redirect after login','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_logout after_logout_custom_page' ),
									'value'		=>	cloudfw_get_option( 'custom_logout',  'after_logout_custom_page' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterLogoutOptions afterLogoutURL',
							'title'		=>	__('Custom URL to redirect after login','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_logout after_logout_custom_url' ),
									'value'		=>	cloudfw_get_option( 'custom_logout',  'after_logout_custom_url' ),
									'width'		=>	400,
									'holder'	=>	'http://',
								)

							)

						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Registration Options','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=> 'module',
							'title'		=>	__('User passwords','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_register user_passwords' ),
									'value'		=>	cloudfw_get_option( 'custom_register',  'user_passwords' ),
									'source'	=>	array(
										'via_user'	=>	__('User can set own password when registering','cloudfw'),
										'via_email'	=>	__('Send the user\'s password via email','cloudfw'),
									),
									'width'		=>	400,
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Auto-Login after registration?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_register after_registration_be_logged_in' ),
									'value'		=>	cloudfw_get_option( 'custom_register',  'after_registration_be_logged_in' ),
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('After registration','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_register after_registration' ),
									'value'		=>	cloudfw_get_option( 'custom_register',  'after_registration' ),
									'source'	=>	array(
										'redirect_to_referer'     =>	__('Redirect to referer or the Login Page','cloudfw'),
										'redirect_to_login'       =>	__('Redirect to the Login Page','cloudfw'),
										'redirect_to_home_page'   =>	__('Redirect to Homepage','cloudfw'),
										'redirect_to_custom_page' =>	__('Redirect to a Custom Page','cloudfw'),
										'redirect_to_custom_url'  =>	__('Redirect to a Custom URL','cloudfw'),
										'show_message'            =>	__('Show the succesful registration message','cloudfw'),
									),
									'width'		=>	400,
								)

							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'afterRegistrationPageOptions',
									'conditions'    => array(
										array( 'val' => 'redirect_to_custom_page', 'e' => '.afterRegistrationPage' ),
										array( 'val' => 'redirect_to_custom_url', 'e' => '.afterRegistrationURL' ),
									)
								),

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterRegistrationPageOptions afterRegistrationPage',
							'title'		=>	__('Custom Page to redirect after registration','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_register after_registration_custom_page' ),
									'value'		=>	cloudfw_get_option( 'custom_register',  'after_registration_custom_page' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages',
										'include'	=>	array(
											'NULL' 		=>	__('(Not set)','cloudfw'),
										),
									),
									'width'		=>	250,

								)

							)

						),

						array(
							'type'		=> 'module',
							'related'	=> 'afterRegistrationPageOptions afterRegistrationURL',
							'title'		=>	__('custom URL to redirect after registration','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize( PFIX.'_custom_register after_registration_custom_url' ),
									'value'		=>	cloudfw_get_option( 'custom_register',  'after_registration_custom_url' ),
									'width'		=>	400,
									'holder'	=>	'http://',
									'desc'		=>	__('Variables:','cloudfw') . '<code>%username%</code> <code>%userid%</code>' 
								)

							)

						),

					)

				),

				array(
					'type'			=>	'container',
					'title'			=>	__('Button Colors','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(
						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Login Form Submit Button','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'		=>	'select',
									'title'     =>  __('In the content area','cloudfw'),
									'id'        =>  cloudfw_sanitize( PFIX.'_custom_login_button_color login' ),
									'value'     =>  cloudfw_get_option( 'custom_login_button_color',  'login' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

								## Element
								array(
									'type'		=>	'select',
									'title'     =>  __('In the side panel','cloudfw'),
									'id'        =>  cloudfw_sanitize( PFIX.'_custom_login_button_color login_side_panel' ),
									'value'     =>  cloudfw_get_option( 'custom_login_button_color',  'login_side_panel' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Register Form Submit Button','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'		=>	'select',
									'id'        =>  cloudfw_sanitize( PFIX.'_custom_login_button_color register' ),
									'value'     =>  cloudfw_get_option( 'custom_login_button_color',  'register' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Lost Password Form Submit Button','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'		=>	'select',
									'id'        =>  cloudfw_sanitize( PFIX.'_custom_login_button_color lost-password' ),
									'value'     =>  cloudfw_get_option( 'custom_login_button_color',  'lost-password' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Change Password Form Submit Button','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'		=>	'select',
									'id'        =>  cloudfw_sanitize( PFIX.'_custom_login_button_color change-password' ),
									'value'     =>  cloudfw_get_option( 'custom_login_button_color',  'change-password' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

							)

						),

					)

				),
			
				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true,
				), 

			)

		)
	);

	return $schemes;
}