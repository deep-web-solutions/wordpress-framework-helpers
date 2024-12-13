<?php

namespace DeepWebSolutions\Framework\tests\_support\dws-wp-helpers-test-plugin\src\includes;

use DeepWebSolutions\Framework\Helpers\FileSystem\FilesystemAwareTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\PathsTrait;

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
