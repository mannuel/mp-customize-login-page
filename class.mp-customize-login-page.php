<?php
/**
* mpclp - MP Customize Login Page
* Author: Manuel Padilla manuel@plugdigital.net
*/
class mpclp {
	const NONCE = 'mpclp';

	private static $initiated = false;

	public static function init() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'update' ) {
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
		add_filter( 'login_message', array( 'mpclp', 'mpclp_add_login_message' ) );
	}

	/**
	 * Enqueue Scripts
	 */
	public static function mpclp_admin_scripts() {
		if (isset($_GET["page"]) == "mpclp-settings-menu") {
			// Bootstrap Grid
			wp_register_style( 'mpclp-bootstrap-grid', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap-grid.css', array(), '1.0.0', 'all' );
			wp_enqueue_style( 'mpclp-bootstrap-grid' );

			wp_register_style( 'mpclp-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/mp-customize-login-page.admin.css', array(), '1.0.0', 'all' );
			wp_enqueue_style( 'mpclp-admin-styles' );

			wp_enqueue_media();

			wp_enqueue_style( 'wp-color-picker' );

			wp_register_script( 'mpclp-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/mp-customize-login-page.admin.js', array('jquery', 'wp-color-picker'), '1.0.0', true );
			wp_enqueue_script( 'mpclp-admin-script' );
		}
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
	 * Options DB Save
	 */
	public static function enter_mpclp_login_options() {
		if ( wp_verify_nonce( $_POST['_wpnonce'] ) ){
			return false;
		}

		update_option( 'mpclp_login_image', esc_url_raw($_POST['mpclp-login-image']) );
		update_option( 'mpclp_login_image_height', sanitize_text_field($_POST['mpclp-login-image-height']) );
		update_option( 'mpclp_login_background', sanitize_text_field($_POST['mpclp-login-background']) );
		update_option( 'mpclp_login_form_background', sanitize_text_field($_POST['mpclp-login-form-background']) );
		update_option( 'mpclp_login_form_label', sanitize_text_field($_POST['mpclp-login-form-label']) );
		update_option( 'mpclp_login_message', sanitize_text_field( htmlentities($_POST['mpclp-login-message'])) );
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

	/**
	 * Add login message
	 */
	public static function mpclp_add_login_message() {
		if ( get_option( 'mpclp_login_message' ) ) {
			return '<div class="message">' . html_entity_decode(get_option( 'mpclp_login_message' )). '</div>';
		}
	}
} // class mpclp end


/**
 * 
 */
function register_settings() {
	register_setting( 'mpclp_options', 'mpclp' );
	add_settings_section( 'mpclp_opstions_section', 'Page options', 'mpclp_opstions_fields', 'MP Customize Login Page' );
	add_settings_section( 'mpclp_opstions_form_section', 'Form options', 'mpclp_opstions_form_fields', 'MP Customize Form Login Page' );

	add_settings_field( 'mpclp-login-image', 'Logo image', 'mpclp_opt_logo_image', 'MP Customize Login Page', 'mpclp_opstions_section', '' );
	add_settings_field( 'mpclp-login-image-height', 'Login image height', 'mpclp_opt_login_image_height', 'MP Customize Login Page', 'mpclp_opstions_section', '' );
	add_settings_field( 'mpclp-login-form-background', 'Page background', 'mpclp_opt_page_background', 'MP Customize Login Page', 'mpclp_opstions_section', '' );

	add_settings_field( 'mpclp-login-form-background', 'Form background', 'mpclp_login_form_background', 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
	add_settings_field( 'mpclp-login-form-label', 'Form label color', 'mpclp_login_form_label', 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
	add_settings_field( 'mpclp-login-message', 'Message', 'mpclp_login_message', 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
}
add_action( 'admin_init', 'register_settings' );

function mpclp_opstions_fields(){
	echo "";
}

function mpclp_opstions_form_fields(){
	echo "Set styles for your login form";
}

function mpclp_opt_logo_image(  ){
	$mpclp_login_image = esc_attr( get_option( 'mpclp_login_image' ) );
	echo '<input type="hidden" name="mpclp-login-image" id="mpclp-login-image" value="'.$mpclp_login_image.'">';
	echo '<input type="button" value="Set login image" id="upload-login-image-button" class="button">';
}

function mpclp_opt_login_image_height(  ){
	$mpclp_login_image_height = esc_attr( get_option( 'mpclp_login_image_height' ) );
	echo '<input type="text" id="mpclp-login-image-height" name="mpclp-login-image-height" value="'.$mpclp_login_image_height.'" placeholder="100px">';
}

function mpclp_opt_page_background(  ){
	$mpclp_login_background = esc_attr( get_option( 'mpclp_login_background' ) );
	echo '<input type="text" id="mpclp-login-background" class="wpColorPicker" name="mpclp-login-background" value="'.$mpclp_login_background.'" />';
}

function mpclp_login_form_background(  ){
	$mpclp_login_form_background = esc_attr( get_option( 'mpclp_login_form_background' ) );
	echo '<input type="text" id="mpclp-login-form-background" class="wpColorPicker" name="mpclp-login-form-background" value="'.$mpclp_login_form_background.'">';
}

function mpclp_login_form_label(  ){
	$mpclp_login_form_label = esc_attr( get_option( 'mpclp_login_form_label' ) );
	echo '<input type="text" class="wpColorPicker" name="mpclp-login-form-label" value="'.$mpclp_login_form_label.'" id="mpclp-login-form-label">';
}

function mpclp_login_message(  ){
	$mpclp_login_message = html_entity_decode(get_option( 'mpclp_login_message' ));
	// echo '<textarea name="mpclp-login-message" id="mpclp-login-message" class="">'.$mpclp_login_message.'</textarea>';
	$settings = array(
		'editor_height' => 70 
	);
	wp_editor( $mpclp_login_message, 'mpclp-login-message', $settings );
}