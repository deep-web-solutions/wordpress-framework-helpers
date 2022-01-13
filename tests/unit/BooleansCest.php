<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use DeepWebSolutions\Framework\Helpers\DataTypes\Booleans;
use UnitTester;

/**
 * Tests for the boolean helpers.
 *
 * @since   1.0.0
 * @version 1.7.0
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
	 */
	public function _before(): void {
		defined( 'ABSPATH' ) || define( 'ABSPATH', __DIR__ );
	}

	// endregion

	// region TESTS

	/**
	 * Test the 'validate' helper.
	 *
	 * @since   1.7.0
	 * @version 1.7.0
	 *
	 * @param   UnitTester  $I  Codeception actor instance.
	 *
	 * @return  void
	 */
	public function test_validate( UnitTester $I ) {
		$I->assertEquals( Booleans::validate( true ), true );
		$I->assertEquals( Booleans::validate( false ), false );

		$I->assertNull( Booleans::validate( 'not_bool' ) );
		$I->assertEquals( Booleans::validate( 'not_bool', true ), true );
		$I->assertEquals( Booleans::validate( 'not_bool', false ), false );
	}

	/**
	 * Test the 'maybe_cast' helper.
	 *
	 * @since   1.7.0
	 * @version 1.7.0
	 *
	 * @param   UnitTester  $I  Codeception actor instance.
	 *
	 * @return  void
	 */
	public function test_maybe_cast( UnitTester $I ) {
		$I->assertNull( Booleans::maybe_cast( null ) );
		$I->assertEquals( Booleans::maybe_cast( null, true ), true );
		$I->assertEquals( Booleans::maybe_cast( null, false ), false );

		$I->assertEquals( Booleans::maybe_cast( true ), true );
		$I->assertEquals( Booleans::maybe_cast( false ), false );

		$I->assertEquals( Booleans::maybe_cast( 'yes' ), true );
		$I->assertEquals( Booleans::maybe_cast( 'no' ), false );

		$I->assertEquals( Booleans::maybe_cast( '1' ), true );
		$I->assertEquals( Booleans::maybe_cast( '0' ), false );
	}

	/**
	 * Test the 'resolve' helper.
	 *
	 * @since   1.7.0
	 * @version 1.7.0
	 *
	 * @param   UnitTester  $I  Codeception actor instance.
	 *
	 * @return  void
	 */
	public function test_resolve( UnitTester $I ) {
		$I->assertEquals( Booleans::resolve( true ), true );
		$I->assertEquals( Booleans::resolve( false ), false );

		$I->assertEquals( Booleans::resolve( fn() => true ), true );
		$I->assertEquals( Booleans::resolve( fn() => false ), false );

		$I->assertNull( Booleans::resolve( array( $this, 'get_bool' ) ) );
		$I->assertEquals( Booleans::resolve( array( $this, 'get_bool' ), null, array( true ) ), true );
		$I->assertEquals( Booleans::resolve( array( $this, 'get_bool' ), null, array( false ) ), false );
		$I->assertEquals( Booleans::resolve( array( $this, 'get_bool' ), true ), true );
		$I->assertEquals( Booleans::resolve( array( $this, 'get_bool' ), false ), false );
	}

	/**
	 * Test the 'to_string' helper.
	 *
	 * @since   1.7.0
	 * @version 1.7.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 *
	 * @return void
	 */
	public function test_to_string( UnitTester $I ) {
		$I->assertEquals( 'yes', Booleans::to_string( true ) );
		$I->assertEquals( 'no', Booleans::to_string( false ) );
	}

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

	// region HELPERS

	/**
	 * Returns a given bool.
	 *
	 * @since   1.7.0
	 * @version 1.7.0
	 *
	 * @param   null|bool   $bool   Bool to return.
	 *
	 * @return  bool|null
	 */
	public function get_bool( ?bool $bool = null ): ?bool {
		return $bool;
	}

	// endregion
}
