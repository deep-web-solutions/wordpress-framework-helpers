<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress\Traits;

use DeepWebSolutions\Framework\Helpers\PHP\Traits\ReferenceHelperTrait;

defined( 'ABSPATH' ) || exit;

/**
 * Defines useful methods for working with WP's assets system.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress\Traits
 */
trait AssetsHelperTrait {
	use ReferenceHelperTrait;

	/**
	 * Returns a meaningful, hopefully unique, handle for an asset.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The actual descriptor of the asset's purpose. Leave blank for default.
	 * @param   array   $extra  Further descriptor of the asset's purpose.
	 * @param   string  $root   Prepended to all asset handles inside the same class.
	 *
	 * @return  string
	 */
	public function get_asset_handle( string $name = '', array $extra = array(), string $root = '' ): string {
		return $this->get_reference_name(
			$name,
			$extra,
			$root,
			array(
				' '  => '-',
				'/'  => '',
				'\\' => '_',
			)
		);
	}
}
