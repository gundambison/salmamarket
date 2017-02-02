<?php
	global $wpt_login;
	$level = $this->form_level;
?>

<div id="change-password-form-container" class="ui--custom-login change-password-form-container">


		<?php if ( $level == 1 ) { ?>

		<?php if ( !$inform ) { ?>
		<form method="post" class="change-password-form form-horizontal ui-row">
		<?php } ?>
				
				<div class="form-elements">

					<?php if ( !empty ( $_POST['wpt_change_password'] ) && !$inform ) $this->show_messages(); ?>

					<div class="ui-row row">

						<p class="control-group">
							<label class="control-label ui--animation" for="password_cur"><?php echo cloudfw_translate( 'custom_login.widget.form.current_password' ); ?> <span class="required">*</span></label>
							<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="password_cur" id="password_cur" /></span>
						</p>
						<p class="control-group">
							<label class="control-label ui--animation" for="password_1"><?php echo cloudfw_translate( 'custom_login.widget.form.new_password' ); ?> <span class="required">*</span></label>
							<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="password_1" id="password_1" /></span>
						</p>
						<p class="control-group">
							<label class="control-label ui--animation" for="password_2"><?php echo cloudfw_translate( 'custom_login.widget.form.renew_password' ); ?> <span class="required">*</span></label>
							<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="password_2" id="password_2" /></span>
						</p>

						<?php do_action('changepassword_form'); ?>
					</div>
					
					<input type="hidden" name="wpt_change_password" value="1" />

					<?php if ( !$inform ) { ?>
					<div class="custom-login-form-actions clearfix">
						<?php if ( $level !== 'message' ) { ?>
							<?php $this->nonce_field('change_password', 'change_password') ?>
							<p>
								<button type="submit" class="ui--animation btn <?php echo cloudfw_make_button_style( cloudfw_get_option( 'custom_login_button_color',  'change_pass', 'btn-primary' ), true ); ?>" name="wpt_change_password_submit" value="<?php echo esc_attr(cloudfw_translate( 'custom_login.widget.form.change_password' )); ?>" ><?php echo cloudfw_translate( 'custom_login.widget.form.change_password' ); ?></button>
							</p>

						<?php } ?>

					</div>
					<?php } ?>

				</div>
		<?php if ( !$inform ) { ?>
		</form>
		<?php } ?>

		<?php } elseif ( $level == 'message' && !$inform ) { ?>
			
			<?php if ( !empty ( $_POST['wpt_change_password'] ) ) $this->show_messages(); ?>

		<?php } ?>

</div>