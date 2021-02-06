<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP hooks helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Hooks {
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
}
