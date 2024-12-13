<?php

namespace DeepWebSolutions\Framework;

\defined( 'ABSPATH' ) || exit;

// region META

/**
 * Returns the helpers component's basename.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  string
 */
function get_helpers_basename() {
	$basename = \constant( __NAMESPACE__ . '\HELPERS_BASENAME' );
	\assert( \is_string( $basename ) );

	return $basename;
}

/**
 * Returns the helpers component's directory path.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  string
 */
function get_helpers_dir_path() {
	$dir_path = \constant( __NAMESPACE__ . '\HELPERS_DIR_PATH' );
	\assert( \is_string( $dir_path ) );

	return $dir_path;
}

/**
 * Returns the helpers component's directory URL.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  string
 */
function get_helpers_dir_url() {
	$dir_url = \constant( __NAMESPACE__ . '\HELPERS_DIR_URL' );
	\assert( \is_string( $dir_url ) );

	return $dir_url;
}

/**
 * Returns the helpers component's metadata.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @phpstan-type PluginMetaData array{Name: string, PluginURI: string, Version: string, Description: string, Author: string, AuthorURI: string, TextDomain: string, DomainPath: string, Network: bool, Title: string, AuthorName: string, RequiresPHP: string, RequiresWP: string}
 * @template PluginMetaKey of key-of<PluginMetaData>
 *
 * @param PluginMetaKey|null $property Optional. The property to return. Default returns all metadata.
 *
 * @return  ($property is null ? PluginMetaData : ($property is PluginMetaKey ? PluginMetaData[PluginMetaKey] : null))
 * @phpstan-ignore-next-line return.unusedType
 */
function get_helpers_metadata( $property = null ) {
	return get_plugin_metadata( get_helpers_basename(), $property );
}

/**
 * Returns the helpers component's name.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  string
 */
function get_helpers_name() {
	return \wp_sprintf(
		/* translators: %s: Author name */
		\__( '%s Framework Helpers', 'dws-wp-framework-helpers' ),
		get_whitelabel_author_name()
	);
}

/**
 * Returns the helpers component's version.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  string
 */
function get_helpers_version() {
	$version = get_helpers_metadata( 'Version' );
	\assert( \is_string( $version ) );

	return $version;
}

/**
 * Returns any errors that occurred during the helpers component's initialization.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  true|\WP_Error
 */
function get_helpers_requirements_status() {
	$requirements = \constant( __NAMESPACE__ . '\HELPERS_REQUIREMENTS' );
	\assert( $requirements instanceof \WP_Error || true === $requirements );

	return $requirements;
}

/**
 * Returns whether the helpers component has managed to initialize successfully or not in the current environment.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @return  bool
 */
function is_helpers_initialized() {
	return true === get_helpers_requirements_status();
}

// endregion
