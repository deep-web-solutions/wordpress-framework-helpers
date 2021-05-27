<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

use DeepWebSolutions\Framework\Helpers\Security\Sanitization;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful string manipulation helpers to be used throughout the projects.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 *
 * @since   1.0.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Strings {
	/**
	 * Returns a given variable if it is a string or a default value if not.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 *
	 * @param   mixed           $string     Variable to check.
	 * @param   string|null     $default    The default value to return if check fails. By default null.
	 *
	 * @return  string|null
	 */
	public static function check( $string, ?string $default = null ): ?string {
		return \is_string( $string ) ? $string : $default;
	}

	/**
	 * Attempts to turn a variable of unknown type into a string.
	 *
	 * @since   1.3.1
	 * @since   1.4.0   Moved to the Strings class.
	 * @version 1.4.0
	 *
	 * @param   mixed           $string     Variable to cast.
	 * @param   string|null     $default    The default value to return if all fails.
	 *
	 * @return  string|null
	 */
	public static function cast( $string, ?string $default = '' ): ?string {
		if ( ! \is_null( self::check( $string ) ) ) {
			return $string;
		} elseif ( \is_null( Arrays::check( $string ) ) && ( \is_null( Objects::check( $string ) || \method_exists( $string, '__toString' ) ) ) ) {
			return \strval( $string );
		}

		return $default;
	}

	/**
	 * Attempts to cast a variable from an input stream into an integer.
	 *
	 * @since   1.3.1
	 * @since   1.4.0   Moved to the Strings class.
	 * @version 1.4.0
	 *
	 * @param   int         $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string      $variable_name  Name of a variable to get from the input stream.
	 * @param   string|null $default        The default value to return if all fails. By default null.
	 *
	 * @return  string|null
	 */
	public static function cast_input( int $input_type, string $variable_name, ?string $default = null ): ?string {
		if ( \filter_has_var( $input_type, $variable_name ) ) {
			$integer = \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW, FILTER_REQUIRE_SCALAR );
			return self::cast( $integer, $default );
		}

		return $default;
	}

	/**
	 * Attempts to resolve a potential callable to a string.
	 *
	 * @since   1.3.0
	 * @since   1.4.0   Moved to the Strings class.
	 * @version 1.4.0
	 *
	 * @param   mixed|callable  $string     Potential callable to resolve.
	 * @param   string|null     $default    Default value to return on failure. By default null.
	 * @param   array           $args       Arguments to pass on to the callable. By default none.
	 *
	 * @return  string|null
	 */
	public static function resolve( $string, ?string $default = null, array $args = array() ): ?string {
		return self::cast( Callables::maybe_resolve( $string, $args ), $default );
	}

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
		if ( \PHP_VERSION_ID >= 80000 && \function_exists( '\str_starts_with' ) ) {
			\str_starts_with( $haystack, $needle );
		}

		return \substr_compare( $haystack, $needle, 0, \strlen( $needle ) ) === 0;
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
		if ( \PHP_VERSION_ID >= 80000 && \function_exists( '\str_ends_with' ) ) {
			return \str_ends_with( $haystack, $needle );
		}

		return '' === $needle || \substr_compare( $haystack, $needle, -\strlen( $needle ) ) === 0;
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
		return \str_replace( \array_keys( $placeholders ), \array_values( $placeholders ), $string );
	}

	/**
	 * Transforms a string into a lowercase, safe version of itself.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @param   string  $string             String to transform.
	 * @param   array   $unsafe_characters  Unsafe characters and what to replace them with.
	 *
	 * @return  string
	 */
	public static function to_safe_string( string $string, array $unsafe_characters = array() ): string {
		return \strtolower( self::to_ascii_input_string( self::replace_placeholders( $unsafe_characters, $string ) ) );
	}

	/**
	 * Transforms a string into an alphanumeric version of itself by removing any non-alphanumeric characters. Supports
	 * all unicode characters.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @see     https://stackoverflow.com/a/17151182
	 *
	 * @param   string  $string     The string to remove non-alphanumeric characters from.
	 *
	 * @return  string
	 */
	public static function to_alphanumeric_unicode_string( string $string ): string {
		return \preg_replace( '/[^[:alnum:][:space:]]/u', '', $string );
	}

	/**
	 * Removes all non-ASCII characters and all non-alphanumeric ASCII characters from a string and returns the result.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @see     https://stackoverflow.com/a/17151182
	 *
	 * @param   string  $string     The string to remove non-alphanumeric characters from.
	 *
	 * @return  string
	 */
	public static function to_alphanumeric_ascii_string( string $string ): string {
		return \preg_replace( '/[^A-Za-z0-9 ]/', '', $string );
	}

	/**
	 * Removes all non-ASCII characters and all non-user-input ASCII characters (like null bytes and control characters)
	 * and returns the result.
	 *
	 * @since   1.1.0
	 * @version 1.3.2
	 *
	 * @param   string  $string     The string to remove the characters from.
	 *
	 * @return  string
	 */
	public static function to_ascii_input_string( string $string ): string {
		return Sanitization::sanitize_string( $string, '', FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH );
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
		$letter = \substr( $size, -1 );
		$return = \substr( $size, 0, -1 );

		switch ( \strtoupper( $letter ) ) {
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
