<?php
/**
 * Plugin Name: MP Customize Login Page
 * Description: Customize your wp-login page
 * Plugin URI: https://www.plugdigital.net/wp-plugins/mp-customize-login-page
 * Author: Manuel Padilla
 * Author URI: https://www.plugdigital.net/manuel-padilla
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mp_clp
 * Domain Path: /languages/
 */

/*
MP Customize login Page is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
MP Customize login Page is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with MP Customize login Page. If not, see {URI to Plugin License}.
*/

defined( 'ABSPATH' ) or exit;

define( 'MPCLP__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'MPCLP__PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

define( 'MPCLP__PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once( MPCLP__PLUGIN_DIR . 'class.mp-customize-login-page.php' );

add_action( 'init', array( 'mpclp', 'init' ) );