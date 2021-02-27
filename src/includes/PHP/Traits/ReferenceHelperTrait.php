<?php

namespace DeepWebSolutions\Framework\Helpers\PHP\Traits;

use DeepWebSolutions\Framework\Helpers\PHP\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Defines useful methods for persistent referencing.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\PHP\Traits
 */
trait ReferenceHelperTrait {
	/**
	 * Returns a meaningful, hopefully unique, persistent name for a reference.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name               The main descriptor of the referenced object.
	 * @param   array   $extra              Further descriptor of the referenced object.
	 * @param   string  $root               Prepended to all referenced objects inside the same class.
	 * @param   array   $unsafe_characters  Any potential unsafe characters and their replacements.
	 *
	 * @return  string
	 */
	public function get_reference_name( string $name, array $extra = array(), string $root = '', array $unsafe_characters = array() ): string {
		return Strings::generate_safe_string(
			join(
				'_',
				array_filter(
					array_merge(
						array( $root, $name ),
						$extra
					)
				)
			),
			$unsafe_characters
		);
	}
}
