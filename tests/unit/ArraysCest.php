<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use Codeception\Example;
use DeepWebSolutions\Framework\Helpers\DataTypes\Arrays;
use UnitTester;

/**
 * Tests for the array helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class ArraysCest {
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
	 * Test the 'has_string_keys' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    has_string_keys_provider
	 */
	public function test_has_string_keys( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Arrays::has_string_keys( $example['array'] ) );
	}

	/**
	 * Test the 'insert_after' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    insert_after_provider
	 */
	public function test_insert_after( UnitTester $I, Example $example ) {
		$new_array = Arrays::insert_after( $example['original'], $example['key'], $example['insert'] );

		$I->assertEquals( count( $new_array ), count( $example['original'] ) + count( $example['insert'] ) );
		$I->assertEquals( true, $new_array === $example['expected'] );
	}

	/**
	 * Test the 'search_values' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    search_values_provider
	 */
	public function test_search_values( UnitTester $I, Example $example ) {
		$result = Arrays::search_values( $example['array'], $example['needle'], $example['strict'], $example['callback'] );

		if ( is_null( $example['expected'] ) ) {
			$I->assertNull( $result );
		} else {
			$I->assertEquals( true, $example['expected'] === $result );
		}
	}

	/**
	 * Test the 'search_keys' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    search_keys_provider
	 */
	public function test_search_keys( UnitTester $I, Example $example ) {
		$result = Arrays::search_keys( $example['array'], $example['needle'], $example['strict'], $example['callback'] );

		if ( is_null( $example['expected'] ) ) {
			$I->assertNull( $result );
		} else {
			$I->assertEquals( true, $example['expected'] === $result );
		}
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'has_string_keys' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function has_string_keys_provider(): array {
		return array(
			array(
				'array'    => array(
					'string1' => 1,
					'string2' => 2,
					'string3' => 3,
				),
				'expected' => true,
			),
			array(
				'array'    => array(
					1 => 1,
					2 => 2,
					3 => 3,
				),
				'expected' => false,
			),
			array(
				'array'    => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
				),
				'expected' => false, // PHP automatically converts numeric keys to integers since PHP4.
			),
		);
	}

	/**
	 * Provides examples for the 'insert_after' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function insert_after_provider(): array {
		return array(
			array(
				'original' => array(
					'apple'      => 'apple',
					'banana'     => 'banana',
					'cantaloupe' => 'cantaloupe',
					'dates'      => 'dates',
				),
				'key'      => 'banana',
				'insert'   => array(
					'elderberry'  => 'elderberry',
					'dragonfruit' => 'dragonfruit',
				),
				'expected' => array(
					'apple'       => 'apple',
					'banana'      => 'banana',
					'elderberry'  => 'elderberry',
					'dragonfruit' => 'dragonfruit',
					'cantaloupe'  => 'cantaloupe',
					'dates'       => 'dates',
				),
			),
			array(
				'original' => array( 'apple', 'banana', 'cantaloupe', 'dates' ),
				'key'      => 1,
				'insert'   => array( 'elderberry', 'dragonfruit' ),
				'expected' => array( 'apple', 'banana', 'elderberry', 'dragonfruit', 'cantaloupe', 'dates' ),
			),
			array(
				'original' => array(
					'apple'      => 'apple',
					21433        => 'banana',
					'cantaloupe' => 'cantaloupe',
					5755         => 'dates',
				),
				'key'      => 21433,
				'insert'   => array(
					'elderberry' => 'elderberry',
					633446       => 'dragonfruit',
				),
				'expected' => array(
					'apple'      => 'apple',
					21433        => 'banana',
					'elderberry' => 'elderberry',
					633446       => 'dragonfruit',
					'cantaloupe' => 'cantaloupe',
					5755         => 'dates',
				),
			),
		);
	}

	/**
	 * Provides examples for the 'search_values' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function search_values_provider(): array {
		return array(
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => 3,
				'strict'   => true,
				'callback' => null,
				'expected' => array(
					2 => 3,
					6 => 3,
				),
			),

			// Test the 'strict' argument.
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => '3',
				'strict'   => true,
				'callback' => null,
				'expected' => null,
			),
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => '3',
				'strict'   => false,
				'callback' => null,
				'expected' => array(
					2 => 3,
					6 => 3,
				),
			),

			// Test the 'callable' argument.
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => true,
				'strict'   => false,
				'callback' => function( int $entry ) {
					return 3 === $entry;
				},
				'expected' => array(
					2 => 3,
					6 => 3,
				),
			),
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => '3',
				'strict'   => true,
				'callback' => function( int $entry ) {
					return strval( $entry );
				},
				'expected' => array(
					2 => 3,
					6 => 3,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'search_keys' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function search_keys_provider(): array {
		return array(
			array(
				'array'    => array( 1, 2, 3, 4, 5, 6, 3, 7, 8, 9, 10 ),
				'needle'   => 3,
				'strict'   => true,
				'callback' => null,
				'expected' => array( 3 => 3 ),
			),
			array(
				'array'    => array(
					25252  => 1,
					46566  => 2,
					464432 => 3,
				),
				'needle'   => 46566,
				'strict'   => true,
				'callback' => null,
				'expected' => array( 1 => 46566 ),
			),

			// Test the 'strict' argument.
			array(
				'array'    => array(
					25252  => 1,
					46566  => 2,
					464432 => 3,
				),
				'needle'   => '46566',
				'strict'   => false,
				'callback' => null,
				'expected' => array( 1 => 46566 ),
			),
			array(
				'array'    => array(
					25252  => 1,
					46566  => 2,
					464432 => 3,
				),
				'needle'   => '46566',
				'strict'   => true,
				'callback' => null,
				'expected' => null,
			),

			// Test the 'callback' argument.
			array(
				'array'    => array(
					25252  => 1,
					46566  => 2,
					464432 => 3,
				),
				'needle'   => '46566',
				'strict'   => true,
				'callback' => function( int $key ) {
					return strval( $key );
				},
				'expected' => array( 1 => 46566 ),
			),
			array(
				'array'    => array(
					'string1' => 1,
					'strnig2' => 2,
					'string3' => 3,
				), // intentional misspelling
				'needle'   => true,
				'strict'   => true,
				'callback' => function( string $key ) {
					return strpos( $key, 'string' ) !== false;
				},
				'expected' => array(
					0 => 'string1',
					2 => 'string3',
				),
			),
		);
	}

	// endregion
}
