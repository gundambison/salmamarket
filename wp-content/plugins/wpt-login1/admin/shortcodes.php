<?php


cloudfw_register_shortcode( 'CloudFw_Shortcode_Custom_Login' );
if ( ! class_exists('CloudFw_Shortcode_Custom_Login') ) {

	class CloudFw_Shortcode_Custom_Login extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'ajax'          => true,
				'icon'          => 'key',
				'group'         => 'composer_widgets',
				'line'          => 5001,
				'options'       => array(
					'title'             => __('Custom Login Forms','cloudfw'),
					'sync_title'        => 'custom_login_part',
					'column'            => '1/1',
					'allow_columns'     => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			$out = do_shortcode(cloudfw_transfer_shortcode_attributes( $case, $atts, $content, FALSE ));

			return "<div class=\"ui--custom-login ui--pass\">{$out}</div>";

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     => __('Custom Login Parts','cloudfw'),
				'ajax'      => true,
				'script'    => array(
					'shortcode:sync'=> 'custom_login_part',
					'tag_close'     => false,
					'attributes'    => array(
						'part'         => array( 'e' => 'custom_login_part' ),
						'form_type'    => array( 'e' => 'custom_login_form_type' ),
					),
					/*'if' =>	array(
						array(
							'type' 	  => 'toggle',
							'e' 	  => 'custom_login_part',
							'related' => 'customLoginStyle',
							'targets' => array(
								array('wpt_login', '.customLoginStyle'),
							)
						),
					)*/
				),
				'data'      =>  array(

					array(
						'type'		=>	'module',
						'condition'	=>	$this->is_widget,
						'title'		=>	__('Title for Logged in Mode','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'text',
								'id'		=>	$this->get_field_name('logged_in_title'),
								'value'		=>	$this->get_value('logged_in_title'),
								'_class'	=>	'widefat',
							)
						),
					),

					array(
						'type'		=>	'module',
						'condition'	=>	$this->is_widget,
						'title'		=>	__('Title for Logged out Mode','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'text',
								'id'		=>	$this->get_field_name('title'),
								'value'		=>	$this->get_value('title'),
								'_class'	=>	'widefat',
							)
						),
					),

					array(
						'type'		=> 'module',
						'title'		=>	__('Custom Login Page Parts','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'select',
								'id'		=>	$this->get_field_name('custom_login_part'),
								'value'     =>  $this->get_value('custom_login_part'),
								'source'	=>	array(
									'wpt_login'           => __('Login Form','cloudfw'),
									'wpt_register'        => __('User Registration Form','cloudfw'),
									'wpt_lost_password'   => __('Lost Password Form','cloudfw'),
									'wpt_change_password' => __('Change Password Form','cloudfw'),
									//'wpt_profile_edit'    => __('Profile Edit Form','cloudfw'),
								),
								'width'		=>	250,
							)

						)

					),

					array(
						'condition'	=>	!$this->is_widget,
						'type'		=> 'module',
						'related'	=> 'customLoginStyle',
						'title'		=>	__('Form Type','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'select',
								'id'		=>	$this->get_field_name('custom_login_form_type'),
								'value'     =>  $this->get_value('custom_login_form_type'),
								'source'	=>	array(
									'NULL'		=> __('Default','cloudfw'),
									'block'		=> __('Blocked','cloudfw'),
								),
								'width'		=>	150,
							)

						)

					),

				)

			);

		}

	}

}


if ( class_exists('CloudFw_Widgets') ) {

/** Class */
class CloudFw_Widget_Custom_Login extends CloudFw_Widgets {
	/** Variables */
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_custom_login',
			/** Title */
			__('Theme - Custom Login Forms','cloudfw'),
			/** Other Options */
			array(
				'classname'   => 'widget_cloudfw_custom_login',
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);

		/** Services */
		$this->class = new CloudFw_Shortcode_Custom_Login();
		$this->class->is_widget = true;
		$this->class->widget = $this;
	}

	/** Render */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = isset($instance['title']) ? $instance['title'] : NULL;
		$logged_in_title = isset($instance['logged_in_title']) ? $instance['logged_in_title'] : NULL;

		echo $before_widget;
		$title = empty($title) ? '' : apply_filters('widget_title', ( is_user_logged_in() ? $logged_in_title : $title));

		if ( !empty( $title ) )
			echo $before_title . $title . $after_title;

		$shortcode_options = $this->class->scheme();
		$instance = cloudfw_composer_convert_data( $instance, $shortcode_options['script'] );

			echo do_shortcode($this->class->shortcode( $instance, '', isset($instance['part']) ? $instance['part'] : NULL ));

		echo $after_widget;
	}

	/** Scheme */
	function scheme( $data = array() ) {

		/** Defaults */
		$data = wp_parse_args( $data, array() );
		$this->class->set_data( $data );

		$scheme = array();
		$shortcode_scheme = $this->class->scheme();
		$scheme['data'] = $shortcode_scheme['data'];

		return $scheme;

	}

}


/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Custom_Login');

}