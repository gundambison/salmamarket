<?php
/**
 *	WooCommerce Page Layout
 *
 *	@since 1.0
 */
$that = cloudfw();
ob_start();
woocommerce_page_title();
$title = ob_get_contents();
ob_end_clean();

$post_type = cloudfw( 'get_post_type' );
$shop_page_id = woocommerce_get_page_id( 'shop' );

if ( ! is_single() ) {
	cloudfw( 'set_ID', $shop_page_id, false );
	cloudfw( 'set', 'woocommerce_is_page', 'shop');


	if ( is_product_category() ) {
		$description = '';
	}

    $spec_cat_options = cloudfw_walk_options( array(
		'id'                   => 'indicator',
		'layout'               => 'layout',
		'sidebar'              => 'sidebar',
		'skin'                 => 'skin',
		'titlebar_style'       => 'titlebar_style',
		'titlebar_title'       => 'titlebar_title',
		'titlebar_desc'        => 'titlebar_desc',

		'catalog_layout'       => 'catalog_layout',
		'catalog_column'       => 'catalog_column',
		'catalog_media_ratio'  => 'catalog_media_ratio',
		'catalog_shadow'       => 'catalog_shadow',
		'catalog_effect'       => 'catalog_effect',
		'catalog_hover'        => 'catalog_hover',
		'catalog_hover_effect' => 'catalog_hover_effect',
		'catalog_before_loop'  => 'catalog_before_loop',
		'catalog_after_loop'   => 'catalog_after_loop',

    ), cloudfw_get_option( 'woocommerce_category_options' ), 'indicator', get_queried_object_id() );


	if ( !empty( $spec_cat_options ) ) {

		if ( !empty($spec_cat_options['layout']) ) {
			$layout = $spec_cat_options['layout'];
			$that->set_meta( '_wp_page_template', $layout, NULL, FALSE );
		}

		if ( !empty($spec_cat_options['skin']) ) {
			$that->set('skin', $spec_cat_options['skin'] );
		}

		if ( !empty($spec_cat_options['sidebar']) ) {
			$that->set('custom_sidebar', $spec_cat_options['sidebar']);
		}

		if ( !empty($spec_cat_options['titlebar_style']) ) {
			$that->set('default_titlebar_style', $spec_cat_options['titlebar_style']);
		}

		if ( !empty($spec_cat_options['titlebar_title']) ) {
			$title = $spec_cat_options['titlebar_title'];
		}

		if ( !empty($spec_cat_options['titlebar_desc']) ) {
			$description = $spec_cat_options['titlebar_desc'];
		}

		if ( !empty($spec_cat_options['catalog_layout']) ) {
			$that->set('woocommerce_catalog_layout', $spec_cat_options['catalog_layout']);
		}

		if ( !empty($spec_cat_options['catalog_column']) ) {
			$that->set('woocommerce_catalog_column', $spec_cat_options['catalog_column']);
		}

		if ( !empty($spec_cat_options['catalog_shadow']) ) {
			$that->set('woocommerce_catalog_shadow', $spec_cat_options['catalog_shadow']);
		}

		if ( !empty($spec_cat_options['catalog_effect']) ) {
			$that->set('woocommerce_catalog_effect', $spec_cat_options['catalog_effect']);
		}

		if ( !empty($spec_cat_options['catalog_media_ratio']) ) {
			$that->set('woocommerce_catalog_media_ratio', $spec_cat_options['catalog_media_ratio']);
		}

		if ( !empty($spec_cat_options['catalog_hover']) ) {
			$that->set('woocommerce_catalog_hover', $spec_cat_options['catalog_hover']);
		}

		if ( !empty($spec_cat_options['catalog_hover_effect']) ) {
			$that->set('woocommerce_catalog_hover_effect', $spec_cat_options['catalog_hover_effect']);
		}

		if ( !empty($spec_cat_options['catalog_before_loop']) ) {
			$that->set('before_page_content', "<div class=\"clearfix\">". $spec_cat_options['catalog_before_loop'] ."</div>");
		}

		if ( !empty($spec_cat_options['catalog_after_loop']) ) {
			$that->set('after_page_content', $spec_cat_options['catalog_after_loop']);
		}

	}

} else {
	cloudfw( 'set', 'woocommerce_is_page', 'product');
	$layout = cloudfw_get_option('woocommerce', 'post_page_layout');

	$meta_sidebar = cloudfw( 'get_meta', 'custom_sidebar' );
	if ( !empty($meta_sidebar) ) {
		$sidebar = $meta_sidebar;
	} else {
		$sidebar = cloudfw_get_option('woocommerce', 'post_page_sidebar');
	}

	$skin = cloudfw_get_option('woocommerce', 'post_page_skin');
	$titlebar_style = cloudfw_get_option('woocommerce', 'post_page_titlebar_style');

	$title = cloudfw( 'get_meta', 'titlebar_title' ) ? cloudfw( 'get_meta', 'titlebar_title' ) : $title;
}

cloudfw( 'set_meta', 'titlebar_title', $title );
cloudfw( 'set', 'woocommerce', true);

if ( isset($description) ) {
	cloudfw( 'set_meta', 'titlebar_text', $description );
}

if ( empty($layout) ) {
	$layout = cloudfw('get_layout');
}
$layout = apply_filters( 'cloudfw_wc_shop_layout', isset($layout) ? $layout : '' );
$sidebar = apply_filters( 'cloudfw_wc_shop_sidebar', isset($sidebar) ? $sidebar : '' );

if ( !empty($sidebar) ) {
	cloudfw( 'set', 'custom_sidebar', $sidebar);
}

if ( !empty($skin) ) {
	cloudfw( 'set', 'skin', $skin);
}

if ( !empty($titlebar_style) ) {
	cloudfw( 'set', 'default_titlebar_style', $titlebar_style);
}

if ( !empty($layout) ) {
	cloudfw('return_layout', $layout);
}

cloudfw('return_layout', 'page.php');