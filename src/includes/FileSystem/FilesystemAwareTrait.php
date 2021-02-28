<?php

namespace DeepWebSolutions\Framework\Helpers\FileSystem;

use DeepWebSolutions\Framework\Helpers\WordPress\Request;
use WP_Filesystem_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Defines methods for retrieving instances of the WP Files API objects.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\FileSystem
 */
trait FilesystemAwareTrait {
	/**
	 * Returns an instance of the WP_Filesystem API. Upon failure, return null.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string|null     $form_url       The URL to post the form to.
	 * @param   string          $context        Full path to the directory that is tested for being writable. Default empty.
	 * @param   array|null      $extra_fields   Extra `POST` fields to be checked for inclusion in the post. Default null.
	 *
	 * @return  WP_Filesystem_Base|null
	 */
	public function get_wp_filesystem( ?string $form_url = null, $context = '', ?array $extra_fields = null ): ?WP_Filesystem_Base {
		global $wp_filesystem;

		if ( ! function_exists( 'request_filesystem_credentials' ) ) {
			include_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$form_url    = $form_url ?? site_url();
		$credentials = request_filesystem_credentials( $form_url, '', false, $context, $extra_fields );

		if ( false === $credentials ) {
			if ( Request::has_debug() ) {
				// phpcs:disable WordPress.PHP.DevelopmentFunctions
				error_log( 'Failed to retrieve WP Files credentials.' );
				// phpcs:enable
			}
			return null;
		} elseif ( ! wp_filesystem( $credentials ) ) {
			if ( Request::has_debug() ) {
				// phpcs:disable WordPress.PHP.DevelopmentFunctions
				error_log( 'Failed to connect to the WP Files.' );
				// phpcs:enable
			}
			request_filesystem_credentials( $form_url, '', true, $context, $extra_fields );
			return null;
		}

		return $wp_filesystem;
	}
}
