<?php
/**
 *	Author Page
 *
 *	@since 1.0
 */
$that = cloudfw();
$layout = $that->page_settings(
	'blog_archive_page',
	array(
		'layout' 		 => 'page_layout',
		'sidebar' 		 => 'page_sidebar',
		'titlebar_style' => 'page_titlebar_style',
		'skin' 			 => 'page_skin',
	),
	'layout'
);
$that->set('blog_options', $that->blog_settings( 'blog_archive_page' ));

$title = $that->get_meta('titlebar_title');
if ( empty($title) ) {
	$that->set_meta('titlebar_title', get_the_author_meta( 'display_name' ) );
	$that->set_meta('titlebar', true);
}

$that->set_meta('titlebar_text', get_the_author_meta( 'description' ) );

if ( empty($layout) ) {
	$layout = $that->blog_page_layout();
}

$that->return_layout( $layout );