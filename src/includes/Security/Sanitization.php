<?php

namespace DeepWebSolutions\Framework\Helpers\Security;

use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful sanitization helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\Security
 */
final class Sanitization {
	// region METHODS

	/**
	 * Sanitizes an int-like value.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
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

		return ( $sign ?? 1 ) * Validation::validate_integer(
			\filter_var( $integer, FILTER_SANITIZE_NUMBER_INT ),
			$default
		);
	}

	/**
	 * Sanitizes an int-like value from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   int     $default        The default value to return if all fails. By default 0.
	 *
	 * @return  int
	 */
	public static function sanitize_integer_input( int $input_type, string $variable_name, int $default = 0 ): int {
		$value = \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW );
		return self::sanitize_integer( $value, $default );
	}

	/**
	 * Sanitizes a float-like value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
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
				$float = $sign ? "-{$float}" : $float;
			}
		}

		return Validation::validate_float(
			\filter_var( $float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC ),
			$default
		);
	}

	/**
	 * Sanitizes a float-like value from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   float   $default        The default value to return if all fails. By default 0.
	 *
	 * @return  float
	 */
	public static function sanitize_float_input( int $input_type, string $variable_name, float $default = 0.0 ): float {
		$value = \filter_input( $input_type, $variable_name, FILTER_UNSAFE_RAW );
		return self::sanitize_float( $value, $default );
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
