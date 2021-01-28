<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Helpers
 */
final class Assets {
	// region CSS-specific

	/**
	 * Register a stylesheet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to the child theme's directory.
	 * @param   string  $absolute_path_stub Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media              The media query that the CSS asset should be loaded on.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_style( string $handle, string $relative_path, string $absolute_path_stub, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ): bool {
		$relative_path = self::maybe_switch_to_minified_file( $relative_path, $absolute_path_stub, '.css', $constant_name );

		$absolute_path = Files::generate_full_path( $absolute_path_stub, $relative_path );
		if ( ! Files::is_file( $absolute_path ) ) {
			return false;
		}

		return wp_register_style(
			$handle,
			str_replace( ABSPATH, '', $absolute_path ),
			$deps,
			self::maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
			$media
		);
	}

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
	 * Returns the content of a file CSS file maybe wrapped in style tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the CSS file with the content.
	 * @param   bool    $wrap   Whether the contents of the stylesheet should be wrapped in a style-tag or not.
	 *
	 * @return  string
	 */
	public static function get_stylesheet( string $path, bool $wrap = true ): string {
		$css_content = Files::load_file_contents( $path, 'css' );
		return $wrap ? self::get_stylesheet_from_string( $css_content ) : $css_content;
	}

	/**
	 * Returns the content of a CSS file, maybe wrapped in style tags, and replaces some placeholders.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path           The path to the CSS file with the content.
	 * @param   array   $placeholders   The values with which the placeholders should be replaced: {placeholder} => {value}.
	 * @param   bool    $wrap           Whether the contents of the stylesheet should be wrapped in a style-tag or not.
	 *
	 * @return  string
	 */
	public static function get_stylesheet_with_variables( string $path, array $placeholders, bool $wrap = true ): string {
		$content = self::get_stylesheet( $path, $wrap );
		return Strings::replace_placeholders( $placeholders, $content );
	}

	// endregion

	// region JS-specific

	/**
	 * Register a JavaScript file.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to the child theme's directory.
	 * @param   string  $absolute_path_stub Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer          Whether the file should be enqueued to the footer or header of the site.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_script( string $handle, string $relative_path, string $absolute_path_stub, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ): bool {
		$relative_path = self::maybe_switch_to_minified_file( $relative_path, $absolute_path_stub, '.js', $constant_name );

		$absolute_path = Files::generate_full_path( $absolute_path_stub, $relative_path );
		if ( ! Files::is_file( $absolute_path ) ) {
			return false;
		}

		return wp_register_script(
			$handle,
			str_replace( ABSPATH, '', $absolute_path ),
			$deps,
			self::maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
			$in_footer
		);
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
	 * Returns the content of a file JS file maybe wrapped in script tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the JS file with the content.
	 * @param   bool    $wrap   Whether the contents of the stylesheet should be wrapped in a script-tag or not.
	 *
	 * @return  string
	 */
	public static function get_javascript( $path, bool $wrap = true ): string {
		$js_content = esc_js( Files::load_file_contents( $path, 'js' ) );
		return $wrap ? self::get_javascript_from_string( $js_content ) : $js_content;
	}

	/**
	 * Returns the content of a JS file, maybe wrapped in script tags, and replaces some placeholders.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path           The path to the JS file with the content.
	 * @param   array   $placeholders   The values with which the placeholders should be replaced: {placeholder} => {value}.
	 * @param   bool    $wrap           Whether the contents of the stylesheet should be wrapped in a style-tag or not.
	 *
	 * @return  bool|string     True if the content should be echoed, the content itself otherwise.
	 */
	public static function get_javascript_with_variables( string $path, array $placeholders, bool $wrap = true ): string {
		$content = self::get_javascript( $path, $wrap );
		return Strings::replace_placeholders( $placeholders, $content );
	}

	// endregion

	// region ENQUEUING HELPERS

	/**
	 * Register a stylesheet that exists in the child theme.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to the child theme's directory.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media              The media query that the CSS asset should be loaded on.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_child_theme_style( string $handle, string $relative_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ): bool {
		return self::register_style( $handle, $relative_path, get_stylesheet_directory(), $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Register a stylesheet that exists in a plugin.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to the plugin's assets directory.
	 * @param   string  $assets_directory_path  The absolute path to the plugin's assets directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be loaded on.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_plugin_style( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ): bool {
		return self::register_style( $handle, $relative_path, $assets_directory_path, $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Register a JavaScript file that exists in the child theme.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to the child theme's directory.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer          Whether the file should be enqueued to the footer or header of the site.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_child_theme_script( string $handle, string $relative_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ): bool {
		return self::register_script( $handle, $relative_path, get_stylesheet_directory(), $fallback_version, $deps, $in_footer, $constant_name );
	}

	/**
	 * Register a JavaScript file that exists in a plugin.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to the child theme's directory.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer          Whether the file should be enqueued to the footer or header of the site.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 */
	public static function register_plugin_script( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ): bool {
		return self::register_script( $handle, $relative_path, $assets_directory_path, $fallback_version, $deps, $in_footer, $constant_name );
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
		return ( defined( $constant_name ) && constant( $constant_name ) ) ? '' : '.min';
	}

	/**
	 * Maybe updates the relative path such that it loads the minified version of the file, if it exists and minification
	 * enqueuing is active.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $relative_path          The relative path to the assets file.
	 * @param   string  $absolute_path_stub     The absolute path to the theme/plugin.
	 * @param   string  $extension              The extension of the assets file, including the ".".
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  string  The updated relative path.
	 */
	private static function maybe_switch_to_minified_file( string $relative_path, string $absolute_path_stub, string $extension, string $constant_name = 'SCRIPT_DEBUG' ): string {
		$suffix = self::get_assets_minified_state( $constant_name );
		if ( ! empty( $suffix ) && strpos( $relative_path, $suffix ) === false ) {
			$minified_relative_path = str_replace( $extension, "{$suffix}{$extension}", $relative_path );
			if ( Files::is_file( Files::generate_full_path( $absolute_path_stub, $minified_relative_path ) ) ) {
				$relative_path = $minified_relative_path;
			}
		}

		return $relative_path;
	}

	/**
	 * Tries to generate an asset file's version based on its last modified time.
	 * If that fails, defaults to the fallback versioning.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $absolute_path      The absolute path to an asset file.
	 * @param   string  $fallback_version   The fallback version in case reading the mtime fails.
	 *
	 * @return  string
	 */
	private static function maybe_generate_mtime_version_string( string $absolute_path, string $fallback_version ): string {
		$version = Files::get_modified_time( $absolute_path );
		return ( 0 === $version ) ? $fallback_version : strval( $version );
	}

	// endregion
}
