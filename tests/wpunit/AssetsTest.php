<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Helpers\WordPress\Assets;
use WpunitTester;

/**
 * Tests for the WP asset helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Integration
 */
class AssetsTest extends WPTestCase {
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
	 * Test for the 'wrap_string_in_style_tags' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_wrap_string_in_style_tags() {
		$this->assertEquals( "<style type='text/css'>.test{}</style>", Assets::wrap_string_in_style_tags( '.test{}' ) );
	}

	/**
	 * Test for the 'wrap_string_in_script_tags' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_wrap_string_in_script_tags() {
		$this->assertEquals( "<script type='text/javascript'>var test= '';</script>", Assets::wrap_string_in_script_tags( "var test= '';" ) );
	}

	/**
	 * Test for the 'maybe_get_minified_suffix' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_maybe_get_minified_suffix() {
		$this->assertEquals( '.min', Assets::maybe_get_minified_suffix( 'TEST_SCRIPT_DEBUG' ) );

		define( 'TEST_SCRIPT_DEBUG', true );
		$this->assertEquals( '', Assets::maybe_get_minified_suffix( 'TEST_SCRIPT_DEBUG' ) );
	}

	/**
	 * Test for the 'get_asset_handle' function of the 'AssetsHelpersTrait' trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array     $example    Example to run the test on.
	 *
	 * @dataProvider    _get_asset_handle_provider
	 */
	public function test_get_asset_handle_function_trait( array $example ) {
		$assets = new \DeepWebSolutions\Framework\Tests\Helpers\Assets();

		if ( isset( $example['name'], $example['extra'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( $example['name'], $example['extra'], $example['root'] ) );
		} elseif ( isset( $example['name'], $example['extra'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( $example['name'], $example['extra'] ) );
		} elseif ( isset( $example['name'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( $example['name'], array(), $example['root'] ) );
		} elseif ( isset( $example['extra'], $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( '', $example['extra'], $example['root'] ) );
		} elseif ( isset( $example['name'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( $example['name'] ) );
		} elseif ( isset( $example['extra'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( '', $example['extra'] ) );
		} elseif ( isset( $example['root'] ) ) {
			$this->assertEquals( $example['expected'], $assets->get_asset_handle( '', array(), $example['root'] ) );
		}
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'get_asset_handle' function tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	public function _get_asset_handle_provider(): array {
		return array(
			array(
				array(
					'name'     => 'test',
					'extra'    => array( 'extra-test1', 'extra-test2' ),
					'root'     => 'codeception-unit-test',
					'expected' => 'codeception-unit-test_test_extra-test1_extra-test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'extra'    => array( 'extra test1', 'extra test2' ),
					'expected' => 'dws-framework-helpers_test_extra-test1_extra-test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'root'     => 'codeception-unit-test',
					'expected' => 'codeception-unit-test_test',
				),
			),
			array(
				array(
					'extra'    => array( 'extra/test1', 'extra\\test2' ),
					'root'     => 'codeception-unit-test',
					'expected' => 'codeception-unit-test_extra-test1_extra-test2',
				),
			),
			array(
				array(
					'name'     => 'test',
					'expected' => 'dws-framework-helpers_test',
				),
			),
			array(
				array(
					'extra'    => array( 'extra-test1', 'extra-test2' ),
					'expected' => 'dws-framework-helpers_extra-test1_extra-test2',
				),
			),
			array(
				array(
					'root'     => 'codeception-unit-test',
					'expected' => 'codeception-unit-test',
				),
			),
		);
	}

	// endregion
}
