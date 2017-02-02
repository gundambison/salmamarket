<?php

/**
 *  CloudFw Composer - Data Key
 */
function cloudfW_composer_data_key(){
  if( cloudfw_ml_plugin() == 'qtranslate' ) {
	return PFIX . '_composer' . '_' . cloudfw_get_current_language();
  }

  return PFIX . '_composer';
}

/**
 *	CloudFw Composer - Get Composer Data
 *
 *	@since 3.0
 */
function cloudfw_composer_get_data( $post_id = NULL ) {
	if ( !$post_id ) {
		$post_id = get_queried_object_id();
	}

	$data = get_post_meta( $post_id, cloudfw_composer_data_key(), true );

	if ( ! empty( $data ) ) {
		if ( is_array( $data ) ) {
			return $data;
		} else {

			try {

				//$data = stripcslashes($data);
				//return (array) @json_decode( $data, true );

				if ( is_serialized( $data ) ) {
					return cloudfw_unserialize( $data );
				}

			} catch (Exception $e) {}

		}
	}

	return array();
}

/**
 *	Check composer is activated
 *
 *	@since 3.0
 */
function cloudfw_composer_is_activated( $post_id = NULL ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}

	return get_post_meta( $post_id, PFIX . '_composer_activate', true );
}

/**
 *	CloudFw Composer - Get Column Shortcode
 *
 *	@since 3.0
 */
function cloudfw_composer_get_column_code( $column_text, $last = false ){
	if ( empty( $column_text ) ) {
		return '';
	}

	$column = explode( '/' , $column_text );
	$out = $column[0] . 'of' . $column[1];

	if ($last) {
		$out .='_last';
	}

	return $out;
}

/**
 *	CloudFw Composer - Filter Data
 *
 *	@since 3.0
 */
function cloudfw_composer_filter_data( $data ){
	unset($data['_composer-title']);
	unset($data['_composer-type']);
	unset($data['_composer-column']);
	unset($data['_composer-last']);
	unset($data['_composer_data']);
	return $data;
}


/**
 *	CloudFw Composer - Convert Data
 *
 *	@since 3.0
 */
function cloudfw_composer_convert_data( $item_data, $shortcode_data ){
	global $cloudfw_debug_not_defineds;

	foreach ((array)$shortcode_data['attributes'] as $attribute => $options) {
		$element = isset($options['e']) ? $options['e'] : NULL;
		$value   = isset($item_data[$element]) ? $item_data[$element] : NULL;

		unset( $item_data[$element] );
		if ( !empty( $value ) || $value === '0' ) {
			$item_data[$attribute] = $value;
		}

	}

	foreach ($item_data as $item_attribute => $value) {
		if ( empty( $shortcode_data['attributes'][$item_attribute] ) ) {
			$cloudfw_debug_not_defineds[] = $item_attribute;
		}

	}
	return $item_data;
}


/**
 * Generates composer content
 *
 * @param  array $data
 * @param  integer $level
 *
 * @return string
 */
function cloudfw_composer_make_content( $data = array(), $level = 0, $key = '' ){
	if ( !is_array($data) ) {
		return '';
	}

	$out = '';
	$level++;

	foreach ($data as $item_id => $item_data) {
		$code = $sub_out = NULL;
		$shortcode_options = array();

		$type 	= isset($item_data['_composer-type']) ? $item_data['_composer-type'] : NULL;
		$column = isset($item_data['_composer-column']) ? $item_data['_composer-column'] : NULL;
		$last 	= isset($item_data['_composer-last']) ? $item_data['_composer-last'] : NULL;

		if ( !empty($column) && $column != '1/1' ) {
			$column_code = cloudfw_composer_get_column_code($column, $last);
		} else {
			$column_code = false;
		}

		if ( class_exists( $type ) ) {
			$obj =  new $type;
			$shortcode_options = $obj->scheme();
			$converted_item_data = cloudfw_composer_convert_data(
				cloudfw_composer_filter_data($item_data),
				isset($shortcode_options['script']) ? $shortcode_options['script'] : NULL
			);

			if ( !empty($shortcode_options['script']['shortcode:sync']) ) {
				$code = $item_data[$shortcode_options['script']['shortcode:sync']];
			} elseif ( !empty($shortcode_options['script']['shortcode']) ){
				$code = $shortcode_options['script']['shortcode'];
			}

			if ( !empty($item_data['_composer_data']) ) {
				$sub_out = cloudfw_composer_make_content( $item_data['_composer_data'], $level );
			} else {
				if( isset($converted_item_data['content']) ) {
					$sub_out = $converted_item_data['content'];
				}
			}

			if( method_exists($obj, 'shortcode') ) {
				if ( empty( $key ) ) {
					$key = 'composer_' . $level;
				}

				$out .= cloudfw_UI_column( array('_key' => $key, 'do_shortcode' => false), $obj->shortcode( $converted_item_data, $sub_out, $code ), $column_code );
			}

		}

	}

	return $out;

}

/**
 *	Improved Search Queries
 *	
 * 	@param  array $pieces
 *
 * 	@return array
 *	@since 2.0.9
 */
function cloudfw_improved_search( $pieces ) {
	if ( ! is_search() || ! is_main_query() || ! apply_filters( 'cloudfw_composer_search_enable', true ) || ! cloudfw_check_onoff( 'global', 'cc_search' )) {
		return $pieces;
	}

	global $wpdb;

	$keywords = explode(' ', get_query_var('s'));
	$query = "";
	foreach ($keywords as $word) {

		if (is_numeric($word) || strlen($word) <= 2)
			continue;

		$query .= "((composer.meta_key = 'env_composer')";
		$query .= " AND (composer.meta_value  LIKE '%{$word}%')) OR ";
	}

	if (!empty($query)) {
		$pieces['where'] = str_replace("((({$wpdb->posts}.post_title LIKE '%", "( {$query} (({$wpdb->posts}.post_title LIKE '%", $pieces['where']);
		$pieces['join'] = $pieces['join'] . " LEFT JOIN {$wpdb->postmeta} AS composer ON ({$wpdb->posts}.ID = composer.post_id AND (composer.meta_key = 'env_composer') )";
	}

	return $pieces;
}


if ( !is_admin() ) {
	add_filter('posts_clauses', 'cloudfw_improved_search', 20, 1);
}
