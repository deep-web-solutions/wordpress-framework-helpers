<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress\Hooks;

use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the hooks-helpers-aware interface.
 *
 * @since   1.0.0
 * @version 1.4.1
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress\Hooks
 */
trait HooksHelpersTrait {
	/**
	 * Returns a meaningful, hopefully unique, tag for an internal hook.
	 *
	 * @since   1.0.0
	 * @version 1.4.1
	 *
	 * @param   string  $name   The actual descriptor of the hook's purpose.
	 * @param   array   $extra  Further descriptor of the hook's purpose.
	 * @param   string  $root   Prepended to all hooks inside the same class.
	 *
	 * @return  string
	 */
	public function get_hook_tag( string $name, array $extra = array(), string $root = 'dws_framework_helpers' ): string {
		return Strings::to_safe_string(
			\join(
				'/',
				\array_filter(
					\array_merge(
						array( $root, $name ),
						$extra
					)
				)
			),
			array(
				' '  => '_',
				'\\' => '_',
			)
		);
	}
}
