<?php
/*
 * Plugin Name: Tagline Box
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Video_Background', 'video_background', 'style', 25 );
if ( ! class_exists('CloudFw_Composer_Video_Background') ) {
	class CloudFw_Composer_Video_Background extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'droppable'     => true,
				'icon'          => 'video',
				'group'         => 'composer_layouts',
				'line'          => 3,
				'options'       => array(
					'title'             => __('Video/Image Background','cloudfw'),
					'column'            => '1/1',
					'allow_columns'     => false,
					'allow_edit'        => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'id'               => '',
				'class'            => '',
				'type'             => '',
				'style'            => 'custom',
				'device'           => '',

				'video_type'       => '',
				'source_m4v'       => '',
				'source_ogv'       => '',
				'source_webmv'     => '',
				'source_vimeo'     => '',
				'source_youtube'   => '',
				'poster'           => '',
				'poster_style'     => 'cover',
				'loop'             => true,

				'opacity'          => '',
				'gradient_start'   => '',
				'gradient_stop'    => '',
				'color'            => '',
				'link_color'       => '',
				'link_hover_color' => '',

				'video_width'      => '',
				'video_height'     => '',

				'full_height'      => false,
				'parallax'         => false,

				'margin_top'       => '',
				'margin_bottom'    => '',
				'padding_top'      => '',
				'padding_bottom'   => '',
			), _check_onoff_false($atts)));

			$video_exists = ! empty( $source_m4v ) || ! empty( $source_webmv ) || ! empty( $source_ogv );

			$id = trim( $id );
			if ( empty( $id ) ) {
				$id = cloudfw_id( 'video-background' );
			}

			if ( empty($parallax) || $parallax == 'FALSE' ) {
				$parallax = false;
			}

			$cover = false;
			$wrap_classes = array();
			$wrap_classes[] = 'ui--video-background-wrapper';
			$wrap_classes[] = 'fullwidth-content';
			if ( $parallax ) {
				$wrap_classes[] = 'cloudfw-ui-parallax-effect';
			}
			$wrap_classes[] = 'clearfix';
			$wrap_classes[] = cloudfw_visible( $device );
			$wrap_classes[] = $class;

			if ( $full_height ) {
				$wrap_classes[] = 'ui--section-content-v-center';
			}

			$bg_classes = array();
			$bg_classes[] = 'ui--video-background';

			$video_classes = array();
			$video_classes[] = 'ui--video-background-video';
			if ( $parallax ) {
				$video_classes[] = 'ui--parallax';
			}
			$video_classes[] = cloudfw_visible( 'desktop-tablet' );

			$poster_classes = array();
			if ( $parallax ) {
				$poster_classes[] = 'ui--parallax';
			}
			$poster_classes[] = 'ui--video-background-poster';

			if ( $video_exists ) {
				//$poster_classes[] = cloudfw_visible( 'phone' );
			}

			$content_classes = array();
			$content_classes[] = 'ui--section-content';
			$content_classes[] = 'container';
			$content_classes[] = 'clearfix';


			if ( empty($gradient_start) ) {
				$gradient_start = $gradient_stop;
			} elseif ( empty($gradient_stop) ) {
				$gradient_stop = $gradient_start;
			}

			if ( cloudfw_color_analysis( $gradient_stop, 'bool' ) === 'dark' ) {
				$wrap_classes[] = 'color--dark';
			}

			$css = '';
			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background",
				), array(
					'opacity'       => $opacity,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background .ui--gradient",
				), array(
					'gradient'      => array( $gradient_start, $gradient_stop ),
				), FALSE, FALSE
			);


			if ( !empty($poster) && $poster_style == 'cover' ) {
				$poster_style = NULL;
				$cover = true;
			} else {
				if (empty($poster)) {
					$poster_style = NULL;

				} else {
					if (empty($poster_style)) {
						$poster_style = 'repeat';
					}

				}

			}


			if ( isset($cover) && $cover ) {
				$css .= cloudfw_make_style( array(
						"html #{$id} .ui--video-background-poster",
					), array(
						'background-ie'     => $poster,
						'background-image'  => $poster,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id} .ui--video-background-poster",
					), array(
						'background-image'  => $poster,
						'background-repeat' => $poster_style,
					), FALSE, FALSE
				);
			}

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--section-content (|p|h*)",
				), array(
					'color'  => $color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--section-content a",
				), array(
					'color'  => $link_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--section-content a:hover",
				), array(
					'color'  => $link_hover_color,
				), FALSE, FALSE
			);

			cloudfw_vc_set( 'css', $id, $css );
			unset( $css );

			$out  = '';
			$out .= "<div ".
				cloudfw_make_id( $id ) .
				cloudfw_make_class( $wrap_classes, true ) .
				cloudfw_make_style_attribute( array(
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE ) .
			">";

				$out .= "<div class=\"ui--video-background-holder\">";
					/** Video */
					$out .= "<div ".
						cloudfw_make_class( $video_classes, true ) .
					">";

					switch ($video_type) {
						default:
							if ( $video_exists ) {

								/** Video */
								$out .= "<video".
									cloudfw_make_attribute( array(
										'autoplay'  => 'autoplay',
										'loop'      => $loop ? 'loop' : NULL,
										'muted'     => 'muted',
										//'poster'    => $poster,
										'width'     => $video_width,
										'height'    => $video_height,
									), FALSE ) .
								">";

									if ( ! empty( $source_m4v ) ) {
										$out .= "<source".
											cloudfw_make_attribute( array(
												'src'   => $source_m4v,
												'type'  => 'video/mp4',
											), FALSE ) .
										" />";
									}

									if ( ! empty( $source_webmv ) ) {
										$out .= "<source".
											cloudfw_make_attribute( array(
												'src'   => $source_webmv,
												'type'  => 'video/webm',
											), FALSE ) .
										" />";
									}

									if ( ! empty( $source_ogv ) ) {
										$out .= "<source".
											cloudfw_make_attribute( array(
												'src'   => $source_ogv,
												'type'  => 'video/ogg',
											), FALSE ) .
										" />";
									}

								$out .= "</video>";

							}
							break;

						case 'youtube':
							$regex = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
							if (!empty($source_youtube) && preg_match($regex, $source_youtube, $match)) {
								$source_youtube = $match[1];
							}
							if ( !empty($source_youtube) ) {

								/** Vimeo Video */
								$vimeo_iframe_id = cloudfw_id( 'ui--video-background-iframe-youtube' );
								$vimeo_iframe_callback_player = cloudfw_id( 'BGVideo_player', '_' );
								$vimeo_iframe_callback_on_ready = cloudfw_id( 'BGVideo_onPlayerReady', '_' );
								$vimeo_iframe_callback_on_state_change = cloudfw_id( 'BGVideo_onPlayerStateChange', '_' );

								$video_iframe_url  = 'https://';
								$video_iframe_url .= 'www.youtube.com/embed/';
								$video_iframe_url .= $source_youtube;
								$video_iframe_url .= '?';
								$video_iframe_url .= 'enablejsapi=1';
								$video_iframe_url .= '&amp;controls=0';
								$video_iframe_url .= '&amp;showinfo=0';
								$video_iframe_url .= '&amp;rel=0';
								$video_iframe_url .= '&amp;vq=' . apply_filters('cloudfw_youtube_background_quality', 'hd1080');
								$video_iframe_url .= '&amp;modestbranding=1';
								$video_iframe_url .= '&amp;wmode=transparent';
								$video_iframe_url .= '&amp;loop=' . (  $loop ? '1' : '0' );
								$video_iframe_url .= '&amp;autoplay=1';
								$video_iframe_url .= '&amp;playerapiid=' . $vimeo_iframe_id;
								//$video_iframe_url .= '&amp;origin=' . cloudfw_home_url();

								$out .= "<iframe".
									cloudfw_make_attribute( array(
										'id'        => $vimeo_iframe_id,
										'width'     => $video_width,
										'height'    => $video_height,
										'src'       => esc_attr($video_iframe_url),
										'frameborder'=> '0',
									), FALSE ) .
								" webkitallowfullscreen mozallowfullscreen allowfullscreen>";
								$out .= "</iframe>";


								$youtube_api_loader = "
										new YT.Player('". $vimeo_iframe_id ."', {
											events: {
												'onReady': ". $vimeo_iframe_callback_on_ready . ",
												'onStateChange':  ". $vimeo_iframe_callback_on_state_change . "
											}
										});
								";
								cloudfw_vc_set( 'cloudfw_youtube_api_loader', $vimeo_iframe_id, $youtube_api_loader );

								$out .= " <script type=\"text/javascript\">";
								$out .= "   function ". $vimeo_iframe_callback_on_ready . "(event) { event.target.mute(); }";
								$out .= "   function  ". $vimeo_iframe_callback_on_state_change . "(event) {";
								if ( $loop ) {
									$out .= "       if(event.data === 0) {";
									$out .= "           event.target.playVideo();";
									$out .= "       }";
								}
								$out .= "   }";
								$out .= " </script>";
							}
							break;

						case 'vimeo':
							$regex = '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix';
							if (!empty($source_vimeo) && preg_match($regex, $source_vimeo, $match)) {
								$source_vimeo = $match[1];
							}
							if ( !empty($source_vimeo) ) {

								/** Vimeo Video */
								$vimeo_iframe_id = cloudfw_id( 'ui--video-background-iframe-vimeo' );
								$protocol = is_ssl() ? 'https://' : 'http://';

								$video_iframe_url  = $protocol;
								$video_iframe_url .= 'player.vimeo.com/video/';
								$video_iframe_url .= $source_vimeo;
								$video_iframe_url .= '?';
								$video_iframe_url .= 'api=1';
								$video_iframe_url .= '&amp;title=0';
								$video_iframe_url .= '&amp;byline=0';
								$video_iframe_url .= '&amp;portrait=0';
								$video_iframe_url .= '&amp;playbar=0';
								$video_iframe_url .= '&amp;loop=' . (  $loop ? '1' : '0' );
								$video_iframe_url .= '&amp;autoplay=1';
								$video_iframe_url .= '&amp;wmode=transparent';
								$video_iframe_url .= '&amp;player_id=' . $vimeo_iframe_id;

								$out .= "<iframe".
									cloudfw_make_attribute( array(
										'id'        => $vimeo_iframe_id,
										'width'     => $video_width,
										'height'    => $video_height,
										'src'       => esc_attr($video_iframe_url),
										'frameborder'=> '0',
									), FALSE ) .
								" webkitallowfullscreen mozallowfullscreen allowfullscreen>";
								$out .= "</iframe>";

								$out .= "

									<script type=\"text/javascript\">(function($) {

									  var \$f = jQuery('#". $vimeo_iframe_id ."'),
										  url = \$f.attr('src').split('?')[0];

									  if ( window.addEventListener )
										  window.addEventListener('message', onMessageReceived, false);
									  else
										  window.attachEvent('onmessage', onMessageReceived, false);

									  function onMessageReceived(e) {

										var data = JSON.parse(e.data);

										switch (data.event) {
											case 'ready':
											  var data = { method: 'setVolume', value: '0' };
											  \$f[0].contentWindow.postMessage(JSON.stringify(data), url);
											  data = { method: 'play' };
											  \$f[0].contentWindow.postMessage(JSON.stringify(data), url);
											  break;
										}

									  }

									})(jQuery);
									</script>

								";
							}
							break;

					}


					$out .= "</div>";

					if ( !empty( $poster ) ) {
						$out .= "<div".
							cloudfw_make_class( $poster_classes, true ) .
						"></div>";
					}


					/** Background */
					$out .= "<div ".
						cloudfw_make_class( $bg_classes, true ) .
					"><div class=\"ui--gradient\"></div></div>";

				$out .= "</div>";

				/** Content */
				$out .= "<div ".
					cloudfw_make_class( $content_classes, true ) .
					cloudfw_make_style_attribute( array(
						'padding-top'    => $padding_top,
						'padding-bottom' => $padding_bottom,
					), FALSE, TRUE ) .
				">";

					$out .= do_shortcode( $content );

				$out .= "</div>";

			$out .= "</div>";

			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Video/Image Background','cloudfw'),
				'script'    => array(
					'shortcode'     => 'boxed_content',
					'tag_close'     => true,
					'attributes'    => array(
						'id'               => array( 'e' => 'custom_id' ),
						'class'            => array( 'e' => 'custom_class' ),
						'device'           => array( 'e' => 'the_device' ),
						'content'          => array( 'e' => 'content' ),
						'radius'           => array( 'e' => 'box_radius' ),

						'gradient_start'   => array( 'e' => 'box_gradient_0' ),
						'gradient_stop'    => array( 'e' => 'box_gradient_1' ),
						'opacity'          => array( 'e' => 'box_opacity' ),

						'color'            => array( 'e' => 'box_color' ),
						'link_color'       => array( 'e' => 'box_link_color' ),
						'link_hover_color' => array( 'e' => 'box_link_hover_color' ),

						'video_type'       => array( 'e' => 'video_type' ),
						'source_vimeo'     => array( 'e' => 'video_source_vimeo' ),
						'source_youtube'   => array( 'e' => 'video_source_youtube' ),
						'source_m4v'       => array( 'e' => 'video_source_m4v' ),
						'source_ogv'       => array( 'e' => 'video_source_ogv' ),
						'source_webmv'     => array( 'e' => 'video_source_webmv' ),
						'poster'           => array( 'e' => 'video_poster' ),
						'poster_style'     => array( 'e' => 'video_poster_style' ),
						'loop'             => array( 'e' => 'video_loop', 'onoff' => true ),

						'video_width'      => array( 'e' => 'video_width' ),
						'video_height'     => array( 'e' => 'video_height' ),
						'full_height'      => array( 'e' => 'full_height' ),
						'parallax'         => array( 'e' => 'parallax' ),

						'margin_top'       => array( 'e' => 'margin_top' ),
						'margin_bottom'    => array( 'e' => 'margin_bottom' ),
						'padding_top'      => array( 'e' => 'padding_top' ),
						'padding_bottom'   => array( 'e' => 'padding_bottom' ),
					),
					'if' => array(
						array(
							'type'    => 'toggle',
							'e'       => 'video_type',
							'mode'    => 'same',
							'related' => 'videoBGOptions',
							'targets' => array(
								array('', '.videoBGOptions-Selfhosted'),
								array('youtube', '.videoBGOptions-Youtube'),
								array('vimeo', '.videoBGOptions-Vimeo'),
							)
						)
					),
				),
				'data'      =>  $this->load_scheme( __FILE__ ),

			);

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'      =>  array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}


/**
 *    CloudFw Youtube API Loader
 *
 *    @since 1.0
 */
add_filter('wp_footer','cloudfw_youtube_api_loader', 1000);
function cloudfw_youtube_api_loader(){

	$datas = cloudfw_vc_get( 'cloudfw_youtube_api_loader' );
	if ( !empty($datas) && is_array($datas) ) {
		$datas = implode("\r\n", $datas);

		if ( !empty($datas) ) {

			echo "
				<script type=\"text/javascript\">

					var tag = document.createElement('script');
					tag.src = \"http://www.youtube.com/player_api\";
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

					function onYouTubePlayerAPIReady() {
						$datas
					}
				</script>
			";
		}

	}

	cloudfw_vc_clear( 'cloudfw_youtube_api_loader' );

}