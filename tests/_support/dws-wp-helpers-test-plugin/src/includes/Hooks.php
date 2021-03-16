<?php

namespace DeepWebSolutions\Framework\Tests\Helpers;

use DeepWebSolutions\Framework\Helpers\WordPress\Hooks\HooksHelpersAwareInterface;
use DeepWebSolutions\Framework\Helpers\WordPress\Hooks\HooksHelpersTrait;

/**
 * Class Hooks
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers
 */
class Hooks implements HooksHelpersAwareInterface {
	use HooksHelpersTrait;
}
