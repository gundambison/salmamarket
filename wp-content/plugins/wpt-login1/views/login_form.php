<div id="login-form-container" class="ui--custom-login login-form-container">

	<form method="post" class="login-form form-horizontal ui-row">

		<?php if ( !empty ( $_POST['wpt_login'] ) ) $this->show_messages(); ?>

		<div class="form-elements">
			<div class="ui-row row">

				<p class="control-group">
					<label class="control-label ui--animation" for="user_login"><?php echo cloudfw_translate( 'custom_login.widget.form.username_or_email' ); ?></label>
					<span class="controls ui--animation"><input tabindex="100" type="text" class="input-text" name="log" id="user_login" value="<?php echo isset($_REQUEST['log']) ? $_REQUEST['log'] : ''; ?>" /></span>
				</p>
				<p class="control-group">

					<?php if ( cloudfw_check_onoff( 'custom_login', 'show_lostpass_link' ) ) { ?>
					<small class="pull-right ui--animation">
						<a class="lost_password" href="<?php echo wp_lostpassword_url(); ?>"><?php echo cloudfw_translate( 'custom_login.widget.lost_password.text' ); ?></a>
					</small>
					<?php } ?>

					<label class="control-label ui--animation" for="user_pass"><?php echo cloudfw_translate( 'custom_login.widget.form.password' ); ?></label>
					<span class="controls ui--animation"><input tabindex="101" class="input-text" type="password" name="pwd" id="user_pass" /></span>
				</p>

				<?php do_action( 'login_form' ); ?>

			</div>
		</div>


		<div class="custom-login-form-actions clearfix">
			<?php $this->nonce_field('login', 'login') ?>

			<?php ob_start(); ?>
				<label class="control-label checkbox inline ui--animation" for="rememberme"><input tabindex="100" type="checkbox" name="rememberme" id="rememberme" value="forever" /> <?php echo cloudfw_translate( 'custom_login.widget.rememberme.text' ); ?></label>
			<?php $rememberme_label = ob_get_contents(); ob_end_clean();  ?>

			<?php ob_start(); ?>
				<button type="submit" class="ui--animation btn <?php echo $form_type == 'block' ? 'btn-block ' : ''; echo cloudfw_make_button_style( cloudfw_get_option( 'custom_login_button_color',  ( $location == 'sidepanel' ? 'login_side_panel' : 'login'), 'btn-primary' ), true ); ?>" tabindex="102" name="wpt_login" value="<?php echo esc_attr(cloudfw_translate( 'custom_login.widget.form.submit' )); ?>" ><?php echo cloudfw_translate( 'custom_login.widget.form.submit' ); ?></button>
			<?php $submit_button = ob_get_contents(); ob_end_clean();  ?>

			<?php ob_start(); ?>
				<span class="ui--animation">
					<a class="register_btn btn <?php echo $form_type == 'block' ? 'btn-block ' : '' ; ?> btn-secondary" href="<?php echo esc_url( wp_registration_url() );?>"><?php echo cloudfw_translate( 'custom_login.widget.register_new_user.text' ); ?></a>
				</span>
			<?php $register_button = ob_get_contents(); ob_end_clean();  ?>

			<?php if ( $form_type == 'block' ): ?>
				<p class="control-group"><?php echo $rememberme_label ?></p>
				<p class="control-group"><?php echo $submit_button ?></p>
				<?php if ( get_option( 'users_can_register' ) ): ?><p class="control-group"><?php echo $register_button ?></p><?php endif; ?>
			<?php else: ?>
				<p class="control-group pull-right"><?php echo $rememberme_label ?></p>
				<p class="control-group pull-left"><?php echo $submit_button ?></p>
				<div class="clearfix"></div>
				<?php if ( get_option( 'users_can_register' ) ): ?><p class="control-group "><?php echo $register_button ?></p><?php endif; ?>
			<?php endif; ?>

		</div>
	</form>
	<?php //do_action( 'login_footer' ); ?>

	<?php if ( ( isset($location) && $location == 'sidepanel' ) && ! empty( $_POST['wpt_login'] ) ) { ?>
		<script type="text/javascript">

			jQuery(window).load(function(){

				var login_form = jQuery('.login-form-container');
				if ( login_form.length == 1 ) {
					if( ! jQuery('html').hasClass('side-panel-open') ) {
						jQuery( ".ui--side-panel" ).filter( "[data-target='ui--side-login-default-widget']" ).first().click();
					}
				}

			});

		</script>
	<?php } ?>

</div>