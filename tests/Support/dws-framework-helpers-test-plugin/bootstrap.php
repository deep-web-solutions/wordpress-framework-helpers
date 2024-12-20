<?php
/**
 * The DWS WordPress Framework Helpers Test Plugin bootstrap file.
 *
 * @since               1.0.0
 * @version             2.0.0
 * @author              Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:         DWS Framework Helpers Test Plugin
 * Description:         A WP plugin used to run automated tests against the DWS WP Framework Helpers package.
 * Version:             2.0.0
 */

namespace DeepWebSolutions\Plugins;

use DeepWebSolutions\Framework\Helpers\DataType\IntegerDataType;
use DeepWebSolutions\Framework\Helpers\Request;

\defined( 'ABSPATH' ) || exit;

// Register autoloader for testing dependencies.
is_file( __DIR__ . '/vendor/autoload.php' ) && require_once __DIR__ . '/vendor/autoload.php';
if ( ! defined( 'DeepWebSolutions\Framework\BOOTSTRAPPER_BASENAME' ) ) {
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-bootstrapper/bootstrap.php';
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-helpers/bootstrap.php';
}

$test = IntegerDataType::lazy( fn() => 4 );
var_dump( $test );

return; // TODO: Debugging code below.

// Trigger helpers externally.
add_action( 'parse_query', function( &$wp_query ) {
	if ( false !== strpos( $_SERVER['REQUEST_URI'], 'dws-wp-framework-helpers/users-functions' ) ) {
		include ABSPATH . 'wp-content/plugins/dws-wp-helpers-test-plugin/users-functions.php';
		exit;
	}
} );

// Append request type
add_action( 'init', function() {
	$headers = array(
		'X-DWS-REQ-TYPE-ADMIN'    => 0,
		'X-DWS-REQ-TYPE-AJAX'     => 0,
		'X-DWS-REQ-TYPE-CRON'     => 0,
		'X-DWS-REQ-TYPE-REST'     => 0,
		'X-DWS-REQ-TYPE-FRONTEND' => 0,
	);

	if ( Request::is_type( 'admin' ) ) {
		$headers['X-DWS-REQ-TYPE-ADMIN'] = 1;
	}
	if ( Request::is_type( 'ajax' ) ) {
		$headers['X-DWS-REQ-TYPE-AJAX'] = 1;
	}
	if ( Request::is_type( 'cron' ) ) {
		$headers['X-DWS-REQ-TYPE-CRON'] = 1;
	}
	if ( Request::is_type( 'rest' ) ) {
		$headers['X-DWS-REQ-TYPE-REST'] = 1;
	}
	if ( Request::is_type( 'front' ) ) {
		$headers['X-DWS-REQ-TYPE-FRONTEND'] = 1;
	}

	foreach ( $headers as $header => $value ) {
		header( "$header: $value" );
	}
} );
