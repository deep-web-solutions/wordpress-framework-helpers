<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful string manipulation helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Strings {
	/**
	 * Checks whether a string starts in a particular way or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $haystack   String to check.
	 * @param   string  $needle     Beginning to check against.
	 *
	 * @return  bool    True if the string starts as expected, false otherwise.
	 */
	public static function starts_with( string $haystack, string $needle ): bool {
		if ( \PHP_VERSION_ID >= 80000 && function_exists( 'str_starts_with' ) ) {
			str_starts_with( $haystack, $needle );
		}

		return substr_compare( $haystack, $needle, 0, strlen( $needle ) ) === 0;
	}

	/**
	 * Checks whether a string end in a particular way or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $haystack   String to check.
	 * @param   string  $needle     Ending to check against.
	 *
	 * @return  bool    True if the string ends as expected, false otherwise.
	 */
	public static function ends_with( string $haystack, string $needle ): bool {
		if ( \PHP_VERSION_ID >= 80000 && function_exists( 'str_ends_with' ) ) {
			return str_ends_with( $haystack, $needle );
		}

		return substr_compare( $haystack, $needle, -strlen( $needle ) ) === 0;
	}

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
	public static function replace_placeholders( array $placeholders, string $string ): string {
		return str_replace( array_keys( $placeholders ), array_values( $placeholders ), $string );
	}

	/**
	 * Transforms a string into a lowercase, safe version of itself.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $string             String to transform.
	 * @param   array   $unsafe_characters  Unsafe characters and what to replace them with.
	 *
	 * @return  string
	 */
	public static function to_safe_string( string $string, array $unsafe_characters ): string {
		return self::replace_placeholders(
			$unsafe_characters,
			strtolower( $string )
		);
	}

	/**
	 * Transforms a string into an alphanumeric version of itself by removing any non-alphanumeric characters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     https://stackoverflow.com/a/17151182
	 *
	 * @param   string  $string     The string to remove non-alphanumeric characters from.
	 *
	 * @return  string
	 */
	public static function to_alphanumeric_string( string $string ): string {
		return preg_replace( '/[^[:alnum:][:space:]]/u', '', $string );
	}

	/**
	 * Transforms the php.ini notation for numbers (like 2M) to an integer.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     http://hookr.io/functions/wc_let_to_num/
	 *
	 * @noinspection PhpMissingBreakStatementInspection
	 *
	 * @param   string  $size   The php.ini size to transform into an integer.
	 *
	 * @return  int
	 */
	public static function letter_to_number( string $size ): int {
		$letter = substr( $size, -1 );
		$return = substr( $size, 0, -1 );

		switch ( strtoupper( $letter ) ) {
			case 'P': // phpcs:ignore
				$return *= 1024;
			case 'T': // phpcs:ignore
				$return *= 1024;
			case 'G': // phpcs:ignore
				$return *= 1024;
			case 'M': // phpcs:ignore
				$return *= 1024;
			case 'K': // phpcs:ignore
				$return *= 1024;
		}

		return $return;
	}
}
