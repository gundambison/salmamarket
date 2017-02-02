<?php

/**
 *	
 */
function cloudfw_post_vars_restrictors() {
	$restrictors = array();
	$restrictors['suhosin_post_maxvars'] = @ini_get( 'suhosin.post.max_vars' );
	$restrictors['suhosin_request_maxvars'] = @ini_get( 'suhosin.request.max_vars' );
	$restrictors['max_input_vars'] = @ini_get( 'max_input_vars' );

	return apply_filters( 'cloudfw_post_vars_restrictors', $restrictors );
}

/**
 * 
 */
function cloudfw_need_increase_max_input_vars( $count = 0, $options = array() ){
	$options = cloudfw_make_var(array(
		'warning_message'         => __( "You are approaching the post variable limit imposed by your server configuration. Exceeding this limit may automatically delete the datas on the page when you save. Please increase your <strong>%s</strong> directive in php.ini. %s" , 'cloudfw' ),
		'warning_message.suhosin' => __( "Your server is running Suhosin, and your current maxvars settings may limit the number of the datas you can save." , 'cloudfw' ),
	), $options);

	$count = (int) $count;

	$restrictors = cloudfw_post_vars_restrictors();
	$message = array();

	if( $restrictors['suhosin_post_maxvars'] != '' ||
		$restrictors['suhosin_request_maxvars'] != '' ||
		$restrictors['max_input_vars'] != '' ){

		if( ( $restrictors['suhosin_post_maxvars'] != '' && $restrictors['suhosin_post_maxvars'] < 1000 ) || 
			( $restrictors['suhosin_request_maxvars']!= '' && $restrictors['suhosin_request_maxvars'] < 1000 ) ){
			$message[] = $options['warning_message.suhosin'];
		}

		foreach( $restrictors as $key => $val ){
			if( $val > 0 ){
				if( $val - $count < 150 ){
					$message[] = sprintf($options['warning_message'], $key, '<a target="_blank" href=\''. cloudfw_admin_url('global') .'#troubleshooting\'>'. __('More information','cloudfw') .'</a>');
				}
			}
		}
	}

	return array_filter( $message );
}

/**
 *	
 */
function cloudfw_count_post_vars() {
	return count($_POST, COUNT_RECURSIVE);
}