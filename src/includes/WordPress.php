<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WordPress helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class WordPress {
	/**
	 * Removes an anonymous object action or filter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string   $hook       Hook name.
	 * @param   string   $class      Class name.
	 * @param   string   $method     Method name.
	 */
	public static function remove_anonymous_object_hook( string $hook, string $class, string $method ): void {
		$filters = $GLOBALS['wp_filter'][ $hook ];
		if ( empty( $filters ) ) {
			return;
		}

		foreach ( $filters as $priority => $filter ) {
			foreach ( $filter as $identifier => $function ) {
				if ( is_array( $function ) && is_array( $function['function'] ) && is_a( $function['function'][0], $class ) && $method === $function['function'][1] ) {
					remove_filter( $hook, array( $function['function'][0], $method ), $priority );
				}
			}
		}
	}

	/**
	 * Returns the current priority of the hook currently executing.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  int
	 */
	public static function get_current_hook_priority(): int {
		return $GLOBALS['wp_filter'][ current_filter() ]->current_priority();
	}

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
