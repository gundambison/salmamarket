<?php

$option_field = $args[1];
$options = isset($args[2]) ? $args[2] : array();

return $scheme = array(

	array(
		'type'      =>  'sorting',
		'id'        =>  'woocommerce_category_options_sorting',
		'data'      =>

			cloudfw_core_loop_multi_option(
			array(
			'indicator' => cloudfw_get_option('woocommerce_category_options', 'indicator'),
			'data'      =>
				array(
					'type'      =>  'module-set',
					'title'     =>  '<span class="category-option-title"></span>',
					'closable'  =>  true,
					'state'     =>  'closed',
					'title_right'=> '
						<a class="small-button small-grey cloudfw-action-only-duplicate" href="javascript:;"><span>'.__('Duplicate','cloudfw').'</span></a>
						<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
					',
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Category','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_woocommerce_category_options indicator'),
									'value'     =>  cloudfw_get_option('woocommerce_category_options', 'indicator'),
									'source'    =>  array(
										'type'      =>  'function',
										'function'  =>  'cloudfw_admin_loop_terms',
										'vars'      =>  array('product_cat', __('Select category','cloudfw'), '%s')
									),
									'reset'     =>  '',
									'width'     =>  300,
									'brackets'  =>  true

								), // #### element: 0

							)

						),
						array(
							'type'      =>  'mini-section',
							'title'     =>  __('Category Page Options','cloudfw'),
							'data'      =>  array(


								array(
									'type'		=> 'module',
									'title'		=>	__('Page Layout','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_woocommerce_category_options layout' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options', 'layout' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_page_templates',
											),
											'width'		=>	250,
											'reset'		=>	'',
											'brackets'	=>	true,
										)

									)

								),


								array(
									'type'		=> 'module',
									'title'		=>	__('Sidebar','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_woocommerce_category_options sidebar' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'sidebar' ),
							                'source'    =>  array(
							                    'type'      =>  'function',
							                    'function'  =>  'cloudfw_admin_loop_custom_sidebars'
							                ),
							                'width'     =>  400,
											'reset'		=>	'',
											'brackets'	=>	true,
							            ), // #### element: 0

									)

								),

								array(
									'type'		=> 'module',
									'title'		=>	__('Page Skin','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_woocommerce_category_options skin' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'skin' ),
							                'source'    =>  array(
							                    'type'          => 'function',
							                    'function'      => 'cloudfw_module_admin_gel_all_skins_array',
												'send_data'	=>	true,
												'send_args'	=>	true,
							                ),
							                'ui'        =>  true,
							                'main_class'=>  'input input_400',
											'reset'		=>	'',
											'brackets'	=>	true,
							            )

									)

								),

								array(
									'type'		=> 'module',
									'title'		=>	__('Title Bar Style','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_woocommerce_category_options titlebar_style' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'titlebar_style' ),
							                'source'    =>  array(
							                    'type'          => 'function',
							                    'function'      => 'cloudfw_admin_loop_titlebar_styles',
							                ),
							                'ui'        =>  true,
							                'main_class'=>  'input input_300',
											'reset'		=>	'',
											'brackets'	=>	true,
							            )

									)

								),

								array(
									'type'      => 'module',
									'title'     => __('Titlebar Heading','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'text',
											'id'        =>  cloudfw_sanitize(PFIX.'_woocommerce_category_options titlebar_title'),
											'value'     =>  cloudfw_get_option('woocommerce_category_options', 'titlebar_title'),
											'reset'     =>  '',
											'width'     =>  400,
											'brackets'  =>  true
										), // #### element: 0

									)

								),

								array(
									'type'      => 'module',
									'title'     => __('Titlebar Description','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'textarea',
											'id'        =>  cloudfw_sanitize(PFIX.'_woocommerce_category_options titlebar_desc'),
											'value'     =>  cloudfw_get_option('woocommerce_category_options', 'titlebar_desc'),
											'reset'     =>  '',
											'width'     =>  400,
											'line'      =>  2,
											'brackets'  =>  true
										), // #### element: 0

									)

								),

							)
						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Loop Options','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=> 'module',
									'title'		=>	__('Loop Layout','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_layout' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_layout' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_content_layouts',
												'exclude'	=>	array( 'carousel' ),
												'prepend'	=>	array(
													'NULL' 		=> __('Default','cloudfw'),
													'normal' 	=> __('Normal','cloudfw') 
												),
											),
											'width'		=>	250,
											'reset'  	=>  '',
											'brackets'  =>  true,
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
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_column' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_column' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_columns',
											),
											'width'		=>	250,
											'reset'  	=>  '',
											'brackets'  =>  true,
										)

									)

								),

								array(
									'type'      => 'module',
									'title'     => __('Product Images Aspect Ratio','cloudfw'),
									'data'      => array(

										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_media_ratio' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_media_ratio' ),
											'source'	=>	array(
												'type' 		=> 'function',
												'function'	=> 'cloudfw_admin_loop_aspect_ratio',
											),
											'width'		=>  250,
											'reset'  	=>  '',
											'brackets'  =>  true,
										),

									)

								),

							)

						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Shadow','cloudfw'),
							'data'		=>	array(

								array(
									'type'      => 'module',
									'title'     => __('Box Shadows','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_shadow' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_shadow' ),
											'source'    =>  array(
												'type'          => 'function',
												'function'      => 'cloudfw_admin_loop_shadows',
											),
											'width'     =>  250,
											'reset'  	=>  '',
											'brackets'  =>  true,

										), // #### element: 0

									)

								),


							)

						),


						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Effects','cloudfw'),
							'data'		=>	array(

								array(
									'type'      => 'module',
									'title'     => __('Entrance Effect for Products','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_effect' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_effect' ),
											'ui'		=>	true,
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_css_effect_list',
												'vars'		=>	array(''),
											),
											'width'		=>	400,
											'reset'  	=>  '',
											'brackets'  =>  true,
										),

									)

								),


								array(
									'type'		=> 'module',
									'title'		=>	__('Gallery Effect on Hover?','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_hover' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_hover' ),
											'ui'		=>	true,
											'source'	=>	array(
												'NULL'		=>	__('Default','cloudfw'),
												'TRUE'		=>	__('Yes','cloudfw'),
												'FALSE'		=>	__('No','cloudfw'),
											),
											'width'		=>	150,
											'reset'  	=>  '',
											'brackets'  =>  true,
										),

									)

								),


								array(
									'type'      => 'module',
									'title'     => __('Hover Transition Effect','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_hover_effect' ),
											'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_hover_effect' ),
											'source'    =>  array(
												'type'          => 'function',
												'function'      => 'cloudfw_UI_box_hover_effects',
											),
											'width'     =>  250,
											'reset'  	=>  '',
											'brackets'  =>  true,

										), // #### element: 0

									)

								),


								array(
									'type'      => 'mini-section',
									'title'     => __('Contents','cloudfw'),
									'data'      => array(

										array(
											'type'      => 'module',
											'title'     => __('Content Before the Product Loop','cloudfw'),
											'data'      => array(

												## Element
												array(
													'type'      =>  'textarea',
													'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_before_loop' ),
													'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_before_loop' ),
													'reset'     =>  '',
													'width'     =>  400,
													'line'      =>  4,
													'brackets'  =>  true
												), // #### element: 0


											)

										),

										array(
											'type'      => 'module',
											'title'     => __('Content After the Product Loop','cloudfw'),
											'data'      => array(

												## Element
												array(
													'type'      =>  'textarea',
													'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce_category_options catalog_after_loop' ),
													'value'		=>	cloudfw_get_option( 'woocommerce_category_options',  'catalog_after_loop' ),
													'reset'     =>  '',
													'width'     =>  400,
													'line'      =>  4,
													'brackets'  =>  true
												), // #### element: 0


											)

										),

									)

								),


							)

						),


					)

				),

			)

		),

	),


	## Module Item
	array(
		'type'      =>  'module',
		'layout'    =>  'raw',
		'divider'   =>  false,
		'data'      =>  array(

			## Element
			array(
				'type'      =>  'html',
				'data'      =>  '<a data-target="#woocommerce_category_options_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Specific Category Options','cloudfw').'</span></a>',
			), // #### element: 0

		)
	),

	array(
		'type'      => 'jquery',
		'data'      => '

			/** Add event listener for font titles */
			jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_woocommerce_category_options indicator') .'[]\']", "change" ,function(e){
				var element     = jQuery(this),
					container   = element.parents(".module-set"),
					title       = container.find(".category-option-title"),
					value       = element.find("option:selected").text();

				title.html( value );

			});

			jQuery("[name=\''. cloudfw_sanitize(PFIX.'_woocommerce_category_options indicator') .'[]\']").change();

		'
	),

);

return $schemes;