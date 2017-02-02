<?php

/**
 *  CloudFw Menu - Callback for adding menu item.
 */
/*add_action('wp_ajax_cloudfw-add-menu', 'wpmega_add_menu_item_callback');
function wpmega_add_menu_item_callback(){
	if ( ! class_exists('CloudFw_Admin_Menu_Walker') || !current_user_can( 'edit_theme_options' ) )
		die('-1');

	check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

	$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );
	if ( is_wp_error( $item_ids ) )
		die('-1');

	foreach ( (array) $item_ids as $menu_item_id ) {
		$menu_obj = get_post( $menu_item_id );
		if ( ! empty( $menu_obj->ID ) ) {
			$menu_obj = wp_setup_nav_menu_item( $menu_obj );
			$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
			$menu_items[] = $menu_obj;
		}
	}

	if ( ! empty( $menu_items ) ) {
		$args = array(
			'after' => '',
			'before' => '',
			'link_after' => '',
			'link_before' => '',
			'walker' => new CloudFw_Admin_Menu_Walker,
		);
		echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
	}
	exit;
}*/

/**
 *  CloudFw Menu - Add the walker.
 */
function cloudfw_admin_init_menu_walker(){
	return 'CloudFw_Admin_Menu_Walker';
}

global $pagenow;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;
if ( is_theme_setting_page('menu') || ($action == 'add-menu-item' && ( defined( 'DOING_AJAX' ) && DOING_AJAX )) ) {

	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
	class CloudFw_Admin_Menu_Walker extends Walker_Nav_Menu_Edit  {

		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
			$current_location = cloudfw_get_editing_menu_location();

			/** Get the menu option map */
			$map = cloudfw_get_schemes('menu_map', false, $item->ID, $current_location);
			if ( $map ) {
				parent::start_el($output_current, $item, $depth, $args, $id);

				/** Variables */
				$handler  = '<div class="menu-item-actions description-wide submitbox">';

				$options  = '<div class="clear cf"></div>';
				$options .= '<div class="cloudfw-ui-options cloudfw-ui-menu-options">';
					$options .= '<div class="cloudfw-ui-menu-options-handler">';
						$options .= '<a data-id="'. $item->ID .'" data-location="'. $current_location .'" class="small-button small-grey cloudfw-ui-menu-options-handler-link" href="javascript:;"><span>'. __('Show Menu Options','cloudfw') .'</span></a>';
					$options .= '</div>';
				$options .= '<div class="clear cf"></div>';
				$options .= '<div class="cloudfw-ui-menu-options-content">';
				/* ob_start();
					require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
					echo cloudfw_render_page( $map );
				$render   = ob_get_clean();

				$options .= $render;*/
				$options .= '</div>';
				$options .= '</div>';

				$output .= str_replace($handler, $options . $handler, $output_current);
				unset($options);
				unset($output_current);

			} else
				parent::start_el($output, $item, $depth, $args, $id);

		}

	}

}

/**
 *    Register Ajax Function :: Get Menu Options
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_load_menu_options', 'cloudfw_ajax_load_menu_options' );
function cloudfw_ajax_load_menu_options() {

	$id = isset($_POST['id']) ? $_POST['id'] : NULL;
	$location = isset($_POST['location']) ? $_POST['location'] : NULL;

	if ( empty( $id ) || !is_numeric($id) )
		return;

	$map = cloudfw_get_schemes('menu_map', false, $id, $location);
	ob_start();
		require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
		echo cloudfw_render_page( $map );
	$render   = ob_get_clean();

	echo $render;
	exit;

}


/** Add the menu callbacks. */
add_action( 'init', 'cloudfw_admin_init_menus');
function cloudfw_admin_init_menus(){
	add_filter( 'wp_edit_nav_menu_walker', 'cloudfw_admin_init_menu_walker' , 500);
	add_action( 'wp_update_nav_menu_item', 'cloudfw_admin_update_menu', 10, 3);
}

/**
 *  Catch the menu items on update.
 */
function cloudfw_admin_update_menu($menu_id, $menu_item_db_id, $args ){
	$current_location = cloudfw_get_editing_menu_location();
	$options = cloudfw_detect_options( array('data' => cloudfw_get_schemes('menu_map', false, NULL, $current_location)) );

	if ( is_array($options) && !empty($options) ) {
		/* Loop the menu options. */
		foreach ((array) $options as $field) {
			$name = $field['id'] . '_' . $menu_item_db_id;

			$old = get_post_meta( $menu_item_db_id, $field['id'], true );
			$new = isset($_POST[ $name ]) ? $_POST[ $name ] : NULL;

				$is_defined = isset($_POST[ 'is_defined_'. $name ]) ? $_POST[ 'is_defined_'. $name ] : NULL;
				if ( $is_defined == 'onoff' && empty( $new ) ) {
					$new = 'FALSE';
					$_POST[ $name ] = $new;
				}

				if ( !is_array( $new ) )
					$new = stripslashes( $new );

			if ( array_key_exists($name, $_POST) && !is_null($new) && $new != $old )
				update_post_meta( $menu_item_db_id, $field['id'], $new );
			elseif (  array_key_exists($field['id'], $_POST) && !is_null( $new ) && empty( $new ) && isset( $old ) )
				delete_post_meta( $menu_item_db_id, $field['id'], $old );

		}
	}
}

/**
 *  Gets editing menu location.
 */
function cloudfw_get_editing_menu_location( $nav_menu_id = NULL ) {
	if ( !$nav_menu_id )
		$nav_menu_id = isset( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0;

	if ( !$nav_menu_id )
		$nav_menu_id = (int) get_user_option( 'nav_menu_recently_edited' );

	if ( !$nav_menu_id )
		return false;

	if ( cloudfw_vc_isset( __FUNCTION__, $nav_menu_id ) )
		return cloudfw_vc_get( __FUNCTION__, $nav_menu_id );

	$locations = (array) get_nav_menu_locations();
	$locations = apply_filters('cloudfw_menu_locations', $locations);
	$current_location = array_search($nav_menu_id, $locations);

	return cloudfw_vc_set( __FUNCTION__, $nav_menu_id, $current_location );
}

add_action( 'admin_notices',  'cloudfw_check_post_limits_menu' );
function cloudfw_check_post_limits_menu(){

	$screen = get_current_screen();
	if( $screen->id != 'nav-menus' ) return;

	if( isset( $_POST['save_menu'] ) ){
		$current_post_vars_count = cloudfw_count_post_vars(); 
		update_option( 'cloudfw_post_var_count_menu' , $current_post_vars_count );
	}
	else{
		$current_post_vars_count = get_option( 'cloudfw_post_var_count_menu' , 0 );
	}
	

	$restrictors = cloudfw_post_vars_restrictors();
	$message = cloudfw_need_increase_max_input_vars( $current_post_vars_count, array(
		'warning_message'         => __( "You are approaching the post variable limit imposed by your server configuration. Exceeding this limit may automatically delete menu items when you save. Please increase your <strong>%s</strong> directive in php.ini. %s" , 'cloudfw' ),
		'warning_message.suhosin' => __( "Your server is running Suhosin, and your current maxvars settings may limit the number of menu items you can save." , 'cloudfw' ),
	));

	if( !empty( $message ) ): 

	?>
	<div class="cloudfw-update-messages error">
		<div style="padding: 15px;">
			<div><strong><?php _e( 'Menu Item Limit Warning' , 'cloudfw' ); ?></strong></div>
				<ul>
				<?php foreach( $message as $m ): ?>
					<li><?php echo $m; ?></li>
				<?php endforeach; ?>
				</ul>

				<?php
				if( $restrictors['max_input_vars'] != '' ) echo "<strong style='text-decoration: underline;'>max_input_vars</strong>: ". $restrictors['max_input_vars']. " <br/>";
				if( $restrictors['suhosin_post_maxvars'] != '' ) echo "<strong style='text-decoration: underline;'>suhosin.post.max_vars</strong>: ".$restrictors['suhosin_post_maxvars']. " <br/>";
				if( $restrictors['suhosin_request_maxvars'] != '' ) echo "<strong style='text-decoration: underline;'>suhosin.request.max_vars</strong>: ". $restrictors['suhosin_request_maxvars'] ." <br/>";
				
				echo "<strong style='text-decoration: underline;'>".__( 'Menu Item Post variable Count on Last Save' )."</strong>: ". $current_post_vars_count."<br/>";

				?>
		</div>
	</div>
	<?php endif;

}