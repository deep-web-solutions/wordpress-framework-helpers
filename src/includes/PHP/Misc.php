<?php

namespace DeepWebSolutions\Framework\Helpers\PHP;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful misc helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP
 */
final class Misc {
	/**
	 * Gets the recursive list of traits used by a given class.
	 *
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

	/**
	 * Transforms the php.ini notation for numbers (like 2M) to an integer.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     http://hookr.io/functions/wc_let_to_num/
	 *
	 * @noinspection PhpMissingBreakStatementInspection
	 *
	 * @param   string  $size   The php.ini size to transform into an integer.
	 *
	 * @return  int
	 */
	public static function let_to_num( string $size ): int {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );

		switch ( strtoupper( $l ) ) {
			case 'P': // phpcs:ignore
				$ret *= 1024;
			case 'T': // phpcs:ignore
				$ret *= 1024;
			case 'G': // phpcs:ignore
				$ret *= 1024;
			case 'M': // phpcs:ignore
				$ret *= 1024;
			case 'K': // phpcs:ignore
				$ret *= 1024;
		}

		return $ret;
	}
}
