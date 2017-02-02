<?php
/**
 * Envision Custom Login.
 *
 * @package   WPTation Login
 * @author    Orkun Gursel <support@wptation.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Wptation
 */

class WPT_Login {

	/**
	 * Prefix for Cookies
	 *
	 * @since   1.0.0
	 *
	 * @const   string
	 */
	var $prefix = 'wpt_login';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'wpt-login';

	/**
	 * Pluin URL
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_url;

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * @var array
	 */
	public $errors = array();

	/**
	 * @var array
	 */
	public $messages = array();

	/**
	 * @var array
	 */
	public $page_ids = array();

	/**
	 * @var array
	 */
	public $form_level = 1;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// $plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'plugin-name.php' );
		// add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Load admin style sheet and JavaScript.
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

		add_action( 'init', array( $this, 'process_login' ) );
		add_action( 'init', array( $this, 'process_registration' ) );
		add_action( 'init', array( $this, 'process_reset_password' ) );
		add_action( 'init', array( $this, 'process_change_password' ) );
		//add_action( 'init', array( $this, 'process_update_profile' ) );
		add_action( 'init', array( $this, 'add_shortcodes' ) );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );

		//add_action( 'show_user_profile', array( $this, 'user_meta_fields') );
		//add_action( 'edit_user_profile', array( $this, 'user_meta_fields') );
		//add_action( 'personal_options_update', array( $this, 'save_user_meta_fields') );
		//add_action( 'edit_user_profile_update', array( $this,'save_user_meta_fields') );

		add_filter( 'register_url', array( $this, 'register_url' ) );
		add_filter( 'login_url', array( $this, 'login_url' ), 10, 2 );
		add_filter( 'logout_url', array( $this, 'logout_url' ), 10, 2 );
		add_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ) );

		add_filter( 'cloudfw_topbar_widgets', array( $this, 'register_topbar_widget' ) );
		add_action( 'cloudfw_topbar_widget_login_default', array( $this, 'render_topbar_widget' ) );

		require_once( plugin_dir_path( __FILE__ ) . '/admin/options.php' );
		require_once( plugin_dir_path( __FILE__ ) . '/admin/shortcodes.php' );
		require_once( plugin_dir_path( __FILE__ ) . '/admin/translate.php' );

		if ( is_admin() ) {
			require_once( plugin_dir_path( __FILE__ ) . '/admin/metabox.php' );
		}

		$this->plugin_url = plugins_url( '', __FILE__ );

		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );


	}

	/**
	 *	Add plugin action links
	 */
	function plugin_action_links( $links, $file ) {
		if ( $file != $this->plugin_slug .'/' . $this->plugin_slug . '.php' || !function_exists('cloudfw_admin_url') )
			return $links;

		$settings_link = '<a href="' . cloudfw_admin_url( 'translate' ) . '#translate_custom_login">'
			. esc_html( __( 'Translate', 'wpt' ) ) . '</a>';

		array_unshift( $links, $settings_link );

		$settings_link = '<a href="' . cloudfw_admin_url( 'modules' ) . '#custom_login">'
			. esc_html( __( 'Settings', 'wpt' ) ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 *	Register Topbar Widget
	 */
	public function register_topbar_widget( $widgets ){
		$widgets['login_default'] = __('User Login Widget','cloudfw');
		return $widgets;
	}


	/**
	 *	Render Topbar Widget
	 */
	public function render_topbar_widget( $args = array() ){
		if ( !empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		require_once( plugin_dir_path( __FILE__ ) . '/views/widget.topbar.php' );
	}

	/**
	 * Set Redirects
	 *
	 * @return string
	 */
	public function template_redirect( $type ){
		global $pagenow;

		if ( ( $page_id = $this->get_page_id( 'logout' ) ) && is_page( $page_id ) ) {
			return $this->process_logout();

		} elseif ( !is_user_logged_in() &&
			( 	( ($page_id = $this->get_page_id( 'change-password' )) && is_page( $page_id ) ) ||
			 	( ($page_id = $this->get_page_id( 'profile' )) && is_page( $page_id ) )
			) ) {
			wp_redirect( str_replace( '&amp;', '&', wp_login_url( get_permalink( $page_id ) ) ) );
			exit;

		} elseif ( is_user_logged_in() &&
			( 	( ($page_id = $this->get_page_id( 'login' )) && is_page( $page_id ) ) ||
			 	( ($page_id = $this->get_page_id( 'register' )) && is_page( $page_id ) && empty( $_POST['wpt_register'] ) ) ||
			 	( ($page_id = $this->get_page_id( 'lost-password' )) && is_page( $page_id ) )
			) ) {
			wp_redirect( str_replace( '&amp;', '&', home_url() ) );
			exit;

		}
	}

	/**
	 * Gets Page IDs by Options
	 *
	 * @return string
	 */
	public function get_all_page_ids(){
		if ( !empty( $this->page_ids ) ) {
			return $this->page_ids;
		}

		$this->page_ids = array();
		$this->page_ids['login'] = cloudfw_get_option( 'custom_login_pages',  'login', 0 );
		$this->page_ids['logout'] = cloudfw_get_option( 'custom_login_pages',  'logout', 0 );
		$this->page_ids['lost-password'] = cloudfw_get_option( 'custom_login_pages',  'lost-password', 0 );
		$this->page_ids['change-password'] = cloudfw_get_option( 'custom_login_pages',  'change-password', 0 );
		$this->page_ids['register'] = cloudfw_get_option( 'custom_login_pages',  'register', 0 );
		$this->page_ids['profile'] = cloudfw_get_option( 'custom_login_pages',  'profile', 0 );

		return $this->page_ids;
	}

	/**
	 * Gets Page IDs
	 *
	 * @return string
	 */
	public function get_page_id( $key ){
		$keys = $this->get_all_page_ids();
		return isset($keys[ $key ]) ? $keys[ $key ] : 0;
	}

	/**
	 * Gets URLs
	 *
	 * @return string
	 */
	public function get_url( $type, $query_strings = array() ){
		$page_id = $this->get_page_id( $type );

		if ( $page_id ) {
			$link = get_permalink( $page_id );
		} else {
			$link = home_url();
		}

		if( !empty($query_strings) && is_array($query_strings) ) {
			foreach ($query_strings as $key => $value) {
				$link = add_query_arg( $key, urlencode( $value ), $link );
			}
		}

		return $link;

	}

	/**
	 * Login URL
	 *
	 * @return string
	 */
	public function login_url( $login_url, $redirect ){

		if ( ! is_admin() ) {
			$login_url = $this->get_url( 'login' );

			if ( ! empty( $redirect ) ){
				$login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
			} elseif ( get_permalink( get_queried_object_id() ) ) {
				$login_url = add_query_arg( 'redirect_to', urlencode( get_permalink( get_queried_object_id() ) ), $login_url );
			}
		}

		return $login_url;
	}

	/**
	 * Logout URL
	 *
	 * @return string
	 */
	public function logout_url( $logout_url, $redirect ){

		$logout_page_id = $this->get_page_id( 'logout' );
		if ( !empty( $logout_page_id ) ) {
			if ( ! is_page( $logout_page_id ) ) {
				$logout_url = $this->get_url( 'logout' );
			}
		}

		return $logout_url;
	}

	/**
	 * Register URL
	 *
	 * @return string
	 */
	public function register_url( $url ){

		$page_id = $this->get_page_id( 'register' );
		if ( !empty( $page_id ) ) {
			$url = $this->get_url( 'register' );
		}

		return $url;
	}

	/**
	 * Changes lostpassword URL
	 *
	 * @return string
	 */
	public function lostpassword_url( $url, $query_strings = array() ){
		if ( ($page_id = $this->get_page_id( 'lost-password' )) ) {
			return $this->get_url( 'lost-password', $query_strings );
		}
		return $url;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {


	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( 'wpt-custom-login', plugins_url('css/custom-login.css', __FILE__) );
		wp_enqueue_style( 'wpt-custom-login' );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	}

	/**
	 * Email Class.
	 *
	 * @access public
	 * @return WC_Email
	 */
	public function mailer() {
		if ( empty( $this->mailer ) ) {
			require_once( plugin_dir_path( __FILE__ ) . '/libs/mailer/class.mailer.php' );
			$this->mailer = new WPT_Emails();
		}
		return $this->mailer;
	}

	/**
	 * Add an error.
	 *
	 * @access public
	 * @param string $error
	 * @return void
	 */
	public function add_error( $error ) {
		$this->errors[] = apply_filters( 'cloudfw_custom_login_add_error', $error );
	}


	/**
	 * Add a message.
	 *
	 * @access public
	 * @param string $message
	 * @return void
	 */
	public function add_message( $message ) {
		$this->messages[] = apply_filters( 'cloudfw_custom_login_add_message', $message );
	}


	/**
	 * Clear messages and errors from the session data.
	 *
	 * @access public
	 * @return void
	 */
	public function clear_messages() {
		$this->errors = $this->messages = array();
	}

	/**
	 * error_count function.
	 *
	 * @access public
	 * @return int
	 */
	public function error_count() {
		return sizeof( $this->errors );
	}


	/**
	 * Get message count.
	 *
	 * @access public
	 * @return int
	 */
	public function message_count() {
		return sizeof( $this->messages );
	}

	/**
	 * Check it has message.
	 *
	 * @access public
	 * @return bool
	 */
	public function has_message() {
		return $this->error_count() > 0 || $this->message_count() > 0;
	}

	/**
	 * Get errors.
	 *
	 * @access public
	 * @return array
	 */
	public function get_errors() {
		return (array) $this->errors;
	}


	/**
	 * Get messages.
	 *
	 * @access public
	 * @return array
	 */
	public function get_messages() {
		return (array) $this->messages;
	}


	/**
	 * Output the errors and messages.
	 *
	 * @access public
	 * @return void
	 */
	public function show_messages( $reset = true ) {

		if ( $this->error_count() > 0  ) {
			$errors = $this->get_errors();
		?>
			<div class="errors ui--custom-login-message ui--animation">
				<?php foreach ( $errors as $error ) : ?>
					<div><?php echo wp_kses_post( $error ); ?></div>
				<?php endforeach; ?>
			</div>

		<?php
		}


		if ( $this->message_count() > 0  ) {
			$messages = $this->get_messages();

		?>
			<div class="messages ui--custom-login-message ui--animation">
				<?php foreach ( $messages as $message ) : ?>
					<div><?php echo wp_kses_post( $message ); ?></div>
				<?php endforeach; ?>
			</div>

		<?php
		}

		if ( $reset ) {
			//$this->clear_messages();
		}

	}

	/**
	 * Return a nonce field.
	 *
	 * @access public
	 * @param mixed $action
	 * @param bool $referer (default: true)
	 * @param bool $echo (default: true)
	 * @return void
	 */
	public function nonce_field( $action, $referer = true , $echo = true ) {
		return wp_nonce_field('wpt-' . $action, '_n', $referer, $echo );
	}

	/**
	 * Check a nonce and sets wpt error in case it is invalid.
	 *
	 * To fail silently, set the error_message to an empty string
	 *
	 * @access public
	 * @param string $name the nonce name
	 * @param string $action then nonce action
	 * @param string $method the http request method _POST, _GET or _REQUEST
	 * @param string $error_message custom error message, or false for default message, or an empty string to fail silently
	 * @return bool
	 */
	public function verify_nonce( $action, $method='_POST', $error_message = false ) {

		$name = '_n';
		$action = 'wpt-' . $action;

		if ( $error_message === false ) $error_message = __( 'Action failed. Please refresh the page and retry.', 'wpt' );

		if ( ! in_array( $method, array( '_GET', '_POST', '_REQUEST' ) ) ) $method = '_POST';

		if ( isset($_REQUEST[$name] ) && wp_verify_nonce( $_REQUEST[$name], $action ) ) return true;

		if ( $error_message ) $this->add_error( $error_message );

		return false;
	}

	/**
	 * Prepare custom redirect url
	 *
	 * @access public
	 * @return string
	 */
	public function prepare_custom_redirect_url( $url, $user = NULL ) {

		$current_user = $user ? $user : wp_get_current_user();
		if ( is_object($current_user) && !empty( $current_user->user_login ) ) {
			$url = str_replace('%username%', $current_user->user_login, $url);
		}
		if ( is_object($current_user) && !empty( $current_user->ID ) ) {
			$url = str_replace('%userid%', $current_user->ID, $url);
		}

		return $url;
	}

	/**
	 * Process the login form.
	 *
	 * @access public
	 * @return void
	 */
	public function process_logout() {

		$after_logout = cloudfw_get_option( 'custom_logout', 'after_logout' );
		if ( $after_logout == 'redirect_to_login' ) {
			$redirect = $this->get_url( 'login' );

		} elseif ( $after_logout == 'redirect_to_home_page' ) {
			$redirect = esc_url( home_url() );

		} elseif ( $after_logout == 'redirect_to_custom_page' ) {
			$custom_page_id = cloudfw_get_option( 'custom_logout', 'after_logout_custom_page' );
			if( !empty( $custom_page_id ) && ( $get_permalink = get_permalink( $custom_page_id ) ) ) {
				$redirect = esc_url( $get_permalink );
			} else {
				$redirect = esc_url( home_url() );
			}

		} elseif ( $after_logout == 'redirect_to_custom_url' ) {
			$custom_page_url = cloudfw_get_option( 'custom_logout', 'after_logout_custom_url' );
			if( !empty( $custom_page_url ) ) {
				$custom_page_url = $this->prepare_custom_redirect_url( $custom_page_url );				
				$redirect = esc_url( $custom_page_url );
			} else {
				$redirect = esc_url( home_url() );
			}
		}

		if ( empty( $redirect ) ) {
			$this->get_url( 'login' );
		}

		wp_redirect( str_replace( '&amp;', '&', wp_logout_url( $redirect ) ) );
		exit;
	}

	/**
	 * Process the login form.
	 *
	 * @access public
	 * @return void
	 */
	public function process_login() {


		if ( ! empty( $_POST['wpt_login'] ) ) {

			$_POST = array_map( 'sanitize_text_field', $_POST );
			$this->verify_nonce( 'login' );

			try {
				$creds = array();

				if ( empty( $_POST['log'] ) )
					throw new Exception( cloudfw_translate( 'custom_login.widget.errors.username_required' ) );
				if ( empty( $_POST['pwd'] ) )
					throw new Exception( cloudfw_translate( 'custom_login.widget.errors.password_required' ) );

				if ( is_email( $_POST['log'] ) ) {
					$user = get_user_by( 'email', $_POST['log'] );

					if ( isset( $user->user_login ) )
						$creds['user_login'] 	= $user->user_login;
					else
						throw new Exception( cloudfw_translate( 'custom_login.widget.errors.user_not_found' ) );
				} else {
					$creds['user_login'] = isset($_POST['log']) ? $_POST['log'] : NULL;
				}

				$creds['user_password'] = isset($_POST['pwd']) ? $_POST['pwd'] : NULL;
				$creds['remember']      = ! empty( $_POST['rememberme'] );
				$secure_cookie          = is_ssl() ? true : false;
				$user                   = wp_signon( $creds, $secure_cookie );

				if ( is_wp_error( $user ) ) {
					throw new Exception( $user->get_error_message() );
				} else {

					$after_login = cloudfw_get_option( 'custom_login', 'after_login' );
					if ( $after_login == 'redirect_to_home_page' ) {
						$redirect = esc_url( home_url() );

					} elseif ( $after_login == 'redirect_to_custom_page' ) {
						$custom_page_id = cloudfw_get_option( 'custom_login', 'after_login_custom_page' );
						if( !empty( $custom_page_id ) && ( $get_permalink = get_permalink( $custom_page_id ) ) ) {
							$redirect = esc_url( $get_permalink );
						} else {
							$redirect = esc_url( home_url() );
						}

					} elseif ( $after_login == 'redirect_to_custom_url' ) {
						$custom_page_url = cloudfw_get_option( 'custom_login', 'after_login_custom_url' );
						
						if( !empty( $custom_page_url ) ) {
							$custom_page_url = $this->prepare_custom_redirect_url( $custom_page_url, $user );
							$redirect = esc_url( $custom_page_url );
						} else {
							$redirect = esc_url( home_url() );
						}
					}

					if ( empty( $redirect ) ) {
						if ( ! empty( $_REQUEST['redirect_to'] ) ) {
							$redirect = esc_url( $_REQUEST['redirect_to'] );
						} elseif ( wp_get_referer() ) {
							$redirect = esc_url( wp_get_referer() );
						} else {
							$redirect = esc_url( home_url() );
						}
					}
	
					wp_redirect( $redirect );
					exit;
				}
			} catch (Exception $e) {
				$this->add_error( $e->getMessage() );
			}
		}
	}


	/**
	 * Process the registration form.
	 *
	 * @access public
	 * @return void
	 */
	public function process_registration() {
		global $current_user;

		if ( ! empty( $_POST['wpt_register'] ) ) {

			$_POST = array_map( 'sanitize_text_field', $_POST );
			if ( is_user_logged_in() ) {
				wp_redirect( home_url() );
				exit;
			}

			$this->verify_nonce( 'register' );
			$password_method = cloudfw_get_option( 'custom_register',  'user_passwords', 'via_user' );

			// Get fields
			$to_level = isset( $_POST['to_level'] ) ? trim( $_POST['to_level'] ) : 1;
			$purchase_code = isset( $_POST['purchase_code'] ) ? trim( $_POST['purchase_code'] ) : '';

			$user_email = isset( $_POST['user_email'] ) ? trim( $_POST['user_email'] ) : '';
			$password   = isset( $_POST['user_password'] ) ? trim( $_POST['user_password'] ) : '';
			$password2  = isset( $_POST['user_password2'] ) ? trim( $_POST['user_password2'] ) : '';
			$user_email = apply_filters('user_registration_email', $user_email );

			$username 				= isset( $_POST['user_login'] ) ? trim( $_POST['user_login'] ) : '';
			$sanitized_user_login 	= sanitize_user( $username );

			// Check the username
			if ( $sanitized_user_login == '' ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.enter_username' ) );
			} elseif ( ! validate_username( $username ) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_char_in_username' ) );
				$sanitized_user_login = '';
			} elseif ( username_exists( $sanitized_user_login ) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.username_already_exists' ) );
			}

			// Check the e-mail address
			if ( $user_email == '' ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.type_email_address' ) );
			} elseif ( ! is_email( $user_email ) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.email_incorrect' ) );
				$user_email = '';
			} elseif ( email_exists( $user_email ) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.email_exists' ) );
			}

			if ( $password_method == 'via_user' ) {
				// Password
				if ( empty( $password ) ) $this->add_error( cloudfw_translate( 'custom_login.widget.errors.password_required' ) );
				if ( empty( $password2 ) ) $this->add_error( cloudfw_translate( 'custom_login.widget.errors.password_reenter' ) );
				if ( $password !== $password2 ) $this->add_error( cloudfw_translate( 'custom_login.widget.errors.passwords_dont_match' ) );
			}

			// Spam trap
			if ( ! empty( $_POST['email_2'] ) ) {
				$this->add_error( __( 'Anti-spam field was filled in.', 'cloudfw' ) );
			}

			// More error checking
			$reg_errors = new WP_Error();
			do_action( 'register_post', $sanitized_user_login, $user_email, $reg_errors );
			$reg_errors = apply_filters( 'registration_errors', $reg_errors, $sanitized_user_login, $user_email );

			if ( $reg_errors->get_error_code() ) {
				$this->add_error( $reg_errors->get_error_message() );
				return;
			}

			if ( $this->error_count() == 0 ) {

				if ( $password_method == 'via_user' ) {
					$user_id = wp_create_user( $sanitized_user_login, $password, $user_email );
				} elseif ( $password_method == 'via_email' ) {
					$user_id = register_new_user( $sanitized_user_login, $user_email );
				} else {
					$this->add_error( cloudfw_translate( 'custom_login.widget.errors.couldnt_register' ) );
					return;
				}


				if ( is_wp_error( $user_id ) ) {
					//$this->add_error( cloudfw_translate( 'custom_login.widget.errors.couldnt_register' ) );
					$this->add_error( $user_id->get_error_message() );
					return;
				}

				// Get user
				$current_user = get_user_by( 'id', $user_id );

				if ( $password_method == 'via_email' ) {
					//wp_new_user_notification($user_id, wp_unslash( $user_pass ));
				} else {
					wp_new_user_notification( $user_id );
				}

				//$mailer = $this->mailer();
				//$result = $mailer->welcome_user( $user_email, $sanitized_user_login );

				$after_registration_be_logged_in = cloudfw_check_onoff( 'custom_register', 'after_registration_be_logged_in' );
				if ( $after_registration_be_logged_in ) {
					$secure_cookie = is_ssl() ? true : false;
					wp_set_auth_cookie( $user_id, true, $secure_cookie );
				}

				$after_registration = cloudfw_get_option( 'custom_register',  'after_registration', 'redirect_to_referer' );
				if ( $after_registration == 'redirect_to_referer' ) {
					$redirect = wp_get_referer() ? esc_url( wp_get_referer() ) : esc_url( $this->get_url( 'login' ) );

				} elseif ( $after_registration == 'redirect_to_login' ) {
					$redirect = esc_url( $this->get_url( 'login' ) );

				} elseif ( $after_registration == 'redirect_to_home_page' ) {
					$redirect = esc_url( home_url() );

				} elseif ( $after_registration == 'redirect_to_custom_page' ) {
					$custom_page_id = cloudfw_get_option( 'custom_register', 'after_registration_custom_page' );
					if( !empty( $custom_page_id ) && ( $get_permalink = get_permalink( $custom_page_id ) ) ) {
						$redirect = esc_url( $get_permalink );
					} else {
						$redirect = esc_url( home_url() );
					}

				} elseif ( $after_registration == 'redirect_to_custom_url' ) {
					$custom_page_url = cloudfw_get_option( 'custom_register', 'after_registration_custom_url' );
					if( !empty( $custom_page_url ) ) {
						$custom_page_url = $this->prepare_custom_redirect_url( $custom_page_url, $current_user );						
						$redirect = esc_url( $custom_page_url );
					} else {
						$redirect = esc_url( home_url() );
					}

				} else {
					$redirect = '';
					$this->add_message( cloudfw_translate( 'custom_login.widget.messages.register_successful' ) );
					$this->form_level = 'message';
					return;

				}

				if ( ! empty( $redirect ) ) {
					wp_redirect( str_replace( '&amp;', '&', $redirect ) );

					exit;
				}

			}

		}

	}

	/**
	 * Process reset password.
	 *
	 * @access public
	 * @return void
	 */
	public function process_reset_password() {

		if ( ! empty( $_POST['wpt_lost_password'] ) ) {
			$_POST = array_map( 'sanitize_text_field', $_POST );

			if ( is_user_logged_in() ) {
				wp_redirect( home_url() );
				exit;
			}

			$this->verify_nonce( 'reset_password' );

			global $wpdb;

			$to_level = isset( $_POST['to_level'] ) ? trim( $_POST['to_level'] ) : 1;
			$email_or_username = isset( $_POST['email_or_username'] ) ? trim( $_POST['email_or_username'] ) : '';

			/** Send Reset Key */
			if ( !empty( $email_or_username ) && $to_level == 1 ) {

				if ( empty( $email_or_username ) ) {

					$this->add_error( cloudfw_translate( 'custom_login.widget.errors.enter_username_or_email' ) );

				} elseif ( strpos( $email_or_username, '@' ) ) {

					$user_data = get_user_by( 'email', trim( $email_or_username ) );
					if ( empty( $user_data ) ) {
						$this->add_error( cloudfw_translate( 'custom_login.widget.errors.there_is_no_user' ) );
						return false;
					}

				} else {

					$login = trim( $email_or_username );
					$user_data = get_user_by('login', $login );
				}

				do_action('lostpassword_post');

				if( $this->error_count() > 0 )
					return false;

				if ( ! $user_data ) {
					$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_username_or_email' ) );
					return false;
				}

				// redefining user_login ensures we return the right case in the email
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;

				do_action('retrieve_password', $user_login);

				$allow = apply_filters('allow_password_reset', true, $user_data->ID);

				if ( ! $allow ) {

					$this->add_error( cloudfw_translate( 'custom_login.widget.errors.pass_reset_not_allowed_for_user') );

					return false;

				} elseif ( is_wp_error( $allow ) ) {

					$this->add_error( $allow->get_error_message );

					return false;
				}

				$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );

				if ( empty( $key ) ) {

					// Generate something random for a key...
					$key = wp_generate_password( 20, false );

					do_action('retrieve_password_key', $user_login, $key);

					// Now insert the new md5 key into the db
					$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );
				}

				// Send email notification
				//do_action( 'wpt_reset_password_notification', $user_login, $key );

				$mailer = $this->mailer();
				$result = $mailer->reset_password( $user_email, $user_login, $key );

				if ( $result ) {
					$this->add_message( cloudfw_translate( 'custom_login.widget.messages.check_your_comfirmation_email' ) );
					$this->form_level = 'message';
				} else {
					$this->add_error( __( 'The e-mail could not be sent. Possible reason: your host may have disabled the mail() function.', 'wpt' ) );
				}

				return true;


			} elseif ( isset( $_POST['password_1'] ) && isset( $_POST['password_2'] ) && isset( $_POST['reset_key'] ) ) {

				$this->form_level = 2;

				// verify reset key again
				$user = $this->check_password_reset_key( $_POST['reset_key'], $_POST['reset_login'] );

				if( is_object( $user ) ) {

					if( empty( $_POST['password_1'] ) || empty( $_POST['password_2'] ) ) {
						$this->add_error( cloudfw_translate( 'custom_login.widget.errors.enter_password' ) );
					}

					if( $_POST[ 'password_1' ] !== $_POST[ 'password_2' ] ) {
						$this->add_error( cloudfw_translate( 'custom_login.widget.errors.passwords_dont_match' ) );
					}

					if( 0 == $this->error_count() && ( $_POST['password_1'] == $_POST['password_2'] ) ) {

						$this->reset_password( $user, esc_attr( $_POST['password_1'] ) );

						$this->add_message( cloudfw_translate( 'custom_login.widget.messages.password_has_been_reset' ) );
						$this->form_level = 'message';
					}
				}

			}


		} elseif( isset( $_GET['key'] ) && isset( $_GET['login'] ) ) {

			$user = $this->check_password_reset_key( $_GET['key'], $_GET['login'] );

			// reset key / login is correct, display reset password form with hidden key / login values
			if( is_object( $user ) ) {
				$this->form_level = 2;

			} else {
				$this->form_level = 'message';
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_key' ) );

			}

		}


	}

	public function check_password_reset_key( $key, $login ) {
		global $wpdb;

		$key = preg_replace( '/[^a-z0-9]/i', '', $key );

		if ( empty( $key ) || ! is_string( $key ) ) {
			$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_key' ) );
			return false;
		}

		if ( empty( $login ) || ! is_string( $login ) ) {
			$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_key' ) );
			return false;
		}

		$user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login ) );

		if ( empty( $user ) ) {
			$this->add_error( cloudfw_translate( 'custom_login.widget.errors.invalid_key' ) );
			return false;
		}

		return $user;
	}

	/**
	 * Handles resetting the user's password.
	 *
	 * @access public
	 * @param object $user The user
	 * @param string $new_pass New password for the user in plaintext
	 * @return void
	 */
	public function reset_password( $user, $new_pass ) {
		do_action( 'password_reset', $user, $new_pass );

		wp_set_password( $new_pass, $user->ID );
		wp_password_change_notification( $user );
	}


	/**
	 * Process update profile.
	 *
	 * @access public
	 * @return void
	 */
	public function process_update_profile() {
		if ( ! ($page_id = $this->get_page_id( 'profile' )) && is_page( $page_id ) )
			return;

		if ( ! empty( $_POST['wpt_edit_profile_submit'] ) ) {
			$_POST = array_map( 'sanitize_text_field', $_POST );

			if ( ! is_user_logged_in() ) {
				wp_redirect( esc_url( $this->get_url( 'login' ) ) );
				exit;
			}

			$this->verify_nonce( 'edit_profile' );

			$user = new stdClass();
			$user->ID = (int) get_current_user_id();

			if ( $user->ID <= 0 ) {
				return;
			}

			global $errors, $wpdb;
			if ( ! is_object( $errors ) ) {
				$errors = new WP_Error();
			}

			do_action( 'personal_options_update', $user->ID );

			if( $errors->get_error_code() ) {
				$this->add_error( $errors->get_error_message() );
				return;
			}

			if( 0 == $this->error_count() ) {
				$this->add_message( __('All settings saved.','cloudfw') );
			}
		
		}

	}

	/**
	 * Process change password.
	 *
	 * @access public
	 * @return void
	 */
	public function process_change_password() {

		if ( ! empty( $_POST['wpt_change_password'] ) ) {
			$_POST = array_map( 'sanitize_text_field', $_POST );

			if ( ! is_user_logged_in() ) {
				wp_redirect( esc_url( $this->get_url( 'login' ) ) );
				exit;
			}

			$this->verify_nonce( 'change_password' );
			$user = new stdClass();
			$user->ID = (int) get_current_user_id();

			if ( $user->ID <= 0 )
				return;

			$password_cur = isset($_POST['password_cur']) ? $_POST['password_cur'] : NULL;
			$password_1   = ! empty( $_POST[ 'password_1' ] ) ? $_POST[ 'password_1' ] : '';
			$password_2   = ! empty( $_POST[ 'password_2' ] ) ? $_POST[ 'password_2' ] : '';

			if ( empty( $password_cur ) && empty( $password_1 ) && empty( $password_2 ) )
				return;

			$user->user_pass = $password_1;

			$current_user = wp_get_current_user();

			if ( empty($password_cur) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.enter_current_password' ) );
				return;
			}

			if ( ! $current_user || ! wp_check_password( $password_cur, $current_user->data->user_pass, $current_user->ID) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.current_password_not_correct' ) );
				return;
			}

			if( empty( $password_1 ) || empty( $password_2 ) ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.enter_password' ) );
			}

			if( $password_1 !== $password_2 ) {
				$this->add_error( cloudfw_translate( 'custom_login.widget.errors.passwords_dont_match' ) );
			}

			if( 0 == $this->error_count() && ( $password_1 == $password_2 ) ) {

				wp_update_user( $user ) ;

				$this->add_message( cloudfw_translate( 'custom_login.widget.messages.password_has_been_changed' ) );
				$this->form_level = 'message';

			}
		
		}

	}


	/**
	 * Get Address Fields for the edit user pages.
	 *
	 * @access public
	 */
	function get_user_meta_fields() {
		$show_fields = apply_filters('cloudfw_custom_login_meta_fields', array(
			'name'	=> array(
				//'title' 	=> __( 'Name', 'wpt' ),
				'fields' 	=> array(

					'first_name' => array(
						'type'  	=> 'text',
						'label' 	=> __( 'First name', 'wpt' ),
					),
					'last_name' => array(
						'type'  	=> 'text',
						'label' 	=> __( 'Last name', 'wpt' ),
					),
					'nickname' 	=> array(
						'type'  	=> 'text',
						'label' 	=> __( 'Nickname', 'wpt' ),
					),

				)
			),

			'contact'	=> array(
				'title' 	=> __( 'Contact Info', 'wpt' ),
				'fields' 	=> array(

					'email' => array(
						'type'  	=> 'text',
						'label' 	=> __( 'Email', 'wpt' ),
					),
					'url' => array(
						'type'  	=> 'text',
						'label' 	=> __( 'Website', 'wpt' ),
					),

				)
			),
		));
		return $show_fields;
	}


	/**
	 * Show Address Fields on edit user pages.
	 *
	 * @access public
	 */
	public function user_meta_fields( $user ) {
		if ( ($page_id = $this->get_page_id( 'profile' )) && is_page( $page_id ) ) {

			$show_fields = $this->get_user_meta_fields();

			foreach( $show_fields as $fieldset ) :
				?>
				<?php if ( !empty($fieldset['title']) ) { ?>
				<h4><strong><?php echo $fieldset['title']; ?></strong></h4>
				<?php } ?>
					<?php
					foreach( $fieldset['fields'] as $key => $field ) :
						?>
						<p class="control-group">
							<label class="control-label ui--animation" for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
							<span class="controls ui--animation"><input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>" class="regular-text" /></span>
							<?php if ( !empty($field['description']) ) { ?>
								<span class="description ui--animation"><?php echo wp_kses_post( $field['description'] ); ?></span>
							<?php } ?>
						</p>
						<?php
					endforeach;
					?>
				<?php
			endforeach;

		}
	}


	/**
	 * Save Address Fields on edit user pages
	 *
	 * @access public
	 */
	public function save_user_meta_fields( $user_id ) {
	 	$save_fields = $this->get_user_meta_fields();

	 	foreach( $save_fields as $fieldset )
	 		foreach( $fieldset['fields'] as $key => $field )
	 			if ( isset( $_POST[ $key ] ) )
	 				update_user_meta( $user_id, $key, sanitize_text_field( $_POST[ $key ] ) );
	}

	/**
	 * Add shortcodes.
	 */
	public function add_shortcodes(){
		add_shortcode( 'wpt_login', array( $this, 'shortcode_login' ) );
		add_shortcode( 'wpt_register', array( $this, 'shortcode_register' ) );
		add_shortcode( 'wpt_lost_password', array( $this, 'shortcode_lost_password' ) );
		add_shortcode( 'wpt_change_password', array( $this, 'shortcode_change_password' ) );
		add_shortcode( 'wpt_profile_edit', array( $this, 'shortcode_edit_profile' ) );
		add_shortcode( 'wpt_messages', array( $this, 'shortcode_messages' ) );
	}

	/**
	 * Login Form.
	 */
	public function shortcode_login( $attr = array(), $content = '' ){
		extract(shortcode_atts( array(
			'location'     => '',
			'form_type' => '',
		), _check_onoff_false($attr)));

		ob_start();

		if ( is_user_logged_in() ) {
			include( dirname( __FILE__ ) . '/views/mini_user.php' );
		} else {
			include( dirname( __FILE__ ) . '/views/login_form.php' );
		}

		$out = ob_get_contents(); ob_end_clean();

		return $out;
	}

	/**
	 * Register Form.
	 */
	public function shortcode_register( $attr = array(), $content = '' ){
		extract(shortcode_atts( array(
			'form_type' => '',
		), _check_onoff_false($attr)));

		ob_start();
		include( dirname( __FILE__ ) . '/views/register_form.php' );
		$out = ob_get_contents(); ob_end_clean();

		return $out;
	}

	/**
	 * Lost Password Form.
	 */
	public function shortcode_lost_password( $attr = array(), $content = '' ){
		extract(shortcode_atts( array(
			'form_type' => '',
		), ($attr)));

		
		ob_start();
		include( dirname( __FILE__ ) . '/views/lost_password.php' );
		$out = ob_get_contents(); ob_end_clean();

		return $out;
	}

	/**
	 * Change Password Form.
	 */
	public function shortcode_change_password( $attr = array(), $content = '' ){
		extract(shortcode_atts( array(
			'inform' => false,
			'form_type' => '',
		), _check_onoff_false($attr)));

		if ( !is_user_logged_in() ) {
			return $this->shortcode_login();
		}

		ob_start();
		include( dirname( __FILE__ ) . '/views/change_password.php' );
		$out = ob_get_contents(); ob_end_clean();

		return $out;
	}

	/**
	 * Edit Profile Form.
	 */
	public function shortcode_edit_profile( $attr = array(), $content = '' ){
		extract(shortcode_atts( array(
			'form_type' => '',
		), _check_onoff_false($attr)));


		if ( !is_user_logged_in() ) {
			return $this->shortcode_login();
		}

		ob_start();
		include( dirname( __FILE__ ) . '/views/edit_profile.php' );
		$out = ob_get_contents(); ob_end_clean();

		return $out;
	}

	/**
	 * Messages.
	 */
	public function shortcode_messages(){
		return $this->show_messages();
	}

}
