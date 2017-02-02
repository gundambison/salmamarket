<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $woocommerce_loop_output, $woocommerce_loop_layout, $woocommerce_loop, $woocommerce_loop_via;
$layout = ''; 

if( isset($woocommerce_loop_layout) && $woocommerce_loop_layout ) {
	$layout = $woocommerce_loop_layout; 
}

$woocommerce_loop_output .= cloudfw_UI_column_close( 'woocommerce' ); 

if ( isset( $woocommerce_loop_via ) && $woocommerce_loop_via !== 'shortcode' ) {
	$is_page = cloudfw( 'get', 'woocommerce_is_page'); 
	if ( $is_page == 'shop' ) {
		$layout = cloudfw_get_option('woocommerce', 'catalog_layout');
	}

	$layout = cloudfw( 'get', 'woocommerce_catalog_layout', $layout );
}

if ( $layout ) {
	$woocommerce_loop_output = cloudfw_make_layout( $layout, $woocommerce_loop_output, array(
		'auto_rotate'    => isset($woocommerce_loop['auto_rotate']) ? $woocommerce_loop['auto_rotate'] : false,
		'arrows'         => true,
		'animation_loop' => true,
		'rotate_time'    => 5,
	) );
}

if ( !empty($woocommerce_loop['effect']) ) {
	$woocommerce_loop_output = cloudfw_do_shortcode( 'fx', array( 'effect' => $woocommerce_loop['effect'], 'delay' => 300 ), $woocommerce_loop_output );
}

echo $woocommerce_loop_output;
unset($woocommerce_loop_output); 
unset($woocommerce_loop_layout);
unset($woocommerce_loop); 
unset($woocommerce_loop_via); 

do_action('cloudfw_woocommerce_after_shop_loop');

?>

</div>