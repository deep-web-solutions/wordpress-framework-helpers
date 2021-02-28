<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress\Assets;

use DeepWebSolutions\Framework\Helpers\WordPress\Request;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress\Assets
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
	public static function wrap_string_in_style_tags( string $css ): string {
		return "<style type='text/css'>{$css}</style>";
	}

	/**
	 * Returns a string wrapped in JS tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $javascript     The JS content.
	 *
	 * @return  string
	 */
	public static function wrap_string_in_script_tags( string $javascript ): string {
		return "<script type='text/javascript'>{$javascript}</script>";
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
	public static function maybe_get_minified_suffix( string $constant_name = 'SCRIPT_DEBUG' ): string {
		return Request::has_debug( $constant_name ) ? '' : '.min';
	}
}
