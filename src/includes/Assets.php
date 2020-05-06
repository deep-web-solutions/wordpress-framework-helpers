<?php

namespace DeepWebSolutions\Framework\Helpers\v1_0_0;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\Framework\Helpers\v1_0_0
 */
final class Assets {
	/**
	 * Returns the content of a file inside CSS style tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the CSS file with the content.
	 *
	 * @return  string
	 */
	public static function get_stylesheet( $path ) {
		ob_start();

		echo '<style type="text/css">';

		/* @noinspection PhpIncludeInspection */
		include $path;

		echo '</style>';

		return ob_get_clean();
	}

	/**
	 * Returns the content of a file, wrapped in CSS tags, and replaces some placeholders.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path           The path to the CSS file with the content.
	 * @param   array   $placeholders   The values with which the placeholders should be replaced: {placeholder} => {value}.
	 *
	 * @return  string
	 */
	public static function get_stylesheet_with_variables( string $path, array $placeholders ) {
		$content = self::get_stylesheet( $path );
		return Strings::replace_placeholders( $placeholders, $content );
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
	public static function get_stylesheet_from_string( $css ) {
		ob_start();

		echo '<style type="text/css">';
		echo $css;
		echo '</style>';

		return ob_get_clean();
	}

	/**
	 * Sometimes we need to add inline CSS to handles which are not registered at all.
	 * This creates a dummy handle to allow for custom CSS output.
	 *
	 * @param   string  $handle     The fake handle to which the inline content should be added.
	 * @param   string  $css        The CSS content to be added inline.
	 */
	public static function add_inline_stylesheet_to_false_handle( string $handle, string $css ) {
		wp_register_style( $handle, false, array(), '1.0.0' );
		wp_enqueue_style( $handle );
		wp_add_inline_style( $handle, $css );
	}

	/**
	 * Returns the content of a file wrapped in JS tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path   The path to the JS file with the content.
	 * @param   bool    $echo   True if the content should be echoed, false if returned.
	 *
	 * @return  bool|string     True if the content should be echoed, the content itself otherwise.
	 */
	public static function get_javascript($path, $echo = false) {
		ob_start();

		echo '<script type="text/javascript">';
		/** @noinspection PhpIncludeInspection */
		include($path);
		echo '</script>';

		if ($echo) {
			echo ob_get_clean();
			return true;
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Returns the content of a JS file wrapped in JS tags,
	 * and replaces placeholders.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $path           The path to the JS file with the content.
	 * @param   array   $placeholders   The values with which the placeholders should be replaced: {placeholder} => {value}
	 * @param   bool    $echo           True if the content should be echoed, false if returned.
	 *
	 * @return  bool|string     True if the content should be echoed, the content itself otherwise.
	 */
	public static function get_javascript_with_variables($path, $placeholders, $echo = false) {
		$content = self::get_javascript($path);
		$result  = self::replace_placeholders($placeholders, $content);

		if ($echo) {
			echo $result;
			return true;
		} else {
			return $result;
		}
	}

	/**
	 * Wraps a string in JS tags.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $js     The JS content.
	 * @param   bool    $echo   True if the content should be echoed, false if returned.
	 *
	 * @return  bool|string     True if the content should be echoed, the content itself otherwise.
	 */
	public static function get_javascript_from_string($js, $echo = false) {
		ob_start();

		echo '<script type="text/javascript">';
		echo $js;
		echo '</script>';

		if ($echo) {
			echo ob_get_clean();
			return true;
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Sometimes we need to add inline JS to handles which are not registered at all.
	 * This creates a dummy handle to allow for custom JS output.
	 *
	 * @param   string  $handle     The fake handle to which the inline content should be added.
	 * @param   string  $js         The JS to be added inline.
	 */
	public static function add_inline_script_to_false_handle($handle, $js) {
		// todo: the trick from inline css doesn't work for JS, this is a workaround for now
		wp_add_inline_script(DWS_Public::get_asset_handle(), $js);
	}
}