<?php global $wpt_login; ?>

<div id="register-form-container" class="ui--custom-login login-form-container">

	<?php if ( $wpt_login->form_level != 'message' ): ?>

	<form method="post" class="register-form form-horizontal ui-row">

		<?php if ( !empty ( $_POST['wpt_register'] ) ) $this->show_messages(); ?>

		<div class="form-elements">

		
			<div class="ui-row row">

				<p class="control-group">
					<label class="control-label ui--animation" for="user_login"><?php echo cloudfw_translate( 'custom_login.widget.form.username' ); ?> <span class="required">*</span></label>
					<span class="controls ui--animation"><input type="text" autocomplete="off" class="input-text" id="user_login" name="user_login" value="<?php if (isset($_POST['user_login'])) echo esc_attr($_POST['user_login']); ?>" /></span>
				</p>

				<p class="control-group">
					<label class="control-label ui--animation" for="user_email"><?php echo cloudfw_translate( 'custom_login.widget.form.email' ); ?> <span class="required">*</span></label>
					<span class="controls ui--animation"><input type="email" autocomplete="off" class="input-text" name="user_email" id="user_email" value="<?php if (isset($_POST['user_email'])) echo esc_attr($_POST['user_email']); ?>" /></span>
				</p>

				<?php if ( cloudfw_get_option( 'custom_register',  'user_passwords' ) == 'via_user' ) { ?>
			
				<p class="control-group">
					<label class="control-label ui--animation" for="user_password"><?php echo cloudfw_translate( 'custom_login.widget.form.password' ); ?> <span class="required">*</span></label>
					<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="user_password" id="user_password" value="" /></span>
				</p>
				<p class="control-group">
					<label class="control-label ui--animation" for="user_password2"><?php echo cloudfw_translate( 'custom_login.widget.form.re-password' ); ?> <span class="required">*</span></label>
					<span class="controls ui--animation"><input type="password" autocomplete="off" class="input-text" name="user_password2" id="user_password2" value="" /></span>
				</p>

				<?php } else { ?>
				<p class="control-group">
					<span class="controls ui--animation"><?php echo cloudfw_translate( 'custom_login.widget.messages.password_will_be_emailed' ); ?></span>
				</p>					
				<?php } ?>

				<?php do_action( 'register_form' ); ?>

			</div>

			<input type="hidden" autocomplete="off" name="to_level" value="2" />

			<!-- Spam Trap -->
			<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" autocomplete="off" name="email_2" id="trap" tabindex="-1" /></div>

		</div>

		<div class="custom-login-form-actions clearfix">
			<?php $this->nonce_field('register', 'register') ?>
			<p>
				<button type="submit" class="ui--animation btn btn-block <?php echo cloudfw_make_button_style( cloudfw_get_option( 'custom_login_button_color',  'register', 'btn-primary' ), true ); ?>" name="wpt_register" value="<?php echo esc_attr(cloudfw_translate( 'custom_login.widget.form.register' )); ?>" ><?php echo cloudfw_translate( 'custom_login.widget.form.register' ); ?></button>
			</p>

			<p class="clearfix">
				<a class="ui--animation btn btn-block btn-secondary" href="<?php echo esc_url( wp_login_url() );?>"><?php echo cloudfw_translate( 'custom_login.widget.go_back_login.text' ); ?></a>				</span>
			</p>
		</div>



	</form>

	<?php else: ?>

		<?php if ( !empty ( $_POST['wpt_register'] ) ) $this->show_messages(); ?>

		<p class="clearfix">
			<a class="ui--animation btn btn-block btn-secondary" href="<?php echo esc_url( wp_login_url() );?>"><?php echo cloudfw_translate( 'custom_login.widget.go_back_login.text' ); ?></a>				</span>
		</p>

	<?php endif; ?>

</div>