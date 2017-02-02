<?php
/**
 *	Index Page
 *
 * 	This page is reserved for blog posts.
 *	@since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

cloudfw( 'check' );
cloudfw( 'check', 'is_blog' );
get_header(); ?>

	<?php cloudfw( 'page' ); ?>

<?php get_footer(); ?>