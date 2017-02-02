<?php
	global $wpt_login;
	$level = $this->form_level;
?>

<div id="lost-password-form-container" class="ui--custom-login lost-password-form-container">

	<form method="post" class="lost-password-form form-horizontal ui-row">

		<div class="form-elements">

			<?php if( $level == 1 ) { ?>
				
				<?php if ( !empty ( $_POST['wpt_lost_password'] ) ) $this->show_messages(); ?>

				<div class="ui-row row">
					<p class="control-group">
						<label class="control-label ui--animation" for="email_or_username"><?php echo cloudfw_translate( 'custom_login.widget.form.username_or_email' ); ?>:</label>
						<span class="controls ui--animation"><input type="text" class="input-text" name="email_or_username" id="email_or_username" value="<?php echo isset($_REQUEST['email_or_username']) ? $_REQUEST['email_or_username'] : ''; ?>" /></span>
					</p>
					
					<?php do_action('lostpassword_form'); ?>
				</div>


				<input type="hidden" autocomplete="off" name="to_level" value="1" />


			<?php } elseif ( $level == 2 ) { ?>

				<?php if ( !empty ( $_POST['wpt_lost_password'] ) ) $this->show_messages(); ?>

				<div class="ui-row row">

					<p class="control-group">
						<label class="control-label ui--animation" for="password_1"><?php echo cloudfw_translate( 'custom_login.widget.form.password' ); ?> <span class="required">*</span></label>
						<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="password_1" id="password_1" /></span>
					</p>
					<p class="control-group">
						<label class="control-label ui--animation" for="password_2"><?php echo cloudfw_translate( 'custom_login.widget.form.re-password' ); ?> <span class="required">*</span></label>
						<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="password_2" id="password_2" /></span>
					</p>

					<?php do_action('lostpassword_form'); ?>
				</div>

				<input type="hidden" autocomplete="off" name="reset_key" value="<?php if (isset($_REQUEST['key'])) echo esc_attr($_REQUEST['key']); ?>" />
				<input type="hidden" autocomplete="off" name="reset_login" value="<?php if (isset($_REQUEST['login'])) echo esc_attr($_REQUEST['login']); ?>" />
				<input type="hidden" autocomplete="off" name="to_level" value="2" />

			<?php } elseif ( $level == 'message' ) { ?>
				
				<?php if ( !empty ( $_POST['wpt_lost_password'] ) ) $this->show_messages(); ?>

			<?php } ?>
	

		</div>

		<div class="custom-login-form-actions clearfix">
			<?php if ( $level !== 'message' ) { ?>
				<?php $this->nonce_field('reset_password', 'reset_password') ?>
				<p>
					<button type="submit" class="ui--animation btn <?php echo $form_type == 'block' ? 'btn-block ' : '' ; ?><?php echo cloudfw_make_button_style( cloudfw_get_option( 'custom_login_button_color',  'lost_pass', 'btn-primary' ), true ); ?>" name="wpt_lost_password" value="<?php echo esc_attr(cloudfw_translate( 'custom_login.widget.form.reset_password' )); ?>" ><?php echo cloudfw_translate( 'custom_login.widget.form.reset_password' ); ?></button>
				</p>

			<?php } ?>

			<p class="clearfix">
				<a class="ui--animation btn btn-block btn-secondary" href="<?php echo esc_url( wp_login_url() );?>"><?php echo cloudfw_translate( 'custom_login.widget.go_back_login.text' ); ?></a>				</span>
			</p>
		
		</div>

	</form>

</div>