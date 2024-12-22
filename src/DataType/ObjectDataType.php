<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling object-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<object>
 */
final class ObjectDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value ): bool {
		return \is_object( $value );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?object {
		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?object {
		if ( self::check( $value ) ) {
			return $value;
		} elseif ( ArrayDataType::check( $value ) ) {
			return (object) $value;
		} elseif ( ! StringDataType::check( $value ) ) {
			return $fallback;
		}

		$value = \trim( $value );
		if ( '' === $value ) {
			return $fallback;
		}

		if ( \json_validate( $value ) ) {
			$value = \json_decode( $value, associative: false );
		} else {
			$value = maybe_unserialize( $value );
		}

		return self::validate( $value, $fallback );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?object {
		if ( \filter_has_var( $input_type, $var_name ) ) {
			$value = \filter_input( $input_type, $var_name, options: \FILTER_REQUIRE_SCALAR );
			return self::maybe_cast( $value, $fallback );
		}

		return $fallback;
	}
}
