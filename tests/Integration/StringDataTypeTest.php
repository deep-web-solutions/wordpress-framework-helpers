<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\ObjectDataType;
use DeepWebSolutions\Framework\Helpers\DataType\StringDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class StringDataTypeTest extends WPTestCase {
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
			// Basic string values
			array( 'input' => 'string', 'expected' => true ),
			array( 'input' => 'string with spaces', 'expected' => true ),

			// Invalid string values
			array( 'input' => 123, 'expected' => false ),
			array( 'input' => 123.456, 'expected' => false ),
			array( 'input' => array(), 'expected' => false ),
			array( 'input' => new \stdClass(), 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => true, 'expected' => false ),
			array( 'input' => false, 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = StringDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic string values
			array( 'input' => 'string', 'expected' => 'string' ),
			array( 'input' => 'string with spaces', 'expected' => 'string with spaces' ),

			// Invalid string values
			array( 'input' => 123, 'expected' => null ),
			array( 'input' => 123.456, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = StringDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Basic string values
			array( 'input' => 'string', 'expected' => 'string' ),
			array( 'input' => 'string with spaces', 'expected' => 'string with spaces' ),

			// Not-a-string values
			array( 'input' => 123, 'expected' => '123' ),
			array( 'input' => 123.456, 'expected' => '123.456' ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => true, 'expected' => 'yes' ),
			array( 'input' => false, 'expected' => 'no' ),

			// Fallback values
			array( 'input' => new \stdClass(), 'fallback' => 'fallback', 'expected' => 'fallback' ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = StringDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] == $case['expected'], 'Failed for case: ' . \print_r( $case, true ) ); // Loose comparison
		}
	}

	// endregion
}
