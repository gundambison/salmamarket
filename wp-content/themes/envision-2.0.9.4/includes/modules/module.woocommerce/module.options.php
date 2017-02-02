<?php


/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@subpackage WooCommerce
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_woocommerce' );
function cloudfw_module_map_woocommerce( $map ) {
     $map -> option	 ( 'woocommerce' )
          -> sub     ( 'cart_in_navigation' )
          -> sub     ( 'cart_in_navigation_action' )
          -> sub     ( 'mini_cart_submit_button_color' )
          -> sub     ( 'mini_cart_secondary_button_color' )
          -> sub     ( 'catalog_mode', 'FALSE' )
          -> sub     ( 'archive_description_position' )

          -> sub     ( 'catalog_layout' )
          -> sub     ( 'catalog_column' )
          -> sub     ( 'catalog_post_perpage', 24 )
          -> sub     ( 'catalog_hover' )
          -> sub     ( 'catalog_hover_effect' )
          -> sub     ( 'catalog_posts_per_page' )
          -> sub     ( 'catalog_media_ratio', '3:4' )
          -> sub     ( 'catalog_shadow', 0 )
          -> sub     ( 'catalog_effect' )

          -> sub     ( 'related_column' )
          -> sub     ( 'related_limit' )
          -> sub     ( 'related_layout' )
          -> sub     ( 'related_hover' )
          -> sub     ( 'related_hover_effect' )
          -> sub     ( 'related_posts_per_page' )
          -> sub     ( 'related_media_ratio' )
          -> sub     ( 'related_shadow', 0 )
          -> sub     ( 'related_effect' )

          -> sub  	 ( 'up_sells_column' )
          -> sub  	 ( 'up_sells_limit' )
          -> sub  	 ( 'up_sells_layout' )

          -> sub  	 ( 'cross_sells_column' )
          -> sub  	 ( 'cross_sells_limit' )
          -> sub  	 ( 'cross_sells_layout' )

          -> sub  	 ( 'post_page_layout' )
          -> sub     ( 'post_page_sidebar' )
          -> sub     ( 'post_page_skin' )
          -> sub     ( 'post_page_titlebar_style' )

          -> sub     ( 'login_message' )
          -> sub     ( 'register_message' )
          
          -> sub     ( 'code_single_before_content' )
          -> sub     ( 'code_single_after_content' )


          -> sub     ( 'gallery_style', 'horizontal' )

          -> sub     ( 'zoom', 'FALSE' )
          -> sub     ( 'zoom_type', 'window' )
          -> sub     ( 'zoom_easing', true )
          -> sub     ( 'zoom_scroll', true )
          -> sub     ( 'zoom_window_width', 500 )
          -> sub     ( 'zoom_window_height', 500 )

     ;

     $map  -> option ( 'woocommerce_button_color' )
          -> sub     ( 'add_to_cart' )
          -> sub     ( 'add_to_cart_in_product' )
          -> sub     ( 'price_tag' )
          -> sub     ( 'update_cart' )
          -> sub     ( 'proceed_to_checkout' )
          -> sub     ( 'place_order' )
     ;

     $map  -> option ( 'woocommerce_category_options' )
           -> sub    ( 'indicator', array() )
           -> sub    ( 'id', array() )
           -> sub    ( 'layout', array() )
           -> sub    ( 'sidebar', array() )
           -> sub    ( 'skin', array() )
           -> sub    ( 'titlebar_style', array() )
           -> sub    ( 'titlebar_title', array() )
           -> sub    ( 'titlebar_desc', array() )

           -> sub    ( 'catalog_layout', array() )
           -> sub    ( 'catalog_column', array() )
           -> sub    ( 'catalog_media_ratio', array() )
           -> sub    ( 'catalog_shadow', array() )
           -> sub    ( 'catalog_effect', array() )
           -> sub    ( 'catalog_hover', array() )
           -> sub    ( 'catalog_hover_effect', array() )
           -> sub    ( 'catalog_before_loop', array() )
           -> sub    ( 'catalog_after_loop', array() )
     ;

	return $map;
}

cloudfw_translate_register( 'login_message', 'woocommerce' );
cloudfw_translate_register( 'register_message', 'woocommerce' );
cloudfw_translate_register( 'code_single_before_content', 'woocommerce' );
cloudfw_translate_register( 'code_single_after_content', 'woocommerce' );

if ( is_admin() && file_exists(dirname(__FILE__) . '/module.options.scheme.php') )
   require_once( dirname(__FILE__) . '/module.options.scheme.php' );
