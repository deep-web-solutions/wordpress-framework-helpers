<?php

namespace DeepWebSolutions\Framework\Helpers\PHP;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful misc helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP
 */
final class Misc {
	/**
	 * Gets the recursive list of traits used by a given class or trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 *
	 * @see     https://www.php.net/manual/en/function.class-uses.php#122427
	 *
	 * @param   object|string   $class          An object (class instance) or a string (class name).
	 * @param   bool            $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep( $class, bool $autoload = true ): array {
		static $results = array();

		$original_class_name = is_object( $class ) ? get_class( $class ) : $class;

		if ( isset( $results[ $original_class_name ] ) ) {
			$traits = $results[ $original_class_name ];
		} else {
			$traits = array();

			// Get all the traits of $class and its parent classes
			do {
				$class_name = is_object( $class ) ? get_class( $class ) : $class;
				if ( class_exists( $class_name, $autoload ) || trait_exists( $class_name, $autoload ) ) {
					$traits[ $class_name ] = class_uses( $class_name, $autoload );
				}
			} while ( $class = get_parent_class( $class ) ); // phpcs:ignore

			// Get traits of all parent traits
			$traits_to_search = array_merge( ...array_values( $traits ) );
			while ( ! empty( $traits_to_search ) ) {
				$trait_name = array_pop( $traits_to_search );
				if ( ! isset( $traits[ $trait_name ] ) ) {
					$traits[ $trait_name ] = class_uses( $trait_name, $autoload );
					$traits_to_search      = array_merge( $traits[ $trait_name ], $traits_to_search );
				}
			}

			// Cache the result if autoload is active.
			if ( true === $autoload ) {
				$results[ $original_class_name ] = $traits;
			}
		}

		return $traits;
	}

	/**
	 * Gets the recursive list of traits used by a given class or trait as a list with no parent information.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   object|string   $class          An object (class instance) or a string (class name).
	 * @param   bool            $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep_list( $class, bool $autoload = true ): array {
		static $results = array();

		$original_class_name = is_object( $class ) ? get_class( $class ) : $class;
		if ( isset( $results[ $original_class_name ] ) ) {
			$traits = $results[ $original_class_name ];
		} else {
			$traits = self::class_uses_deep( $class, $autoload );
			$traits = array_unique( array_merge( ...array_values( $traits ) ) );

			// Cache the result if autoload is active.
			if ( true === $autoload ) {
				$results[ $original_class_name ] = $traits;
			}
		}

		return $traits;
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
		$letter = substr( $size, -1 );
		$return = substr( $size, 0, -1 );

		switch ( strtoupper( $letter ) ) {
			case 'P': // phpcs:ignore
				$return *= 1024;
			case 'T': // phpcs:ignore
				$return *= 1024;
			case 'G': // phpcs:ignore
				$return *= 1024;
			case 'M': // phpcs:ignore
				$return *= 1024;
			case 'K': // phpcs:ignore
				$return *= 1024;
		}

		return $return;
	}
}
