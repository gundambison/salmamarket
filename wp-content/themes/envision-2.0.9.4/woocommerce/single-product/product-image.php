<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images">

	<?php

	$is_mobile 		= wp_is_mobile();
	$zoom_effect 	= cloudfw_check_onoff( 'woocommerce', 'zoom' );	
	$attachment_ids = (array) $product->get_gallery_attachment_ids();
	$attachment_ids = array_merge( array( get_post_thumbnail_id() ), $attachment_ids);
	$attachment_ids = array_filter( $attachment_ids );
	$attachment_ids_count = count($attachment_ids);


	if ( $attachment_ids ) {

			$gallery = array();
			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image 		 = wp_get_attachment_image_src( $attachment_id, 'large');
				$image_class = esc_attr( implode( ' ', isset($classes) ? $classes : array() ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );

				$gallery[] 	 = array( 'src' => $image[0], 'width' => $image[1], 'height' => $image[2], 'link' => $zoom_effect && $is_mobile ? null : $image_link, 'alt' => $image_title, 'itemprop' => 'image' );

			}


			$image_width = 200;
			$image_height = cloudfw_match_ratio( $image_width, '1:1' );

			$slider_class = array();
			$slider_class[] = 'ui--shop-gallery';
			if ( $attachment_ids_count > 1 ) {
				$slider_class[] = 'ui--shop-gallery-multi';
			}
			
			$slider_class[] = 'ui--shop-slider-' . get_the_ID();
			$slider_class[] = 'ui--shop-slider-count-' . count($gallery);
			$slider_class[] = 'ui--shop-slider-zoom-' . ($zoom_effect ? 'enabled' : 'disabled');

			$gallery_content = cloudfw_UI_gallery()
					-> set('id', 'ui--shop-slider')
					-> set('class', $slider_class)
					-> set('alt', !empty($image_title) ? $image_title : get_the_title())
					-> set('slides_element', 'ul')
					-> set('item_element', 'li')
					-> set('slides_class', 'slides')
					//-> set('link_class', 'zoom')
					-> set('item_class', 'ui--shop-gallery-item')
					-> set('image_class', 'ui--shop-gallery-image')
					-> set('lightbox_group', $zoom_effect && $is_mobile ? '' : 'prettyPhoto[shop_gallery]')
					//-> set('width', $image_width)
					//-> set('height', $image_height)
					-> items( $gallery )
					-> render();

			echo apply_filters( 'woocommerce_single_product_image_html', $gallery_content );

	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img class="ui--shop-gallery-image" src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );
	}

	if ( $attachment_ids_count > 0 ): 


		/*if ( $is_mobile ) {
			$zoom_effect = false; 
		}*/

	?>

	<script type="text/javascript">

		jQuery(window).load(function() {
			var carousel = jQuery('.ui--shop-slider-carousel-<?php echo get_the_ID(); ?>');
			var slider = jQuery('.ui--shop-slider-<?php echo get_the_ID(); ?>');
			
			/** Zoom Function */
			<?php if ( $zoom_effect ):

				$zoom_type = $is_mobile ? 'inner' : cloudfw_get_option( 'woocommerce', 'zoom_type', 'window' );
				$zoom_easing = cloudfw_check_onoff( 'woocommerce', 'zoom_easing' );
				$zoom_scroll = cloudfw_check_onoff( 'woocommerce', 'zoom_scroll' );
				$zoom_window_width = (int) cloudfw_get_option( 'woocommerce', 'zoom_window_width', 500 );
				$zoom_window_height = (int) cloudfw_get_option( 'woocommerce', 'zoom_window_height', 500 );

				/** Enqueue Script Files for zoom function */
				wp_enqueue_script ('theme-woocommerce-zoom');

			 ?>
				var zoom_settings = {};
					zoom_settings["easing"] = <?php echo $zoom_easing ? 'true' : 'false'; ?>; 
					zoom_settings["responsive"] = true; 
					zoom_settings["zoomType"] = '<?php echo !empty($zoom_type) ? $zoom_type : 'window'; ?>'; 
					zoom_settings["scrollZoom"] = <?php echo $zoom_scroll ? 'true' : 'false'; ?>; 
					zoom_settings["zoomWindowWidth"] = <?php echo $zoom_window_width > 0 ? $zoom_window_width : 500; ?>; 
					zoom_settings["zoomWindowHeight"] = <?php echo $zoom_window_height > 0 ? $zoom_window_height : 500; ?>;

				if ( jQuery.isFunction( jQuery.fn.elevateZoom ) ) {
					var zoom_function = function( obj ){
						jQuery(".zoomContainer").remove();
						jQuery(".ui--shop-slider-<?php echo get_the_ID(); ?> .flex-active-slide .ui--shop-gallery-image").elevateZoom( zoom_settings );
					}
				} else {
					var zoom_function = jQuery.noop;
				}
			<?php else: ?>
				var zoom_function = jQuery.noop;
			<?php endif; ?>

			carousel.show().flexslider({
				animation: "slide",
				controlNav: false,
				direction: "<?php 
					if ( cloudfw_get_option( 'woocommerce', 'gallery_style' ) == 'vertical' ) { 
						echo 'vertical';
					} else { 
						echo 'horizontal'; 
					} 
				?>",
				animationLoop: false,
				slideshow: false,
				itemWidth: 150,
				itemHeight: 150,
				itemMargin: 18,
				animationSpeed: 500,
				smoothHeight: false,
				asNavFor: '.ui--shop-slider-<?php echo get_the_ID(); ?>'
			});

			slider.flexslider({
				animation: "slide",
				controlNav: false,
				animationLoop: false,
				slideshow: false,
				smoothHeight: true,
				animationSpeed: 500,
				sync: ".ui--shop-slider-carousel-<?php echo get_the_ID(); ?>",
				start: zoom_function,
				after: zoom_function
			}).css({'visibility': 'visible'});


			slider.find('.flex-prev').html('<span class=\"arr arr-large arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span>');
			slider.find('.flex-next').html('<span class=\"arr arr-large ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');

			carousel.find('.flex-prev').html('<span class=\"arr arr-small arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span>');
			carousel.find('.flex-next').html('<span class=\"arr arr-small ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');

			jQuery('form.variations_form .variations select').change(function(){
	            setTimeout(function () {
	                jQuery(window).resize();
	            }, 100)
			});



		});

	</script>

	<?php endif; ?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
