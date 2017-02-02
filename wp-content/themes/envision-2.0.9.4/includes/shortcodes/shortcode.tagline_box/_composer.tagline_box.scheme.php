<?php

return array(
	array(
		'type'		=> 'module',
		'condition'	=> !$that->is_composer,
		'title'		=> __('Content','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'content',
				'value'		=>	$that->get_value('content'),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Visibility','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'the_device',
				'value'		=>	$that->get_value('the_device'),
	            'source'	=>	array(
	            	'type'		=>	'function',
	            	'function'	=>	'cloudfw_admin_get_visibility_options'
	            ),
				'width'		=>	250,
			), // #### element: 0

		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Layout','cloudfw'),
		'data'		=> array(

			array(
				'type'		=> 'module',
				'title'		=> __('Minimum Box Height','cloudfw'),
				'layout'	=> 'float',
				'data'		=> array(

					## Element
					array(
						'type'		=>	'text',
						'title'		=>	__('Widescreen','cloudfw'),
						'id'		=>	'box_height',
						'value'		=>	$that->get_value('box_height'),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw'),
						'desc'		=>	__('Leave blank for auto.','cloudfw'),

					), // #### element: 0

					## Element
					array(
						'type'		=>	'text',
						'title'		=>	__('Tablet','cloudfw'),
						'id'		=>	'box_tablet_height',
						'value'		=>	$that->get_value('box_tablet_height'),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw'),
						'desc'		=>	__('Leave blank for auto.','cloudfw'),

					), // #### element: 0

					## Element
					array(
						'type'		=>	'text',
						'title'		=>	__('Phone','cloudfw'),
						'id'		=>	'box_phone_height',
						'value'		=>	$that->get_value('box_phone_height'),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw'),
						'desc'		=>	__('Leave blank for auto.','cloudfw'),

					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Shadow','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	'shadow',
						'value'		=>	$that->get_value('shadow'),
						'source'	=>	array(
							'type'			=> 'function',
							'function'		=> 'cloudfw_admin_loop_shadows',
						),
						'width'		=>	250,

					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Border Radius','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'select',
						'id'		=>	'box_radius',
						'value'		=>	$that->get_value('box_radius', 'radius-3px'),
						'ui'		=>	true,
						'source'	=>	array(
							'NULL'			=> __('Default','cloudfw'),
							'radius-3px'	=> __('3px Radius','cloudfw'),
							'radius-6px'	=> __('6px Radius','cloudfw'),
							'radius-30px'	=> __('30px Radius','cloudfw'),
							'no-radius'		=> __('No Radius','cloudfw'),
						),
						'width'		=>	250

					), // #### element: 0

				)

			),


		)

	),

	array(
		'type'		=> 'mini-section',
		'title'		=> __('Style Options','cloudfw'),
		'data'		=> array(

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Overlay','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'background_overlay',
						'value'		=>	$that->get_value('background_overlay'),
						'source'    => array(
							'NULL'		=>	'Default',
							'yes'		=>	'Enable',
							'no'		=>	'Disable',
						),
						'width'		=>	250,

					),

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Background Color','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'gradient',
						'id'		=>	'box_gradient',
						'value'		=>	array( $that->get_value('box_gradient_0'), $that->get_value('box_gradient_1') ),
					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Background Overlay Opacity','cloudfw'),
				'data'		=> array(

					array(
						'type'      =>  'slider',
						'id'		=>	'opacity',
						'value'		=>	$that->get_value('opacity', 100),
						'default'   =>  100,
						'min'       =>  0,
						'max'       =>  100,
						'step'      =>  5,
						'unit'      =>  '%',
						'width'		=>	400,
					)

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Image','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'		=>	'upload',
						'id'		=>	'background_image',
						'value'		=>	$that->get_value('background_image'),
						'removable'	=>	true,
						'hide_input'=>	false,
						'library'	=>	true,
						'store'		=>	true,

					), // #### element: 0

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Style','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'background_style',
						'value'		=>	$that->get_value('background_style'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_array_bg_styles',
						),
						'width'		=>	250,

					),

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Position','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'background_position',
						'value'		=>	$that->get_value('background_position'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_loop_background_positions',
						),
						'width'		=>	250,

					),

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Attachment','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'background_attachment',
						'value'		=>	$that->get_value('background_attachment'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_loop_background_attachments',
						),
						'width'		=>	250,

					),

				)

			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'border',
				'this'		=>	$that,
				'vars'		=>	array( )
			),

			array(
				'type'		=> 'module',
				'title'		=> __('Text Color','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_color',
						'value'		=>	$that->get_value('box_color'),
					), // #### element: 0

				)

			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'text_shadow',
				'this'		=>	$that,
				'vars'		=>	array( )
			),

			array(
				'type'		=> 'module',
				'layout'	=> 'split',
				'title'		=> array(__('Link Color','cloudfw'), __('Link Hover Color','cloudfw')),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_link_color',
						'value'		=>	$that->get_value('box_link_color'),
					), // #### element: 0

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_link_hover_color',
						'value'		=>	$that->get_value('box_link_hover_color'),
					), // #### element: 0

				)

			),

		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Style Options on Hover','cloudfw'),
		'data'		=> array(

			array(
				'type'		=> 'module',
				'title'		=> __('Background Color on Hover','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'gradient',
						'id'		=>	'hover_box_gradient',
						'value'		=>	array( $that->get_value('hover_box_gradient_0'), $that->get_value('hover_box_gradient_1') ),
					), // #### element: 0

				)

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Background Overlay Opacity on Hover','cloudfw'),
				'data'		=> array(

					array(
						'type'      =>  'slider',
						'id'		=>	'hover_opacity',
						'value'		=>	$that->get_value('hover_opacity', 100),
						'default'   =>  100,
						'min'       =>  0,
						'max'       =>  100,
						'step'      =>  5,
						'unit'      =>  false,
						'width'		=>	400,
					)

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Image on Hover','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'		=>	'upload',
						'id'		=>	'hover_background_image',
						'value'		=>	$that->get_value('hover_background_image'),
						'removable'	=>	true,
						'hide_input'=>	false,
						'library'	=>	true,
						'store'		=>	true,

					), // #### element: 0

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Style on Hover','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'hover_background_style',
						'value'		=>	$that->get_value('hover_background_style'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_array_bg_styles',
						),
						'width'		=>	250,

					),

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Position on Hover','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'hover_background_position',
						'value'		=>	$that->get_value('hover_background_position'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_loop_background_positions',
						),
						'width'		=>	250,

					),

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Background Attachment on Hover','cloudfw'),
				'data'      =>  array(

					array(
						'type'      => 'select',
						'id'		=>	'hover_background_attachment',
						'value'		=>	$that->get_value('hover_background_attachment'),
						'source'    => array(
							'type'		=>	'function',
							'function'  =>	'cloudfw_admin_loop_background_attachments',
						),
						'width'		=>	250,

					),

				)

			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'border',
				'this'		=>	$that,
				'vars'		=>	array( 'hover_', array('style' => false, 'width' => false) )

			),

			array(
				'type'		=> 'module',
				'title'		=> __('Text Color on Hover','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'hover_box_color',
						'value'		=>	$that->get_value('hover_box_color'),
					), // #### element: 0

				)

			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'text_shadow',
				'this'		=>	$that,
				'vars'		=>	array( 'hover_' )
			),

			array(
				'type'		=> 'module',
				'layout'	=> 'split',
				'title'		=> array(__('Link Color','cloudfw'), __('Link Hover Color','cloudfw')),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'hover_box_link_color',
						'value'		=>	$that->get_value('hover_box_link_color'),
					), // #### element: 0

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'hover_box_link_hover_color',
						'value'		=>	$that->get_value('hover_box_link_hover_color'),
					), // #### element: 0

				)

			),

		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Link','cloudfw'),
		'data'		=> array(


			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'link',
				'this'		=>	$that
			),


		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Margins','cloudfw'),
		'data'		=> array(


			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'margins',
				'this'		=>	$that
			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'paddings',
				'this'		=>	$that
			),

		)

	),

	array(
		'type'		=> 'module',
		'layout'	=> 'split',
		'title'		=> array(__('Custom ID','cloudfw'), __('Custom Class','cloudfw')),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'custom_id',
				'value'		=>	$that->get_value('custom_id'),
				'width'		=>	150,
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'custom_class',
				'value'		=>	$that->get_value('custom_class'),
				'width'		=>	150,
			), // #### element: 0

		)

	),

);