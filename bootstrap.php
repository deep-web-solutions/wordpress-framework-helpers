<?php
/**
 * The DWS WordPress Framework bootstrap file.
 *
 * @since               1.0.0
 * @version             1.0.0
 * @package             DeepWebSolutions\wordpress-framework-core
 * @author              Deep Web Solutions GmbH
 * @copyright           2020 Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:         DWS WordPress Framework
 * Description:         A set of related classes and helpers to kick start WordPress plugin development.
 * Version:             1.0.0
 * Author:              Deep Web Solutions GmbH
 * Author URI:          https://www.deep-web-solutions.de
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:         dws-wp-framework
 * Domain Path:         /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	return; // Since this file is autoloaded by Composer, 'exit' breaks all external dev tools.
}

// Maybe stop loading if this version of the framework has already been loaded by another component.
if ( defined( 'DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR' ) ) {
	// This version of the DWS Helpers Framework has already been loaded by another plugin. No point in reloading...
	return;
}
define( 'DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR', 'v1.0.0' ); // The suffix must be unique across all versions of the core.

defined( 'DWS_WP_FRAMEWORK_HELPERS_NAME' ) || define( 'DWS_WP_FRAMEWORK_HELPERS_NAME', DWS_WP_FRAMEWORK_WHITELABEL_NAME . ': Framework Helpers' );

define( dws_wp_framework_constant_get_versioned_name( 'DWS_WP_FRAMEWORK_HELPERS_MIN_PHP', DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR ), '7.4' );
define( dws_wp_framework_constant_get_versioned_name( 'DWS_WP_FRAMEWORK_HELPERS_MIN_WP', DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR ), '5.4' );

$dws_helpers_min_php_version_v1_0_0 = constant( dws_wp_framework_constant_get_versioned_name( 'DWS_WP_FRAMEWORK_HELPERS_MIN_PHP', DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR ) );
$dws_helpers_min_wp_version_v1_0_0  = constant( dws_wp_framework_constant_get_versioned_name( 'DWS_WP_FRAMEWORK_HELPERS_MIN_WP', DWS_WP_FRAMEWORK_HELPERS_VERSION_HG847H8GFDHGIHERGR ) );
if ( ! dws_wp_framework_check_php_wp_requirements_met( $dws_helpers_min_php_version_v1_0_0, $dws_helpers_min_wp_version_v1_0_0 ) ) {
	dws_wp_framework_output_requirements_error( DWS_WP_FRAMEWORK_HELPERS_NAME, $dws_helpers_min_php_version_v1_0_0, $dws_helpers_min_wp_version_v1_0_0 );
}
