<?php declare( strict_types=1 );

namespace DeepWebSolutions\Framework\Helpers\DataType;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of useful helpers for handling callable-type values.
 *
 * @since   1.4.0
 * @version 2.0.0
 *
 * @implements DataTypeInterface<callable>
 */
final class CallableDataType implements DataTypeInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function check( mixed $value, bool $syntax_only = false ): bool {
		return \is_callable( $value, $syntax_only );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.4.0
	 * @version 2.0.0
	 */
	public static function validate( mixed $value, $fallback = null ): ?callable {
		if ( self::check( $value ) ) {
			return $value;
		}

		if ( StringDataType::check( $value ) ) {
			$value = \trim( $value );
		} elseif ( self::check( $value, true ) && ArrayDataType::check( $value ) ) {
			if ( StringDataType::check( $value[0] ) ) {
				$value[0] = \trim( $value[0] );
			}
			$value[1] = \trim( $value[1] );
		}

		return self::check( $value ) ? $value : $fallback;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function maybe_cast( mixed $value, $fallback = null ): ?callable {
		throw new \LogicException( 'Cannot cast to callback.' );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.0
	 * @version 2.0.0
	 */
	public static function maybe_cast_input( int $input_type, string $var_name, $fallback = null ): ?callable {
		throw new \LogicException( 'Cannot cast to callback.' );
	}
}
