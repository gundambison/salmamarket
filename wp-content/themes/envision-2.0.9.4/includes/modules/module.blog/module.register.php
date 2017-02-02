<?php
/**
 *    Register the post type for breadcrumb trial
 */
add_filter('cloudfw_breadcrumbs_singular_post_before', 'cloudfw_breadcrumbs_singular_post_before');
add_filter('cloudfw_breadcrumbs_archive_category_before', 'cloudfw_breadcrumbs_singular_post_before');
function cloudfw_breadcrumbs_singular_post_before( $trial ) {
	
	$blog_page = cloudfw_get_option('blog', 'page');
	//$blog_page = cloudfw('blog_page_id');

	if ( !empty($blog_page) && is_numeric($blog_page) ) {
		if ( function_exists('icl_object_id') ) {
			$blog_page = icl_object_id($blog_page, 'page', false);
		}

		$page_data = get_page( $blog_page );
		if ( !empty($page_data->post_title) )
			$trial[] = array( 'link' => get_page_link( $blog_page ), 'title' => $page_data->post_title );
	}
	return $trial;
}