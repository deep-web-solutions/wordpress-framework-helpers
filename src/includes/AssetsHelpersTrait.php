<?php

namespace DeepWebSolutions\Framework\Helpers;

use DeepWebSolutions\Framework\Helpers\DataTypes\Arrays;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;
use DeepWebSolutions\Framework\Helpers\FileSystem\Files;
use DeepWebSolutions\Framework\Helpers\FileSystem\FilesystemAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the assets-helpers-aware interface.
 *
 * @since   1.0.0
 * @version 1.5.2
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
trait AssetsHelpersTrait {
	// region TRAITS

	use FilesystemAwareTrait;

	// endregion

	// region METHODS

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.0.0
	 * @version 1.5.0
	 */
	public function get_asset_handle( string $name = '', $extra = array(), string $root = 'dws-framework-helpers' ): string {
		return Strings::to_safe_string(
			\join(
				'_',
				\array_filter(
					\array_merge(
						array( $root, $name ),
						Arrays::validate( $extra, array( $extra ) )
					)
				)
			),
			array(
				' '  => '-',
				'/'  => '-',
				'\\' => '-',
			)
		);
	}

	/**
	 * Returns the path to a minified version of a given asset, if it exists.
	 *
	 * @since   1.5.1
	 * @version 1.5.2
	 *
	 * @param   string  $relative_path  Path of the asset relative to the WordPress root directory.
	 * @param   string  $constant_name  Constant which if set and true, the unminified path will always be returned.
	 *
	 * @return  string
	 */
	protected function maybe_get_minified_asset_path( string $relative_path, string $constant_name = 'SCRIPT_DEBUG' ): string {
		$minified_suffix = Assets::maybe_get_minified_suffix( $constant_name );
		if ( ! empty( $minified_suffix ) && false === \strpos( $relative_path, $minified_suffix ) ) {
			$wp_filesystem = $this->get_wp_filesystem();
			if ( ! \is_null( $wp_filesystem ) ) {
				$abs_path  = Files::generate_full_path( $wp_filesystem->abspath(), $relative_path );
				$extension = Strings::maybe_prefix( \pathinfo( $abs_path, PATHINFO_EXTENSION ), '.' ); // pathinfo returns the extension without the dot

				$minified_rel_path = Strings::maybe_suffix( Strings::maybe_unsuffix( $relative_path, $extension ), $minified_suffix . $extension );
				$minified_abs_path = Files::generate_full_path( $wp_filesystem->abspath(), $minified_rel_path );

				if ( $wp_filesystem->is_file( $minified_abs_path ) ) {
					$relative_path = $minified_rel_path;
				}
			}
		}

		return $relative_path;
	}

	/**
	 * Tries to generate an asset's version string based on its disk modified time.
	 *
	 * @since   1.5.1
	 * @version 1.5.1
	 *
	 * @param   string  $relative_path      Path of the asset relative to the WordPress root directory.
	 * @param   string  $fallback_version   Fallback version string to return if retrieving the modified time fails.
	 *
	 * @return  string
	 */
	protected function maybe_get_asset_mtime_version( string $relative_path, string $fallback_version ): string {
		$wp_filesystem = $this->get_wp_filesystem();
		if ( ! \is_null( $wp_filesystem ) ) {
			$mtime = $wp_filesystem->mtime( Files::generate_full_path( $wp_filesystem->abspath(), $relative_path ) );
			return ! empty( $mtime ) ? \strval( $mtime ) : $fallback_version;
		}

		return $fallback_version;
	}

	// endregion
}
