<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful integer helpers to be used throughout the projects.
 *
 * @since   1.4.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Integers {


	/**
	 * Attempts to resolve a potential callable to an integer.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 *
	 * @param   mixed|callable $integer    Potential callable to resolve.
	 * @param   int|null       $default    Default value to return on failure. By default null.
	 * @param   array          $args       Arguments to pass on to the callable. By default none.
	 *
	 * @return  int|null
	 */
	public static function resolve( $integer, ?int $default = null, array $args = array() ): ?int {
		return self::maybe_cast( Callables::maybe_resolve( $integer, $args ), $default );
	}
}
