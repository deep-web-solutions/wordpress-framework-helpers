<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful callable helpers to be used throughout the projects.
 *
 * @since   1.4.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Callables {
	/**
	 * Returns a given variable if it is a callable or a default value if not.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 *
	 * @param   mixed           $callable   Variable to check.
	 * @param   callable|null   $default    The default value to return if check fails.
	 *
	 * @return  callable|null
	 */
	public static function check( $callable, ?callable $default = null ): ?callable {
		return \is_callable( $callable ) ? $callable : $default;
	}

	/**
	 * Attempts to validate a variable of unknown type as a callable.
	 *
	 * @since   1.0.0
	 * @since   1.4.0   Moved to the Callables class.
	 * @version 1.4.0
	 *
	 * @param   mixed           $callable   Variable to validate.
	 * @param   callable|null   $default    The default value to return if all fails.
	 *
	 * @return  callable|null
	 */
	public static function validate( $callable, ?callable $default = null ): ?callable {
		if ( ! \is_null( self::check( $callable ) ) ) {
			return $callable;
		} elseif ( \is_string( $callable ) ) {
			return self::check( \trim( $callable ), $default );
		}

		return $default;
	}

	/**
	 * If given a callable, returns the return value of said callable otherwise the passed value itself.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 *
	 * @param   callable|mixed  $maybe_callable     Variable to maybe evaluate.
	 * @param   array           $args               Arguments to pass on to the callable. No arguments by default.
	 *
	 * @return  mixed
	 */
	public static function maybe_resolve( $maybe_callable, array $args = array() ) {
		return self::check( $maybe_callable ) ? \call_user_func_array( $maybe_callable, $args ) : $maybe_callable;
	}
}
