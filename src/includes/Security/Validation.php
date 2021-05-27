<?php

namespace DeepWebSolutions\Framework\Helpers\Security;

\defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful validation helpers to be used throughout the projects.
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 *
 * @since   1.0.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\Security
 */
final class Validation {
	/**
	 * Validates a values against a whitelist.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   mixed   $entry      The entry to validate.
	 * @param   array   $allowed    The list of allowed entries.
	 * @param   mixed   $default    The default value to return if all fails.
	 *
	 * @return  mixed
	 */
	public static function validate_allowed_value( $entry, array $allowed, $default ) {
		$is_allowed = \in_array( $entry, $allowed, true );
		if ( false === $is_allowed && \is_string( $entry ) ) {
			$entry      = \trim( $entry );
			$is_allowed = \in_array( $entry, $allowed, true );
		}

		return $is_allowed ? $entry : $default;
	}
}
