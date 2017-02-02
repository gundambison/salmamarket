<?php

global $yith_woocompare;

if ( isset( $yith_woocompare ) && is_object( $yith_woocompare ) ) {

	add_filter('cloudfw_woocommerce_loop_footer_action_after', 'custom_cloudfw_woocommerce_loop_footer_action_after_yith_compare');
	function custom_cloudfw_woocommerce_loop_footer_action_after_yith_compare( $content ){
		global $yith_woocompare;

		$out = '';
		if ( isset( $yith_woocompare ) && is_object( $yith_woocompare ) ) {
			$out .= ' <span class="product"><a data-product_id="'. get_the_ID() .'" href="'. add_query_arg( array( 'iframe' => 'true', 'width' => '80%', 'height' => '80%', 'id' => get_the_ID() ), $yith_woocompare->obj->view_table_url() ) .'" class="compare btn-small btn '. esc_attr( cloudfw_make_button_style( cloudfw_get_option('woocommerce_button_color', 'price_tag', 'btn-secondary muted'), true ) ) . '">'. __( 'Compare', 'yit' ) .'</a></span>';
		}

		$content .= $out ;
		return $content;
	}

}