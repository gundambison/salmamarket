<?php
/**
 * @package     Envision - Custom Login Pages
 * @author      Orkun Gursel <support@wptation.com>
 * @license     GPL-2.0+
 * @link        http://wptation.com
 * @copyright   2013 WPTATION
 *
 * @wordpress-plugin
 * Plugin Name: Envision - Custom Login Pages
 * Plugin URI:  
 * Description: Custom Login Pages for CloudFw Framework
 * Version:     1.0.2
 * Author:      Orkun Gursel
 * Author URI:  http://orkungursel.com
 * Text Domain: wptation
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'cloudfw_modules_init', 'cloudfw_plugin_envision_login' );
function cloudfw_plugin_envision_login() {
	global $wpt_login;

	require_once( plugin_dir_path( __FILE__ ) . 'class-wpt-login.php' );

	register_activation_hook( __FILE__, array( 'WPT_Login', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'WPT_Login', 'deactivate' ) );

	$wpt_login = WPT_Login::get_instance();
}