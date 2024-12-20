<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\FloatDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class FloatDataTypeTest extends WPTestCase {
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
    public function setUp() :void {
        parent::setUp();
		// Your set-up methods here.
    }

	/**
	 * {@inheritDoc}
	 */
    public function tearDown() :void {
        // Your tear down methods here.
        parent::tearDown();
    }

	// endregion

	// region TESTS

	public function test_check(): void {
		$cases = array(
			// Basic float values
			array( 'input' => 3.14, 'expected' => true ),
			array( 'input' => 1_234.567, 'expected' => true ),
			array( 'input' => 1.2e3, 'expected' => true ),
			array( 'input' => 7E-10, 'expected' => true ),
			array( 'input' => -3.14, 'expected' => true ),
			array( 'input' => 0.0, 'expected' => true ),

			// Special float values
			array( 'input' => INF, 'expected' => false ),
			array( 'input' => -INF, 'expected' => false ),
			array( 'input' => NAN, 'expected' => false ),
			array( 'input' => PHP_FLOAT_MAX, 'expected' => true ),
			array( 'input' => -PHP_FLOAT_MAX, 'expected' => true ),
			array( 'input' => PHP_FLOAT_MIN, 'expected' => true ),
			array( 'input' => -PHP_FLOAT_MIN, 'expected' => true ),

			// Not-a-float values
			array( 'input' => '3.14', 'expected' => false ),
			array( 'input' => '-3.14', 'expected' => false ),
			array( 'input' => '1.2e3', 'expected' => false ),
			array( 'input' => '7E-10', 'expected' => false ),
			array( 'input' => 42, 'expected' => false ),
			array( 'input' => -42, 'expected' => false ),
			array( 'input' => 0, 'expected' => false ),
			array( 'input' => '', 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => false, 'expected' => false ),
			array( 'input' => true, 'expected' => false ),
			array( 'input' => array(), 'expected' => false ),
			array( 'input' => new \stdClass(), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = FloatDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic float values
			array( 'input' => 3.14, 'expected' => 3.14 ),
			array( 'input' => 1_234.567, 'expected' => 1_234.567 ),
			array( 'input' => 1.2e3, 'expected' => 1200.0 ),
			array( 'input' => 7E-10, 'expected' => 7E-10 ),
			array( 'input' => -3.14, 'expected' => -3.14 ),
			array( 'input' => 0.0, 'expected' => 0.0 ),

			// Special float values
			array( 'input' => INF, 'expected' => null ),
			array( 'input' => -INF, 'expected' => null ),
			array( 'input' => NAN, 'expected' => null ),
			array( 'input' => PHP_FLOAT_MAX, 'expected' => PHP_FLOAT_MAX ),
			array( 'input' => -PHP_FLOAT_MAX, 'expected' => -PHP_FLOAT_MAX ),
			array( 'input' => PHP_FLOAT_MIN, 'expected' => PHP_FLOAT_MIN ),
			array( 'input' => -PHP_FLOAT_MIN, 'expected' => -PHP_FLOAT_MIN ),

			// Not-a-float values
			array( 'input' => '3.14', 'expected' => null ),
			array( 'input' => '-3.14', 'expected' => null ),
			array( 'input' => '1.2e3', 'expected' => null ),
			array( 'input' => '7E-10', 'expected' => null ),
			array( 'input' => 42, 'expected' => null ),
			array( 'input' => -42, 'expected' => null ),
			array( 'input' => 0, 'expected' => null ),
			array( 'input' => '', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),

			// Fallback values
			array( 'input' => '3.14', 'fallback' => 9.8596, 'expected' => 9.8596 ),
			array( 'input' => '', 'fallback' => 0.0, 'expected' => 0.0 ),
			array( 'input' => null, 'fallback' => -1.0, 'expected' => -1.0 ),
			array( 'input' => array(), 'fallback' => 42.0, 'expected' => 42.0 ),
			array( 'input' => 'invalid', 'fallback' => 3.14159, 'expected' => 3.14159 ),
			array( 'input' => '$123.45', 'fallback' => 123.45, 'expected' => 123.45 ),
			array( 'input' => '50%', 'fallback' => 0.5, 'expected' => 0.5 ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = FloatDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Basic float values
			array( 'input' => 3.14, 'expected' => 3.14 ),
			array( 'input' => 1_234.567, 'expected' => 1_234.567 ),
			array( 'input' => 1.2e3, 'expected' => 1.2e3 ),
			array( 'input' => 7E-10, 'expected' => 7E-10 ),
			array( 'input' => -3.14, 'expected' => -3.14 ),
			array( 'input' => 0.0, 'expected' => 0.0 ),

			// String representations
			array( 'input' => '3.14', 'expected' => 3.14 ),
			array( 'input' => '-3.14', 'expected' => -3.14 ),
			array( 'input' => '1.2e3', 'expected' => 1200.0 ),
			array( 'input' => '7E-10', 'expected' => 7E-10 ),

			// Thousand separators and different formats
			array( 'input' => '1,234.56', 'expected' => 1234.56 ),
			array( 'input' => '1.234,56', 'expected' => 1234.56 ),
			array( 'input' => '1 234.56', 'expected' => 1234.56 ),
			array( 'input' => '1234,56', 'expected' => 1234.56 ),

			// Integer inputs
			array( 'input' => 42, 'expected' => 42.0 ),
			array( 'input' => '42', 'expected' => 42.0 ),
			array( 'input' => '-42', 'expected' => -42.0 ),

			// Edge cases and invalid inputs
			array( 'input' => '', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => 'abc', 'expected' => null ),
			array( 'input' => '12.34.56', 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),

			// Fallback values
			array( 'input' => 'invalid', 'fallback' => 9.8596, 'expected' => 9.8596 ),
			array( 'input' => '', 'fallback' => 0.0, 'expected' => 0.0 ),
			array( 'input' => null, 'fallback' => -1.0, 'expected' => -1.0 ),
			array( 'input' => array(), 'fallback' => 42.0, 'expected' => 42.0 ),

			// Very large and small numbers
			array( 'input' => '1.23456789e10', 'expected' => 1.23456789e10 ),
			array( 'input' => '0.00000000001', 'expected' => 1e-11 ),
			array( 'input' => PHP_FLOAT_MAX, 'expected' => PHP_FLOAT_MAX ),
			array( 'input' => -PHP_FLOAT_MAX, 'expected' => -PHP_FLOAT_MAX ),
			array( 'input' => PHP_FLOAT_MIN, 'expected' => PHP_FLOAT_MIN ),
			array( 'input' => -PHP_FLOAT_MIN, 'expected' => -PHP_FLOAT_MIN ),

			// Special float values
			array( 'input' => INF, 'expected' => null ),
			array( 'input' => -INF, 'expected' => null ),
			array( 'input' => NAN, 'expected' => null ),

			// Whitespace handling
			array( 'input' => ' 3.14 ', 'expected' => 3.14 ),
			array( 'input' => "\t42.0\n", 'expected' => 42.0 ),

			// Currency-like inputs
			array( 'input' => '$123.45', 'expected' => 123.45 ),
			array( 'input' => '€123,45', 'expected' => 123.45 ),
			array( 'input' => '$123.45', 'expected' => 123.45 ),

			// Percentage inputs
			array( 'input' => '50%', 'expected' => 50.0 ),
			array( 'input' => '50.5%', 'expected' => 50.5 ),

			// Mixed format edge cases
			array('input' => '1,234,567.89', 'expected' => 1234567.89 ),
			array('input' => '1.234.567,89', 'expected' => 1234567.89 ),
			array('input' => '1 234 567.89', 'expected' => 1234567.89 ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = FloatDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	// endregion
}
