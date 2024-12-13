<?php
/**
 * The DWS WordPress Framework Helpers bootstrap file.
 *
 * @since       1.0.0
 * @version     2.0.0
 * @package     DeepWebSolutions\Framework
 * @author      Antonius Hegyes
 * @license     GPL-3.0-or-later
 *
 * @noinspection    ALL
 *
 * @wordpress-plugin
 * Plugin Name:         Deep Web Solutions Framework Helpers
 * Description:         A set of related helpers to kick-start WordPress development.
 * Version:             2.0.0
 * Requires at least:   6.7
 * Requires PHP:        8.4
 * Author:              Antonius Hegyes
 * Author URI:          https://github.com/ahegyes
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:         dws-wp-framework-helpers
 * Domain Path:         /languages
 */

namespace DeepWebSolutions\Framework;

if ( ! \defined( 'ABSPATH' ) ) {
	// Since this file is autoloaded by Composer, 'exit' breaks all external dev tools.
	return;
}

// Define component constants.
\define( __NAMESPACE__ . '\HELPERS_BASENAME', \plugin_basename( __FILE__ ) );
\define( __NAMESPACE__ . '\HELPERS_DIR_PATH', \plugin_dir_path( __FILE__ ) );
\define( __NAMESPACE__ . '\HELPERS_DIR_URL', \plugin_dir_url( __FILE__ ) );
