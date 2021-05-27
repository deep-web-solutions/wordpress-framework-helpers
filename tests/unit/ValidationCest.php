<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use Codeception\Example;
use DeepWebSolutions\Framework\Helpers\DataTypes\Arrays;
use DeepWebSolutions\Framework\Helpers\DataTypes\Booleans;
use DeepWebSolutions\Framework\Helpers\DataTypes\Callables;
use DeepWebSolutions\Framework\Helpers\DataTypes\Floats;
use DeepWebSolutions\Framework\Helpers\DataTypes\Integers;
use UnitTester;

/**
 * Tests for the validation helpers.
 *
 * @since   1.0.0
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class ValidationCest {
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
	 * Test the 'validate_boolean' helper.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    validate_boolean_provider
	 */
	public function test_validate_boolean( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Booleans::maybe_cast( $example['value'], $example['default'] ) );
	}

	/**
	 * Test the 'validate_integer' helper.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    validate_integer_provider
	 */
	public function test_validate_integer( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Integers::maybe_cast( $example['value'], $example['default'] ) );
	}

	/**
	 * Test the 'validate_float' helper.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    validate_float_provider
	 */
	public function test_validate_float( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Floats::maybe_cast( $example['value'], $example['default'] ) );
	}

	/**
	 * Test the 'validate_callable' helper.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    validate_callable_provider
	 */
	public function test_validate_callable( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Callables::validate( $example['value'], $example['default'] ) );
	}

	/**
	 * Test the 'validate_allowed_value' helper.
	 *
	 * @since   1.0.0
	 * @version 1.4.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    validate_allowed_value_provider
	 */
	public function test_validate_allowed_value( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Arrays::validate_allowed_value( $example['value'], $example['allowed'], $example['default'] ) );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'validate_boolean' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function validate_boolean_provider(): array {
		return array(
			array(
				'value'    => true,
				'default'  => false,
				'expected' => true,
			),
			array(
				'value'    => false,
				'default'  => true,
				'expected' => false,
			),
			array(
				'value'    => 'yes',
				'default'  => false,
				'expected' => true,
			),
			array(
				'value'    => 'yes2',
				'default'  => true,
				'expected' => true,
			),
			array(
				'value'    => 'yes2',
				'default'  => false,
				'expected' => false,
			),
			array(
				'value'    => '1',
				'default'  => false,
				'expected' => true,
			),
			array(
				'value'    => '12',
				'default'  => true,
				'expected' => true,
			),
			array(
				'value'    => '12',
				'default'  => false,
				'expected' => false,
			),
			array(
				'value'    => 'true',
				'default'  => false,
				'expected' => true,
			),
			array(
				'value'    => 'true2',
				'default'  => true,
				'expected' => true,
			),
			array(
				'value'    => 'true2',
				'default'  => false,
				'expected' => false,
			),
			array(
				'value'    => 'on',
				'default'  => false,
				'expected' => true,
			),
			array(
				'value'    => 'on2',
				'default'  => true,
				'expected' => true,
			),
			array(
				'value'    => 'on2',
				'default'  => false,
				'expected' => false,
			),
		);
	}

	/**
	 * Provides examples for the 'validate_integer' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function validate_integer_provider(): array {
		return array(
			array(
				'value'    => 15,
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => '15',
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => 017, // 15 in octal
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => '017', // 15 in octal
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => 0xF, // 15 in hexadecimal
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => '0xF', // 15 in hexadecimal
				'default'  => 20,
				'expected' => 15,
			),
			array(
				'value'    => 'not a number',
				'default'  => 20,
				'expected' => 20,
			),
		);
	}

	/**
	 * Provides examples for the 'validate_float' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function validate_float_provider(): array {
		return array(
			array(
				'value'    => '19.5',
				'default'  => 20,
				'expected' => 19.5,
			),
			array(
				'value'    => '19,500.5',
				'default'  => 20,
				'expected' => 19500.5,
			),
			array(
				'value'    => '19500.5',
				'default'  => 20,
				'expected' => 19500.5,
			),
			array(
				'value'    => '19,5',
				'default'  => 20,
				'expected' => 19.5,
			),
			array(
				'value'    => '19.500,5',
				'default'  => 20,
				'expected' => 19500.5,
			),
			array(
				'value'    => '19500,5',
				'default'  => 20,
				'expected' => 19500.5,
			),
			array(
				'value'    => 'not a number',
				'default'  => 20.5,
				'expected' => 20.5,
			),
		);
	}

	/**
	 * Provides examples for the 'validate_callback' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function validate_callable_provider(): array {
		return array(
			array(
				'value'    => 'is_string',
				'default'  => 'is_numeric',
				'expected' => 'is_string',
			),
			array(
				'value'    => 'is_string2',
				'default'  => 'is_numeric',
				'expected' => 'is_numeric',
			),
			array(
				'value'    => ( $func = function() {} ), // phpcs:ignore
				'default'  => 'is_numeric',
				'expected' => $func,
			),
		);
	}

	/**
	 * Provides examples for the 'validate_allowed_value' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function validate_allowed_value_provider(): array {
		return array(
			array(
				'value'    => 'ID',
				'allowed'  => array( 'ID', 'post_title', 'post_content' ),
				'default'  => 'name',
				'expected' => 'ID',
			),
			array(
				'value'    => 'ID  ', // white-space intentional
				'allowed'  => array( 'ID', 'post_title', 'post_content' ),
				'default'  => 'name',
				'expected' => 'ID',
			),
			array(
				'value'    => 'name',
				'allowed'  => array( 'ID', 'post_title', 'post_content' ),
				'default'  => 'ID',
				'expected' => 'ID',
			),
		);
	}

	// endregion
}
