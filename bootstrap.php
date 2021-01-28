<?php
/**
 * The DWS WordPress Framework Helpers bootstrap file.
 *
 * @since               1.0.0
 * @version             1.0.0
 * @package             DeepWebSolutions\WP-Helpers
 * @author              Deep Web Solutions GmbH
 * @copyright           2021 Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:         DWS WordPress Framework Helpers
 * Description:         A set of related helpers to kick start WordPress development.
 * Version:             1.0.0
 * Author:              Deep Web Solutions GmbH
 * Author URI:          https://www.deep-web-solutions.de
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:         dws-wp-framework-helpers
 * Domain Path:         /languages
 */

namespace DeepWebSolutions\Framework;

if ( ! defined( 'ABSPATH' ) ) {
	return; // Since this file is autoloaded by Composer, 'exit' breaks all external dev tools.
}

// Start by autoloading dependencies and defining a few functions for running the bootstrapper.
// The conditional check makes the whole thing compatible with Composer-based WP management.
file_exists( __DIR__ . '/vendor/autoload.php' ) && require_once __DIR__ . '/vendor/autoload.php';

// Define helpers constants.
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_NAME', dws_wp_framework_get_whitelabel_name() . ': Framework Helpers' );
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_VERSION', '1.0.0' );

/**
 * Returns the whitelabel name of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_name(): string {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_NAME' );
}

/**
 * Returns the version of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_version(): string {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_VERSION' );
}

// Define minimum environment requirements.
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_MIN_PHP', '7.4' );
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_MIN_WP', '5.2' );

/**
 * Returns the minimum PHP version required to run the Bootstrapper of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_min_php(): string {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_MIN_PHP' );
}

/**
 * Returns the minimum WP version required to run the Bootstrapper of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_min_wp(): string {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_MIN_WP' );
}

// Bootstrap the helpers (maybe)!
if ( dws_wp_framework_check_php_wp_requirements_met( dws_wp_framework_get_helpers_min_php(), dws_wp_framework_get_helpers_min_wp() ) ) {
	add_action(
		'plugins_loaded',
		function() {
			define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_INIT', DWS_WP_FRAMEWORK_BOOTSTRAPPER_INIT );
		},
		PHP_INT_MIN
	);
} else {
	define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_INIT', false );
	dws_wp_framework_output_requirements_error( dws_wp_framework_get_helpers_name(), dws_wp_framework_get_helpers_version(), dws_wp_framework_get_helpers_min_php(), dws_wp_framework_get_helpers_min_wp() );
}
