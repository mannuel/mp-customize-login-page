<h1><?php esc_html_e( 'MP Customize Login Page', 'mp_clp' ); ?></h1>

<form action="" method="post" id="mpclp_frm">
	<?php wp_nonce_field( mpclp::NONCE ) ?>
	<input type="hidden" name="action" value="enter-mpclp-login-options">
	
	<input type="button" value="<?php _e( 'Set login image', 'mp_clp' ); ?>" id="upload-login-image-button">
	<input type="hidden" name="mpclp-login-image" id="mpclp-login-image" value="<?php echo get_option( 'mpclp_login_image' ); ?>">

	<label>Login image height</label>
	<input type="text" name="mpclp-login-image-height" id="mpclp-login-image-height" value="<?php echo get_option( 'mpclp_login_image_height' ); ?>" placeholder="100px">

	<label>Page background</label>
	<input type="color" name="mpclp-login-background-selector" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background-selector">
	<input type="text" name="mpclp-login-background" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background">


	<span class="card-title">Login form</span>
	<label>Form background color</label>
	<input type="color" name="mpclp-login-form-background-selector" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background-selector">
	<input type="text" name="mpclp-login-form-background" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background">

	<label>Form label color</label>
	<input type="color" name="mpclp-login-form-label-selector" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label-selector">
	<input type="text" name="mpclp-login-form-label" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label">

	<span class="card-title">Message</span>
	<textarea name="mpclp-login-message" id="mpclp-login-message" class=""><?php echo get_option( 'mpclp_login_message' ); ?></textarea>

	<input type="submit" name="submit" id="submit" class="" value="<?php _e( 'Save all', 'mp_clp' );?>">
</form>

<?php if (get_option( 'mpclp_login_image' )): ?>
	<label><?php _e( 'Current login image', 'mp_clp' ); ?></label>
	<div id="login-image-current" style="background-image: url(<?php echo get_option( 'mpclp_login_image' ); ?>);"></div>

	<form action="" method="post">
		<?php wp_nonce_field( mpclp::NONCE ) ?>
		<input type="hidden" name="action" value="delete-mpclp-login-image">
		<input type="submit" class="waves-effect waves-light btn red darken-4" value="<?php _e( 'Remove', 'mp_clp' ); ?>" id="delete-login-image-button">
	</form>
<?php endif; ?>

<div class="">
	<img src="<?php echo MPCLP__PLUGIN_DIR_URL .'assets/img/mannuel.svg' ?>" alt="Manuel Padilla" style="width: 60%; margin-bottom: 1.5em">
</div>

<span class="card-title"><?php _e( 'About this plugin', 'mp_clp' );?></span>

<ul>
	<li><?php _e( 'Name' );?>: MP Customize Login Page</li>
	<li><?php _e( 'Developer' );?>: Manuel Padilla</li>
</ul>

<div class="">
	<a href="https://goo.gl/BsnMiH" target="_blank" title="MP Customize login Page git repo">Bitbucket Repo</a>
	<a href="https://goo.gl/Rd8Gev" target="_blank" title="Manuel Padilla LikedIn">LinkedIn</a>
</div>