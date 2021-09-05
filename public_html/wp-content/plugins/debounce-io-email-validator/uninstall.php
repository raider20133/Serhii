<?php
/**
 * Run the uninstall routine
 *
 * @package debounce
 */

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

delete_option( 'debounce-api-key-invalid' );
delete_option( 'debounce_settings' );
