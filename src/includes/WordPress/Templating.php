<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * A collection of very useful WP templating helpers to be used throughout the projects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class Templating {
	/**
	 * Allows for the theme to overwrite templates from DWS plugins.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $default_template   The absolute system path to the default template file.
	 * @param   string  $slug               Template slug.
	 * @param   string  $name               Template name.
	 * @param   string  $path               Relative path inside the theme's directory.
	 */
	public static function get_template_part( string $default_template, string $slug, string $name, string $path ): void {
		$path = trailingslashit( $path );

		$template = locate_template( $path . "{$slug}-{$name}.php" );
		if ( ! $template ) {
			$template = $default_template;
		}

		load_template( $template, false );
	}
}
