<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

use DeepWebSolutions\Framework\Helpers\DataTypes\Arrays;

\defined( 'ABSPATH' ) || exit;

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

		foreach ( $args as $key => &$value ) {
			$result[ $key ] = ( \is_array( $value ) && isset( $result[ $key ] ) && Arrays::has_string_keys( $result[ $key ] ) )
				? self::wp_parse_args_recursive( $value, $result[ $key ] )
				: $value;
		}

		return $result;
	}

	/**
	 * Returns the UNIX timestamp of today's midnight adjusted to a specific timezone.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string|null     $timezone_string    Optional timezone string. If not provided, will use the website's own timezone.
	 *
	 * @return  int
	 */
	public static function get_midnight_unix_timestamp( ?string $timezone_string = null ): int {
		$timezone_string = $timezone_string ?: \get_option( 'timezone_string' ); // phpcs:ignore
		return \strtotime( \sprintf( 'today midnight %s', $timezone_string ) );
	}
}
