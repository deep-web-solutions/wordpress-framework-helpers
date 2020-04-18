<?php
/**
 * The DWS Test Plugin bootstrap file.
 *
 * @since               1.0.0
 * @version             1.0.0
 * @package             DeepWebSolutions\test-plugin
 * @author              Deep Web Solutions GmbH
 * @copyright           2020 Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:         DWS Test Plugin
 * Description:         Plugin for running the DWS WP Framework tests on.
 * Version:             1.0.0
 * Author:              Deep Web Solutions GmbH
 * Author URI:          https://www.deep-web-solutions.de
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:         dws-test-plugin
 * Domain Path:         /languages
 */

use DeepWebSolutions\Plugins\FrameworkTest\Plugin;
use DI\ContainerBuilder;

defined( 'ABSPATH' ) || exit;

define( 'DWS_TEST_PLUGIN_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'DWS_TEST_PLUGIN_BASE_URL', plugin_dir_url( __FILE__ ) );

define( 'DWS_TEST_PLUGIN_NAME', 'DWS Test Plugin' );
define( 'DWS_TEST_PLUGIN_SLUG', 'dws-test-plugin' );
define( 'DWS_TEST_PLUGIN_MIN_PHP', '7.4' );
define( 'DWS_TEST_PLUGIN_MIN_WP', '5.4' );

define( 'DWS_TEST_PLUGIN_TEMP_DIR_NAME', 'test-plugin' );
define( 'DWS_TEST_PLUGIN_TEMP_DIR_PATH', DWS_WP_FRAMEWORK_TEMP_DIR_PATH . DWS_TEST_PLUGIN_TEMP_DIR_NAME );
define( 'DWS_TEST_PLUGIN_TEMP_DIR_URL', DWS_WP_FRAMEWORK_TEMP_DIR_URL . DWS_TEST_PLUGIN_TEMP_DIR_NAME );

/* @noinspection PhpDocMissingThrowsInspection */
/**
 * Singleton instance function for the plugin.
 *
 * @return Plugin|mixed
 */
function dws_test_plugin() {
	return dws_test_plugin_container()->get( Plugin::class );
}

/**
 * Container singleton that enables one to setup unit testing by passing an environment file for class mapping in PHP-DI.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @param   string  $environment    The environment rules that the container should be initialized on.
 *
 * @throws  Exception   Thrown if initializing the container fails.
 *
 * @return  \DI\Container
 */
function dws_test_plugin_container( $environment = 'prod' ) {
	static $container;

	if ( empty( $container ) ) {
		$container_builder = new ContainerBuilder();
		$container_builder->addDefinitions( __DIR__ . "/config_{$environment}.php" );
		$container = $container_builder->build();
	}

	return $container;
}

/**
 * Initialization function shortcut.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
function dws_test_plugin_init() {
	dws_test_plugin()->init();
}

/**
 * Activate function shortcut.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
function dws_test_plugin_activate() {
	dws_test_plugin()->activate();
}

/**
 * Deactivate function shortcut.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
function dws_test_plugin_deactivate() {
	dws_test_plugin()->deactivate();
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php'; // The conditional check makes the whole thing compatible with Bedrock.
}

if ( function_exists( 'dws_wp_framework_check_php_wp_requirements_met' ) ) {
	if ( dws_wp_framework_check_php_wp_requirements_met( DWS_TEST_PLUGIN_MIN_PHP, DWS_TEST_PLUGIN_MIN_WP ) ) {
		add_action( 'plugins_loaded', 'dws_test_plugin_init', 100 );
		register_activation_hook( __FILE__, 'dws_test_plugin_activate' );
		register_deactivation_hook( __FILE__, 'dws_test_plugin_deactivate' );
	} else {
		dws_wp_framework_output_requirements_error( DWS_TEST_PLUGIN_NAME, DWS_TEST_PLUGIN_MIN_PHP, DWS_TEST_PLUGIN_MIN_WP );
	}
} else {
	add_action(
		'admin_notices',
		function() {
			require_once __DIR__ . '/templates/installation-error.php';
		}
	);
}
