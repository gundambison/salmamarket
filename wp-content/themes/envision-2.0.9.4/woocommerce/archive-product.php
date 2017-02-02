<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$woocommerce_archive_description_position = cloudfw_get_option( 'woocommerce', 'archive_description_position', 'before_loop' );

if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

<?php endif; ?>

<?php if ( $woocommerce_archive_description_position == 'before_loop' ) do_action( 'woocommerce_archive_description' ); ?>

<?php if ( have_posts() ) : ?>

	<?php do_action('woocommerce_before_shop_loop'); ?>

	<?php woocommerce_product_loop_start(); ?>

		<?php woocommerce_product_subcategories(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php woocommerce_product_loop_end(); ?>

	<?php if ( $woocommerce_archive_description_position == 'after_loop' ) do_action( 'woocommerce_archive_description' ); ?>

	<?php do_action('woocommerce_after_shop_loop'); ?>

<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif;