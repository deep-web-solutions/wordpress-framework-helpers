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
	 * Gets the recursive list of traits used by a given class or trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     https://www.php.net/manual/en/function.class-uses.php#122427
	 *
	 * @param   string  $class_name     Class/trait name.
	 * @param   bool    $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep( string $class_name, bool $autoload = true ): array {
		static $results = array();

		if ( isset( $results[ $class_name ] ) ) {
			$traits = $results[ $class_name ];
		} else {
			$traits = array();

			// Get all the traits of $class and its parent classes
			do {
				if ( class_exists( $class_name, $autoload ) || trait_exists( $class_name, $autoload ) ) {
					$traits[ $class_name ] = class_uses( $class_name, $autoload );
				}
			} while ( $class_name = get_parent_class( $class_name ) ); // phpcs:ignore

			// Get traits of all parent traits
			$traits_to_search = array_merge( ...$traits );
			while ( ! empty( $traits_to_search ) ) {
				$trait_name = array_pop( $traits_to_search );
				if ( ! isset( $traits[ $trait_name ] ) ) {
					$traits[ $trait_name ] = class_uses( $trait_name, $autoload );
					$traits_to_search      = array_merge( $traits[ $trait_name ], $traits_to_search );
				}
			}

			// Cache the result if autoload is active.
			if ( true === $autoload ) {
				$results[ $class_name ] = $traits;
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
	 * @param   string  $class_name     Class/trait name.
	 * @param   bool    $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep_list( string $class_name, bool $autoload = true ): array {
		$traits = self::class_uses_deep( $class_name, $autoload );
		return array_unique( array_merge( ...$traits ) );
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
