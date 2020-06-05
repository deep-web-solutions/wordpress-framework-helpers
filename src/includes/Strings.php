<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful string manipulation helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\Framework\Helpers
 */
final class Strings {
	/**
	 * Takes an associate array($placeholder -> $replacement) and replaces all instances of $placeholder with $replacement
	 * inside the given string parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $placeholders   The values with which the placeholders must be replaced: {placeholder} => {value}.
	 * @param   string  $string         The string containing the placeholders.
	 *
	 * @return  string  Processed string with all the placeholders replaced.
	 */
	public static function replace_placeholders( $placeholders, $string ) {
		return str_replace( array_keys( $placeholders ), array_values( $placeholders ), $string );
	}
}