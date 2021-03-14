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

defined( 'ABSPATH' ) || exit;

// Register autoloader for testing dependencies.
is_file( __DIR__ . '/vendor/autoload.php' ) && require_once __DIR__ . '/vendor/autoload.php';
if ( ! defined( 'DeepWebSolutions\Framework\DWS_WP_FRAMEWORK_BOOTSTRAPPER_NAME' ) ) {
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-bootstrapper/bootstrap.php';
	require __DIR__ . '/vendor/deep-web-solutions/wp-framework-helpers/bootstrap.php';
}
