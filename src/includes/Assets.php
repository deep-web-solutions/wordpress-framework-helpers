<?php

namespace DeepWebSolutions\Framework\Helpers;

use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;
use DeepWebSolutions\Framework\Helpers\FileSystem\Files;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.6.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class Assets {
	/**
	 * Returns the path to a minified version of a given asset, if it exists.
	 *
	 * @since   1.6.0
	 * @version 1.6.0
	 *
	 * @param   string                  $relative_path  Path of the asset relative to the WordPress root directory.
	 * @param   string                  $constant_name  Constant which, if set and true, the unminified path will always be returned.
	 * @param \WP_Filesystem_Base|null  $wp_filesystem  WordPress Filesystem object.
	 *
	 * @return  string
	 */
	public static function maybe_get_minified_path( string $relative_path, string $constant_name = 'SCRIPT_DEBUG', ?\WP_Filesystem_Base $wp_filesystem = null ): string {
		$minified_suffix = self::maybe_get_minified_suffix( $constant_name );

		if ( ! empty( $minified_suffix ) && false === \strpos( $relative_path, $minified_suffix ) ) {
			$wp_filesystem = $wp_filesystem ?? new \WP_Filesystem_Direct( false );

			$abs_path  = Files::generate_full_path( $wp_filesystem->abspath(), $relative_path );
			$extension = Strings::maybe_prefix( \pathinfo( $abs_path, PATHINFO_EXTENSION ), '.' ); // pathinfo returns the extension without the dot

			$minified_rel_path = Strings::maybe_suffix( Strings::maybe_unsuffix( $relative_path, $extension ), $minified_suffix . $extension );
			$minified_abs_path = Files::generate_full_path( $wp_filesystem->abspath(), $minified_rel_path );

			if ( $wp_filesystem->is_file( $minified_abs_path ) ) {
				$relative_path = $minified_rel_path;
			}
		}

		return $relative_path;
	}

	/**
	 * Returns a given asset's version string based on its disk modified time.
	 *
	 * @since   1.6.0
	 * @version 1.6.0
	 *
	 * @param   string  $relative_path      Path of the asset relative to the WordPress root directory.
	 * @param   string  $fallback_version   Fallback version string to return if retrieving the modified time fails.
	 * @param   \WP_Filesystem_Base|null    $wp_filesystem  WordPress Filesystem object.
	 *
	 * @return  string
	 */
	public static function maybe_get_mtime_version( string $relative_path, string $fallback_version, ?\WP_Filesystem_Base $wp_filesystem = null ): string {
		$wp_filesystem = $wp_filesystem ?? new \WP_Filesystem_Direct( false );

		$mtime = $wp_filesystem->mtime( Files::generate_full_path( $wp_filesystem->abspath(), $relative_path ) );
		return ! empty( $mtime ) ? \strval( $mtime ) : $fallback_version;
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
