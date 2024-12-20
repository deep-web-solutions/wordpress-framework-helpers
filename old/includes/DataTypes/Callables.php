<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful callable helpers to be used throughout the projects.
 *
 * @since   1.4.0
 * @version 1.7.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Callables {
	/**
	 * If given a callable, returns the return value of said callable otherwise the passed value itself.
	 *
	 * @since   1.4.0
	 * @version 1.7.0
	 *
	 * @param   callable|mixed $maybe_callable     Variable to maybe evaluate.
	 * @param   array          $args               Arguments to pass on to the callable. No arguments by default.
	 *
	 * @return  mixed
	 */
	public static function maybe_resolve( $maybe_callable, array $args = array() ) {
		$callable = self::validate( $maybe_callable );
		return \is_null( $callable ) ? $maybe_callable : \call_user_func_array( $maybe_callable, $args );
	}
}
