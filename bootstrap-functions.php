<?php
/**
 * Defines module-specific getters and functions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers
 *
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace DeepWebSolutions\Framework;

defined( 'ABSPATH' ) || exit;

/**
 * Returns the whitelabel name of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_name() {
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
function dws_wp_framework_get_helpers_version() {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_VERSION' );
}

/**
 * Returns the minimum PHP version required to run the Bootstrapper of the framework's helpers within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_helpers_min_php() {
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
function dws_wp_framework_get_helpers_min_wp() {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_MIN_WP' );
}
