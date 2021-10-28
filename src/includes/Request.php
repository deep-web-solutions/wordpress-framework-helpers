<?php

namespace DeepWebSolutions\Framework\Helpers;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP request helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.5.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class Request {
	// region METHODS

	/**
	 * A copy of WooCommerce's private built-in function for determining what type of request we're dealing with.
	 *
	 * @since   1.0.0
	 * @version 1.5.0
	 *
	 * @see     WooCommerce::is_request()
	 *
	 * @param   string  $type   The type of request to check against. Supported values: admin, ajax, cron, frontend, rest.
	 *
	 * @return  bool    True if the current request is of the type passed on, false otherwise.
	 */
	public static function is_type( string $type ): bool {
		switch ( $type ) {
			case 'admin':
				$result = \is_admin();
				break;
			case 'ajax':
				$result = \defined( 'DOING_AJAX' );
				break;
			case 'cron':
				$result = \defined( 'DOING_CRON' );
				break;
			case 'rest':
				$result = self::is_rest_api_request();
				break;
			case 'front':
				$result = ( ! \is_admin() || \defined( 'DOING_AJAX' ) ) && ! \defined( 'DOING_CRON' ) && ! self::is_rest_api_request();
				break;
			default:
				$result = false;
		}

		return $result;
	}

	/**
	 * Checks whether a debugging constant is set and true-ish.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $constant   The constant to check for. Default is WP_DEBUG.
	 *
	 * @return  bool    True if the constant is defined and true.
	 */
	public static function has_debug( string $constant = 'WP_DEBUG' ): bool {
		return \defined( $constant ) && \constant( $constant );
	}

	// endregion

	// region HELPERS

	/**
	 * Returns true if the request is a non-legacy REST API request.
	 *
	 * Legacy REST requests should still run some extra code for backwards compatibility.
	 *
	 * @todo: replace this function once core WP function is available: https://core.trac.wordpress.org/ticket/42061.
	 *
	 * @since   1.0.0
	 * @version 1.4.3
	 *
	 * @return  bool
	 */
	protected static function is_rest_api_request(): bool {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return ( \wp_is_jsonp_request() || \wp_is_json_request() ) && ! \defined( 'DOING_AJAX' );
		}

		$rest_prefix         = \trailingslashit( \rest_get_url_prefix() );
		$is_rest_api_request = ( false !== \strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		return $is_rest_api_request || ( ( \wp_is_jsonp_request() || \wp_is_json_request() ) && ! \defined( 'DOING_AJAX' ) );
	}

	// endregion
}
