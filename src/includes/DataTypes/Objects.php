<?php

namespace DeepWebSolutions\Framework\Helpers\DataTypes;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful misc helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\DataTypes
 */
final class Objects {
	/**
	 * Returns a given variable if it is an object or a default value if not.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 *
	 * @param   mixed           $object     Variable to check.
	 * @param   object|null     $default    The default value to return if check fails. By default null.
	 *
	 * @return  object|null
	 */
	public static function validate( $object, ?object $default = null ): ?object {
		return \is_object( $object ) ? $object : $default;
	}

	/**
	 * Gets the description of the trait inheritance scheme of a given trait.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @SuppressWarnings(PHPMD.UndefinedVariable)
	 *
	 * @param   string  $trait          The trait to act upon.
	 * @param   bool    $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function trait_uses_deep( string $trait, bool $autoload = true ): array {
		static $results = array();

		if ( isset( $results[ $trait ] ) ) {
			$traits = $results[ $trait ];
		} else {
			$traits      = array();
			$used_traits = \class_uses( $trait, $autoload ) ?: array(); // phpcs:ignore

			foreach ( $used_traits as $used_trait ) {
				$traits[ $used_trait ] = self::trait_uses_deep( $used_trait );
			}

			if ( true === $autoload ) {
				$results[ $trait ] = $traits;
			}
		}

		return $traits;
	}

	/**
	 * Gets a list of all the traits used by a given trait and its own traits.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @SuppressWarnings(PHPMD.UndefinedVariable)
	 *
	 * @param   string  $trait          The trait to act upon.
	 * @param   bool    $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  string[]
	 */
	public static function trait_uses_deep_list( string $trait, bool $autoload = true ): array {
		static $results = array();

		if ( isset( $results[ $trait ] ) ) {
			$traits = $results[ $trait ];
		} else {
			$traits      = array();
			$used_traits = self::trait_uses_deep( $trait, $autoload );

			foreach ( $used_traits as $used_trait => $children_traits ) {
				$traits[ $used_trait ] = $used_trait;
				foreach ( \array_keys( $children_traits ) as $child_trait ) {
					$traits[ $child_trait ] = $child_trait;
					$traits                += self::trait_uses_deep_list( $child_trait );
				}
			}

			if ( true === $autoload ) {
				$results[ $trait ] = $traits;
			}
		}

		return $traits;
	}

	/**
	 * Gets the description of the top-down used traits and their inheritance scheme of a given class.
	 *
	 * @since   1.0.0
	 * @version 1.2.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.UndefinedVariable)
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

		$class = \is_object( $class ) ? \get_class( $class ) : $class;

		if ( isset( $results[ $class ] ) ) {
			$traits = $results[ $class ];
		} else {
			$traits = array();

			foreach ( \array_reverse( \class_parents( $class ) ) + array( $class => $class ) as $current_class ) {
				$traits[ $current_class ] = \class_uses( $current_class, $autoload );
			}

			foreach ( $traits as $current_class => $traits_list ) {
				foreach ( $traits_list as $current_trait ) {
					$traits[ $current_class ][ $current_trait ] = self::trait_uses_deep( $current_trait );
				}
			}

			// Cache the result if autoload is active.
			if ( true === $autoload ) {
				$results[ $class ] = $traits;
			}
		}

		return $traits;
	}

	/**
	 * Gets a list of all the traits used by a class, its parent classes and all of their own traits
	 *
	 * @since   1.0.0
	 * @version 1.2.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @SuppressWarnings(PHPMD.UndefinedVariable)
	 *
	 * @param   object|string   $class          An object (class instance) or a string (class name).
	 * @param   bool            $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  array
	 */
	public static function class_uses_deep_list( $class, bool $autoload = true ): array {
		static $results = array();

		$class = \is_object( $class ) ? \get_class( $class ) : $class;

		if ( isset( $results[ $class ] ) ) {
			$traits = $results[ $class ];
		} else {
			$traits      = array();
			$used_traits = self::class_uses_deep( $class, $autoload );

			foreach ( $used_traits as $traits_list ) {
				foreach ( \array_keys( $traits_list ) as $used_trait ) {
					$traits[ $used_trait ] = $used_trait;
					$traits               += self::trait_uses_deep_list( $used_trait );
				}
			}

			// Cache the result if autoload is active.
			if ( true === $autoload ) {
				$results[ $class ] = $traits;
			}
		}

		return $traits;
	}

	/**
	 * Returns whether a given trait is used in the given class.
	 *
	 * @since   1.0.0
	 * @version 1.2.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string              $trait          Trait to search for.
	 * @param   object|string       $class          An object (class instance) or a string (class name) to investigate.
	 * @param   bool                $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  bool
	 */
	public static function has_trait( string $trait, $class, bool $autoload = true ): bool {
		$traits = \class_uses( $class, $autoload ) ?: array(); // phpcs:ignore
		return isset( $traits[ $trait ] );
	}

	/**
	 * Returns whether a given trait is used in the inheritance tree of a given class or another trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string              $trait          Trait to search for.
	 * @param   object|string       $class          An object (class instance) or a string (class name) to investigate.
	 * @param   bool                $autoload       Whether to allow this function to load the class automatically through the __autoload() magic method.
	 *
	 * @return  bool
	 */
	public static function has_trait_deep( string $trait, $class, bool $autoload = true ): bool {
		return isset( self::class_uses_deep_list( $class, $autoload )[ $trait ] );
	}
}
