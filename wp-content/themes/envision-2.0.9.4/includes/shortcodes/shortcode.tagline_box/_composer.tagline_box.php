<?php
/*
 * Plugin Name: Tagline Box
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Tagline_Box', 'boxed_content', 'columns', 15 );
if ( ! class_exists('CloudFw_Composer_Tagline_Box') ) {
	class CloudFw_Composer_Tagline_Box extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'icon'			=> 'boxed-content',
				'group'			=> 'composer_widgets',
				'line'			=> 210,
				'options'		=> array(
					'title'				=> __('Boxed Content','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'id'                     => '',
				'class'                  => '',
				'type'                   => '',
				'style'                  => 'custom',
				'device'                 => '',
				
				'gradient_start'         => '',
				'gradient_stop'          => '',
				
				'overlay'                => '',
				'opacity'                => '',
				'bg_image'               => '',
				'bg_position'            => '',
				'bg_attachment'          => '',
				'bg_style'               => '',
				
				'border_color'           => '',
				'border_style'           => '',
				'border_width'           => '',
				
				'shadow'                 => 0,
				'shadow_color'           => '',
				'shadow_direction'       => '',
				
				'color'                  => '',
				'link_color'             => '',
				'link_hover_color'       => '',
				
				
				'hover_gradient_start'   => '',
				'hover_gradient_stop'    => '',
				'hover_opacity'          => '',
				'hover_bg_image'         => '',
				'hover_bg_position'      => '',
				'hover_bg_attachment'    => '',
				'hover_bg_style'         => '',
				'hover_border_color'     => '',
				'hover_color'            => '',
				'hover_link_color'       => '',
				'hover_link_hover_color' => '',
				'hover_shadow_color'     => '',
				'hover_shadow_direction' => '',
				
				
				'radius'                 => '',
				'phone_height'           => '',
				'tablet_height'          => '',
				'height'                 => '',
				
				'link'                   => '',
				'target'                 => '',
				
				'margin_top'             => '',
				'margin_bottom'          => '',
				'padding_top'            => '',
				'padding_bottom'         => '',
			), _check_onoff_false($atts)));

			$id = trim( $id );
			if ( empty( $id ) ) {
				$id = cloudfw_id( 'tagline' );
			}

			$cover = false;
			$wrap_classes = array();
			$wrap_classes[] = 'ui--tagline-box-wrapper';
			$wrap_classes[] = 'ui--animation';
			$wrap_classes[] = 'clearfix';
			$wrap_classes[] = cloudfw_visible( $device );
			$wrap_classes[] = $class;

			$classes = array();
			$classes[] = 'ui--tagline-box';
			$classes[] = 'ui-row';
			$classes[] = 'clearfix';

			if ( $style == 'custom' ) {
				$classes[] = 'ui--tagline-box-custom-color';
			} elseif ( $style == 'accent' ) {
				$classes[] = 'ui--accent-gradient';
				$classes[] = 'ui--accent-color';
			} else {
				$classes[] = 'ui--gradient-grey';
				$classes[] = 'ui--box';
			}

			if ( !empty( $radius ) ) {
				$classes[] = $radius;
			}


			if ( empty($gradient_start) ) {
				$gradient_start = $gradient_stop;
			} elseif ( empty($gradient_stop) ) {
				$gradient_stop = $gradient_start;
			}

			if ( empty($border_color) ) {
				$border_style = '';
				$border_width = '';

			} else {

				if ( empty($border_width) ) {
					$border_width = 1;
				}

				if ( empty($border_style) ) {
					$border_style = 'solid';
				}

			}


			if ( ! empty( $bg_image ) && $bg_style == 'cover' ) {
				$bg_style = NULL;
				$cover = true;
			} else {
				if ( empty( $bg_image ) ) {
					$bg_style = NULL;

				} else {
					if ( empty( $bg_style ) ) {
						$bg_style = 'repeat';
					}
				}
			}

			$css = '';
			$css .= cloudfw_make_style( array(
					"html #{$id}",
				), array(
					'min-height'            => $height,
					'border-style'          => $border_style,
					'border-width'          => $border_width,
					'border-color'          => $border_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} > .ui--tagline-background-image",
				), array(
					'background-position'   => $bg_position,
					'background-attachment' => $bg_attachment,
					'z-index' 				=> 1,
				), FALSE, FALSE
			);

			if ( isset( $cover ) && $cover ) {
				$css .= cloudfw_make_style( array(
						"html #{$id} > .ui--tagline-background-image",
					), array(
						'background-ie'     => $bg_image,
						'background-image'  => $bg_image,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id} > .ui--tagline-background-image",
					), array(
						'background-image'  => $bg_image,
						'background-repeat' => $bg_style,
					), FALSE, FALSE
				);
			}

			if( empty( $overlay ) || $overlay == 'yes' ) {
				$css .= cloudfw_make_style( array(
						"html #{$id} > .ui--tagline-background-overlay",
					), array(
						'gradient' 		=> array( $gradient_start, $gradient_stop ),
						'opacity' 		=> $opacity,
						'z-index' 		=> 2,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id}",
					), array(
						'gradient' 		=> array( $gradient_start, $gradient_stop ),
					), FALSE, FALSE
				);

			}

			$css .= cloudfw_make_style( array(
					"html #{$id}",
					"html #{$id} p",
					"html #{$id} h1",
					"html #{$id} h2",
					"html #{$id} h3",
					"html #{$id} h4",
					"html #{$id} h5",
					"html #{$id} h6",
					"html #{$id} .heading",
				), array(
					'color'  => $color,
					'+text-shadow' => array(
						'color'     => $shadow_color,
						'direction' => $shadow_direction,
					)
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} a",
				), array(
					'color'  => $link_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} a:hover",
				), array(
					'color'  => $link_hover_color,
				), FALSE, FALSE
			);

			/**
			 *
			 *	HOVER
			 * 
			 */
			
			$hover_cover = false; 

			if ( empty($hover_gradient_start) ) {
				$hover_gradient_start = $hover_gradient_stop;
			} elseif ( empty($hover_gradient_stop) ) {
				$hover_gradient_stop = $hover_gradient_start;
			}


			if ( ! empty( $hover_bg_image ) && $hover_bg_style == 'cover' ) {
				$hover_bg_style = NULL;
				$hover_cover = true;
			} else {
				if ( empty( $hover_bg_image ) ) {
					$hover_bg_style = NULL;

				} else {
					if ( empty( $hover_bg_style ) ) {
						$hover_bg_style = 'repeat';
					}
				}
			}
			
			$css .= cloudfw_make_style( array(
					"html #{$id}:hover",
				), array(
					'border-color'          => $hover_border_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id}:hover > .ui--tagline-background-image",
				), array(
					'background-position'   => $hover_bg_position,
					'background-attachment' => $hover_bg_attachment,
				), FALSE, FALSE
			);

			if ( isset( $hover_cover ) && $hover_cover ) {
				$css .= cloudfw_make_style( array(
						"html #{$id}:hover > .ui--tagline-background-image",
					), array(
						'background-ie'     => $hover_bg_image,
						'background-image'  => $hover_bg_image,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id}:hover > .ui--tagline-background-image",
					), array(
						'background-image'  => $hover_bg_image,
						'background-repeat' => $hover_bg_style,
					), FALSE, FALSE
				);
			}

			if( empty( $overlay ) || $overlay == 'yes' ) {
				$css .= cloudfw_make_style( array(
						"html #{$id}:hover > .ui--tagline-background-overlay",
					), array(
						'gradient' 		=> array( $hover_gradient_start, $hover_gradient_stop ),
						'opacity' 		=> $hover_opacity,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id}:hover",
					), array(
						'gradient' 		=> array( $hover_gradient_start, $hover_gradient_stop ),
					), FALSE, FALSE
				);

			}

			$css .= cloudfw_make_style( array(
					"html #{$id}:hover",
					"html #{$id}:hover p",
					"html #{$id}:hover h1",
					"html #{$id}:hover h2",
					"html #{$id}:hover h3",
					"html #{$id}:hover h4",
					"html #{$id}:hover h5",
					"html #{$id}:hover h6",
					"html #{$id}:hover .heading",
				), array(
					'color'  => $hover_color,
					'+text-shadow' => array(
						'color'     => $hover_shadow_color,
						'direction' => $hover_shadow_direction,
					)
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id}:hover a",
				), array(
					'color'  => $hover_link_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id}:hover a:hover",
				), array(
					'color'  => $hover_link_hover_color,
				), FALSE, FALSE
			);

			cloudfw_vc_set( 'css', $id, $css );
			unset( $css );

			$out  = '';
			$out .= "<div ".
				cloudfw_make_class( $wrap_classes, true ) .
				cloudfw_make_style_attribute( array(
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE ) .
			">";

				$out .= "<div ".
					cloudfw_make_id( $id ) .
					cloudfw_make_class( $classes, true ) .
					cloudfw_responsive_options( array(
						'css' => array(
							'min-height' => array(
								'phone'         => !empty( $phone_height ) ? (int) $phone_height : 'auto',
								'tablet'        => !empty( $tablet_height ) ? (int) $tablet_height : 'auto',
								'widescreen'    => !empty( $height ) ? (int) $height : '',
							),
						)
					), FALSE ).
				">";
					$out .= "<div ".
						cloudfw_make_class( array('ui--tagline-background-container', 'ui--tagline-background-overlay', $radius), true ) .
					"></div>";

					$out .= "<div ".
						cloudfw_make_class( array('ui--tagline-background-container', 'ui--tagline-background-image', $radius), true ) .
					"></div>";

					$out .= "<div ".
						cloudfw_make_class( array('ui--tagline-content'), true ) .
						cloudfw_make_style_attribute( array(
							'padding-top'    => $padding_top,
							'padding-bottom' => $padding_bottom,
						), FALSE, TRUE ) .
					">";
						$out .= do_shortcode( $content );
					$out .= "</div>";

				/** Link */
				if ( ! empty( $link ) ) {

					$link_classes = array();
					$link_classes[] = 'ui--tagline-box-block-link';

					$link_attributes = array();
					$link_attributes['href'] = $link;
					$link_attributes['target'] = $target;
					$link_attributes['class'] = cloudfw_make_class( $link_classes, false );

					$out .= "<a" .
						cloudfw_make_attribute( $link_attributes, false ) .
					"></a>";
				}

				$out .= "</div>";

				if ( $shadow ) {
					$out .= cloudfw_UI_shadow( $shadow );
				}

			$out .= "</div>";

			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Boxed Content','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'boxed_content',
					'tag_close'  	=> true,
					'attributes' 	=> array(
						'id'               => array( 'e' => 'custom_id' ),
						'class'            => array( 'e' => 'custom_class' ),
						'device'           => array( 'e' => 'the_device' ),
						'content'          => array( 'e' => 'content' ),
						'radius'           => array( 'e' => 'box_radius' ),

						'shadow'           => array( 'e' => 'shadow' ),

						/** Normal */
						'gradient_start'   => array( 'e' => 'box_gradient_0' ),
						'gradient_stop'    => array( 'e' => 'box_gradient_1' ),

						'overlay'          => array( 'e' => 'background_overlay' ),
						'opacity'          => array( 'e' => 'opacity' ),
						'bg_image'         => array( 'e' => 'background_image' ),
						'bg_position'      => array( 'e' => 'background_position' ),
						'bg_attachment'    => array( 'e' => 'background_attachment' ),
						'bg_style'         => array( 'e' => 'background_style' ),

						'border_color'     => array( 'e' => 'border_color' ),
						'border_style'     => array( 'e' => 'border_style' ),
						'border_width'     => array( 'e' => 'border_width' ),

						'color'            => array( 'e' => 'box_color' ),
						'link_color'       => array( 'e' => 'box_link_color' ),
						'link_hover_color' => array( 'e' => 'box_link_hover_color' ),

						'shadow_color'     => array( 'e' => 'shadow_color' ),
						'shadow_direction' => array( 'e' => 'shadow_direction' ),

						/** Hover */
						'hover_gradient_start'   => array( 'e' => 'hover_box_gradient_0' ),
						'hover_gradient_stop'    => array( 'e' => 'hover_box_gradient_1' ),

						'hover_opacity'          => array( 'e' => 'hover_opacity' ),
						'hover_bg_image'         => array( 'e' => 'hover_background_image' ),
						'hover_bg_position'      => array( 'e' => 'hover_background_position' ),
						'hover_bg_attachment'    => array( 'e' => 'hover_background_attachment' ),
						'hover_bg_style'         => array( 'e' => 'hover_background_style' ),

						'hover_border_color'     => array( 'e' => 'hover_border_color' ),

						'hover_color'            => array( 'e' => 'hover_box_color' ),
						'hover_link_color'       => array( 'e' => 'hover_box_link_color' ),
						'hover_link_hover_color' => array( 'e' => 'hover_box_link_hover_color' ),

						'hover_shadow_color'     => array( 'e' => 'hover_shadow_color' ),
						'hover_shadow_direction' => array( 'e' => 'hover_shadow_direction' ),

						/** Link */
						'link'             => array( 'e' => 'link' ),
						'target'           => array( 'e' => 'target' ),

						/** Heights */
						'height'           => array( 'e' => 'box_height' ),
						'tablet_height'    => array( 'e' => 'box_tablet_height' ),
						'phone_height'     => array( 'e' => 'box_phone_height' ),

						/** Margins & Paddings */
						'margin_top'       => array( 'e' => 'margin_top' ),
						'margin_bottom'    => array( 'e' => 'margin_bottom' ),
						'padding_top'      => array( 'e' => 'padding_top' ),
						'padding_bottom'   => array( 'e' => 'padding_bottom' ),
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