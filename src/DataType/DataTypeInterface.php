<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * Interface for helpers that deal with data types.
 *
 * @since   2.0.0
 * @version 2.0.0
 *
 * @template TPrimitive
 * @phpstan-type InputType INPUT_GET|INPUT_POST|INPUT_COOKIE|INPUT_SERVER|INPUT_ENV
 */
interface DataTypeInterface {
	/**
	 * Checks if a given variable is of the correct type.
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 *
	 * @param   mixed $value  Variable to check.
	 *
	 * @return  bool
	 * @phpstan-assert-if-true TPrimitive $value
	 */
	public static function check( mixed $value ): bool;


	/**
	 * Returns a given variable if it is of the correct type or a default value if not.
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 *
	 * @param   mixed           $value    Variable to check.
	 * @param   TPrimitive|null $fallback  The default value to return if check fails. Defaults to null.
	 *
	 * @return  TPrimitive|null
	 */
	public static function validate( mixed $value, $fallback = null );

	/**
	 * Attempts to cast a given variable of unknown type into the correct type.
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 *
	 * @param   mixed           $value    Variable to cast.
	 * @param   TPrimitive|null $fallback  The default value to return if all fails. Defaults to null.
	 *
	 * @return  TPrimitive|null
	 */
	public static function maybe_cast( mixed $value, $fallback = null );

	/**
	 * Attempts to cast a variable from an input stream into the correct type.
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 *
	 * @param   InputType       $input_type  The input stream to search for the variable in.
	 * @param   string          $var_name    The name of the variable to cast.
	 * @param   TPrimitive|null $fallback     The default value to return if all fails. Defaults to null.
	 *
	 * @return  TPrimitive|null
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null );
}
