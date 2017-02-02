<?php
/**
 * Transactional Emails Controller
 *
 * @class 		WPT_Emails
 */
class WPT_Emails {


	/**
	 * Constructor for the email class hooks in all emails that can be sent.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {

	}

	public function reset_password( $user_email, $user_login, $key ){
		global $wpt_login;

		$args = array(
			'key'	=> $key,
			'login'	=> rawurlencode( $user_login ),
		);

		$url = add_query_arg( $args, wp_lostpassword_url() );

		$vars = apply_filters( 'cloudfw_custom_login_reset_mail_vars', array(
			'site_url'  => network_home_url( '/' ),
			'username'  => $user_login,
			'reset_url' => $url,
		));

		$message = cloudfw_translate( 'custom_login.widget.email_templates.reset_password' );

		$default_message = '
Someone requested that the password be reset for the following account: %site_url%

Username: %username%

If this was a mistake, just ignore this email and nothing will happen.

To reset your password, visit the following address: %reset_url%
';

		if ( empty( $message ) ) {
			$message = $default_message;
		}

		foreach ($vars as $find => $replace) {
			$message = str_replace("%$find%", $replace, $message);
		}

		if ( is_multisite() ) {
			$blogname = $GLOBALS['current_site']->site_name;
		}
		else {
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		}

		$title = sprintf( cloudfw_translate( 'custom_login.widget.email_templates.reset_password_title' ), $blogname );

		$title = apply_filters('retrieve_password_title', $title);
		$message = apply_filters('retrieve_password_message', $message, $key);

		return wp_mail( $user_email, $title, $message );
	}

}