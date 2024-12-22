<?php

namespace Tests;

use DeepWebSolutions\Framework\Helpers\DataType\ObjectDataType;
use lucatume\WPBrowser\TestCase\WPTestCase;

class ObjectDataTypeTest extends WPTestCase {
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
			// Basic object values
			array( 'input' => new \stdClass(), 'expected' => true ),
			array( 'input' => $GLOBALS['wpdb'], 'expected' => true ),
			array( 'input' => new \WP_User( 0 ), 'expected' => true ),
			array( 'input' => (object) array(), 'expected' => true ),

			// Not-an-object values
			array( 'input' => 'string', 'expected' => false ),
			array( 'input' => 123, 'expected' => false ),
			array( 'input' => null, 'expected' => false ),
			array( 'input' => true, 'expected' => false ),
			array( 'input' => false, 'expected' => false ),
			array( 'input' => array(), 'expected' => false ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ObjectDataType::check( $case['input'] );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_validate(): void {
		$cases = array(
			// Basic object values
			array( 'input' => ( $obj = new \stdClass() ), 'expected' => $obj ),
			array( 'input' => $GLOBALS['wpdb'], 'expected' => $GLOBALS['wpdb'] ),
			array( 'input' => ( $obj = new \WP_User( 0 ) ), 'expected' => $obj ),
			array( 'input' => ( $obj = (object) array() ), 'expected' => $obj ),

			// Not-an-object values
			array( 'input' => 'string', 'expected' => null ),
			array( 'input' => 123, 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),
			array( 'input' => array(), 'expected' => null ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ObjectDataType::validate( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] === $case['expected'], 'Failed for case: ' . \print_r( $case, true ) );
		}
	}

	public function test_maybe_cast(): void {
		$cases = array(
			// Basic object values
			array( 'input' => ( $obj = new \stdClass() ), 'expected' => $obj ),
			array( 'input' => $GLOBALS['wpdb'], 'expected' => $GLOBALS['wpdb'] ),
			array( 'input' => ( $obj = new \WP_User( 0 ) ), 'expected' => $obj ),
			array( 'input' => ( $obj = (object) array() ), 'expected' => $obj ),

			// Not-an-object values
			array( 'input' => 'string', 'expected' => null ),
			array( 'input' => 123, 'expected' => null ),
			array( 'input' => null, 'expected' => null ),
			array( 'input' => true, 'expected' => null ),
			array( 'input' => false, 'expected' => null ),

			// Array to object casting
			array( 'input' => array(), 'expected' => new \stdClass() ),
			array( 'input' => array( 'key' => 'value' ), 'expected' => (object) array( 'key' => 'value' ) ),
			array( 'input' => array( 'nested' => array('key' => 'value') ), 'expected' => (object) array( 'nested' => array( 'key' => 'value' ) ) ),
			array( 'input' => array( 1, 2, 3 ), 'expected' => (object) array( 0 => 1, 1 => 2, 2 => 3 ) ),

			// JSON string values
			array( 'input' => '{}', 'expected' => new \stdClass() ),
			array( 'input' => '{"key":"value"}', 'expected' => (object) array('key' => 'value') ),
			array( 'input' => '{"nested":{"key":"value"}}', 'expected' => (object) array('nested' => (object) array( 'key' => 'value' ) ) ),
			array( 'input' => '{"bool":true,"null":null}', 'expected' => (object) array( 'bool' => true, 'null' => null ) ),

			// Invalid JSON strings
			array( 'input' => '{invalid json}', 'expected' => null ),
			array( 'input' => '[invalid json]', 'expected' => null ),
			array( 'input' => '{"unclosed": "object"', 'expected' => null ),

			// Serialized values
			array( 'input' => serialize( new \stdClass() ), 'expected' => new \stdClass() ),
			array( 'input' => serialize( (object) array( 'key' => 'value' ) ), 'expected' => (object) array( 'key' => 'value' ) ),
			array( 'input' => serialize( (object) array( 'nested' => (object) array( 'key' => 'value' ) ) ), 'expected' => (object) array( 'nested' => (object) array( 'key' => 'value' ) ) ),
			array( 'input' => serialize( (object) array(1, 2, 3) ), 'expected' => (object) array( 0 => 1, 1 => 2, 2 => 3 ) ),

			// Invalid serialized strings
			array( 'input' => 'O:8:"stdClass":1:{s:3:"key";s:5:"value"}', 'expected' => null ), // Malformed serialized string
			array( 'input' => 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 'expected' => null ), // Serialized array (not object)

			// Fallback values
			array( 'input' => 'string', 'fallback' => new \stdClass(), 'expected' => new \stdClass() ),
			array( 'input' => 123, 'fallback' => (object) array('key' => 'value'), 'expected' => (object) array('key' => 'value') ),
			array( 'input' => null, 'fallback' => new \WP_User(0), 'expected' => new \WP_User(0) ),
			array( 'input' => true, 'fallback' => $GLOBALS['wpdb'], 'expected' => $GLOBALS['wpdb'] ),

			// Fallback values with invalid inputs
			array( 'input' => 'invalid json', 'fallback' => new \stdClass(), 'expected' => new \stdClass() ),
			array( 'input' => '{bad json}', 'fallback' => (object) array('key' => 'value'), 'expected' => (object) array('key' => 'value') ),
			array( 'input' => 'bad serialized', 'fallback' => new \WP_User(0), 'expected' => new \WP_User(0) ),
			array( 'input' => 123, 'fallback' => $GLOBALS['wpdb'], 'expected' => $GLOBALS['wpdb'] ),
		);

		foreach ( $cases as $case ) {
			$case['output'] = ObjectDataType::maybe_cast( $case['input'], $case['fallback'] ?? null );
			$this->assertTrue( $case['output'] == $case['expected'], 'Failed for case: ' . \print_r( $case, true ) ); // Loose comparison
		}
	}

	// endregion
}
