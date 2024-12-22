<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling array-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<array<mixed>>
 */
final class ArrayDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_array( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?array {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?array {
		if ( self::check( $value ) ) {
			return $value;
		} elseif ( \is_null( $value ) ) {
			return $fallback;
		}

		return array( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?array {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$input_array = \filter_input( $input_type, $var_name, options: \FILTER_FORCE_ARRAY );
			return self::maybe_cast( $input_array, $fallback );
		}

		return $fallback;
	}
}
