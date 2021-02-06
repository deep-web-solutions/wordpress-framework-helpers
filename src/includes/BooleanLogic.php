<?php

namespace DeepWebSolutions\Framework\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful boolean logic helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Helpers
 */
final class BooleanLogic {
	/**
	 * Useful class for calls to functional programming constructs, such as 'array_reduce'. Returns the logical or result
	 * of the two parameters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $boolean1   The first boolean value.
	 * @param   bool    $boolean2   The second boolean value.
	 *
	 * @return  bool    The result of "or-ing" the two boolean parameters.
	 */
	public static function logical_or( bool $boolean1, bool $boolean2 ): bool {
		return $boolean1 || $boolean2;
	}

	/**
	 * Useful class for calls to functional programming constructs, such as 'array_reduce'. Returns the logical or result
	 * of the two parameters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $boolean1   The first boolean value.
	 * @param   bool    $boolean2   The second boolean value.
	 *
	 * @return  bool    The result of "and-ing" the two boolean parameters.
	 */
	public static function logical_and( bool $boolean1, bool $boolean2 ): bool {
		return $boolean1 && $boolean2;
	}
}
