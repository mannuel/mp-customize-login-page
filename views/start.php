<div class="wrap">
	<div class="mpclp-content">
		<div class="row">
			<div class="col m8 s12">
				<nav class="main orange darken-2" role="navigation">
					<div class="nav-wrapper valign-wrapper">
						<div class="row">
							<div class="col m12 center-align">
								<h1 class="white-text"><?php esc_html_e( 'MP Customize Login Page', 'mp_clp' ); ?></h1>
							</div>

<!-- 							<div class="col m4 right-align">
								<img src="<?php echo MPCLP__PLUGIN_DIR_URL .'assets/img/mannuel.svg' ?>" alt="Manuel Padilla">
							</div> -->
						</div>
					</div>
				</nav>

				<form action="" method="post" id="mpclp_frm">
					<?php wp_nonce_field( mpclp::NONCE ) ?>
					<input type="hidden" name="action" value="enter-mpclp-login-options">
					
					<div class="card">
						<div class="card-content">
							<span class="card-title">Login page</span>
								<div class="row">
									<div class="col s12 m6">
										<!-- <label>Login image</label> -->
										<input type="button" class="waves-effect waves-light btn" value="<?php _e( 'Set login image', 'mp_clp' ); ?>" id="upload-login-image-button">
										<input type="hidden" name="mpclp-login-image" id="mpclp-login-image" value="<?php echo get_option( 'mpclp_login_image' ); ?>">
									</div>
								</div>

							<div class="row">
								<div class="col s12 m6">
									<label>Login image height</label>
									<input type="text" name="mpclp-login-image-height" id="mpclp-login-image-height" value="<?php echo get_option( 'mpclp_login_image_height' ); ?>" placeholder="100px">
								</div>

								<div class="col s12 m6">
									<label>Page background</label>
									<input type="color" name="mpclp-login-background-selector" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background-selector">
									<input type="text" name="mpclp-login-background" value="<?php echo get_option( 'mpclp_login_background' ); ?>" id="mpclp-login-background">
								</div>
							</div>
						</div>
					</div> <!-- /.card -->

					<div class="card">
						<div class="card-content">
							<span class="card-title">Login form</span>
							<div class="row">
								<div class="col s12 m6">
									<label>Form background color</label>
									<input type="color" name="mpclp-login-form-background-selector" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background-selector">
									<input type="text" name="mpclp-login-form-background" value="<?php echo get_option( 'mpclp_login_form_background' ); ?>" id="mpclp-login-form-background">
								</div>

								<div class="col s12 m6">
									<label>Form label color</label>
									<input type="color" name="mpclp-login-form-label-selector" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label-selector">
									<input type="text" name="mpclp-login-form-label" value="<?php echo get_option( 'mpclp_login_form_label' ); ?>" id="mpclp-login-form-label">
								</div>
							</div>
						</div>
					</div> <!-- /.card -->

					<div class="card">
						<div class="card-content">
							<span class="card-title">Message</span>
							<div class="row">
								<div class="input-field col s12">
									<textarea name="mpclp-login-message" id="mpclp-login-message" class="materialize-textarea"><?php echo get_option( 'mpclp_login_message' ); ?></textarea>
								</div>
							</div>
						</div>
					</div> <!-- /.card -->

					<div class="row">
						<div class="col m12 s12 right-align">
							<input type="submit" name="submit" id="submit" class="waves-effect waves-light btn btn-large green darken-2" value="<?php _e( 'Save all', 'mp_clp' );?>">
						</div>
					</div>

					<div class="fixed-action-btn">
						<button type="submit" class="btn-floating waves-effect waves-light btn-large green darken-2"><i class="material-icons">save</i></button>
					</div>
				</form>
			</div> <!-- /.col m10 s12 -->

			<div class="col m4 s12">
				<?php if (get_option( 'mpclp_login_image' )): ?>
					<div class="card" style="margin-top: 0">
						<div class="card-content">
							<label><?php _e( 'Current login image', 'mp_clp' ); ?></label>
							<div id="login-image-current" style="background-image: url(<?php echo get_option( 'mpclp_login_image' ); ?>);"></div>

							<form action="" method="post">
								<?php wp_nonce_field( mpclp::NONCE ) ?>
								<input type="hidden" name="action" value="delete-mpclp-login-image">
								<input type="submit" class="waves-effect waves-light btn red darken-4" value="<?php _e( 'Remove', 'mp_clp' ); ?>" id="delete-login-image-button">
							</form>
						</div>
					</div>
				<?php endif; ?>

				<div class="card hoverable center-align about-plugin" style="margin-top: 0">
					<div class="card-content">
						<div class="">
							<img src="<?php echo MPCLP__PLUGIN_DIR_URL .'assets/img/mannuel.svg' ?>" alt="Manuel Padilla" style="width: 60%; margin-bottom: 1.5em">
						</div>
						<span class="card-title"><?php _e( 'About this plugin', 'mp_clp' );?></span>
						<ul>
							<li><?php _e( 'Name' );?>: MP Customize Login Page</li>
							<li><?php _e( 'Developer' );?>: Manuel Padilla</li>
						</ul>
					</div>
					<div class="card-action">
						<a href="https://goo.gl/BsnMiH" target="_blank" title="MP Customize login Page git repo">Bitbucket Repo</a>
						<a href="https://goo.gl/Rd8Gev" target="_blank" title="Manuel Padilla LikedIn">LinkedIn</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>