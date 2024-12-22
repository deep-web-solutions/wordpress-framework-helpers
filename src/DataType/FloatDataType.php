<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling float-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<float>
 */
final class FloatDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_float( $value ) && \is_finite( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?float {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?float {
		if ( self::check( $value ) ) {
			return $value;
		} elseif ( IntegerDataType::check( $value ) ) {
			return (float) $value;
		} elseif ( ! StringDataType::check( $value ) ) {
			return $fallback;
		}

		$value = \filter_var( $value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION | \FILTER_FLAG_ALLOW_THOUSAND | \FILTER_FLAG_ALLOW_SCIENTIFIC );
		if ( '' === $value ) {
			return $fallback;
		}

		$filter_options = array( 'flags' => \FILTER_REQUIRE_SCALAR | \FILTER_FLAG_ALLOW_THOUSAND );

		$maybe_float = \filter_var( $value, \FILTER_VALIDATE_FLOAT, array( 'options' => array( 'decimal' => '.' ) ) + $filter_options );
		if ( false === $maybe_float ) {
			$maybe_float = \filter_var( $value, \FILTER_VALIDATE_FLOAT, array( 'options' => array( 'decimal' => ',' ) ) + $filter_options );
		}

		return self::validate( $maybe_float, $fallback );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?float {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$input_maybe_float = \filter_input( $input_type, $var_name, options: \FILTER_REQUIRE_SCALAR );
			return self::maybe_cast( $input_maybe_float, $fallback );
		}

		return $fallback;
	}
}
