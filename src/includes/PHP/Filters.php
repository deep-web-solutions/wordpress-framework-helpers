<?php

namespace DeepWebSolutions\Framework\Helpers\PHP;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful validation and sanitization helpers to be used throughout the projects.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP
 */
final class Filters {
	/**
	 * Validates a bool-like value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $boolean    Value to sanitize.
	 * @param   bool    $default    The default value to return if all fails.
	 *
	 * @return  bool
	 */
	public static function validate_boolean( $boolean, bool $default ): bool {
		return filter_var( $boolean, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ?? $default;
	}

	/**
	 * Validates a bool-like variable from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   bool    $default        The default value to return if all fails.
	 *
	 * @return  bool
	 */
	public static function validate_boolean_input( int $input_type, string $variable_name, bool $default ): bool {
		return filter_input( $input_type, $variable_name, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ?? $default;
	}

	/**
	 * Validates an int-like value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $integer    Value to sanitize.
	 * @param   int     $default    The default value to return if all fails.
	 *
	 * @return  int
	 */
	public static function validate_integer( $integer, int $default ): int {
		return filter_var(
			$integer,
			FILTER_VALIDATE_INT,
			array(
				'options' => array( 'default' => $default ),
				'flags'   => FILTER_FLAG_ALLOW_OCTAL | FILTER_FLAG_ALLOW_HEX,
			)
		);
	}

	/**
	 * Validates an int-like variable from an input stream.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $input_type     One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
	 * @param   string  $variable_name  Name of a variable to get.
	 * @param   int     $default    The default value to return if all fails.
	 *
	 * @return  int
	 */
	public static function validate_integer_input( int $input_type, string $variable_name, int $default ): int {
		return filter_input(
			$input_type,
			$variable_name,
			FILTER_VALIDATE_INT,
			array(
				'options' => array( 'default' => $default ),
				'flags'   => FILTER_FLAG_ALLOW_OCTAL | FILTER_FLAG_ALLOW_HEX,
			)
		);
	}

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
		return self::validate_integer(
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
		return self::validate_integer(
			filter_input( $input_type, $variable_name, FILTER_SANITIZE_NUMBER_INT ),
			$default
		);
	}

	/**
	 * Validates a float-like value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $float      Value to sanitize.
	 * @param   float   $default    The default value to return if all fails.
	 *
	 * @return  float
	 */
	public static function validate_float( $float, float $default ): float {
		$float = filter_var( $float, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND );
		if ( false === $float ) {
			$float = filter_var( $float, FILTER_VALIDATE_FLOAT, array( 'options' => array( 'decimal' => ',' ) ) );
		}

		return $float ?: $default; // phpcs:ignore
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
		return self::validate_float(
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
		return self::validate_float(
			filter_input( $input_type, $variable_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC ),
			$default
		);
	}

	/**
	 * Validates a callback.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed       $callback   Value to sanitize.
	 * @param   callable    $default    The default value to return if all fails.
	 *
	 * @return  callable
	 */
	public static function validate_callback( $callback, callable $default ): callable {
		if ( is_string( $callback ) ) {
			$callback = trim( $callback );
			return is_callable( $callback ) ? $callback : $default;
		} elseif ( is_callable( $callback ) ) {
			return $callback;
		}

		return $default;
	}

	/**
	 * Validates a values against a whitelist.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $entry      The entry to validate.
	 * @param   array   $allowed    The list of allowed entries.
	 * @param   mixed   $default    The default value to return if all fails.
	 *
	 * @return  mixed
	 */
	public static function validate_allowed_value( $entry, array $allowed, $default ) {
		$is_allowed = in_array( $entry, $allowed, true );
		if ( false === $is_allowed && is_string( $entry ) ) {
			$entry      = trim( $entry );
			$is_allowed = in_array( $entry, $allowed, true );
		}

		return $is_allowed ? $entry : $default;
	}
}
