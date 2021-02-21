<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

use DeepWebSolutions\Framework\Helpers\PHP\Arrays;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP misc helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Misc {
	/**
	 * Recursive version of WP's own 'wp_parse_args' in order to handle multi-dimensional arrays.
	 * In this implementation, non-associative arrays are also leaves.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $args       The arguments to parse.
	 * @param   array   $defaults   The default arguments.
	 *
	 * @see     https://mekshq.com/recursive-wp-parse-args-wordpress-function/
	 *
	 * @return  array
	 */
	public static function wp_parse_args_recursive( array &$args, array $defaults ): array {
		$result = $defaults;

		foreach ( $args as $k => &$v ) {
			$result[ $k ] = ( is_array( $v ) && isset( $result[ $k ] ) && Arrays::has_string_keys( $v ) )
				? self::wp_parse_args_recursive( $v, $result[ $k ] )
				: $v;
		}

		return $result;
	}
}
