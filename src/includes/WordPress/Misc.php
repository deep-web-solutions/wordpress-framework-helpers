<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful misc WP helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Misc {
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
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'rest':
				return self::is_rest_api_request();
			case 'frontend':
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
			return false;
		}

		return ( false !== strpos( $_SERVER['REQUEST_URI'], trailingslashit( rest_get_url_prefix() ) ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	}
}
