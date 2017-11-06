<?php

/*
 * MP Customize login page uninstall
*/

if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
	die;
}

delete_option( 'mpclp_login_image' );
delete_option( 'mpclp_login_image_link' );
delete_option( 'mpclp_login_image_height' );
delete_option( 'mpclp_login_background' );
delete_option( 'mpclp_login_form_background' );
delete_option( 'mpclp_login_form_label' );
delete_option( 'mpclp_login_message' );