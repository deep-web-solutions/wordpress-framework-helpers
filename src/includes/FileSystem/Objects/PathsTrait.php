<?php

namespace DeepWebSolutions\Framework\Helpers\FileSystem\Objects;

defined( 'ABSPATH' ) || exit;

/**
 * Defines a few short-hand methods for retrieving file system and URL paths.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\FileSystem\Objects
 */
trait PathsTrait {
	use ReflectionTrait;

	// region METHODS

	/**
	 * Returns the path to the current folder of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   bool    $keep_file_name     If true, then returns the path including the end filename.
	 *
	 * @return  string
	 */
	final public static function get_base_path( bool $keep_file_name = false ): string {
		$file_name = self::get_file_name();

		return $keep_file_name
			? trailingslashit( $file_name )
			: trailingslashit( plugin_dir_path( $file_name ) );
	}

	/**
	 * Returns the relative URL to the current folder of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   bool    $keep_file_name     If true, then returns the URL including the end filename.
	 *
	 * @return  string
	 */
	final public static function get_base_relative_url( bool $keep_file_name = false ): string {
		$file_name = self::get_file_name();

		$relative_url = $keep_file_name
			? str_replace( ABSPATH, '', trailingslashit( $file_name ) )
			: trailingslashit( plugin_dir_url( $file_name ) );

		// Fix for operating systems where the directory separator is not a forward slash.
		return str_replace( array( site_url(), DIRECTORY_SEPARATOR ), array( '', '/' ), $relative_url );
	}

	/**
	 * Returns the path to a custom file or directory prepended by the path to the using class' path.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path       The path to append to the current file's base path.
	 *
	 * @return  string
	 */
	final public static function get_custom_base_path( string $path ): string {
		return trailingslashit( self::get_base_path() . $path );
	}

	/**
	 * Returns the relative URL to a custom file or directory prepended by the path to the using class' path.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path       The path to append to the current file's base path.
	 *
	 * @return  string
	 */
	final public static function get_custom_base_relative_url( string $path ): string {
		return trailingslashit( self::get_base_relative_url() . $path );
	}

	// endregion
}
