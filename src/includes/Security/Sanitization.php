<?php

namespace DeepWebSolutions\Framework\Helpers\Security;

use DeepWebSolutions\Framework\Helpers\DataTypes\Floats;
use DeepWebSolutions\Framework\Helpers\DataTypes\Integers;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful sanitization helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.3.2
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\Security
 */
final class Sanitization {
	// region METHODS

	/**
	 * Sanitizes a string.
	 *
	 * @since   1.3.2
	 * @version 1.4.0
	 *
	 * @param   mixed   $string     Value to sanitize.
	 * @param   string  $default    The default value to return if all fails. By default the empty string.
	 * @param   int     $flags      Flags supported by the used filter.
	 * @param   int     $filter     One of the sanitization filters supported by PHP.
	 *
	 * @return  string
	 */
	public static function sanitize_string( $string, string $default = '', int $flags = FILTER_FLAG_STRIP_LOW, int $filter = FILTER_SANITIZE_STRING ): string {
		return \filter_var( Strings::maybe_cast( $string, $default ), $filter, $flags );
	}

	/**
	 * Sanitizes a string from an input stream.
	 *
	 * @since   1.3.2
	 * @version 1.3.2
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   string  $default        The default value to return if all fails. By default the empty string.
	 * @param   int     $flags          Flags supported by the used filter.
	 * @param   int     $filter         One of the sanitization filters supported by PHP.
	 *
	 * @return  string
	 */
	public static function sanitize_string_input( int $input_type, string $variable_name, string $default = '', int $flags = FILTER_FLAG_STRIP_LOW, int $filter = FILTER_SANITIZE_STRING ): string {
		return \filter_has_var( $input_type, $variable_name )
			? self::sanitize_string( \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW ), $default, $flags, $filter )
			: $default;
	}

	/**
	 * Sanitizes an int-like value.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   mixed   $integer    Value to sanitize.
	 * @param   int     $default    The default value to return if all fails. By default 0.
	 *
	 * @return  int
	 */
	public static function sanitize_integer( $integer, int $default = 0 ): int {
		if ( \is_string( $integer ) ) {
			$sign    = self::has_minus_before_number( $integer ) ? -1 : 1;
			$integer = Strings::to_alphanumeric_ascii_string( $integer );
		}

		return ( $sign ?? 1 ) * Integers::maybe_cast(
			\filter_var( $integer, FILTER_SANITIZE_NUMBER_INT ),
			$default
		);
	}

	/**
	 * Sanitizes an int-like value from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.3.2
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   int     $default        The default value to return if all fails. By default 0.
	 *
	 * @return  int
	 */
	public static function sanitize_integer_input( int $input_type, string $variable_name, int $default = 0 ): int {
		return \filter_has_var( $input_type, $variable_name )
			? self::sanitize_integer( \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW ), $default )
			: $default;
	}

	/**
	 * Sanitizes a float-like value.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   mixed   $float      Value to sanitize.
	 * @param   float   $default    The default value to return if all fails. By default 0.
	 *
	 * @return  float
	 */
	public static function sanitize_float( $float, float $default = 0.0 ): float {
		if ( \is_string( $float ) ) {
			$float = Strings::to_safe_string( $float, array( '+' => '' ) );

			$scientific = strpos( $float, 'E' ) !== false || strpos( $float, 'e' ) !== false;
			if ( ! $scientific ) {
				$sign  = self::has_minus_before_number( $float );
				$float = Strings::to_safe_string( $float, array( '-' => '' ) );
				$float = $sign ? "-$float" : $float;
			}
		}

		return Floats::maybe_cast(
			\filter_var( $float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC ),
			$default
		);
	}

	/**
	 * Sanitizes a float-like value from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.3.2
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   float   $default        The default value to return if all fails. By default 0.
	 *
	 * @return  float
	 */
	public static function sanitize_float_input( int $input_type, string $variable_name, float $default = 0.0 ): float {
		return \filter_has_var( $input_type, $variable_name )
			? self::sanitize_float( \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW ), $default )
			: $default;
	}

	// endregion

	// region HELPERS

	/**
	 * Checks whether a string has the '-' character before any numeric characters.
	 *
	 * @since   1.0.0
	 * @version 1.3.1
	 *
	 * @param   string  $string     String to perform the check for.
	 *
	 * @return  bool
	 */
	protected static function has_minus_before_number( string $string ): bool {
		$matches = array();

		return \preg_match( '/^([A-Z-]+)([0-9]+)(.)*$/i', $string, $matches ) && \strpos( $matches[1], '-' ) !== false;
	}

	// endregion
}
