<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\IntegerDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class IntegerDataTypeTest extends WPTestCase {
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
			// Basic integer values
			array( 'input' => 42, 'expected' => true ),
			array( 'input' => -42, 'expected' => true ),
			array( 'input' => 0, 'expected' => true ),
			array( 'input' => PHP_INT_MAX, 'expected' => true ),
			array( 'input' => PHP_INT_MIN, 'expected' => true ),
			array( 'input' => 1_234_567, 'expected' => true ),
			array( 'input' => 0b1010, 'expected' => true ),
			array( 'input' => 0x1A, 'expected' => true ),

			// Other types
			array( 'input' => 3.14, 'expected' => false ),
			array( 'input' => -3.14, 'expected' => false ),
			array( 'input' => 1.0, 'expected' => false ),
			array( 'input' => 0.0, 'expected' => false ),
			array( 'input' => INF, 'expected' => false ),
			array( 'input' => -INF, 'expected' => false ),
			array( 'input' => NAN, 'expected' => false ),
			array( 'input' => '42', 'expected' => false ),
			array( 'input' => '-42', 'expected' => false ),
			array( 'input' => '0', 'expected' => false ),
			array( 'input' => '1e5', 'expected' => false ),
			array( 'input' => '3.14', 'expected' => false ),
			array( 'input' => '', 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => false, 'expected' => false ),
			array( 'input' => true, 'expected' => false ),
			array( 'input' => array(), 'expected' => false ),
			array( 'input' => new \stdClass(), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = IntegerDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic integer values
			array( 'input' => 42, 'expected' => 42 ),
			array( 'input' => -42, 'expected' => -42 ),
			array( 'input' => 0, 'expected' => 0 ),

			// Special integer values
			array( 'input' => PHP_INT_MAX, 'expected' => PHP_INT_MAX ),
			array( 'input' => PHP_INT_MIN, 'expected' => PHP_INT_MIN ),
			array( 'input' => 1_000_000, 'expected' => 1_000_000 ),
			array( 'input' => 0b1010, 'expected' => 10 ),
			array( 'input' => 0x1A, 'expected' => 26 ),

			// Not-an-integer values
			array( 'input' => 3.14, 'expected' => null ),
			array( 'input' => -3.14, 'expected' => null ),
			array( 'input' => 1.0, 'expected' => null ),
			array( 'input' => 0.0, 'expected' => null ),
			array( 'input' => INF, 'expected' => null ),
			array( 'input' => -INF, 'expected' => null ),
			array( 'input' => NAN, 'expected' => null ),
			array( 'input' => '42', 'expected' => null ),
			array( 'input' => '-42', 'expected' => null ),
			array( 'input' => '0', 'expected' => null ),
			array( 'input' => '', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),

			// Fallback values
			array( 'input' => '42', 'fallback' => 99, 'expected' => 99 ),
			array( 'input' => '', 'fallback' => 0, 'expected' => 0 ),
			array( 'input' => null, 'fallback' => -1, 'expected' => -1 ),
			array( 'input' => array(), 'fallback' => 42, 'expected' => 42 ),
			array( 'input' => 'invalid', 'fallback' => 100, 'expected' => 100 ),
			array( 'input' => 3.14, 'fallback' => 3, 'expected' => 3 ),
			array( 'input' => false, 'fallback' => 99, 'expected' => 99 ),
			array( 'input' => true, 'fallback' => 44, 'expected' => 44 ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = IntegerDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Basic integer values
			array( 'input' => 42, 'expected' => 42 ),
			array( 'input' => -42, 'expected' => -42 ),
			array( 'input' => 0, 'expected' => 0 ),
			array( 'input' => PHP_INT_MAX, 'expected' => PHP_INT_MAX ),
			array( 'input' => PHP_INT_MIN, 'expected' => PHP_INT_MIN ),
			array( 'input' => 1_000_000, 'expected' => 1_000_000 ),

			// String integers
			array( 'input' => '42', 'expected' => 42 ),
			array( 'input' => '-42', 'expected' => -42 ),
			array( 'input' => '0', 'expected' => 0 ),
			array( 'input' => '+42', 'expected' => 42 ),
			array( 'input' => ' 42 ', 'expected' => 42 ),
			array( 'input' => "\t42\n", 'expected' => 42 ),

			// Different number bases
			array( 'input' => '0x1A', 'expected' => 26 ),   // Hexadecimal
			array( 'input' => '0X1a', 'expected' => 26 ),   // Hex case-insensitive
			array( 'input' => '0xFF', 'expected' => 255 ),  // Hex
			array( 'input' => '042', 'expected' => 34 ),    // Octal
			array( 'input' => '0o42', 'expected' => 34 ),   // New octal notation
			array( 'input' => '0b1010', 'expected' => 10 ), // Binary

			// Float values
			array( 'input' => 3.14, 'expected' => 3 ),
			array( 'input' => -3.14, 'expected' => -3 ),
			array( 'input' => 1.0, 'expected' => 1 ),
			array( 'input' => '3.14', 'expected' => 3 ),
			array( 'input' => '-3.14', 'expected' => -3 ),
			array( 'input' => '3,14', 'expected' => 3 ),
			array( 'input' => '-3,14', 'expected' => -3 ),
			array( 'input' => '1.0', 'expected' => 1 ),

			// Number formats
			array( 'input' => '1,234', 'expected' => 1 ),
			array( 'input' => '1.234', 'expected' => 1 ),
			array( 'input' => '1 234', 'expected' => 1234 ),
			array( 'input' => '1e5', 'expected' => 100000 ),
			array( 'input' => '1E5', 'expected' => 100000 ),

			// Invalid inputs
			array( 'input' => '', 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
			array( 'input' => new \stdClass(), 'expected' => null ),
			array( 'input' => 'abc', 'expected' => null ),
			array( 'input' => '12.34.56', 'expected' => null ),
			array( 'input' => INF, 'expected' => null ),
			array( 'input' => -INF, 'expected' => null ),
			array( 'input' => NAN, 'expected' => null ),

			// Special formats
			array( 'input' => '$123', 'expected' => 123 ),
			array( 'input' => '€123', 'expected' => 123 ),
			array( 'input' => '50%', 'expected' => 50 ),
			array( 'input' => '1,234,567', 'expected' => 1234567 ),
			array( 'input' => '1.234.567', 'expected' => 1234567 ),

			// Fallback values
			array( 'input' => 'invalid', 'fallback' => 99, 'expected' => 99 ),
			array( 'input' => '', 'fallback' => 0, 'expected' => 0 ),
			array( 'input' => null, 'fallback' => -1, 'expected' => -1 ),
			array( 'input' => array(), 'fallback' => 42, 'expected' => 42 ),
			array( 'input' => false, 'fallback' => 44, 'expected' => 44 ),
			array( 'input' => true, 'fallback' => 88, 'expected' => 88 ),

			// Edge cases
			array( 'input' => '9223372036854775807', 'expected' => PHP_INT_MAX ),    // Max 64-bit integer
			array( 'input' => '-9223372036854775808', 'expected' => PHP_INT_MIN ),   // Min 64-bit integer
		);

		foreach ( $cases as $case ) {
			$case['output'] = IntegerDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	// endregion
}
