<?php

namespace DeepWebSolutions\Framework\Helpers\v1_0_0;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful file system helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\Framework\Helpers\v1_0_0
 */
final class Files {
	// region PUBLIC

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
		if ( ! is_dir( $directory ) ) {
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