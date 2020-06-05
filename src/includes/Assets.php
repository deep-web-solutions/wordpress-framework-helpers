<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP asset handling helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\Framework\Helpers
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
		$result  = Strings::replace_placeholders($placeholders, $content);

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
}