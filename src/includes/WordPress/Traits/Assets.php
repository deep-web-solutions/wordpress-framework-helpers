<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress\Traits;

use DeepWebSolutions\Framework\Helpers\PHP\Files;
use DeepWebSolutions\Framework\Helpers\WordPress\Assets as AssetsHelpers;

defined( 'ABSPATH' ) || exit;

/**
 * Defines useful methods for working with WP's assets system.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress\Traits
 */
trait Assets {
	use Filesystem;

	// region METHODS

	/**
	 * Returns a meaningful, hopefully unique, handle for an asset.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The actual descriptor of the asset's purpose. Leave blank for default.
	 * @param   array   $extra  Further descriptor of the asset's purpose.
	 * @param   string  $root   Prepended to all asset handles inside the same class.
	 *
	 * @return  string
	 */
	public function get_asset_handle( string $name = '', array $extra = array(), string $root = '' ): string {
		return str_replace(
			array( ' ', '/', '\\' ),
			array( '-', '', '' ),
			strtolower(
				join(
					'_',
					array_filter(
						array_merge(
							array( $root, $name ),
							$extra
						)
					)
				)
			)
		);
	}

	/**
	 * Register a stylesheet.
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to the child theme's directory.
	 * @param   string  $assets_directory_path  Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be loaded on.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function register_style( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ): bool {
		$relative_path = $this->maybe_switch_to_minified_file( $relative_path, $assets_directory_path, '.css', $constant_name );

		$wp_filesystem = $this->get_wp_filesystem();
		$absolute_path = Files::generate_full_path( $assets_directory_path, $relative_path );
		if ( is_null( $wp_filesystem ) || ! $wp_filesystem->is_file( $absolute_path ) ) {
			return false;
		}

		return wp_register_style(
			$handle,
			str_replace( $wp_filesystem->abspath(), '', $absolute_path ),
			$deps,
			self::maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
			$media
		);
	}

	/**
	 * Register a JavaScript file.
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to the child theme's directory.
	 * @param   string  $assets_directory_path  Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the file should be enqueued to the footer or header of the site.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  bool
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function register_script( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ): bool {
		$relative_path = $this->maybe_switch_to_minified_file( $relative_path, $assets_directory_path, '.js', $constant_name );

		$wp_filesystem = $this->get_wp_filesystem();
		$absolute_path = Files::generate_full_path( $assets_directory_path, $relative_path );
		if ( is_null( $wp_filesystem ) || ! $wp_filesystem->is_file( $absolute_path ) ) {
			return false;
		}

		return wp_register_script(
			$handle,
			str_replace( $wp_filesystem->abspath(), '', $absolute_path ),
			$deps,
			self::maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
			$in_footer
		);
	}

	/**
	 * Register and enqueue a JavaScript file.
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to the child theme's directory.
	 * @param   string  $assets_directory_path  Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the file should be enqueued to the footer or header of the site.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @version 1.0.0
	 *
	 * @since   1.0.0
	 */
	public function enqueue_script( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ): void {
		$this->register_script( $handle, $relative_path, $assets_directory_path, $fallback_version, $deps, $in_footer, $constant_name );
		wp_enqueue_script( $handle );
	}

	/**
	 * Register and enqueue a stylesheet.
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to the child theme's directory.
	 * @param   string  $assets_directory_path  Absolute path that should be prepended to the relative path to get the full path.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be loaded on.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @version 1.0.0
	 *
	 * @since   1.0.0
	 */
	public function enqueue_style( string $handle, string $relative_path, string $assets_directory_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ): void {
		$this->register_style( $handle, $relative_path, $assets_directory_path, $fallback_version, $deps, $media, $constant_name );
		wp_enqueue_style( $handle );
	}

	// endregion

	// region HELPERS

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
	protected function maybe_switch_to_minified_file( string $relative_path, string $absolute_path_stub, string $extension, string $constant_name = 'SCRIPT_DEBUG' ): string {
		$suffix = AssetsHelpers::get_assets_minified_state( $constant_name );
		if ( ! empty( $suffix ) && strpos( $relative_path, $suffix ) === false ) {
			$minified_relative_path = str_replace( $extension, "{$suffix}{$extension}", $relative_path );
			$wp_filesystem          = $this->get_wp_filesystem();

			if ( $wp_filesystem && $wp_filesystem->is_file( Files::generate_full_path( $absolute_path_stub, $minified_relative_path ) ) ) {
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
	protected function maybe_generate_mtime_version_string( string $absolute_path, string $fallback_version ): string {
		$wp_filesystem = $this->get_wp_filesystem();
		$version       = $wp_filesystem ? $wp_filesystem->mtime( $absolute_path ) : false;

		return ( empty( $version ) ) ? $fallback_version : strval( $version );
	}

	// endregion
}
