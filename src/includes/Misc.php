<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful misc helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class Misc {
	/**
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     https://www.php.net/manual/en/function.class-uses.php#122427
	 *
	 * @param   object|string   $class      An object (class instance) or a string (class name).
	 * @param   bool            $autoload   Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep( $class, $autoload = true ): array {
		$traits = array();

		// Get all the traits of $class and its parent classes
		do {
			$class_name = is_object( $class ) ? get_class( $class ) : $class;
			if ( class_exists( $class_name, $autoload ) ) {
				$traits = array_merge( class_uses( $class, $autoload ), $traits );
			}
		} while ( $class = get_parent_class( $class ) ); // phpcs:ignore

		// Get traits of all parent traits
		$traits_to_search = $traits;
		while ( ! empty( $traits_to_search ) ) {
			$new_traits       = class_uses( array_pop( $traits_to_search ), $autoload );
			$traits           = array_merge( $new_traits, $traits );
			$traits_to_search = array_merge( $new_traits, $traits_to_search );
		};

		return array_unique( $traits );
	}
}
