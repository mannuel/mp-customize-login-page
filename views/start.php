<div class="wrap">
	<h1><?php esc_html_e( 'MP Customize Login Page', 'mp_clp' ); ?></h1>

	<div class="row">
		<div class="col-md-8">
			<form action="" method="post" id="mpclp_frm">
				<input type="hidden" name="mpclp-options" value="update">

				<?php wp_nonce_field() ?>
				
				<?php settings_fields( 'mpclp_options' ); ?>
				<?php do_settings_sections( 'MP Customize Login Page' ); ?>

				<hr>

				<?php do_settings_sections( 'MP Customize Form Login Page' ); ?>

				<input type="submit" value="<?php _e('Save settings', 'mp_clp'); ?>" class="button button-primary" name="submit" />
				<input type="button" id="reset-options" class="button button-secondary reset_settings" value="<?php _e('Reset settings', 'mp_clp'); ?>">
			</form>
		</div> <!-- /.col-md-8 -->
		<div class="col-md-3">
			<?php if (get_option( 'mpclp_login_image' )): ?>
				<div class="mp-card">
					<div class="mp-card-title">
						<h3><?php _e( 'Current login image', 'mp_clp' ); ?></h3>
					</div><!-- /.mp-card-title -->

					<div class="mp-card-content">
						<div id="login-image-current" style="background-image: url(<?php echo get_option( 'mpclp_login_image' ); ?>);"></div>

						<form action="" method="post">
							<?php wp_nonce_field( mpclp::NONCE ) ?>
							<input type="hidden" name="action" value="delete-mpclp-login-image">
							<input type="submit" class="button button-link" value="<?php _e( 'Remove image', 'mp_clp' ); ?>" id="delete-login-image-button">
						</form>
					</div><!-- /.mp-card-content -->
				</div><!-- /.mp-card -->
			<?php endif; ?>

			<?php if (get_option( 'mpclp_background' )): ?>
				<div class="mp-card">
					<div class="mp-card-title">
						<h3><?php _e( 'Current background image', 'mp_clp' ); ?></h3>
					</div><!-- /.mp-card-title -->

					<div class="mp-card-content">
						<div id="background-image-current" style="background-image: url(<?php echo get_option( 'mpclp_background' ); ?>); height: 100px; background-size: cover"></div>

						<form action="" method="post">
							<?php wp_nonce_field( mpclp::NONCEBG ) ?>
							<input type="hidden" name="action" value="delete-mpclp-background-image">
							<input type="submit" class="button button-link" value="<?php _e( 'Remove background image', 'mp_clp' ); ?>" id="delete-background-image-button">
						</form>

						<ul>
							<li><b>background-repeat</b>: <?php echo get_option( 'mpclp_background_repeat' ) ?></li>
							<li><b>background-size</b>: <?php echo get_option( 'mpclp_background_size' ) ?></li>
						</ul>
					</div><!-- /.mp-card-content -->
				</div><!-- /.mp-card -->
			<?php endif; ?>

			<div class="mp-card">
				<div class="mp-card-title">
					<h3><?php _e( 'About this Plugin', 'mp_clp' );?></h3>
				</div><!-- /.mp-card-title -->

				<div class="mp-card-content">
					<div class="text-center">
						<img src="<?php echo MPCLP__PLUGIN_DIR_URL .'assets/img/mannuel.svg' ?>" alt="Manuel Padilla" style="width: 60%; margin-bottom: 1.5em">
					</div>

					<ul>
						<li><b><?php _e( 'Name' );?></b>: MP Customize Login Page</li>
						<li><b><?php _e( 'Developer' );?></b>: Manuel Padilla</li>
					</ul>
				</div><!-- /.mp-card-content -->

				<div class="mp-card-action">
					<div class="mp-card-content">
						<a href="https://github.com/mannuel/mp-customize-login-page" target="_blank" title="MP Customize login Page git repo" class="mp-orange-text">GitHub Repo</a>
						<a href="https://goo.gl/Rd8Gev" target="_blank" title="Manuel Padilla LikedIn" class="mp-orange-text">LinkedIn</a>
					</div>
				</div><!-- /.mp-card-action -->
			</div> <!-- ./mp-card -->
		</div> <!-- /.col-md-4 -->
	</div> <!-- /.row -->

</div> <!-- /.wrap -->