<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Assets {
	/**
	 * Returns a string wrapped in CSS tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $css    The CSS content.
	 *
	 * @return  string
	 */
	public static function get_stylesheet_from_string( string $css ): string {
		return "<style type='text/css'>{$css}</style>";
	}

	/**
	 * Returns a string wrapped in JS tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $js     The JS content.
	 *
	 * @return  string
	 */
	public static function get_javascript_from_string( string $js ): string {
		return "<script type='text/javascript'>{$js}</script>";
	}

	/**
	 * Returns the assets suffix which determines whether assets should be enqueued minified or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $constant_name  The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  string
	 */
	public static function get_assets_minified_state( string $constant_name = 'SCRIPT_DEBUG' ): string {
		return Requests::has_debug( $constant_name ) ? '' : '.min';
	}
}
