<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( cloudfw_check_onoff( 'woocommerce', 'catalog_mode' ) )
	return;
	
?>
<?php do_action('woocommerce_before_add_to_cart_button'); ?>

<p class="cart"><a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button btn btn-small <?php echo esc_attr( cloudfw_make_button_style( cloudfw_get_option('woocommerce_button_color', 'add_to_cart_in_product', 'btn-primary'), true ) ); ?>"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a></p>

<?php do_action('woocommerce_after_add_to_cart_button'); ?>