<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling boolean-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<bool>
 */
final class BooleanDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_bool( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?bool {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?bool {
		if ( self::check( $value ) ) {
			return $value;
		} elseif ( IntegerDataType::check( $value ) || FloatDataType::check( $value ) ) {
			return ( $value > 0 );
		} elseif ( ! StringDataType::check( $value ) ) {
			return $fallback;
		}

		$value = \str_replace( ' ', '', \trim( $value ) );
		if ( '' === $value ) {
			return $fallback;
		}

		$maybe_boolean = \filter_var( $value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
		if ( \is_null( $maybe_boolean ) && \is_numeric( $value ) ) {
			$maybe_boolean = ( IntegerDataType::maybe_cast( $value ) > 0 );
		}

		return self::validate( $maybe_boolean, $fallback );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?bool {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$maybe_boolean = \filter_input( $input_type, $var_name, options: FILTER_REQUIRE_SCALAR | FILTER_NULL_ON_FAILURE );
			return self::maybe_cast( $maybe_boolean, $fallback );
		}

		return $fallback;
	}

	/**
	 * Returns an unambiguous string representation of a boolean value.
	 *
	 * @since   1.4.4
	 * @version 1.4.4
	 *
	 * @param   bool $value Boolean value to stringify.
	 *
	 * @return  string
	 */
	public static function stringify( bool $value ): string {
		return $value ? 'yes' : 'no';
	}
}
