<?php
/**
 * The DeBounce email validator start file. Here we do initialize the plugin.
 *
 * Plugin Name: DeBounce.io Email Validator
 * Version: 3.2.1
 * Description: This is DeBounce email validation plugin which allows you to validate emails before submitting on the forms. This plugin uses DeBounce API platform. Please visit <a href="https://debounce.io" target="_blank">debounce.io</a> to get free credits and API.
 * Author: DeBounce.io
 * Author URI: https://debounce.io/
 * Text Domain: debounce-email-validator
 * Domain Path: /languages
 *
 * @package Plugins
 */

require_once( dirname( __FILE__ ) . '/src/functions.php' );
require_once( dirname( __FILE__ ) . '/src/class-debounce-plugin.php' );
add_action( 'after_setup_theme', 'debounce_load', 11 );

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];
	
define ( 'DEBOUNCE_PLUGIN_CURRENT_VERSION', $plugin_version );
	
/**
 * Initialize the plugin
 *
 * @return void
 */
function debounce_load() {

	$plugin = DEBOUNCE_Plugin::get_instance();
	$plugin->plugin_setup();
}
