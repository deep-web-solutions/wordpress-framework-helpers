<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Integration;

use Codeception\TestCase\WPTestCase;
use WpunitTester;

/**
 * Tests for the WP hooks helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Integration
 */
class HooksTest extends WPTestCase {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the WP actor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     WpunitTester
	 */
	protected WpunitTester $tester;

	// endregion

	// region LIFECYCLE

	/**
	 * Logic to execute before the tests are run.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function setUp(): void {
		// Before...
		parent::setUp();

		// Your set up methods here.
	}

	/**
	 * Logic to execute after the tests are run.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function tearDown(): void {
		// Your tear down methods here.

		// Then...
		parent::tearDown();
	}

	// endregion

	// region TESTS

	// endregion
}
