<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

use DeepWebSolutions\Framework\Helpers\Security\Validation;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful boolean helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.3.1
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Booleans {
	/**
	 * Useful class for calls to functional programming constructs, such as 'array_reduce'. Returns the logical or result
	 * of the two parameters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $boolean1   The first boolean value.
	 * @param   bool    $boolean2   The second boolean value.
	 *
	 * @return  bool    The result of "or-ing" the two boolean parameters.
	 */
	public static function logical_or( bool $boolean1, bool $boolean2 ): bool {
		return $boolean1 || $boolean2;
	}

	/**
	 * Useful class for calls to functional programming constructs, such as 'array_reduce'. Returns the logical or result
	 * of the two parameters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $boolean1   The first boolean value.
	 * @param   bool    $boolean2   The second boolean value.
	 *
	 * @return  bool    The result of "and-ing" the two boolean parameters.
	 */
	public static function logical_and( bool $boolean1, bool $boolean2 ): bool {
		return $boolean1 && $boolean2;
	}

	/**
	 * Attempts to resolve a potential callable value to a boolean.
	 *
	 * @since   1.3.0
	 * @version 1.3.1
	 *
	 * @param   mixed|callable  $bool       Callable to resolve.
	 * @param   bool            $default    Default value to return on failure.
	 *
	 * @return  bool
	 */
	public static function resolve( $bool, bool $default ): bool {
		$bool = \is_callable( $bool ) ? \call_user_func( $bool ) : $bool;
		return Validation::validate_boolean( $bool, $default );
	}
}
