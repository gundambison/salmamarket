<?php

/**
 *	Border Radius Kit
 */
function cloudfw_predefined_kit_border_radius_kit( $args = array() ){
	extract(cloudfw_make_var(array(
		'title'   => '',
		'id'      => '',
		'value'   => array(),
		'options' => array(),
	), _check_onoff_false($args)));

	if ( !isset($defaults) || empty($defaults) ) {
		$defaults = array(
			'border-top-left-radius' => array( 'id' => cloudfw_sanitize( $id, 'border-top-left-radius' ), 'value' => isset($value['border-top-left-radius']) ? $value['border-top-left-radius'] : NULL ),
			'border-bottom-left-radius' => array( 'id' => cloudfw_sanitize( $id, 'border-bottom-left-radius' ), 'value' => isset($value['border-bottom-left-radius']) ? $value['border-bottom-left-radius'] : NULL ),
			'border-top-right-radius' => array( 'id' => cloudfw_sanitize( $id, 'border-top-right-radius' ), 'value' => isset($value['border-top-right-radius']) ? $value['border-top-right-radius'] : NULL ),
			'border-bottom-right-radius' => array( 'id' => cloudfw_sanitize( $id, 'border-bottom-right-radius' ), 'value' => isset($value['border-bottom-right-radius']) ? $value['border-bottom-right-radius'] : NULL ),
		);
	}

	$options = cloudfw_make_var( $defaults, $options);
	$out = array();

	if ( $options['border-top-left-radius'] !== false ) {
		$out[] = array(
			'type'		=>	'text',
			'title'		=>	__('Top Left','cloudfw'),
			'id'		=>	$options['border-top-left-radius']['id'],
			'value'		=>	$options['border-top-left-radius']['value'],
			'width'		=>	'70',
			'unit'		=>	'px',
		);
	}

	if ( $options['border-bottom-left-radius'] !== false ) {
		$out[] = array(
			'type'		=>	'text',
			'title'		=>	__('Bottom Left','cloudfw'),
			'id'		=>	$options['border-bottom-left-radius']['id'],
			'value'		=>	$options['border-bottom-left-radius']['value'],
			'width'		=>	'70',
			'unit'		=>	'px',
		);
	}

	if ( $options['border-top-right-radius'] !== false ) {
		$out[] = array(
			'type'		=>	'text',
			'title'		=>	__('Top Right','cloudfw'),
			'id'		=>	$options['border-top-right-radius']['id'],
			'value'		=>	$options['border-top-right-radius']['value'],
			'width'		=>	'70',
			'unit'		=>	'px',
		);
	}

	if ( $options['border-bottom-right-radius'] !== false ) {
		$out[] = array(
			'type'		=>	'text',
			'title'		=>	__('Bottom Right','cloudfw'),
			'id'		=>	$options['border-bottom-right-radius']['id'],
			'value'		=>	$options['border-bottom-right-radius']['value'],
			'width'		=>	'70',
			'unit'		=>	'px',
		);
	}

	if ( ! empty( $out ) ) {

		$args = cloudfw_merge_option_args( $args );

		if ( !empty( $args['type'] ) ) {
			$args['data'] = $out;
			if ( !isset( $args['auto_column'] ) ) $args['auto_column'] = false;
			if ( !isset( $args['layout'] ) ) $args['layout'] = 'float';
			$out = array( 'data' => $args );
		}

		cloudfw_render_page( $out );

	}

}