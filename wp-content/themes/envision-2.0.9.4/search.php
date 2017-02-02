<?php
/**
 *	Search Page
 *
 *	@since 1.0
 */
$that = cloudfw();
$layout = $that->page_settings(
	'blog_search_page', 
	array(
		'layout' 		 => 'page_layout',
		'sidebar' 		 => 'page_sidebar',
		'titlebar_style' => 'page_titlebar_style',
		'skin' 			 => 'page_skin',
	), 
	'layout'
);
$that->set('blog_options', $that->blog_settings( 'blog_search_page' ));

$title = $that->get_meta('titlebar_title');
if ( empty($title) ) {			
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate('search_titles'), get_search_query()) );
}

global $wp_query;
if( have_posts()) {
	$that->set_meta('titlebar_text', '<p>'. sprintf( cloudfw_translate( 'search_result_count' ), get_search_query(), $wp_query->found_posts) .'</p>' );
}

if ( empty($layout) )
	$layout = $that->blog_page_layout();

$that->return_layout( $layout );