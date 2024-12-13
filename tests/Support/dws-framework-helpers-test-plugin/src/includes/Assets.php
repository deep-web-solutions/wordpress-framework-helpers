<?php

namespace DeepWebSolutions\Framework\tests\_support\dws-wp-helpers-test-plugin\src\includes;

use DeepWebSolutions\Framework\Helpers\AssetsHelpersAwareInterface;
use DeepWebSolutions\Framework\Helpers\AssetsHelpersTrait;

/**
 * Class Assets
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers
 */
class Assets implements AssetsHelpersAwareInterface {
	use AssetsHelpersTrait;
}
