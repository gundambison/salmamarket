<?php 

	$logout_url = wp_logout_url();

	global $current_user;
	get_currentuserinfo();

?>

<div id="mini-user-container" class="ui--custom-login mini-user-container clearfix">

	<?php echo get_avatar( $current_user->ID, 40 ); ?> 
	<div class="mini-user-content">
		<div class="mini-user-username"><?php echo sprintf( cloudfw_translate( 'custom_login.widget.logged_in.text' ) , $current_user->display_name); ?></div>
		<div class="mini-user-logout" class="ui--animation">
			<a class="btn btn-small btn-secondary" href="<?php echo esc_url( wp_logout_url() );?>"><?php echo cloudfw_translate( 'custom_login.widget.logout.text' ); ?></a>
		</div>

	</div>

</div>