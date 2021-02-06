<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WordPress Users helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class Users {
	/**
	 * Logs out a given user from WordPress.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int|null    $user_id    The ID of the user to log out. Defaults to the currently logged-in user.
	 */
	public static function logout_user( ?int $user_id = null ): void {
		$user_sessions = \WP_Session_Tokens::get_instance( $user_id ?? get_current_user_id() );
		$user_sessions->destroy_all();
	}

	/**
	 * Retrieves the list of roles that a given user has. Defaults to the current logged-in user.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int|null    $user_id    The ID of the user to retrieve the roles for. Defaults to the currently logged-in user.
	 *
	 * @return  array|null  The list of roles or null if the user could not be retrieved.
	 */
	public static function get_roles( ?int $user_id = null ): ?array {
		$user = is_null( $user_id ) ? wp_get_current_user() : get_user_by( 'id', $user_id );
		return ( $user instanceof \WP_User && $user->exists() ) ? $user->roles : null;
	}

	/**
	 * Checks whether a given user has certain roles.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array       $roles      The roles to check for.
	 * @param   int|null    $user_id    The ID of the user to check for. Defaults to the currently logged-in user.
	 * @param   string      $logic      Whether the user needs to have all the roles mentioned or either of them. Valid values: 'and', 'or'. Default: 'and'.
	 *
	 * @return  bool|null   Null if the user could not be found, otherwise the result of the check.
	 */
	public static function has_roles( array $roles, ?int $user_id = null, string $logic = 'and' ): ?bool {
		$user_roles = self::get_roles( $user_id );
		if ( is_null( $user_roles ) ) {
			return null;
		}

		if ( empty( $roles ) ) {
			return true;
		} elseif ( empty( $user_roles ) ) {
			return false;
		}

		return array_reduce(
			array_map(
				function( string $role ) use ( $user_roles ) {
					return in_array( $role, $user_roles, true );
				},
				$roles
			),
			array( BooleanLogic::class, "logical_{$logic}" ),
			'and' === $logic
		);
	}

	/**
	 * Checks whether a given user has certain capabilities.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array       $capabilities   The capabilities to check for.
	 * @param   int|null    $user_id        The ID of the user to check for. Defaults to the currently logged-in user.
	 * @param   string      $logic          Whether the user needs to have all the roles mentioned or either of them. Valid values: 'and', 'or'. Default: 'and'.
	 * @param   mixed       ...$args        Optional further parameters, typically starting with an object ID. See user_can().
	 *
	 * @return  bool|null   Null if the user could not be found, otherwise the result of the check.
	 */
	public static function has_capabilities( array $capabilities, ?int $user_id = null, string $logic = 'and', ...$args ): ?bool {
		$user = is_null( $user_id ) ? wp_get_current_user() : get_user_by( 'id', $user_id );
		if ( is_null( $user ) ) {
			return null;
		}

		if ( empty( $capabilities ) ) {
			return true;
		}

		return array_reduce(
			array_map(
				function( string $capability ) use ( $user, $args ) {
					return $user->has_cap( $capability, ...$args );
				},
				$capabilities
			),
			array( BooleanLogic::class, "logical_{$logic}" ),
			'and' === $logic
		);
	}
}
