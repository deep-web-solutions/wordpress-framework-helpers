<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP request helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Requests {
	// region FIELDS AND CONSTANTS

	/**
	 * Enum-type constant for identifying an admin request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  ADMIN_REQUEST
	 */
	public const ADMIN_REQUEST = 'admin';

	/**
	 * Enum-type constant for identifying an ajax request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  AJAX_REQUEST
	 */
	public const AJAX_REQUEST = 'ajax';

	/**
	 * Enum-type constant for identifying a cron request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  CRON_REQUEST
	 */
	public const CRON_REQUEST = 'cron';

	/**
	 * Enum-type constant for identifying a REST request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  REST_REQUEST
	 */
	public const REST_REQUEST = 'rest';

	/**
	 * Enum-type constant for identifying a frontend request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  FRONTEND_REQUEST
	 */
	public const FRONTEND_REQUEST = 'frontend';

	// endregion

	// region METHODS

	/**
	 * A copy of WooCommerce's private built-in function for determining what type of request we're dealing with.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     WooCommerce::is_request()
	 *
	 * @param   string  $type   The type of request to check against. Supported values: admin, ajax, cron, frontend, rest.
	 *
	 * @return  bool    True if the current request is of the type passed on, false otherwise.
	 */
	public static function is_request( string $type ): bool {
		switch ( $type ) {
			case self::ADMIN_REQUEST:
				return is_admin();
			case self::AJAX_REQUEST:
				return defined( 'DOING_AJAX' );
			case self::CRON_REQUEST:
				return defined( 'DOING_CRON' );
			case self::REST_REQUEST:
				return self::is_rest_api_request();
			case self::FRONTEND_REQUEST:
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! self::is_rest_api_request();
		}

		return false;
	}

	/**
	 * Returns true if the request is a non-legacy REST API request.
	 *
	 * Legacy REST requests should still run some extra code for backwards compatibility.
	 *
	 * @todo: replace this function once core WP function is available: https://core.trac.wordpress.org/ticket/42061.
	 *
	 * @return  bool
	 */
	public static function is_rest_api_request(): bool {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return wp_is_jsonp_request() || wp_is_json_request();
		}

		$rest_prefix         = trailingslashit( rest_get_url_prefix() );
		$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		return $is_rest_api_request || wp_is_jsonp_request() || wp_is_json_request();
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
		return defined( $constant ) && constant( $constant );
	}

	// endregion
}
