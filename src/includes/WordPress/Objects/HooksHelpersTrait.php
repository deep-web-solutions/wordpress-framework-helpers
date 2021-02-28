<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress\Objects;

use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Defines useful methods for working with WP's hooks system.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress\Objects
 */
trait HooksHelpersTrait {
	/**
	 * Returns a meaningful, hopefully unique, tag for an internal hook.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name       The actual descriptor of the hook's purpose.
	 * @param   array   $extra      Further descriptor of the hook's purpose.
	 * @param   string  $root       Prepended to all hooks inside the same class.
	 *
	 * @return  string
	 */
	public function get_hook_tag( string $name, array $extra = array(), string $root = '' ): string {
		return Strings::to_safe_string(
			join(
				'_',
				array_filter(
					array_merge(
						array( $root, $name ),
						$extra
					)
				)
			),
			array(
				' '  => '-',
				'/'  => '',
				'\\' => '_',
			)
		);
	}
}
