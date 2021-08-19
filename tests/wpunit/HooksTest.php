<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Helpers\WordPress\Hooks;
use WpunitTester;

/**
 * Tests for the WP hooks helpers.
 *
 * @since   1.0.0
 * @version 1.4.1
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Integration
 */
class HooksTest extends WPTestCase {
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
	 * Test for the 'remove_anonymous_object_hook' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_remove_anonymous_object_hook() {
		add_action(
			'dws_wp_framework_helpers_remove_anonymous_object_hook',
			array( $this, '_remove_anonymous_object_hook_dummy' ),
		);

		Hooks::remove_anonymous_object_hook(
			'dws_wp_framework_helpers_remove_anonymous_object_hook',
			self::class,
			'_remove_anonymous_object_hook_dummy'
		);

		do_action( 'dws_wp_framework_helpers_remove_anonymous_object_hook' );
	}

	/**
	 * Test for the 'get_current_hook_priority' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $priority   Priority to test the helper on.
	 *
	 * @dataProvider    _get_current_hook_priority_provider
	 */
	public function test_get_current_hook_priority( int $priority ) {
		add_action(
			'dws_wp_framework_helpers_get_current_hook_priority',
			function( $priority ) {
				$this->assertEquals( $priority, Hooks::get_current_hook_priority() );
			},
			$priority
		);
		do_action( 'dws_wp_framework_helpers_get_current_hook_priority', $priority );
	}

	/**
	 * Test for the 'enqueue_temp' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_enqueue_temp() {
		// Test actions.
		add_action(
			'dws_wp_framework_helpers_enqueue_temp',
			function() {
				$GLOBALS['dws_wp_framework_helpers_enqueue_temp'] = 'original value';
			},
			99
		);
		add_action(
			'dws_wp_framework_helpers_enqueue_temp',
			function( string $expected ) {
				$this->assertEquals( $expected, $GLOBALS['dws_wp_framework_helpers_enqueue_temp'] );
			},
			101
		);

		Hooks::enqueue_temp(
			'dws_wp_framework_helpers_enqueue_temp',
			function() {
				$GLOBALS['dws_wp_framework_helpers_enqueue_temp'] = 'modified value';
			},
			100,
			0
		);
		do_action( 'dws_wp_framework_helpers_enqueue_temp', 'modified value' );

		Hooks::enqueue_temp(
			'dws_wp_framework_helpers_enqueue_temp',
			array( $this, '_enqueue_temp_dummy' ),
			100,
			0
		);
		do_action( 'dws_wp_framework_helpers_enqueue_temp', 'modified value 2' );

		do_action( 'dws_wp_framework_helpers_enqueue_temp', 'original value' );

		// Test filters.
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_2', 'original value' );
		$this->assertEquals( 'original value', $result );

		Hooks::enqueue_temp(
			'dws_wp_framework_helpers_enqueue_temp_2',
			function() {
				return 'modified value';
			},
			100,
			0
		);
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_2', 'original value' );
		$this->assertEquals( 'modified value', $result );

		Hooks::enqueue_temp(
			'dws_wp_framework_helpers_enqueue_temp_2',
			array( $this, '_enqueue_temp_dummy2' ),
			100,
			0
		);
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_2', 'original value' );
		$this->assertEquals( 'modified value 2', $result );

		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_2', 'original value' );
		$this->assertEquals( 'original value', $result );
	}

	/**
	 * Test for the 'enqueue_on_next_tick' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_enqueue_on_next_tick() {
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_on_next_tick', 'original value' );
		$this->assertEquals( 'original value', $result ); // sanity check

		add_filter(
			'dws_wp_framework_helpers_enqueue_on_next_tick',
			function( string $value ) {
				static $iteration = false;

				if ( false === $iteration ) {
					$iteration = true;
				} else {
					Hooks::enqueue_on_next_tick(
						function() {
							return 'modified value';
						}
					);
				}

				return $value;
			}
		);
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_on_next_tick', 'original value' );
		$this->assertEquals( 'original value', $result ); // first time around, filter hasn't been hooked

		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_on_next_tick', 'original value' );
		$this->assertEquals( 'modified value', $result ); // filter has been hooked

		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_on_next_tick', 'original value' );
		$this->assertEquals( 'modified value', $result ); // filter is still hooked
	}

	/**
	 * Test for the 'enqueue_temp_on_next_tick' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_enqueue_temp_on_next_tick() {
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_on_next_tick', 'original value' );
		$this->assertEquals( 'original value', $result ); // sanity check

		add_filter(
			'dws_wp_framework_helpers_enqueue_temp_on_next_tick',
			function( string $value ) {
				static $iteration = false;

				if ( false === $iteration ) {
					$iteration = true;
				} else {
					$iteration = false;
					Hooks::enqueue_temp_on_next_tick(
						function() {
							return 'modified value';
						}
					);
				}

				return $value;
			}
		);
		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_on_next_tick', 'original value' );
		$this->assertEquals( 'original value', $result ); // first time around, filter hasn't been hooked

		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_on_next_tick', 'original value' );
		$this->assertEquals( 'modified value', $result ); // filter has been hooked

		$result = apply_filters( 'dws_wp_framework_helpers_enqueue_temp_on_next_tick', 'original value' );
		$this->assertEquals( 'original value', $result ); // filter is now gone
	}

	/**
	 * Test for the 'get_hook_tag' function of the 'HooksHelpersTrait' trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array     $example    Example to run the test on.
	 *
	 * @dataProvider    _get_hook_tag_provider
	 */
	public function test_get_hook_tag_function_trait( array $example ) {
		$hooks = new \DeepWebSolutions\Framework\Tests\Helpers\Hooks();

		if ( isset( $example['name'], $example['extra'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( $example['name'], $example['extra'], $example['root'] ) );
		} elseif ( isset( $example['name'], $example['extra'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( $example['name'], $example['extra'] ) );
		} elseif ( isset( $example['name'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( $example['name'], array(), $example['root'] ) );
		} elseif ( isset( $example['extra'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( '', $example['extra'], $example['root'] ) );
		} elseif ( isset( $example['name'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( $example['name'] ) );
		} elseif ( isset( $example['extra'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( '', $example['extra'] ) );
		} elseif ( isset( $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $hooks->get_hook_tag( '', array(), $example['root'] ) );
		}
	}

	// endregion

	// region HELPERS

	/**
	 * Makes a false assertion that will trigger the tests to fail.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function _remove_anonymous_object_hook_dummy() {
		$this->assertNull( 'not null' ); // if things worked out, this will NOT be called;
	}

	/**
	 * Provides examples for the 'get_current_hook_priority' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	public function _get_current_hook_priority_provider(): array {
		return array(
			array( PHP_INT_MIN ),
			array( 0 ),
			array( 10 ),
			array( 100 ),
			array( 999 ),
			array( PHP_INT_MAX ),
		);
	}

	/**
	 * Modifies a global variable.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function _enqueue_temp_dummy() {
		$GLOBALS['dws_wp_framework_helpers_enqueue_temp'] = 'modified value 2';
	}

	/**
	 * Returns a string value.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function _enqueue_temp_dummy2(): string {
		return 'modified value 2';
	}

	/**
	 * Provides examples for the 'get_hook_tag' function tester.
	 *
	 * @since   1.0.0
	 * @version 1.4.1
	 *
	 * @return  array[]
	 */
	public function _get_hook_tag_provider(): array {
		return array(
			array(
				array(
					'name'     => 'test',
					'extra'    => array( 'extra_test1', 'extra_test2' ),
					'root'     => 'codeception_unit_test',
					'expected' => 'codeception_unit_test/test/extra_test1/extra_test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'extra'    => array( 'extra test1', 'extra test2' ),
					'expected' => 'dws_framework_helpers/test/extra_test1/extra_test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'root'     => 'codeception_unit_test',
					'expected' => 'codeception_unit_test/test',
				),
			),
			array(
				array(
					'extra'    => array( 'extra/test1', 'extra\\test2' ),
					'root'     => 'codeception_unit_test',
					'expected' => 'codeception_unit_test/extra/test1/extra_test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'expected' => 'dws_framework_helpers/test',
				),
			),
			array(
				array(
					'extra'    => array( 'extra_test1', 'extra_test2' ),
					'expected' => 'dws_framework_helpers/extra_test1/extra_test2',
				),
			),
			array(
				array(
					'root'     => 'codeception_unit_test',
					'expected' => 'codeception_unit_test',
				),
			),
		);
	}

	// endregion
}
