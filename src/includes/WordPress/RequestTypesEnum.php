<?php

namespace DeepWebSolutions\Framework\Helpers\WordPress;

/**
 * Valid values for request types.
 *
 * @see     Request::is_request()
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Helpers\WordPress
 */
final class RequestTypesEnum {
	/**
	 * Enum-type constant for referring to an admin request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  ADMIN_REQUEST
	 */
	public const ADMIN_REQUEST = 'admin';

	/**
	 * Enum-type constant for referring to an ajax request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  AJAX_REQUEST
	 */
	public const AJAX_REQUEST = 'ajax';

	/**
	 * Enum-type constant for identifying a cron request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  CRON_REQUEST
	 */
	public const CRON_REQUEST = 'cron';

	/**
	 * Enum-type constant for referring to a REST request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  REST_REQUEST
	 */
	public const REST_REQUEST = 'rest';

	/**
	 * Enum-type constant for referring to a frontend request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  FRONTEND_REQUEST
	 */
	public const FRONTEND_REQUEST = 'frontend';
}
