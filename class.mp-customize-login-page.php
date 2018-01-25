<?php
/**
* mpclp - MP Customize Login Page
* Author: Manuel Padilla manuel@plugdigital.net
*/
class mpclp {
	const NONCE   = 'mpclp';
	const NONCEBG = 'mpclp_bg';

	private static $initiated = false;

	public static function init() {
		if ( isset( $_POST['mpclp-options'] ) && $_POST['mpclp-options'] == 'update' ) {
			self::enter_mpclp_login_options();
		}
		// DELETE Login Image?
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'delete-mpclp-login-image' ) {
			self::delete_mpclp_login_image();
		}
		// DELETE Background Image?
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'delete-mpclp-background-image' ) {
			self::delete_mpclp_background_image();
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
		add_filter( 'login_headerurl', array( 'mpclp', 'mpclp_logo_url' ) );
		add_filter( 'login_headertitle', array( 'mpclp', 'mpclp_logo_title' ) );
		add_filter( 'plugin_action_links_'.MPCLP__PLUGIN_BASENAME, array( 'mpclp', 'mpclp_plugin_action_links' ));
		add_action( 'admin_init', array( 'mpclp', 'register_settings' ) );
	}

	/**
	 * Add settings link on plugin page
	 */
	public static function mpclp_plugin_action_links($links) {
		$settings_link = '<a href="options-general.php?page=mpclp-settings-menu">Settings</a>';	
		array_unshift($links, $settings_link); 
		
		return $links;
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
	 * Show start page
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
		update_option( 'mpclp_login_image_link', esc_url_raw($_POST['mpclp-login-image-link']) );
		update_option( 'mpclp_login_image_height', sanitize_text_field($_POST['mpclp-login-image-height']) );
		update_option( 'mpclp_login_background', sanitize_text_field($_POST['mpclp-login-background']) );
		update_option( 'mpclp_background', esc_url_raw($_POST['mpclp-background']) );
		update_option( 'mpclp_background_repeat', sanitize_text_field($_POST['mpclp-background-repeat']) );
		update_option( 'mpclp_background_size', sanitize_text_field($_POST['mpclp-background-size']) );
		update_option( 'mpclp_login_form_background', sanitize_text_field($_POST['mpclp-login-form-background']) );
		update_option( 'mpclp_login_form_label', sanitize_text_field($_POST['mpclp-login-form-label']) );
		update_option( 'mpclp_login_message', sanitize_text_field( htmlentities($_POST['mpclp-login-message'])) );
		update_option( 'mpclp_login_btn_background', sanitize_text_field($_POST['mpclp-login-btn-background']) );
		update_option( 'mpclp_login_btn_background_hover', sanitize_text_field($_POST['mpclp-login-btn-background-hover']) );
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
	 * DELETE Background image DB Save
	 */
	public static function delete_mpclp_background_image() {
		if ( !wp_verify_nonce( $_POST['_wpnonce'], self::NONCEBG ) )
			return false;

		delete_option( 'mpclp_background' );
		return true;
	}

	/**
	 * Add custom login options
	 */
	public static function mpclp_login_image_form() {
		$page_background = "";
		if (get_option( 'mpclp_background' )) {
			$page_background = "url('". get_option( 'mpclp_background' ) . "') " . get_option( 'mpclp_background_repeat' ) . "; background-size:" . get_option( 'mpclp_background_size' ) . ";";
		}elseif (get_option( 'mpclp_login_background' )) {
			$page_background = get_option( 'mpclp_login_background' );
		}
	?>
		<style type="text/css">
			<?php if($page_background){ ?>
				body{background: <?php echo $page_background; ?>}
			<?php } ?>

			<?php if( get_option( 'mpclp_login_image' ) ) { ?>
				.login h1 a{ background-image: none,url(<?php echo get_option( 'mpclp_login_image' ); ?>); background-repeat: no-repeat; background-size: contain; width: 100%}
			<?php } ?>

			<?php if( get_option( 'mpclp_login_image_height' ) ) { ?>
				.login h1 a{ height: <?php echo get_option( 'mpclp_login_image_height' ); ?> }
			<?php } ?>

			<?php if ( get_option( 'mpclp_login_btn_background' ) ): ?>
				input#wp-submit{background: <?php echo get_option( 'mpclp_login_btn_background' ); ?> !important}
			<?php endif ?>

			<?php if ( get_option( 'mpclp_login_btn_background_hover' ) ): ?>
				input#wp-submit:hover{background: <?php echo get_option( 'mpclp_login_btn_background_hover' ); ?> !important}
				input#wp-submit{
					border-color: <?php echo get_option( 'mpclp_login_btn_background_hover' ); ?>;
					text-shadow: 0 -1px 1px <?php echo get_option( 'mpclp_login_btn_background_hover' ); ?>;
					box-shadow: 0 1px 0 <?php echo get_option( 'mpclp_login_btn_background_hover' ); ?>;
				}
			<?php endif ?>

			<?php if ( get_option( 'mpclp_login_form_background' ) ): ?>
				.login form{background: <?php echo get_option( 'mpclp_login_form_background' ); ?>}
			<?php endif ?>

			<?php if ( get_option( 'mpclp_login_form_label' ) ): ?>
				.login label{color: <?php echo get_option( 'mpclp_login_form_label' ); ?>}
			<?php endif ?>
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

	/**
	 * Logo link
	 */
	public static function mpclp_logo_url() {
		if ( get_option( 'mpclp_login_image_link' ) ) {
			return get_option( 'mpclp_login_image_link' );
		} else {
			return home_url();
		}
	}

	/**
	 * Logo title
	 */
	public static function mpclp_logo_title() {
		return get_bloginfo( 'name' );
	}

	/**
	 * 
	 */
	public static function register_settings() {
		register_setting( 'mpclp_options', 'mpclp' );

		add_settings_section( 'mpclp_opstions_section', 'Page options', array( 'mpclp', 'mpclp_opstions_fields' ), 'MP Customize Login Page' );
		add_settings_section( 'mpclp_opstions_form_section', 'Form options', array( 'mpclp', 'mpclp_opstions_form_fields'), 'MP Customize Form Login Page' );

		add_settings_field( 'mpclp-login-image', 'Logo image', array( 'mpclp', 'mpclp_opt_logo_image'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-login-image-link', 'Logo link', array( 'mpclp', 'mpclp_opt_login_image_link'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-login-image-height', 'Login image height', array( 'mpclp', 'mpclp_opt_login_image_height'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-background', 'Background image', array( 'mpclp', 'mpclp_background'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-background-repeat', 'Background image repeat', array( 'mpclp', 'mpclp_background_repeat'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-background-size', 'Background image size', array( 'mpclp', 'mpclp_background_size'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );
		add_settings_field( 'mpclp-login-form-background', 'Background color', array( 'mpclp', 'mpclp_opt_page_background'), 'MP Customize Login Page', 'mpclp_opstions_section', '' );

		add_settings_field( 'mpclp-login-form-background', 'Form background', array( 'mpclp', 'mpclp_login_form_background'), 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
		add_settings_field( 'mpclp-login-form-label', 'Form label color', array( 'mpclp', 'mpclp_login_form_label'), 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
		add_settings_field( 'mpclp-login-btn-background', 'Button background', array( 'mpclp', 'mpclp_login_btn_background'), 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
		add_settings_field( 'mpclp-login-btn-background-hover', 'Button background hover', array( 'mpclp', 'mpclp_login_btn_background_hover'), 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
		add_settings_field( 'mpclp-login-message', 'Message', array( 'mpclp', 'mpclp_login_message'), 'MP Customize Form Login Page', 'mpclp_opstions_form_section', '' );
	}

	public static function mpclp_opstions_fields(){
		echo "";
	}

	public static function mpclp_opstions_form_fields(){
		echo "Set styles for your login form";
	}

	public static function mpclp_opt_logo_image( ){
		$mpclp_login_image = esc_attr( get_option( 'mpclp_login_image' ) );
		echo '<input type="hidden" name="mpclp-login-image" id="mpclp-login-image" value="'.$mpclp_login_image.'">';
		echo '<input type="button" value="Set login image" id="upload-login-image-button" class="button">';
	}

	public static function mpclp_opt_login_image_link( ){
		$mpclp_login_image_link = esc_attr( get_option( 'mpclp_login_image_link' ) );
		echo '<input type="url" id="mpclp-login-image-link" name="mpclp-login-image-link" value="'.$mpclp_login_image_link.'" placeholder="'.home_url().'">';
	}

	public static function mpclp_opt_login_image_height( ){
		$mpclp_login_image_height = esc_attr( get_option( 'mpclp_login_image_height' ) );
		echo '<input type="text" id="mpclp-login-image-height" name="mpclp-login-image-height" value="'.$mpclp_login_image_height.'" placeholder="100px">';
	}

	public static function mpclp_background( ){
		$mpclp_background = esc_attr( get_option( 'mpclp_background' ) );
		echo '<input type="hidden" name="mpclp-background" id="mpclp-background" value="'.$mpclp_background.'">';
		echo '<input type="button" value="Set background image" id="upload-background-image-button" class="button">';
		echo '<p class="description">Recommended: 1366x768 pixels</p>';
	}

	public static function mpclp_background_repeat( ){
		$mpclp_background_repeat = esc_attr( get_option( 'mpclp_background_repeat' ) );
		?>
		<select name="mpclp-background-repeat" id="mpclp-background-repeat">
			<option value="no-repeat" <?php selected($mpclp_background_repeat, "no-repeat"); ?>>no-repeat</option>
			<option value="repeat-x" <?php selected($mpclp_background_repeat, "repeat-x"); ?>>repeat-x</option>
			<option value="repeat-y" <?php selected($mpclp_background_repeat, "repeat-y"); ?>>repeat-y</option>
		</select>
		<?php
	}

	public static function mpclp_background_size( ){
		$mpclp_background_size = esc_attr( get_option( 'mpclp_background_size' ) );
		?>
		<select name="mpclp-background-size" id="mpclp-background-size">
			<option value="cover" <?php selected($mpclp_background_size, "cover"); ?>>cover</option>
			<option value="contain" <?php selected($mpclp_background_size, "contain"); ?>>contain</option>
		</select>
		<?php
	}

	public static function mpclp_opt_page_background( ){
		$mpclp_login_background = esc_attr( get_option( 'mpclp_login_background' ) );
		echo '<input type="text" id="mpclp-login-background" class="wpColorPicker" name="mpclp-login-background" value="'.$mpclp_login_background.'" />';
	}

	public static function mpclp_login_form_background( ){
		$mpclp_login_form_background = esc_attr( get_option( 'mpclp_login_form_background' ) );
		echo '<input type="text" id="mpclp-login-form-background" class="wpColorPicker" name="mpclp-login-form-background" value="'.$mpclp_login_form_background.'">';
	}

	public static function mpclp_login_btn_background( ){
		$mpclp_login_btn_background = esc_attr( get_option( 'mpclp_login_btn_background' ) );
		echo '<input type="text" id="mpclp-login-btn-background" class="wpColorPicker" name="mpclp-login-btn-background" value="'.$mpclp_login_btn_background.'">';
	}

	public static function mpclp_login_btn_background_hover( ){
		$mpclp_login_btn_background_hover = esc_attr( get_option( 'mpclp_login_btn_background_hover' ) );
		echo '<input type="text" id="mpclp-login-btn-background-hover" class="wpColorPicker" name="mpclp-login-btn-background-hover" value="'.$mpclp_login_btn_background_hover.'">';
	}

	public static function mpclp_login_form_label( ){
		$mpclp_login_form_label = esc_attr( get_option( 'mpclp_login_form_label' ) );
		echo '<input type="text" class="wpColorPicker" name="mpclp-login-form-label" value="'.$mpclp_login_form_label.'" id="mpclp-login-form-label">';
	}

	public static function mpclp_login_message( ){
		$mpclp_login_message = html_entity_decode(get_option( 'mpclp_login_message' ));
		$settings = array(
			'editor_height' => 70 
		);
		wp_editor( $mpclp_login_message, 'mpclp-login-message', $settings );
	}
} // class mpclp end