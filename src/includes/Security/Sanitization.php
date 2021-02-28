<?php

namespace DeepWebSolutions\Framework\Helpers\Security;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful sanitization helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\Security
 */
final class Sanitization {
	/**
	 * Sanitizes an int-like value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $integer    Value to sanitize.
	 * @param   int     $default    The default value to return if all fails. By default 0.
	 *
	 * @return  int
	 */
	public static function sanitize_integer( $integer, int $default = 0 ): int {
		return Validation::validate_integer(
			filter_var( $integer, FILTER_SANITIZE_NUMBER_INT ),
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
		return Validation::validate_integer(
			filter_input( $input_type, $variable_name, FILTER_SANITIZE_NUMBER_INT ),
			$default
		);
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
		return Validation::validate_float(
			filter_var( $float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC ),
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
		return Validation::validate_float(
			filter_input( $input_type, $variable_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC ),
			$default
		);
	}
}
