<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling string-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<string>
 */
final class StringDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_string( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?string {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.3.1
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?string {
		if ( self::check( $value ) ) {
			return $value;
		} elseif ( \is_null( $value ) ) {
			return $fallback;
		}

		if ( ! ArrayDataType::check( $value ) && ( ! ObjectDataType::check( $value ) || \method_exists( $value, '__toString' ) ) ) {
			return (string) $value;
		}

		return $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.3.1
	 * @version 1.4.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?string {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$maybe_string = \filter_input( $input_type, $var_name, options: FILTER_REQUIRE_SCALAR );
			return self::maybe_cast( $maybe_string, $fallback );
		}

		return $fallback;
	}
}
