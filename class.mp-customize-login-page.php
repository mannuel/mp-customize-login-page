<?php
/**
* mpclp - MP Customize Login Page
* Author: Manuel Padilla manuel@plugdigital.net
*/
class mpclp {
	const NONCE = 'mpclp';

	private static $initiated = false;

	public static function init() {
		// Login Image?
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'enter-mpclp-login-options' ) {
			self::enter_mpclp_login_options();
		}
		// DELETE Login Image?
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'delete-mpclp-login-image' ) {
			self::delete_mpclp_login_image();
		}
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
		add_action( 'admin_menu', array( 'mpclp', 'mpclp_settings_menu' ) );
		add_action( 'login_form', array( 'mpclp', 'mpclp_login_image_form' ) );
		add_action( 'admin_enqueue_scripts', array( 'mpclp', 'mpclp_admin_scripts' ) );
	}

	/**
	 * Enqueue Scripts
	 */
	public static function mpclp_admin_scripts() {
		wp_register_style( 'mpclp-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/mp-customize-login-page.admin.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'mpclp-admin-styles' );
		wp_enqueue_media();
		wp_register_script( 'mpclp-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/mp-customize-login-page.admin.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'mpclp-admin-script' );
	}

	/**
	 * Show star page
	 */
	public static function mpclp_start_page() {
		mpclp::view('start');
	}

	public static function view( $name, array $args = array() ) {
		$args = apply_filters( 'mpclp_view_arguments', $args, $name );
		
		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}
		
		load_plugin_textdomain( 'mp_clp' );
		$file = MPCLP__PLUGIN_DIR . 'views/'. $name . '.php';
		include( $file );
	}

	// Add options page
	public static function mpclp_settings_menu() {
		add_options_page( 'MP Customize Login Page', 'MP Customize Login Page', 'manage_options', 'mpclp-settings-menu', 'mpclp::mpclp_start_page' );
	}

	/**
	 * Login image DB Save
	 */
	public static function enter_mpclp_login_options() {
		if ( !wp_verify_nonce( $_POST['_wpnonce'], self::NONCE ) )
			return false;
		update_option( 'mpclp_login_image', $_POST['mpclp-login-image'] );
		update_option( 'mpclp_login_image_height', $_POST['mpclp-login-image-height'] );
		update_option( 'mpclp_login_background', $_POST['mpclp-login-background'] );
		update_option( 'mpclp_login_form_background', $_POST['mpclp-login-form-background'] );
		update_option( 'mpclp_login_form_label', $_POST['mpclp-login-form-label'] );
		return true;
	}

	/**
	 * DELETE Login image DB Save
	 */
	public static function delete_mpclp_login_image() {
		if ( !wp_verify_nonce( $_POST['_wpnonce'], self::NONCE ) )
			return false;
		delete_option( 'mpclp_login_image' );
		return true;
	}

	/**
	 * Add custom login options
	 */
	public static function mpclp_login_image_form() { ?>
		<style type="text/css">
			body{background: <?php echo get_option( 'mpclp_login_background' ); ?>}
			<?php if( get_option( 'mpclp_login_image' ) ) { ?>
				.login h1 a{ background-image: none,url(<?php echo get_option( 'mpclp_login_image' ); ?>); background-repeat: no-repeat; background-size: contain; width: 100%}
			<?php } ?>
			<?php if( get_option( 'mpclp_login_image_height' ) ) { ?>
				.login h1 a{ height: <?php echo get_option( 'mpclp_login_image_height' ); ?> }
			<?php } ?>
			.login form{background: <?php echo get_option( 'mpclp_login_form_background' ); ?>}
			.login label{color: <?php echo get_option( 'mpclp_login_form_label' ); ?>}
		</style>
	<?php }
} // class mpclp end