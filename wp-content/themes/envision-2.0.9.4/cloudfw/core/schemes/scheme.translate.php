<?php

$keys = isset($args[1]) ? $args[1] : array();
$scheme = array(); 
foreach ((array)$keys as $key => $desc) {

	if ( is_numeric( $key ) ) {
		$key = $desc;
		$desc = '';
	}

	$raw = esc_attr(cloudfw_raw_option('texts', $key));

	$scheme[] =	array(
		'type'		=>	'module',
		'title'		=>	$raw,
		'data'		=>	array(
			array(
				'type'		=>	'text',
				'id'		=>	cloudfw_sanitize(PFIX.'_texts ' . $key),
				'value'		=>	cloudfw_get_option( 'texts', $key ),
				'desc'		=>	$desc,
				'holder'	=>	$raw,
			)
		)

	);

}

return $scheme;