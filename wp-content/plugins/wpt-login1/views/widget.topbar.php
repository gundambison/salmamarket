<?php 

if ( ! is_user_logged_in() ) {
	add_action('cloudfw_side_panel', 'cloudfw_side_widget_login_default');
}
if ( ! function_exists('cloudfw_side_widget_login_default') ) {
function cloudfw_side_widget_login_default(){
?>
	<div id="ui--side-login-default-widget">
		<h3><strong><?php echo cloudfw_translate( 'custom_login.widget.login.text' ); ?></strong></h3>
		
		<?php echo do_shortcode( '[wpt_login location="sidepanel" form_type="block"]' ); ?>

	</div>
<?php
}

?>

<ul id="widget--login-default" class="ui--widget ui--custom-menu opt--on-hover unstyled-all <?php echo cloudfw_visible( $device ); ?>">
	<?php if ( ! is_user_logged_in() ) { ?>

		<?php $on_click = cloudfw_get_option( 'custom_login',  'onclick_action' ); ?>
		<li>
		<?php if( $on_click == 'to_login' ): ?>
			<a href="<?php echo wp_login_url(); ?>" class="ui--gradient ui--gradient-grey on--hover hover">
		<?php else: ?>
			<a href="<?php echo wp_login_url(); ?>" class="ui--side-panel ui--gradient ui--gradient-grey on--hover hover" data-target="ui--side-login-default-widget">
		<?php endif; ?>
				<?php echo cloudfw_translate( 'custom_login.widget.login.text' ); ?>
			</a>
		</li>


	<?php } else { 
	 
		$logout_url = wp_logout_url();

		global $current_user;
		get_currentuserinfo();

		$custom_menu_id = cloudfw_get_option( 'custom_login',  'logged_in_menu_id' ); 
		$show_sub_level = cloudfw_check_onoff( 'custom_login',  'show_sub_level' );
		$show_avatar = cloudfw_check_onoff( 'custom_login',  'show_avatar' );
		
		$top_level_custom_link = cloudfw_get_option( 'custom_login',  'top_level_custom_link' );

		if( !empty( $top_level_custom_link ) ) {
			$top_level_custom_link = $this->prepare_custom_redirect_url( $top_level_custom_link );
			$top_level_link = esc_url(__url( $top_level_custom_link ));
		} else {
			$top_level_link = get_edit_user_link( $current_user->ID );
		}


	?>
		<li>
			<a href="<?php echo $top_level_link; ?>" class="ui--gradient ui--gradient-grey on--hover hover">
				<?php 
					if( $show_avatar ) {
						echo get_avatar( $current_user->ID, 20 );
					}
				?> 
				<?php echo sprintf( cloudfw_translate( 'custom_login.widget.logged_in.text' ) , $current_user->display_name); ?>
				<?php if ( $show_sub_level ): ?>
					<i class="fontawesome-angle-down px14"></i>
				<?php endif; ?>
			</a>
			
			<?php if ( $show_sub_level ): ?>
				<?php if ( ! $custom_menu_id ): ?>

				<ul class="sub-menu">
					<?php if ( 1 == 0 && ( $page_id = cloudfw_get_option( 'custom_login_pages',  'profile' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
						<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
					<?php } ?>

					<?php if ( ( $page_id = cloudfw_get_option( 'custom_login_pages',  'change-password' ) ) && ( $title = get_the_title( $page_id ) ) ) { ?>
						<li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo $title; ?></a></li>
					<?php } ?>
					
					<li><a href="<?php echo $logout_url; ?>"><?php echo cloudfw_translate('custom_login.widget.logout.text'); ?></a></li>
				</ul>

				<?php else: ?>
				<?php 


					if ( !class_exists('CloudFw_Walker_Login_Menu_Default') ) {
						/**
						 *  CloudFw Custom Navigation Menu Walker
						 *
						 *  @since 1.0
						**/
						class CloudFw_Walker_Login_Menu_Default extends Walker_Nav_Menu {

							function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
								$element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

								return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
							}

							function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
							   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
							   $class_names = $value = '';
								
							   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
							   $classes[] = 'depth-'.$depth;

							   if ( $depth === 0 )
									$classes[] = 'ui--gradient ui--gradient-grey on--hover';       
															  
								$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
								$class_names = ' class="'. esc_attr( $class_names ) . '"';


								$output .= $indent . '<li ';
								$output .= $item->ID ? 'id="menu-item-' . $item->ID .'"' : ''; 
								$output .= $value . $class_names .'>';
								$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
								$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
								$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
								$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

								$item_output = $args->before;
								
								$item_output .= $args->link_before;            
								$item_output .= '<a'. $attributes .'>';
								$item_output .= apply_filters( 'the_title', $item->title, $item->ID );

								$item_output .= '</a>';
								$item_output .= $args->link_after;
								
								$item_output .= $args->after;
								
								$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
							}

						}


						wp_nav_menu( array( 
								'fallback_cb'     => '__return_false', 
								'menu'            => $custom_menu_id,
								'container'       => false,
								'menu_class'      => 'sub-menu', 
								'menu_id'         => 'custom-login-menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'depth'           => 2,
								'walker'          => new CloudFw_Walker_Login_Menu_Default(),
							) 
						);

					}

				?>

				<?php endif; ?>
			<?php endif; ?>
		</li>
	<?php } ?>
</ul>

<?php } ?>