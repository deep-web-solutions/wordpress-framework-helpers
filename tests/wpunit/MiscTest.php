<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Helpers\WordPress\Misc;
use WpunitTester;

/**
 * Tests for the WP misc helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Integration
 */
class MiscTest extends WPTestCase {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the WP actor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     WpunitTester
	 */
	protected WpunitTester $tester;

	// endregion

	// region TESTS

	/**
	 * Test for the 'wp_parse_args_recursive' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array     $example    Example to run the test on.
	 *
	 * @dataProvider    _wp_parse_args_recursive_provider
	 */
	public function test_wp_parse_args_recursive( array $example ) {
		$this->assertEquals( true, Misc::wp_parse_args_recursive( $example['args'], $example['defaults'] ) === $example['expected'] );
	}

	/**
	 * Test for the 'get_midnight_unix_timestamp' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_get_midnight_unix_timestamp() {
		$func = function() {
			return 'America/New_York';
		};
		add_filter( 'pre_option_timezone_string', $func );
		$ny_time_midnight = Misc::get_midnight_unix_timestamp();
		remove_filter( 'pre_option_timezone_string', $func );

		$this->assertEquals( $ny_time_midnight, Misc::get_midnight_unix_timestamp( 'America/New_York' ) );

		$func = function() {
			return 'America/Los_Angeles';
		};
		add_filter( 'pre_option_timezone_string', $func );
		$la_time_midnight = Misc::get_midnight_unix_timestamp();
		remove_filter( 'pre_option_timezone_string', $func );

		$this->assertEquals( $la_time_midnight, Misc::get_midnight_unix_timestamp( 'America/Los_Angeles' ) );

		// NY is 3 hours ahead of LA;
		$this->assertEquals( ( $la_time_midnight - $ny_time_midnight ), 60 * 60 * 3 );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'wp_parse_args_recursive' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	public function _wp_parse_args_recursive_provider(): array {
		return array(
			array(
				array(
					'args'     => array(),
					'defaults' => array(),
					'expected' => array(),
				),
			),
			array(
				array(
					'args'     => array(),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
				),
			),
			array(
				array(
					'args'     => array(
						'query' => 'test2',
					),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test2',
					),
				),
			),
			array(
				array(
					'args'     => array(
						'layout' => array(
							'use_ajax' => 'no',
						),
					),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'no',
						),
						'query'  => 'test',
					),
				),
			),
			array(
				array(
					'args'     => array(
						'layout' => array(
							'columns' => array(),
						),
					),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array(),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
				),
			),
			array(
				array(
					'args'     => array(
						'layout' => array(
							'columns' => array( 'name', 'add-to-cart' ),
						),
					),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array( 'name', 'add-to-cart' ),
							'use_ajax' => 'yes',
						),
						'query'  => 'test',
					),
				),
			),
			array(
				array(
					'args'     => array(
						'layout' => array(
							'params' => array(
								'perf'         => 'yes',
								'integrations' => array(
									'do' => 'yes',
									'wc' => 'no',
								),
							),
						),
					),
					'defaults' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
							'params'   => array(
								'perf'         => 'no',
								'integrations' => array(
									'do' => 'no',
									'wc' => 'yes',
								),
								'test'         => array(
									'test2' => 'no',
									'test3' => 'yes',
								),
							),
						),
						'query'  => 'test',
					),
					'expected' => array(
						'layout' => array(
							'columns'  => array( 'name', 'sku', 'description' ),
							'use_ajax' => 'yes',
							'params'   => array(
								'perf'         => 'yes',
								'integrations' => array(
									'do' => 'yes',
									'wc' => 'no',
								),
								'test'         => array(
									'test2' => 'no',
									'test3' => 'yes',
								),
							),
						),
						'query'  => 'test',
					),
				),
			),
		);
	}

	// endregion
}
