<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\CallableDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class CallableDataTypeTest extends WPTestCase {
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
			// Basic callable values
			array( 'input' => 'is_string', 'expected' => true ),
			array( 'input' => 'is_int', 'expected' => true ),

			// Invalid callable values
			array( 'input' => 'is_string_', 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = CallableDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic callable values
			array( 'input' => 'is_string', 'expected' => 'is_string' ),
			array( 'input' => 'is_int', 'expected' => 'is_int' ),
			array( 'input' => ( $func = function() {} ), 'expected' => $func ),

			// Invalid callable values
			array( 'input' => 'is_string_', 'expected' => null ),

			// Fallback values
			array( 'input' => 'is_string', 'fallback' => 'is_int', 'expected' => 'is_string' ),
			array( 'input' => 'is_string_', 'fallback' => 'is_int', 'expected' => 'is_int' ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = CallableDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	// endregion
}
