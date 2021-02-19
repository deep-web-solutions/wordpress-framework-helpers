<?php

namespace DeepWebSolutions\Framework\Helpers\PHP;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful validation and sanitization helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP
 */
final class Filtering {
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
