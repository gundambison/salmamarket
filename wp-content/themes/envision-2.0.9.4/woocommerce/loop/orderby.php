<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>
<form class="woocommerce-ordering clearfix" method="get">

	<select name="show_products" class="show_products" style="max-width: 120px;">
		<?php
			$show_products = isset($_GET['show_products']) ? $_GET['show_products'] : '';
			$catalog_show_products = apply_filters( 'woocommerce_catalog_show_products', array(
				''   => !empty($show_products) ? '' : cloudfw_translate('wc.catalog.display'),				
				'12' => sprintf( cloudfw_translate('wc.catalog.d_products'), '12'),
				'24' => sprintf( cloudfw_translate('wc.catalog.d_products'), '24'),
				'32' => sprintf( cloudfw_translate('wc.catalog.d_products'), '32'),
				'48' => sprintf( cloudfw_translate('wc.catalog.d_products'), '48'),
			) );


			foreach ( $catalog_show_products as $id => $name )
				echo '<option value="' . esc_attr( $id ) . '" ' . selected( $show_products, $id, false ) . '>' . esc_attr( $name ) . '</option>';
		?>
	</select>

	<select name="orderby" class="orderby">
		<?php foreach ( (array) $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' == $key || 'show_products' == $key )
				continue;
			
			if (is_array($val)) {
				foreach($val as $innerVal) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>
<div class="clear"></div>