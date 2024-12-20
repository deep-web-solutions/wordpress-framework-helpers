<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\BooleanDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class BooleanDataTypeTest extends WPTestCase {
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
			// Basic boolean values
			array( 'input' => true, 'expected' => true ),
			array( 'input' => false, 'expected' => true ),

			// Not-a-boolean values
			array( 'input' => 99, 'expected' => false ),
			array( 'input' => 7E-10, 'expected' => false ),
			array( 'input' => -3.14, 'expected' => false ),
			array( 'input' => 0.0, 'expected' => false ),
			array( 'input' => 'true', 'expected' => false ),
			array( 'input' => 'false', 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => array(), 'expected' => false ),
			array( 'input' => new \stdClass(), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = BooleanDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic boolean values
			array( 'input' => true, 'expected' => true ),
			array( 'input' => false, 'expected' => false ),

			// Not-a-boolean values
			array( 'input' => 99, 'expected' => null ),
			array( 'input' => 7E-10, 'expected' => null ),
			array( 'input' => -3.14, 'expected' => null ),
			array( 'input' => 0.0, 'expected' => null ),
			array( 'input' => 'true', 'expected' => null ),
			array( 'input' => 'false', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),

			// Edge cases with fallbacks
			array( 'input' => "\n\t", 'fallback' => true, 'expected' => true ),
			array( 'input' => '0.0', 'fallback' => false, 'expected' => false ),
			array( 'input' => 'NULL', 'fallback' => true, 'expected' => true ),
			array( 'input' => 'undefined', 'fallback' => false, 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = BooleanDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Direct boolean values
			array( 'input' => true, 'expected' => true ),
			array( 'input' => false, 'expected' => false ),
			array( 'input' => true, 'fallback' => false, 'expected' => true ),
			array( 'input' => false, 'fallback' => true, 'expected' => false ),

			// Truthy string values
			array( 'input' => 'true', 'expected' => true ),
			array( 'input' => 'yes', 'expected' => true ),
			array( 'input' => 'on', 'expected' => true ),
			array( 'input' => '1', 'expected' => true ),
			array( 'input' => 'TRUE', 'expected' => true ),
			array( 'input' => 'YES', 'expected' => true ),
			array( 'input' => 'ON', 'expected' => true ),
			array( 'input' => 'True', 'expected' => true ),
			array( 'input' => 'Yes', 'expected' => true ),
			array( 'input' => 'On', 'expected' => true ),

			// Falsy string values
			array( 'input' => 'false', 'expected' => false ),
			array( 'input' => 'no', 'expected' => false ),
			array( 'input' => 'off', 'expected' => false ),
			array( 'input' => '0', 'expected' => false ),
			array( 'input' => 'FALSE', 'expected' => false ),
			array( 'input' => 'NO', 'expected' => false ),
			array( 'input' => 'OFF', 'expected' => false ),
			array( 'input' => 'False', 'expected' => false ),
			array( 'input' => 'No', 'expected' => false ),
			array( 'input' => 'Off', 'expected' => false ),

			// Numeric values
			array( 'input' => 1, 'expected' => true ),
			array( 'input' => 0, 'expected' => false ),
			array( 'input' => -1, 'expected' => false ),
			array( 'input' => 1.0, 'expected' => true ),
			array( 'input' => 0.0, 'expected' => false ),
			array( 'input' => -1.0, 'expected' => false ),
			array( 'input' => PHP_INT_MAX, 'expected' => true ),
			array( 'input' => PHP_INT_MIN, 'expected' => false ),

			// Special numeric values
			array( 'input' => INF, 'expected' => null ),
			array( 'input' => -INF, 'expected' => null ),
			array( 'input' => NAN, 'expected' => null ),
			array( 'input' => INF, 'fallback' => true, 'expected' => true ),
			array( 'input' => -INF, 'fallback' => false, 'expected' => false ),
			array( 'input' => NAN, 'fallback' => true, 'expected' => true ),

			// Whitespace variations
			array( 'input' => ' true ', 'expected' => true ),
			array( 'input' => ' false ', 'expected' => false ),
			array( 'input' => "\ttrue\t", 'expected' => true ),
			array( 'input' => "\nfalse\n", 'expected' => false ),
			array( 'input' => " \n\t true \t\n ", 'expected' => true ),
			array( 'input' => " \n\t false \t\n ", 'expected' => false ),

			// Empty and null values
			array( 'input' => '', 'expected' => null ),
			array( 'input' => ' ', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => '', 'fallback' => true, 'expected' => true ),
			array( 'input' => ' ', 'fallback' => false, 'expected' => false ),
			array( 'input' => null, 'fallback' => true, 'expected' => true ),

			// Invalid string values with fallbacks
			array( 'input' => 'invalid', 'fallback' => true, 'expected' => true ),
			array( 'input' => 'undefined', 'fallback' => false, 'expected' => false ),
			array( 'input' => 'null', 'fallback' => true, 'expected' => true ),
			array( 'input' => 'NULL', 'fallback' => false, 'expected' => false ),
			array( 'input' => 'bool', 'fallback' => true, 'expected' => true ),
			array( 'input' => 'boolean', 'fallback' => false, 'expected' => false ),

			// Array values
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => array(true), 'expected' => null ),
			array( 'input' => array(false), 'expected' => null ),
			array( 'input' => array(), 'fallback' => true, 'expected' => true ),
			array( 'input' => array(true), 'fallback' => false, 'expected' => false ),

			// Object values
			array( 'input' => new \stdClass(), 'expected' => null ),
			array( 'input' => new \DateTime(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'fallback' => true, 'expected' => true ),
			array( 'input' => new \DateTime(), 'fallback' => false, 'expected' => false ),

			// Special string formats
			array( 'input' => '1.0', 'expected' => true ),
			array( 'input' => '0.0', 'expected' => false ),
			array( 'input' => '+1', 'expected' => true ),
			array( 'input' => '-1', 'expected' => false ),
			array( 'input' => '1e5', 'expected' => true ),
			array( 'input' => '0e5', 'expected' => false ),

			// Mixed case variations
			array( 'input' => 'tRuE', 'expected' => true ),
			array( 'input' => 'FaLsE', 'expected' => false ),
			array( 'input' => 'YeS', 'expected' => true ),
			array( 'input' => 'nO', 'expected' => false ),
			array( 'input' => 'On', 'expected' => true ),
			array( 'input' => 'OfF', 'expected' => false ),

			// Special characters
			array( 'input' => '👍', 'expected' => null ),
			array( 'input' => '❌', 'expected' => null ),
			array( 'input' => '✓', 'expected' => null ),
			array( 'input' => '✗', 'expected' => null ),
			array( 'input' => '👍', 'fallback' => true, 'expected' => true ),
			array( 'input' => '❌', 'fallback' => false, 'expected' => false ),

			// HTML-like strings
			array( 'input' => '<true/>', 'expected' => null ),
			array( 'input' => '<false/>', 'expected' => null ),
			array( 'input' => '<true>value</true>', 'expected' => null ),
			array( 'input' => '<false>value</false>', 'expected' => null ),
			array( 'input' => '<true/>', 'fallback' => true, 'expected' => true ),
			array( 'input' => '<false/>', 'fallback' => false, 'expected' => false ),

			// Edge cases
			array( 'input' => 'true false', 'expected' => null ),
			array( 'input' => 'false true', 'expected' => null ),
			array( 'input' => '10', 'expected' => true ),
			array( 'input' => '00', 'expected' => false ),
			array( 'input' => 'yes no', 'expected' => null ),
			array( 'input' => 'on off', 'expected' => null ),
			array( 'input' => '2', 'expected' => true ),
			array( 'input' => '-0', 'expected' => false ),

			array( 'input' => BooleanDataType::stringify( true ), 'expected' => true ),
			array( 'input' => BooleanDataType::stringify( false ), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = BooleanDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	// endregion
}
