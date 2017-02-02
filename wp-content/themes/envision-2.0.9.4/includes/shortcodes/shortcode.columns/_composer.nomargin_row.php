<?php
/*
 * Plugin Name: Columns
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Row_Nomargin' );
if ( ! class_exists('CloudFw_Composer_Row_Nomargin') ) {
	class CloudFw_Composer_Row_Nomargin extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'icon'			=> '3columns',
				'group'			=> 'composer_layouts',
				'line'			=> 0,
				'options'		=> array(
					'title'				=> __('No Margin Columns','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			$atts = shortcode_atts(array(
				'id'	=> '',
			), $atts);

			//extract( $atts );

			$classes = array();
			$classes[] = 'ui-row';
			$classes[] = 'ui-row-no-margin';
			$attributes = array();
			if ( !empty( $id ) ) {
				$attributes['id'] = $id;
			}

			if ( !empty( $class ) ) {
				$classes[] = $class;
			}

			if ( !empty( $attributes ) || !empty( $classes ) ) {
				$content = '<div'.
					cloudfw_make_class( $classes, TRUE ) .
					cloudfw_make_attribute( $attributes, FALSE ) .
				'>'. $content .'</div>';
			}


			return $content;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('No Margin Columns','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> '',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'id' 			=> array( 'e' => 'custom_id' ),
						'class' 		=> array( 'e' => 'custom_class' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}