<?php

namespace DeepWebSolutions\Framework\Helpers\PHP;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful file system helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP
 */
final class Files {
	// region PUBLIC

	/**
	 * Append two halves of a full-path in a way that doesn't cause double slashes.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $absolute   The absolute path to prepend.
	 * @param   string  $relative   The relative path to append to the absolute one.
	 *
	 * @return  string  Full disk path.
	 */
	public static function generate_full_path( string $absolute, string $relative ): string {
		return trailingslashit( $absolute ) . untrailingslashit( $relative );
	}

	/**
	 * Checks whether a file or directory exists and can be accessed by the current process.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the file.
	 *
	 * @return  bool
	 */
	public static function exists_and_is_readable( string $path ): bool {
		return file_exists( $path ) && is_readable( $path );
	}

	/**
	 * Checks whether a file exists and can be accessed by the current process.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the file.
	 *
	 * @return  bool
	 */
	public static function is_file( string $path ): bool {
		return self::exists_and_is_readable( $path ) && is_file( $path );
	}

	/**
	 * Checks whether a directory exists and can be accessed by the current process.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the file.
	 *
	 * @return  bool
	 */
	public static function is_directory( string $path ): bool {
		return self::exists_and_is_readable( $path ) && is_dir( $path );
	}

	/**
	 * Returns the time that a file was last modified.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the file.
	 *
	 * @return  int     The UNIX timestamp the file was last modified, or 0 on failure.
	 */
	public static function get_modified_time( string $path ): int {
		return function_exists( 'filemtime' ) && self::exists_and_is_readable( $path ) && filemtime( $path )
			? filemtime( $path ) : 0;
	}

	/**
	 * Checks if a filename has a certain extension. Does NOT actually verify whether the file exists or is actually
	 * truthful about its nature.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param   string  $filename   The path to the file, or just the filename.
	 * @param   string  $extension  The extension to check against.
	 *
	 * @return  bool    Whether the file has the expected extension or not.
	 */
	public static function has_extension( string $filename, string $extension ): bool {
		$extension = Strings::starts_with( $extension, '.' ) ? $extension : ".{$extension}";
		return Strings::ends_with( $filename, $extension );
	}

	/**
	 * Returns the contents of the file.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string          $path       The path to the file with the content.
	 * @param   string|null     $extension  Optional extension to check the file against.
	 *
	 * @return  string          Empty string if file doesn't exist or is somehow fishy, otherwise the contents of the file.
	 */
	public static function load_file_contents( string $path, string $extension = null ): string {
		if ( ! self::is_file( $path ) || ( is_string( $extension ) && ! self::has_extension( $path, $extension ) ) ) {
			return '';
		} else {
			ob_start();

			/* @noinspection PhpIncludeInspection */
			include $path;

			return ob_get_clean();
		}
	}

	/**
	 * Public facade for the self::list_files_in_directory_helper method.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $directory      The directory to search through.
	 * @param   array       $ignore         List of file names to ignore.
	 * @param   bool        $recursive      Whether to recurse through all the directories or not.
	 * @param   int         $max_depth      Maximum depth to recurse to. -1 to disable. 0-based index.
	 *
	 * @return  array   List of the relative paths of all the files inside the directory.
	 */
	public static function list_files_in_directory( string $directory, array $ignore = array( 'index.php' ), bool $recursive = true, int $max_depth = -1 ) : array {
		return self::list_files_in_directory_helper( $directory, $ignore, $recursive, $max_depth, 0 );
	}

	/**
	 * Iterates through all the files in a certain directory and loads them.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $directory  The path to the directory from which the files should be loaded from.
	 * @param   bool    $require    Whether to use the require directive or the include one.
	 * @param   array   $ignore         List of file names to ignore.
	 * @param   bool    $recursive      Whether to recurse through all the directories or not.
	 * @param   int     $max_depth      Maximum depth to recurse to. -1 to disable.
	 */
	public static function load_files_from_directory( string $directory, bool $require = true, array $ignore = array( 'index.php' ), bool $recursive = true, int $max_depth = -1 ) : void {
		$directory = trailingslashit( $directory );
		$files     = self::list_files_in_directory( $directory, $ignore, $recursive, $max_depth );

		foreach ( $files as $file ) {
			if ( $require ) {
				/* @noinspection PhpIncludeInspection */
				require_once $directory . $file;
			} else {
				/* @noinspection PhpIncludeInspection */
				include_once $directory . $file;
			}
		}
	}

	// endregion

	// region PRIVATE

	/**
	 * Gets a list of the files that exist in a certain directory.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $directory      The directory to search through.
	 * @param   array       $ignore         List of file names to ignore.
	 * @param   bool        $recursive      Whether to recurse through all the directories or not.
	 * @param   int         $max_depth      Maximum depth to recurse to. -1 to disable. 0-based index.
	 * @param   int         $depth          Current recursion level.
	 *
	 * @return  array   List of the relative paths of all the files inside the directory.
	 */
	private static function list_files_in_directory_helper( string $directory, array $ignore = array( 'index.php' ), bool $recursive = true, int $max_depth = -1, int $depth = 0 ) : array {
		$directory = trailingslashit( $directory );
		if ( ! self::is_directory( $directory ) ) {
			return array();
		}

		$template_files = scandir( $directory );
		unset( $template_files[ array_search( '.', $template_files, true ) ] );
		unset( $template_files[ array_search( '..', $template_files, true ) ] );

		if ( count( $template_files ) < 1 ) {
			return array();
		}

		$files = call_user_func_array(
			'array_merge',
			array_map(
				function ( $template_file ) use ( $directory, $ignore, $depth, $max_depth, $recursive ) {
					if ( in_array( $template_file, $ignore, true ) ) {
						return array();
					}

					$file_path = trailingslashit( $directory ) . $template_file;
					if ( ! is_dir( $file_path ) ) {
						return array( $file_path );
					}

					return $recursive && ( $depth < $max_depth || -1 === $max_depth )
						? self::list_files_in_directory_helper( $file_path, $ignore, true, $max_depth, $depth + 1 )
						: array();
				},
				$template_files
			)
		);

		// before returning for good, get rid of the original file path
		if ( 0 === $depth ) {
			$files = array_map(
				function ( $file ) use ( $directory ) {
					return str_replace( $directory, '', $file );
				},
				$files
			);
		}

		return $files;
	}

	// endregion
}
