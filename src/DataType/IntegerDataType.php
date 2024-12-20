<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling int-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<int>
 */
final class IntegerDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_int( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?int {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?int {
		if ( self::check( $value ) || FloatDataType::check( $value ) ) {
			return (int) $value;
		} elseif ( ! StringDataType::check( $value ) ) {
			return $fallback;
		}

		$value = \str_replace( ' ', '', \trim( $value ) );
		if ( '' === $value ) {
			return $fallback;
		}

		$maybe_integer = \filter_var( $value, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_OCTAL | FILTER_FLAG_ALLOW_HEX );
		if ( false === $maybe_integer ) {
			if ( \str_starts_with( $value, '0b' ) ) {
				$maybe_integer = \bindec( $value );
			} else {
				if ( ! \str_contains( $value, '.' ) && 1 === \substr_count( $value, ',' ) ) {
					$value = \str_replace( ',', '.', $value );
				}

				$maybe_integer = FloatDataType::maybe_cast( $value );
				if ( FloatDataType::check( $maybe_integer ) ) {
					$maybe_integer = (int) $maybe_integer;
				}
			}
		}

		return self::validate( $maybe_integer, $fallback );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?int {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$input_maybe_integer = \filter_input( $input_type, $var_name, options: FILTER_REQUIRE_SCALAR );
			return self::maybe_cast( $input_maybe_integer, $fallback );
		}

		return $fallback;
	}
}
