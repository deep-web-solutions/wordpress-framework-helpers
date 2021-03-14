<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use DeepWebSolutions\Framework\Helpers\DataTypes\Booleans;
use UnitTester;

/**
 * Tests for the boolean helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class BooleansCest {
	// region LIFECYCLE

	/**
	 * Define the WP-specific ABSPATH constant such that the tests don't exit.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function _before( UnitTester $I ): void {
		defined( 'ABSPATH' ) || define( 'ABSPATH', __DIR__ );
	}

	// endregion

	// region TESTS

	/**
	 * Test the 'logical_or' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_logical_or( UnitTester $I ) {
		$I->assertEquals( true, Booleans::logical_or( true, true ) );
		$I->assertEquals( true, Booleans::logical_or( true, false ) );
		$I->assertEquals( true, Booleans::logical_or( false, true ) );
		$I->assertEquals( false, Booleans::logical_or( false, false ) );
	}

	/**
	 * Test the 'logical_and' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_logical_and( UnitTester $I ) {
		$I->assertEquals( true, Booleans::logical_and( true, true ) );
		$I->assertEquals( false, Booleans::logical_and( true, false ) );
		$I->assertEquals( false, Booleans::logical_and( false, true ) );
		$I->assertEquals( false, Booleans::logical_and( false, false ) );
	}

	// endregion
}
