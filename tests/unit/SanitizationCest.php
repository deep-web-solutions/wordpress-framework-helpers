<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use Codeception\Example;
use DeepWebSolutions\Framework\Helpers\Security\Sanitization;
use UnitTester;

/**
 * Tests for the sanitization helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class SanitizationCest {
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
	 * Test the 'sanitize_integer' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    sanitize_integer_provider
	 */
	public function test_sanitize_integer( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Sanitization::sanitize_integer( $example['value'], $example['default'] ) );
	}

	/**
	 * Test the 'sanitize_float' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    sanitize_float_provider
	 */
	public function test_sanitize_float( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Sanitization::sanitize_float( $example['value'], $example['default'] ) );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'sanitize_integer' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function sanitize_integer_provider(): array {
		return array(
			array(
				'value'    => 523,
				'default'  => 0,
				'expected' => 523,
			),
			array(
				'value'    => -523,
				'default'  => 0,
				'expected' => -523,
			),
			array(
				'value'    => '523',
				'default'  => 0,
				'expected' => 523,
			),
			array(
				'value'    => '-523',
				'default'  => 0,
				'expected' => -523,
			),
			array(
				'value'    => '5-2+3pp',
				'default'  => 0,
				'expected' => 523,
			),
			array(
				'value'    => '-5-2+3pp',
				'default'  => 0,
				'expected' => -523,
			),
			array(
				'value'    => '-+pp',
				'default'  => 0,
				'expected' => 0,
			),
		);
	}

	/**
	 * Provides examples for the 'sanitize_float' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function sanitize_float_provider(): array {
		return array(
			array(
				'value'    => 523.3,
				'default'  => 0,
				'expected' => 523.3,
			),
			array(
				'value'    => -523.3,
				'default'  => 0,
				'expected' => -523.3,
			),
			array(
				'value'    => '523.3',
				'default'  => 0,
				'expected' => 523.3,
			),
			array(
				'value'    => '-523.3',
				'default'  => 0,
				'expected' => -523.3,
			),
			array(
				'value'    => '5-2f+3.3pp',
				'default'  => 0,
				'expected' => 523.3,
			),
			array(
				'value'    => '-5-2f+3.3pp',
				'default'  => 0,
				'expected' => -523.3,
			),
			array(
				'value'    => '5-2f+3,4g5/3.3pp',
				'default'  => 0,
				'expected' => 523453.3,
			),
			array(
				'value'    => '-5-2f+3,4g/3.3pp', // there's too few numbers between the comma and the dot
				'default'  => 0,
				'expected' => 0,
			),
			array(
				'value'    => '-5-2f+34g/3,3pp',
				'default'  => 0,
				'expected' => -52343.3,
			),
			array(
				'value'    => '1.2e3',
				'default'  => 0,
				'expected' => 1200,
			),
			array(
				'value'    => '-1.2e3',
				'default'  => 0,
				'expected' => -1200,
			),
			array(
				'value'    => '1fsh,2e3',
				'default'  => 0,
				'expected' => 1200,
			),
			array(
				'value'    => '7E-10',
				'default'  => 0,
				'expected' => 0.0000000007,
			),
			array(
				'value'    => '1_234.567',
				'default'  => 0,
				'expected' => 1234.567,
			),
		);
	}

	// endregion
}
