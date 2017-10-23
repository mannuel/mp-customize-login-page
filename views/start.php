<div class="wrap">
	<h1><?php esc_html_e( 'MP Customize Login Page', 'mp_clp' ); ?></h1>

	<div class="card">
		<form action="" method="post">
			<?php wp_nonce_field( mpclp::NONCE ) ?>
			<input type="hidden" name="action" value="enter-mpclp-login-options">

			<div>
				<label>Login image</label>
				<input type="button" class="button button-secondary" value="<?php _e( 'Upload login image', 'mp_clp' ); ?>" id="upload-login-image-button">
				<input type="hidden" name="mpclp-login-image" id="mpclp-login-image" value="<?php echo get_option( 'mpclp_login_image' ); ?>">
			</div>

			<div>
				<label>Login image height</label>
				<input type="text" name="mpclp-login-image-height" id="mpclp-login-image-height" value="<?php echo get_option( 'mpclp_login_image_height' ); ?>" placeholder="100px">
			</div>

			<div>
				<label>Background</label>
				<input type="text" name="mpclp-login-background" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background">
				<input type="color" name="mpclp-login-background-selector" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background-selector">
			</div>

			<div>
				<label>Form background color</label>
				<input type="text" name="mpclp-login-form-background" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background">
				<input type="color" name="mpclp-login-form-background-selector" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background-selector">
			</div>

			<div>
				<label>Form label color</label>
				<input type="text" name="mpclp-login-form-label" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label">
				<input type="color" name="mpclp-login-form-label-selector" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label-selector">
			</div>

			<div>
				<input type="submit" name="submit" id="submit" class="button button-primary button-large mpclp-button" value="<?php _e( 'Save', 'mp_clp' );?>">
			</div>
		</form>
	</div> <!-- /.card -->

	<?php if (get_option( 'mpclp_login_image' )): ?>
		<div class="card">
			<h3><?php _e( 'Current login image', 'mp_clp' ); ?></h3>
			<div id="login-image-current" style="background-image: url(<?php echo get_option( 'mpclp_login_image' ); ?>);"></div>

			<form action="" method="post">
				<?php wp_nonce_field( mpclp::NONCE ) ?>
				<input type="hidden" name="action" value="delete-mpclp-login-image">
				<input type="submit" class="button button-danger" value="<?php _e( 'Delete current image', 'mp_clp' ); ?>" id="delete-login-image-button">
			</form>
		</div> <!-- /.card -->
	<?php endif; ?>
</div>