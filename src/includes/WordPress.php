<?php

namespace DeepWebSolutions\Framework\Helpers;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

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

	/**
	 * Logs an event with an appropriate level and returns an exception with the same message.
	 *
	 * @param   LoggerInterface     $logger         The PSR3 logger to use.
	 * @param   string              $log_level      The PSR3 log level.
	 * @param   string              $exception      The exception to instantiate.
	 * @param   string              $message        The message to log/return as exception.
	 * @param   array               $context        The PSR3 context.
	 *
	 * @return  \Exception
	 */
	public static function log_event_and_return_exception( LoggerInterface $logger, string $log_level, string $exception, string $message, array $context = array() ): \Exception {
		$logger->log( $log_level, $message, $context );
		return new $exception( $message );
	}

	/**
	 * Logs a debug-level event and also runs a '_doing_it_wrong' call with the same message.
	 *
	 * @param   LoggerInterface     $logger         The PSR3 logger to use.
	 * @param   string              $function       The function being used incorrectly.
	 * @param   string              $message        The message to log/return as exception.
	 * @param   string              $since_version  The plugin version that introduced this warning message.
	 * @param   array               $context        The PSR3 context.
	 */
	public static function log_event_and_doing_it_wrong( LoggerInterface $logger, string $function, string $message, string $since_version, array $context = array() ): void {
		$logger->log( LogLevel::DEBUG, $message, $context );
		_doing_it_wrong( $function, $message, $since_version ); // phpcs:ignore
	}
}
