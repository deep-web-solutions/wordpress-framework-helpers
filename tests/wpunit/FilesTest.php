<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Helpers\FileSystem\Files;
use DeepWebSolutions\Framework\Tests\Helpers\Paths;
use WpunitTester;

/**
 * Tests for the file helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Integration
 */
class FilesTest extends WPTestCase {
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
	 * Test for the 'generate_full_path' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_generate_full_path() {
		$rel_path = 'wp-content/plugins/dws-wp-helpers-test-plugin/src/includes/Paths.php';
		$this->assertEquals(
			Paths::get_file_name(),
			Files::generate_full_path( ABSPATH, $rel_path )
		);
		$this->assertEquals(
			Paths::get_file_name(),
			Files::generate_full_path( ABSPATH, '/' . $rel_path )
		);
		$this->assertEquals(
			Paths::get_file_name(),
			Files::generate_full_path( ABSPATH, $rel_path . '/' )
		);
		$this->assertEquals(
			Paths::get_file_name(),
			Files::generate_full_path( ABSPATH, '/' . $rel_path . '/' )
		);
	}

	/**
	 * Test for the 'has_extension' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_has_extension() {
		$this->assertEquals( true, Files::has_extension( Paths::get_file_name(), 'php' ) );
		$this->assertEquals( true, Files::has_extension( Paths::get_file_name(), '.php' ) );
		$this->assertEquals( false, Files::has_extension( Paths::get_file_name(), 'anything else' ) );
	}

	/**
	 * Test the 'PathsTrait' trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_paths_trait() {
		$rel_path = 'wp-content/plugins/dws-wp-helpers-test-plugin/src/includes/';
		$this->assertEquals(
			Files::generate_full_path( ABSPATH, $rel_path . 'Paths.php' ),
			Paths::get_base_path( true )
		);
		$this->assertEquals(
			Files::generate_full_path( ABSPATH, $rel_path ) . DIRECTORY_SEPARATOR,
			Paths::get_base_path( false )
		);
		$this->assertEquals(
			Files::generate_full_path( ABSPATH, $rel_path . 'assets' ) . DIRECTORY_SEPARATOR,
			Paths::get_custom_base_path( 'assets' ),
		);

		$this->assertEquals(
			'/wp-content/plugins/dws-wp-helpers-test-plugin/src/includes/Paths.php',
			Paths::get_base_relative_url( true ),
		);
		$this->assertEquals(
			'/wp-content/plugins/dws-wp-helpers-test-plugin/src/includes/',
			Paths::get_base_relative_url( false )
		);
		$this->assertEquals(
			'/wp-content/plugins/dws-wp-helpers-test-plugin/src/includes/assets/',
			Paths::get_custom_base_relative_url( 'assets' ),
		);
	}

	/**
	 * Test the 'FilesystemAware' trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_filesystem_aware_trait() {
		// TODO: no idea how, but try to test the actual credentials system (so the other types of FS) ...
		$paths = new Paths();
		$this->assertEquals( true, $paths->get_wp_filesystem() instanceof \WP_Filesystem_Direct );
	}

	// endregion
}
