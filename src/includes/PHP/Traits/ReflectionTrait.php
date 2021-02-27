<?php

namespace DeepWebSolutions\Framework\Helpers\PHP\Traits;

use ReflectionClass;

defined( 'ABSPATH' ) || exit;

/**
 * Defines a few short-hand methods for retrieving reflection information about the using class.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP\Traits
 */
trait ReflectionTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Collection of reflection class instances for static compatibility with class inheritance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     ReflectionClass[]
	 */
	protected static array $reflection_class = array();

	// endregion

	// region GETTERS

	/**
	 * Gets the reflection class instance of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ReflectionClass
	 */
	final public static function get_reflection_class(): ReflectionClass {
		if ( ! isset( self::$reflection_class[ static::class ] ) ) {
			self::$reflection_class[ static::class ] = new ReflectionClass( static::class );
		}

		return self::$reflection_class[ static::class ];
	}

	// endregion

	// region METHODS

	/**
	 * Gets the short name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	final public static function get_class_name(): string {
		return self::get_reflection_class()->getShortName();
	}

	/**
	 * Gets the full name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	final public static function get_full_class_name(): string {
		return '\\' . ltrim( self::get_reflection_class()->getName(), '\\' );
	}

	/**
	 * Gets the name of the file that the using class is written in.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	final public static function get_file_name(): string {
		return self::get_reflection_class()->getFileName();
	}

	// endregion
}
