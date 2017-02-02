<?php

add_action( 'cloudfw_primary_navigation', 'cloudfw_primary_navigation' );
function cloudfw_primary_navigation() {

	if ( ! has_nav_menu( 'primary' ) ) {
		return;
	}

	require( trailingslashit(dirname(__FILE__)) . 'class.primary-navigation.php' );
?>

	<?php if ( cloudfw_is_responsive() ): ?>
		<div id="header-navigation-toggle" class="<?php echo cloudfw_visible('phone') ?>">
			<a href="javascript:;"><?php echo cloudfw_translate('mobile_navigation'); ?> <i class="fontawesome-align-justify ui--caret"></i></a>
		</div>
	<?php endif; ?>

	<?php

	$cloudfw_primary_navigation_end_lvl = apply_filters( 'cloudfw_primary_navigation_end_lvl', '' );

	$out = wp_nav_menu( array( 
			'fallback_cb'           => '__return_false', 
			'theme_location'        => apply_filters( 'cloudfw_primary_navigation_location', 'primary'),
			'container'             => false,
			'menu_class'            => 'sf-menu clearfix unstyled-all', 
			'menu_id'               => 'header-navigation',
			'before'                => '',
			'after'                 => '',
			'link_before'           => '',
			'link_after'            => '',
			'caret'                 => '<i class="ui--caret fontawesome-angle-down px18"></i>',
			'sub_level_caret_right' => '<i class="ui--caret fontawesome-angle-right px18"></i>',
			'sub_level_caret_left'  => '<i class="ui--caret fontawesome-angle-left px18"></i>',
			'walker'                => new CloudFw_Walker_Primary_Menu(),
			'items_wrap'      		=> '<ul id="%1$s" class="%2$s">%3$s {{cloudfw_primary_navigation_end_lvl}}</ul>',
			'echo'					=> false,
		) 
	);

	$out = str_replace('{{cloudfw_primary_navigation_end_lvl}}', $cloudfw_primary_navigation_end_lvl, $out);

	echo $out;

}