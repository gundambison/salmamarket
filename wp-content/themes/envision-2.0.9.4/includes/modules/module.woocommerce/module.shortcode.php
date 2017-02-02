<?php
/*
 * Plugin Name: WooCommerce Products
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 */

// [recent_products per_page="12" columns="4" orderby="date" order="desc"]
//
cloudfw_register_shortcode( 'CloudFw_Shortcode_WooCommerce_Products' );
if ( ! class_exists('CloudFw_Shortcode_WooCommerce_Products') ) {

	class CloudFw_Shortcode_WooCommerce_Products extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'ajax'          => true,
				'icon'          => 'shop',
				'group'         => 'composer_post_list',
				'line'          => 300,
				'options'       => array(
					'title'             => __('Product List','cloudfw'),
					'sync_title'        => 'box_title',
					'column'            => '1/1',
					'allow_columns'     => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			$atts = shortcode_atts(array(
				'per_page'    => '12',
				'columns'     => '4',
				'orderby'     => NULL,
				'order'       => NULL,

				'layout'      => '',
				'image_ratio' => '',
				'show_hover'  => '',
				'hover_effect'=> '',
				'shadow'      => 0,
				'auto_rotate' => 0,

				'categories'  => NULL,
				'category'    => NULL,
				'parent'      => 0,
				'category_ids'=> NULL,
			), _check_onoff_false( $atts ));

			if ( is_admin() )
				return '';

			global $woocommerce_loop, $woocommerce_loop_layout, $woocommerce_loop_via, $wp_query;
			$woocommerce_loop_via = 'shortcode';
			$temp_woocommerce_loop = $woocommerce_loop;
			$temp_woocommerce_loop_layout = $woocommerce_loop_layout;

			$woocommerce_loop['image_ratio'] = $atts['image_ratio'];
			$woocommerce_loop['show_hover'] = $atts['show_hover'];
			$woocommerce_loop['hover_effect'] = $atts['hover_effect'];
			$woocommerce_loop['shadow'] = $atts['shadow'];
			$woocommerce_loop['auto_rotate'] = $atts['auto_rotate'];
			$woocommerce_loop_layout = $atts['layout'];
			$atts['number'] = $atts['per_page'];

			if ( $case == 'product_categories' ) {
				if ( is_array($atts['category_ids']) && !empty($atts['category_ids']) ) {
					$atts['ids'] = implode(',', $atts['category_ids']);
				}
			}
			
			unset($atts['categories']);
			unset($atts['image_ratio']);
			unset($atts['show_hover']);
			unset($atts['hover_effect']);
			unset($atts['shadow']);
			unset($atts['layout']);
			unset($atts['auto_rotate']);
			unset($atts['per_page']);

				$out = do_shortcode(cloudfw_transfer_shortcode_attributes( $case, $atts, $content, FALSE ));

			$woocommerce_loop_via = '';
			$woocommerce_loop = $temp_woocommerce_loop;
			$woocommerce_loop_layout = $temp_woocommerce_loop_layout;

			return "<div class=\"ui--pass\">{$out}</div>";

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     => __('Product List','cloudfw'),
				'ajax'      => true,
				'script'    => array(
					'shortcode:sync'=> 'product_list_type',
					'tag_close'     => true,
					'attributes'    => array(
						'columns'      => array( 'e' => 'product_list_column' ),
						'per_page'     => array( 'e' => 'product_list_per_page' ),
						'layout'       => array( 'e' => 'product_list_layout' ),
						'image_ratio'  => array( 'e' => 'product_list_image_ratio' ),
						'shadow'       => array( 'e' => 'product_list_shadow' ),
						'show_hover'   => array( 'e' => 'product_list_show_hover', 'onoff' => true ),
						'auto_rotate'  => array( 'e' => 'product_list_auto_rotate', 'onoff' => true ),
						'hover_effect' => array( 'e' => 'product_list_hover_effect' ),
						'orderby'      => array( 'e' => 'product_list_orderby' ),
						'order'        => array( 'e' => 'product_list_order' ),

						'category'     => array( 'e' => 'product_list_category' ),
						'category_ids' => array( 'e' => 'product_list_category_multiple' ),

					),

					'if' =>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'product_list_type',
							'mode' 	  => 'same',
							'related' => 'productListTypeOptions',
							'targets' => array( 
								array('recent_products', ''),
								array('featured_products', ''),
								array('top_rated_products', ''),
								array('best_selling_products', ''),
								array('sale_products', ''),
								array('product_category', '.productListTypeOptions_Category'),
								array('product_categories', '.productListTypeOptions_Category_Multiple'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'product_list_layout',
							'mode' 	  => 'same',
							'related' => 'productListTypeOptions_Carousel',
							'targets' => array( 
								array('carousel', '.productListTypeOptions_Carousel_AutoRotate'),
							)
						),
					)
				),
				'data'      =>  array(


					array(
						'type'		=>	'mini-section',
						'title' 	=>	__('Source','cloudfw'),
						'data'		=> 	array(

							array(
								'type'		=> 'module',
								'title'		=>	__('Type','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'        =>  'product_list_type',
										'value'     =>  $this->get_value('product_list_type'),
										'source'	=>	array(
											'recent_products'       => __('Recent Products','cloudfw'),
											'featured_products'     => __('Featured Products','cloudfw'),
											'top_rated_products'    => __('Top Rated Products','cloudfw'),
											'best_selling_products' => __('Bestseller Products','cloudfw'),
											'sale_products'         => __('Sale Products','cloudfw'),
											'product_category'      => __('Products by Category','cloudfw'),
											'product_categories'    => __('Product Category List','cloudfw'),
										),
										'width'		=>	250,
									)

								)

							),


							array(
								'type'		=>	'module',
								'related'	=>	'productListTypeOptions productListTypeOptions_Category',
								'title'		=>	__('Filter by Category','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'product_list_category',
										'value'		=>	$this->get_value('product_list_category'),
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_terms_for_slug',
											'vars'		=>	array('product_cat', __('- Select a category -','cloudfw'))
										),
										//'multiple'	=>	true,
										//'brackets'	=>	$this->is_composer ? true : false,
										//'height'	=>	200,
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'related'	=>	'productListTypeOptions productListTypeOptions_Category_Multiple',
								'title'		=>	__('Filter by Category','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'product_list_category_multiple',
										'value'		=>	$this->get_value('product_list_category_multiple'),
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_terms',
											'vars'		=>	array('product_cat', __('- Select a category -','cloudfw'))
										),
										'multiple'	=>	true,
										'brackets'	=>	true,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Per Page / Limit','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'        =>  'product_list_per_page',
										'value'     =>  $this->get_value('product_list_per_page'),
										'width'		=>	50,
										'unit'		=>	__('products','cloudfw'),
										'holder'	=>	'12',
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Order By','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'        =>  'product_list_orderby',
										'value'     =>  $this->get_value('product_list_orderby'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_order_by',
										),
										'width'		=>	250,
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Order','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'        =>  'product_list_order',
										'value'     =>  $this->get_value('product_list_order'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_order',
										),
										'width'		=>	250,
									)

								)

							),

						)

					),


					array(
						'type'		=>	'mini-section',
						'title' 	=>	__('Layout','cloudfw'),
						'data'		=> 	array(

							array(
								'type'		=> 'module',
								'title'		=>	__('Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'        =>  'product_list_layout',
										'value'     =>  $this->get_value('product_list_layout'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_content_layouts',
										),
										'width'		=>	250,
									)

								)

							),

							array(
								'type'		=> 'module',
								'related'	=>	'productListTypeOptions_Carousel productListTypeOptions_Carousel_AutoRotate',
								'title'		=>	__('Auto rotate carousel?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'        =>  'product_list_auto_rotate',
										'value'     =>  $this->get_value('product_list_auto_rotate', 'FALSE'),
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Columns','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'        =>  'product_list_column',
										'value'     =>  $this->get_value('product_list_column'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_columns',
										),
										'width'		=>	150,
									)

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Image Size / Ratio','cloudfw'),
								'data'      => array(

									array(
										'type'		=>	'select',
										'id'        =>  'product_list_image_ratio',
										'value'     =>  $this->get_value('product_list_image_ratio'),
										'source'	=>	array(
											'type' 		=> 'function',
											'function'	=> 'cloudfw_admin_loop_aspect_ratio',
										),
										'width'		=>  250,
									),

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Box Shadows','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'product_list_shadow',
										'value'     =>  $this->get_value('product_list_shadow'),
										'source'    =>  array(
											'type'          => 'function',
											'function'      => 'cloudfw_admin_loop_shadows',
										),
										'width'     =>  250,

									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=>	'mini-section',
						'title' 	=>	__('Hover Effect','cloudfw'),
						'data'		=> 	array(

							array(
								'type'		=> 'module',
								'title'		=>	__('Show the second image of product galleries on mouse over?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'        =>  'product_list_show_hover',
										'value'     =>  $this->get_value('product_list_show_hover'),
									)

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Mouse over transition effect','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'product_list_hover_effect',
										'value'     =>  $this->get_value('product_list_hover_effect'),
										'source'    =>  array(
											'type'          => 'function',
											'function'      => 'cloudfw_UI_box_hover_effects',
										),
										'width'     =>  250,

									), // #### element: 0

								)

							),

						)

					),


				)

			);

		}

		/** Skin map */
		function skin_map( $map ){

			$map  -> id      ( 'footer_woocommerce_widgets_border_sync' )
			      -> selector( 'footer .woocommerce ul.cart_list li, footer .woocommerce ul.product_list_widget li, footer .woocommerce-page ul.cart_list li, footer .woocommerce-page ul.product_list_widget li' )
			      -> sync    ( 'border-color', 'footer_widgetized_separator', 'background-color' );

			$map  -> id      ( 'side_panel_woocommerce_widgets_border_sync' )
			      -> selector( '#side-panel .woocommerce ul.cart_list li, #side-panel .woocommerce ul.product_list_widget li, #side-panel .woocommerce-page ul.cart_list li, #side-panel .woocommerce-page ul.product_list_widget li' )
			      -> sync    ( 'border-color', 'side_panel_separator', 'background-color' );

			return cloudfw_UI_box_skin_map( $map, 'wc_products', '.products' );

		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){

			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Product Lists Grid','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	cloudfw_UI_box_skin_scheme( $data, 'wc_products', 'WOOCOMMERCE PRODUCT LIST GRID' ),
				),
				5 //seq

			);

		}

	}

}