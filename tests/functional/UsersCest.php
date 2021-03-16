<?php

namespace DeepWebSolutions\Framework\Tests\Helpers\Functional;

use FunctionalTester;

/**
 * Tests for the WP Users helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Functional
 */
class UsersCest {
	// region TESTS

	/**
	 * Test the 'logout_user' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 */
	public function test_logout_user( FunctionalTester $I ) {
		// test admin user
		$I->loginAsAdmin();
		$I->amOnAdminPage( '/' );
		$I->seeElement( '#wpadminbar' );
		$I->assertNotEmpty( $I->grabCookiesWithPattern( '#^(wordpress_logged_in_).*#' ) );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=logout_user' );

		$I->amOnPage( '/' );
		$I->dontSeeElement( '#wpadminbar' );
		$I->assertEmpty( $I->grabCookiesWithPattern( '#^(wordpress_logged_in_).*#' ) );

		// test random user
		$I->haveUserInDatabase( 'subscriber' );
		$I->seeUserInDatabase( array( 'user_login' => 'subscriber' ) );

		$I->loginAs( 'subscriber', 'subscriber' );
		$I->assertNotEmpty( $I->grabCookiesWithPattern( '#^(wordpress_logged_in_).*#' ) );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=logout_user' );

		$I->amOnPage( '/' );
		$I->assertEmpty( $I->grabCookiesWithPattern( '#^(wordpress_logged_in_).*#' ) );
	}

	/**
	 * Test the 'get_roles' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 */
	public function test_get_roles( FunctionalTester $I ) {
		$I->loginAsAdmin();

		// test admin user
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=get_roles' );
		$I->see( '["administrator"]' );

		// test random user
		$user_id = $I->haveUserInDatabase( 'editor', 'editor' );
		$I->seeUserInDatabase( array( 'user_login' => 'editor' ) );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=get_roles&user_id=' . $user_id );
		$I->see( '["editor"]' );

		$I->haveUserCapabilitiesInDatabase( $user_id, array( 'editor', 'subscriber' ) );
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=get_roles&user_id=' . $user_id );
		$I->see( '["editor","subscriber"]' );
	}

	/**
	 * Test the 'has_roles' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 */
	public function test_has_roles( FunctionalTester $I ) {
		$I->loginAsAdmin();

		// test admin user
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator' );
		$I->see( 'true' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator2' );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator&roles[]=editor' );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator&roles[]=editor&logic=or' );
		$I->see( 'true' );

		// test random user
		$user_id = $I->haveUserInDatabase( 'editor', 'editor' );
		$I->seeUserInDatabase( array( 'user_login' => 'editor' ) );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator&user_id=' . $user_id );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=editor&user_id=' . $user_id );
		$I->see( 'true' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator&roles[]=editor&user_id=' . $user_id );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=administrator&roles[]=editor&logic=or&user_id=' . $user_id );
		$I->see( 'true' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=editor&roles[]=subscriber&user_id=' . $user_id );
		$I->see( 'false' );

		$I->haveUserCapabilitiesInDatabase( $user_id, array( 'editor', 'subscriber' ) );
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_roles&roles[]=editor&roles[]=subscriber&user_id=' . $user_id );
		$I->see( 'true' );
	}

	/**
	 * Test the 'has_capabilities' helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 */
	public function test_has_capabilities( FunctionalTester $I ) {
		$I->loginAsAdmin();

		// test admin user
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=administrator' );
		$I->see( 'true' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=dummy' );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=administrator&capabilities[]=dummy' );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=administrator&capabilities[]=dummy&logic=or' );
		$I->see( 'true' );

		// test random user
		$user_id = $I->haveUserInDatabase( 'subscriber' );
		$I->seeUserInDatabase( array( 'user_login' => 'subscriber' ) );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=administrator&user_id=' . $user_id );
		$I->see( 'false' );

		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=dummy&user_id=' . $user_id );
		$I->see( 'false' );

		$I->haveUserCapabilitiesInDatabase( $user_id, array( 'dummy' => true ) );
		$I->amOnPage( '/dws-wp-framework-helpers/users-functions/?action=has_capabilities&capabilities[]=dummy&user_id=' . $user_id );
		$I->see( 'true' );
	}

	// endregion
}
