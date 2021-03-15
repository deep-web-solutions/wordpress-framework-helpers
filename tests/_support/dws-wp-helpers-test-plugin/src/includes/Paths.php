<?php

namespace DeepWebSolutions\Framework\Tests\Helpers;

use DeepWebSolutions\Framework\Helpers\FileSystem\FilesystemAwareTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\Objects\PathsTrait;

/**
 * Class Paths
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers
 */
class Paths {
	use FilesystemAwareTrait;
	use PathsTrait;
}
