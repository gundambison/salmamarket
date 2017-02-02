<?php

$layout = 'mini'; 
$template_path = $templates_dir_path . "{$layout}/template.php";
$pagination = false;

if ( file_exists($template_path) )
	include( $template_path );
else
	return cloudfw_error_message( sprintf(__( 'Blog template %s cannot found.','cloudfw'), $layout) );

$carousel_atts = array();
$carousel_atts['auto_rotate'] = $auto_rotate;
$content_out = cloudfw_make_layout( 'carousel', $content_out, $carousel_atts );