<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful array manipulation helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\Framework\Helpers
 */
final class Arrays {
	/**
	 * Removes an element from an array by its value. If the value exists more than once, removes all of them.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array       $array      The original array passed by reference.
	 * @param   mixed       $value      The value that should be unset.
	 * @param   callable    $callback   The callback to use to determine whether the value is the one looked for or not.
	 *                                  If not provided, the key search defaults to the function array_keys.
	 *
	 * @return  int     The number of items removed from the array.
	 */
	public static function unset_array_element_by_value( array &$array, $value, callable $callback = null ) {
		if ( is_callable( $callback ) ) {
			$keys = array();
			foreach ( $array as $key => $value ) {
				if ( call_user_func( $callback, $value ) ) {
					$keys[] = $key;
				}
			}
		} else {
			$keys = array_keys( $array, $value, true );
		}

		foreach ( $keys as $key ) {
			unset( $array[ $key ] );
		}

		return count( $keys );
	}
}