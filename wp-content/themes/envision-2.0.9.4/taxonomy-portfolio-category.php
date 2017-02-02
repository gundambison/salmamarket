<?php
/**
 *	Portfolio Category Archives
 *
 *	@since 1.0
 */

$that = cloudfw(); 
$that->set('skip_is_blog', true);

add_filter( 'cloudfw_custom_content', 'cloudfw_portfolio_tax_contents' );
function cloudfw_portfolio_tax_contents(){
	global $wp_query;

	return do_shortcode(
		cloudfw_transfer_shortcode_attributes( 
			'portfolio', 
			array( 
				'from'           => 'wp_query',
				'layout'         => 'masonry',
				'pagination'     => true,
				//'columns'        => 4,
				'limit'          => 3,
				'shadow'         => 8
			)
		)
	);
}
	
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
$title = $term->name;
$text = cloudfw_inline_format( $term->description );

if ( $term->taxonomy == 'portfolio-category' ) {
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate('portfolio_category'), $title) );
} elseif ( $term->taxonomy == 'portfolio-filter' ) {
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate('portfolio_filter'), $title) );
}

$that->set_meta('titlebar_text', $text );


$that->return_layout( 'page.php' );