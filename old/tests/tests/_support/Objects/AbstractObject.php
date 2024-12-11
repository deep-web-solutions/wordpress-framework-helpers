<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Support\Objects;

use DeepWebSolutions\Framework\Helpers\FileSystem\FilesystemAwareTrait;

/**
 * Class AbstractObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Support\Objects
 */
abstract class AbstractObject {
	use FilesystemAwareTrait;
}
