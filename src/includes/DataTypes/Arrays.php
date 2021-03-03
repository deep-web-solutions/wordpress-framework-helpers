<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful array manipulation helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Arrays {
	/**
	 * Checks whether an array has any string keys or if they are all numerical.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $array  The array to check.
	 *
	 * @return  bool    True if it has string keys, false otherwise.
	 */
	public static function has_string_keys( array $array ): bool {
		return count( array_filter( array_keys( $array ), 'is_string' ) ) > 0;
	}

	/**
	 * Returns all the entries in a given array that match a given needle.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   array           $array      Array to search through.
	 * @param   mixed           $needle     The value to search for.
	 * @param   bool            $strict     Whether to perform type checks or not.
	 * @param   callable|null   $callback   Optional callback to run the value through before needle comparison.
	 *
	 * @return  array|null
	 */
	public static function search_values( array $array, $needle, bool $strict = true, ?callable $callback = null ): ?array {
		$comparison_array = is_callable( $callback ) ? array_map( $callback, $array ) : $array;

		foreach ( $comparison_array as $key => $value ) {
			if ( ( $strict && $needle === $value ) || ( ! $strict && $needle == $value ) ) { // phpcs:ignore
				continue;
			}

			unset( $array[ $key ] );
		}

		return empty( $array ) ? null : $array;
	}

	/**
	 * Returns all the keys in a given array that match a given needle.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   array           $array      Array whose keys to search through.
	 * @param   mixed           $needle     The value to search for.
	 * @param   bool            $strict     Whether to perform type checks or not.
	 * @param   callable|null   $callback   Optional callback to run the key through before needle comparison.
	 *
	 * @return  array|null
	 */
	public static function search_keys( array $array, $needle, bool $strict = false, callable $callback = null ): ?array {
		return self::search_values( array_keys( $array ), $needle, $strict, $callback );
	}

	/**
	 * Removes an element from an array by its value. If the value exists more than once, removes all of them.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   array           $array      The original array passed by reference.
	 * @param   mixed           $needle     The value that should be unset.
	 * @param   bool            $strict     Whether to perform type checks or not.
	 * @param   callable|null   $callback   Optional callback to run the value through before needle comparison.
	 *
	 * @return  array|null  The removed elements, or null if nothing removed.
	 */
	public static function unset_elements_by_value( array &$array, $needle, bool $strict = true, ?callable $callback = null ): ?array {
		$to_unset = self::search_values( $array, $needle, $strict, $callback );
		if ( is_null( $to_unset ) ) {
			return null;
		}

		foreach ( array_keys( $to_unset ) as $key ) {
			unset( $array[ $key ] );
		}

		return $to_unset;
	}
}
