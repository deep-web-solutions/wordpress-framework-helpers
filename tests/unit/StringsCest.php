<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Unit;

use Codeception\Example;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;
use UnitTester;

/**
 * Tests for the string helpers.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Unit
 */
class StringsCest {
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
	 * Test the 'starts_with' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    starts_with_provider
	 */
	public function test_starts_with( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::starts_with( $example['haystack'], $example['needle'] ) );
	}

	/**
	 * Test the 'ends_with' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    ends_with_provider
	 */
	public function test_ends_with( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::ends_with( $example['haystack'], $example['needle'] ) );
	}

	/**
	 * Test the 'replace_placeholders' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    replace_placeholders_provider
	 */
	public function test_replace_placeholders( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::replace_placeholders( $example['placeholders'], $example['string'] ) );
	}

	/**
	 * Test the 'to_safe_string' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    to_safe_string_provider
	 */
	public function test_to_safe_string( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::to_safe_string( $example['string'], $example['unsafe_characters'] ) );
	}

	/**
	 * Test the 'to_alphanumeric_unicode_string' helper.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    to_alphanumeric_unicode_string_provider
	 */
	public function test_to_alphanumeric_unicode_string( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::to_alphanumeric_unicode_string( $example['string'] ) );
	}

	/**
	 * Test the 'to_alphanumeric_ascii_string' helper.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    to_alphanumeric_ascii_string_provider
	 */
	public function test_to_alphanumeric_ascii_string( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::to_alphanumeric_ascii_string( $example['string'] ) );
	}

	/**
	 * Test the 'to_ascii_input_string' helper.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    to_ascii_input_string_provider
	 */
	public function test_to_ascii_input_string( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::to_ascii_input_string( $example['string'] ) );
	}

	/**
	 * Test the 'letter_to_number' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   UnitTester  $I          Codeception actor instance.
	 * @param   Example     $example    Example to run the test on.
	 *
	 * @dataProvider    letter_to_number_provider
	 */
	public function test_letter_to_number( UnitTester $I, Example $example ) {
		$I->assertEquals( $example['expected'], Strings::letter_to_number( $example['size'] ) );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'starts_with' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function starts_with_provider(): array {
		return array(
			array(
				'haystack' => '',
				'needle'   => '',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => '',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'fh43h',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'fh43H',
				'expected' => false,
			),
		);
	}

	/**
	 * Provides examples for the 'ends_with' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function ends_with_provider(): array {
		return array(
			array(
				'haystack' => '',
				'needle'   => '',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => '',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'rghrr',
				'expected' => true,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'rghrR',
				'expected' => false,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'rghrrR',
				'expected' => false,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'Rghrr',
				'expected' => false,
			),
			array(
				'haystack' => 'fh43h45htrhrghrr',
				'needle'   => 'Rrghrr',
				'expected' => false,
			),
		);
	}

	/**
	 * Provides examples for the 'replace_placeholders' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function replace_placeholders_provider(): array {
		return array(
			array(
				'string'       => 'Hello {name}! How are you {time}?',
				'placeholders' => array(
					'{name}' => 'tester',
					'{time}' => 'today',
				),
				'expected'     => 'Hello tester! How are you today?',
			),
			array(
				'string'       => '¡Hola, {name}! Astăzi mergem la {place}?',
				'placeholders' => array(
					'{name}'  => 'señorita',
					'{place}' => 'bibliotecă',
				),
				'expected'     => '¡Hola, señorita! Astăzi mergem la bibliotecă?',
			),
		);
	}

	/**
	 * Provides examples for the 'to_safe_string' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function to_safe_string_provider(): array {
		return array(
			array(
				'string'            => 'señorita / bibliotecă / ändern',
				'unsafe_characters' => array(
					'ñ' => 'n',
					'ă' => 'a',
					'ä' => 'ae',
					''  => ' ',
					' ' => '',
				),
				'expected'          => 'senorita/biblioteca/aendern',
			),
		);
	}

	/**
	 * Provides examples for the 'to_alphanumeric_unicode_string' tester.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @return  array[]
	 */
	protected function to_alphanumeric_unicode_string_provider(): array {
		return array(
			array(
				'string'   => 'señorita / bibliotecă / ändern',
				'expected' => 'señorita  bibliotecă  ändern',
			),
			array(
				'string'   => 'senorita +/ biblioteca /- andern',
				'expected' => 'senorita  biblioteca  andern',
			),
			array(
				'string'   => 'señorita /57 bibMNliotecă */-/ ändern',
				'expected' => 'señorita 57 bibMNliotecă  ändern',
			),
		);
	}

	/**
	 * Provides examples for the 'to_alphanumeric_ascii_string' tester.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @return  array[]
	 */
	protected function to_alphanumeric_ascii_string_provider(): array {
		return array(
			array(
				'string'   => 'señorita / bibliotecă / ändern',
				'expected' => 'seorita  bibliotec  ndern',
			),
			array(
				'string'   => 'senorita +/ biblioteca /- andern',
				'expected' => 'senorita  biblioteca  andern',
			),
			array(
				'string'   => 'señorita /57 bibMNliotecă */-/ ändern',
				'expected' => 'seorita 57 bibMNliotec  ndern',
			),
		);
	}

	/**
	 * Provides examples for the 'to_ascii_input_string' tester.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @return  array[]
	 */
	protected function to_ascii_input_string_provider(): array {
		return array(
			array(
				'string'   => 'senorita +/ biblioteca /- andern',
				'expected' => 'senorita +/ biblioteca /- andern',
			),
			array(
				'string'   => 'señorita /57 bibMNliotecă */-/ ändern',
				'expected' => 'seorita /57 bibMNliotec */-/ ndern',
			),
		);
	}

	/**
	 * Provides examples for the 'letter_to_number' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[]
	 */
	protected function letter_to_number_provider(): array {
		return array(
			array(
				'size'     => '2K',
				'expected' => 2 * 1024,
			),
			array(
				'size'     => '3M',
				'expected' => 3 * 1024 * 1024,
			),
			array(
				'size'     => '4G',
				'expected' => 4 * 1024 * 1024 * 1024,
			),
			array(
				'size'     => '5T',
				'expected' => 5 * 1024 * 1024 * 1024 * 1024,
			),
			array(
				'size'     => '6P',
				'expected' => 6 * 1024 * 1024 * 1024 * 1024 * 1024,
			),

		);
	}

	// endregion
}
