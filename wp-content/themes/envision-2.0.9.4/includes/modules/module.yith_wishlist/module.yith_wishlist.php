<?php

global $yith_wcwl;

if ( isset( $yith_wcwl ) && is_object( $yith_wcwl ) ) {

	add_filter('cloudfw_woocommerce_loop_footer_action_after', 'custom_cloudfw_woocommerce_loop_footer_action_after_yith_wishlist');
	function custom_cloudfw_woocommerce_loop_footer_action_after_yith_wishlist( $content ){
		global $yith_wcwl, $product;
		
		$out = '';

		$label_option = get_option( 'yith_wcwl_add_to_wishlist_text' );
		$localize_label = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_wishlist_button', $label_option ) : $label_option;

		$label = apply_filters( 'yith_wcwl_button_label', $localize_label );
		$icon = get_option( 'yith_wcwl_add_to_wishlist_icon' ) != 'none' ? '<i class="fa ' . get_option( 'yith_wcwl_add_to_wishlist_icon' ) . '"></i>' : '';

		$classes = 'class="add_to_wishlist single_add_to_wishlist btn-small btn '. esc_attr( cloudfw_make_button_style( cloudfw_get_option('woocommerce_button_color', 'price_tag', 'btn-secondary muted'), true ) ) . '"';

		$out  = '<span class="yith-wcwl-add-to-wishlist">';
		$out .= '<span class="yith-wcwl-add-button';  // the class attribute is closed in the next row

		$out .= $exists ? ' hide" style="display:none;"' : ' show"';

		$out .= '><a href="' . esc_url( add_query_arg( 'add_to_wishlist', $product->id ) ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' >' . $icon . $label . '</a>';
		$out .= '<img src="' . esc_url( admin_url( 'images/wpspin_light.gif' ) ) . '" class="ajax-loading" alt="loading" width="16" height="16" style="position: absolute; visibility:hidden" />';
		$out .= '</span>';

		$out .= '<span class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><span class="feedback">' . __( 'Product added!','yit' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'yit' ) ) . '</a></span>';
		$out .= '<span class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><span class="feedback">' . __( 'The product is already in the wishlist!', 'yit' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'yit' ) ) . '</a></span>';
		$out .= '<span style="clear:both"></span><span class="yith-wcwl-wishlistaddresponse"></span>';

		$out .= '</span>';

		$content .= $out ;


		return $content;
	}

}