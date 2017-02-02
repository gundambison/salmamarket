<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
?>

<header>
	<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h5'  ), '<strong>'. __('Customer details','woocommerce') .'</strong>' )); ?>
</header>
<table class="shop_table shop_table_responsive customer_details">
<?php
	if ( $order->billing_email ) echo '<tr><th>' . __( 'Email:', 'woocommerce' ) . '</th><td data-title="' . __( 'Email', 'woocommerce' ) . '">' . $order->billing_email . '</td></tr>';
	if ( $order->billing_phone ) echo '<tr><th>' . __( 'Telephone:', 'woocommerce' ) . '</th><td data-title="' . __( 'Telephone', 'woocommerce' ) . '">' . $order->billing_phone . '</td></tr>';

	// Additional customer details hook
	do_action( 'woocommerce_order_details_after_customer_details', $order );
?>
</table>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

<div class="col2-set addresses">

	<div class="col-1">

<?php endif; ?>

		<header class="title">
			<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h5'  ), '<strong>'. __('Billing Address','woocommerce') .'</strong>' )); ?>
		</header>
		<address><p>
			<?php
				if ( ! $order->get_formatted_billing_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_billing_address();
			?>
		</p></address>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

	</div><!-- /.col-1 -->

	<div class="col-2">

		<header class="title">
			<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h5'  ), '<strong>'. __('Shipping Address','woocommerce') .'</strong>' )); ?>
		</header>
		<address><p>
			<?php
				if ( ! $order->get_formatted_shipping_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_shipping_address();
			?>
		</p></address>

	</div><!-- /.col-2 -->

</div><!-- /.col2-set -->

<?php endif; ?>

<div class="clear"></div>
