<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\ArrayDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class ArrayDataTypeTest extends WPTestCase {
	// region FIELDS AND CONSTANTS

	/**
	 * @var \IntegrationTester
	 */
	protected $tester;

	// endregion

	// region LIFECYCLE

	/**
	 * {@inheritDoc}
	 */
	public function setUp(): void {
		parent::setUp();
		// Your set-up methods here.
	}

	/**
	 * {@inheritDoc}
	 */
	public function tearDown(): void {
		// Your tear down methods here.
		parent::tearDown();
	}

	// endregion

	// region TESTS

	public function test_check(): void {
		$cases = array(
			// Basic array values
			array( 'input' => array(), 'expected' => true ),
			array( 'input' => array( 1, 2, 3 ), 'expected' => true ),
			array( 'input' => array( 'a' => 1, 'b' => 2, 'c' => 3 ), 'expected' => true ),

			// Not-an-array values
			array( 'input' => true, 'expected' => false ),
			array( 'input' => false, 'expected' => false ),
			array( 'input' => 99, 'expected' => false ),
			array( 'input' => 7E-10, 'expected' => false ),
			array( 'input' => -3.14, 'expected' => false ),
			array( 'input' => 0.0, 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => new \stdClass(), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ArrayDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic array values
			array( 'input' => array(), 'expected' => array() ),
			array( 'input' => array( 1, 2, 3 ), 'expected' => array( 1, 2, 3 ) ),
			array( 'input' => array( 'a' => 1, 'b' => 2, 'c' => 3 ), 'expected' => array( 'a' => 1, 'b' => 2, 'c' => 3 ) ),

			// Not-an-array values
			array( 'input' => true, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => 99, 'expected' => null ),
			array( 'input' => 7E-10, 'expected' => null ),
			array( 'input' => -3.14, 'expected' => null ),
			array( 'input' => 0.0, 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),

			// Fallback values
			array( 'input' => true, 'fallback' => array(), 'expected' => array() ),
			array( 'input' => false, 'fallback' => array( 1, 2, 3 ), 'expected' => array( 1, 2, 3 ) ),
			array( 'input' => 99, 'fallback' => array( 'a' => 1, 'b' => 2, 'c' => 3 ), 'expected' => array( 'a' => 1, 'b' => 2, 'c' => 3 ) ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ArrayDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Basic array values
			array( 'input' => array(), 'expected' => array() ),
			array( 'input' => array( 1, 2, 3 ), 'expected' => array( 1, 2, 3 ) ),
			array( 'input' => array( 'a' => 1, 'b' => 2 ), 'expected' => array( 'a' => 1, 'b' => 2 ) ),

			// Not-an-array values
			array( 'input' => null, 'expected' => null ),
			array( 'input' => '', 'expected' => array( '' ) ),
			array( 'input' => 'invalid', 'expected' => array( 'invalid' ) ),
			array( 'input' => 123, 'expected' => array( 123 ) ),
			array( 'input' => true, 'expected' => array( true ) ),

			// Fallback values
			array( 'input' => null, 'fallback' => array( 1, 2, 3 ), 'expected' => array( 1, 2, 3 ) ),

			// Edge cases
			array( 'input' => 'lorem ipsum', 'expected' => array( 'lorem ipsum' ) ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ArrayDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	// endregion
}
