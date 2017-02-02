<?php
/**
 *	Schema.org HTML Tag
 */
if ( ! function_exists('cloudfw_html_tag_schema') ) {
	function cloudfw_html_tag_schema(){
		if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) ) {
			$out = cloudfw_vc_get( __FUNCTION__, 'cache' );
		} else {

		    $schema = apply_filters('cloudfw_html_tag_schema_url', 'http://schema.org/' );
		    $type = apply_filters('cloudfw_html_tag_schema_type', '' );

		    if ( empty( $type ) ) {

				if(is_single()) {
				    $type = "Article";
				}
				/*else if( is_page(1) ) {
				    $type = 'ContactPage';
				}*/
				elseif( is_author() ) {
				    $type = 'ProfilePage';
				}
				elseif( is_search() ) {
				    $type = 'SearchResultsPage';
				}
				else {
				    $type = 'WebPage';
				}

		    }
		    $out = 'itemscope="itemscope" itemtype="' . $schema . $type . '" ';
			cloudfw_vc_set( __FUNCTION__, 'type', $type );
			cloudfw_vc_set( __FUNCTION__, 'cache', $out );
		}

		echo $out;
	}
}