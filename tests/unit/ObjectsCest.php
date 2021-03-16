<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use _generated\UnitTesterActions;
use Codeception\Lib\Actor\Shared\Comment;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\FileSystem\FilesystemAwareTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\Objects\PathsTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\Objects\ReflectionTrait;
use DeepWebSolutions\Framework\Tests\Helpers\Support\Objects\AbstractObject;
use DeepWebSolutions\Framework\Tests\Helpers\Support\Objects\ChildObject;
use Prophecy\Prophet;
use ReflectionClass;
use UnitTester;

/**
 * Tests for the object helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class ObjectsCest {
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
	 * Test the 'class_uses_deep' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_class_uses_deep( UnitTester $I ) {
		$expected = array(
			AbstractObject::class       => array( FilesystemAwareTrait::class => FilesystemAwareTrait::class ),
			FilesystemAwareTrait::class => array(),
		);
		$result   = Objects::class_uses_deep( AbstractObject::class );
		$I->assertEquals( true, $expected === $result );

		$expected = array(
			// Traits of all individual classes in the inheritance hierarchy
			ChildObject::class          => array( PathsTrait::class => PathsTrait::class ),
			AbstractObject::class       => array( FilesystemAwareTrait::class => FilesystemAwareTrait::class ),

			// Traits of all used traits
			FilesystemAwareTrait::class => array(),
			PathsTrait::class           => array( ReflectionTrait::class => ReflectionTrait::class ),
			ReflectionTrait::class      => array(),
		);
		$result = Objects::class_uses_deep( ChildObject::class );
		$I->assertEquals( true, $expected === $result );
	}

	/**
	 * Test the 'class_uses_deep_list' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_class_uses_deep_list( UnitTester $I ) {
		$expected = array( FilesystemAwareTrait::class => FilesystemAwareTrait::class );
		$result   = Objects::class_uses_deep_list( AbstractObject::class );
		$I->assertEquals( true, $expected === $result );

		$expected = array(
			PathsTrait::class           => PathsTrait::class,
			FilesystemAwareTrait::class => FilesystemAwareTrait::class,
			ReflectionTrait::class      => ReflectionTrait::class,
		);
		$result   = Objects::class_uses_deep_list( ChildObject::class );
		$I->assertEquals( true, $expected === $result );
	}

	/**
	 * Test the 'has_trait' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_has_trait( UnitTester $I ) {
		$I->assertEquals( false, Objects::has_trait( UnitTesterActions::class, $this ) );
		$I->assertEquals( false, Objects::has_trait( UnitTesterActions::class, self::class ) );

		$I->assertEquals( true, Objects::has_trait( UnitTesterActions::class, $I ) );
		$I->assertEquals( true, Objects::has_trait( UnitTesterActions::class, UnitTester::class ) );
	}

	/**
	 * Test the 'has_trait_deep' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_has_trait_deep( UnitTester $I ) {
		$I->assertEquals( false, Objects::has_trait( Comment::class, UnitTester::class ) );
		$I->assertEquals( true, Objects::has_trait_deep( Comment::class, UnitTester::class ) );
	}

	/**
	 * Test the 'ReflectionTrait' trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I      Codeception actor instance.
	 */
	public function test_reflection_trait( UnitTester $I ) {
		$reflection_class = ChildObject::get_reflection_class();

		$I->assertEquals( true, $reflection_class instanceof ReflectionClass );
		$I->assertEquals( ChildObject::class, $reflection_class->getName() );

		$I->assertEquals( 'ChildObject', ChildObject::get_class_name() );
		$I->assertEquals( '\\' . ChildObject::class, ChildObject::get_full_class_name() );

		$I->assertEquals(
			dirname( ABSPATH ) . str_replace( '/', DIRECTORY_SEPARATOR, '/_support/Objects/ChildObject.php' ),
			ChildObject::get_file_name()
		);
	}

	// endregion
}
