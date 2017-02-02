<?php
	global $wpt_login;
	$level = $this->form_level;
?>

<div id="edit-profile-form-container" class="ui--custom-login edit-profile-form-container">


		<?php if ( $level == 1 ) { ?>

		<form method="post" class="edit-profile-form form-horizontal ui-row">
				
				<div class="form-elements">

					<?php if ( !empty ( $_POST['wpt_edit_profile'] ) ) $this->show_messages(); ?>

					<div class="ui-row row">
						<?php //do_action('personal_options_update'); ?>
						<?php do_action('show_user_profile', wp_get_current_user()); ?>
					</div>
					
					<input type="hidden" name="wpt_edit_profile" value="1" />

					<div class="custom-login-form-actions clearfix">
						<?php if ( $level !== 'message' ) { ?>
							<?php $this->nonce_field('edit_profile', 'edit_profile') ?>
							<p>
								<button type="submit" class="ui--animation btn btn-primary" name="wpt_edit_profile_submit" value="<?php echo esc_attr(cloudfw_translate( 'custom_login.widget.form.change_password' )); ?>" ><?php echo cloudfw_translate( 'custom_login.widget.form.change_password' ); ?></button>
							</p>

						<?php } ?>

					</div>

				</div>
		</form>

		<?php } elseif ( $level == 'message' ) { ?>
			
			<?php if ( !empty ( $_POST['wpt_edit_profile'] ) ) $this->show_messages(); ?>

		<?php } ?>

</div>