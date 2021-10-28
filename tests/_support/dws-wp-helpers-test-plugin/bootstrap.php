<?php
/**
 * The DWS WordPress Framework Helpers Test Plugin bootstrap file.
 *
 * @since               1.0.0
 * @version             1.0.0
 * @package             DeepWebSolutions\WP-Framework\Helpers\Tests
 * @author              Deep Web Solutions GmbH
 * @copyright           2021 Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:         DWS WordPress Framework Helpers Test Plugin
 * Description:         A WP plugin used to run automated tests against the DWS WP Framework Helpers package.
 * Version:             1.0.0
 * Requires PHP:        5.3
 * Author:              Deep Web Solutions GmbH
 * Author URI:          https://www.deep-web-solutions.com
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace DeepWebSolutions\Plugins;

use DeepWebSolutions\Framework\Helpers\Request;

defined( 'ABSPATH' ) || exit;

// Register autoloader for testing dependencies.
is_file( __DIR__ . '/vendor/autoload.php' ) && require_once __DIR__ . '/vendor/autoload.php';
if ( ! defined( 'DeepWebSolutions\Framework\DWS_WP_FRAMEWORK_BOOTSTRAPPER_NAME' ) ) {
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-bootstrapper/bootstrap.php';
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-helpers/bootstrap.php';
}

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
