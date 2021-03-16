<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Helpers\Functional;

use Codeception\Module\WPBrowser;
use FunctionalTester;

/**
 * Tests for the WP Requests helpers.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Helpers\Functional
 */
class RequestCest {
	// region TESTS

	/**
	 * Test the 'is_type' helper for the ADMIN_REQUEST parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   WPBrowser           $wp_browser     WPBrowser module powering the test.
	 * @param   FunctionalTester    $I              Codeception actor instance.
	 */
	public function test_admin_request( WPBrowser $wp_browser, FunctionalTester $I ) {
		$I->loginAsAdmin();
		$I->amOnAdminPage( '/' );

		$headers = $wp_browser->client->getInternalResponse()->getHeaders();
		$I->assertIsArray( $headers );

		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-ADMIN'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-AJAX'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-CRON'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-REST'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-FRONTEND'] ) );

		$I->logOut();
	}

	/**
	 * Test the 'is_type' helper for the FRONTEND_REQUEST parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   WPBrowser           $wp_browser     WPBrowser module powering the test.
	 * @param   FunctionalTester    $I              Codeception actor instance.
	 */
	public function test_frontend_request( WPBrowser $wp_browser, FunctionalTester $I ) {
		$I->amOnPage( '/' );

		$headers = $wp_browser->client->getInternalResponse()->getHeaders();
		$I->assertIsArray( $headers );

		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-ADMIN'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-AJAX'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-CRON'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-REST'] ) );
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-FRONTEND'] ) );
	}

	/**
	 * Test the 'is_type' helper for the AJAX_REQUEST parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   WPBrowser           $wp_browser     WPBrowser module powering the test.
	 * @param   FunctionalTester    $I              Codeception actor instance.
	 */
	public function test_ajax_request( WPBrowser $wp_browser, FunctionalTester $I ) {
		$I->amOnPage( '/' );
		$I->sendAjaxGetRequest( '/wp-admin/admin-ajax.php', array( 'action' => 'nopriv_heartbeat' ) );

		$headers = $wp_browser->client->getInternalResponse()->getHeaders();
		$I->assertIsArray( $headers );

		// Unfortunately there is no way to disambiguate between front-end and back-end AJAX requests currently.
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-ADMIN'] ) );
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-AJAX'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-CRON'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-REST'] ) );
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-FRONTEND'] ) );
	}

	/**
	 * Test the 'is_type' helper for the CRON_REQUEST parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   WPBrowser           $wp_browser     WPBrowser module powering the test.
	 * @param   FunctionalTester    $I              Codeception actor instance.
	 */
	public function test_cron_request( WPBrowser $wp_browser, FunctionalTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( 'wp-cron.php' ); // This will fail unless you remove the call to 'fastcgi_finish_request' in your wp-cron.php file.

		$headers = $wp_browser->client->getInternalResponse()->getHeaders();
		$I->assertIsArray( $headers );

		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-ADMIN'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-AJAX'] ) );
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-CRON'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-REST'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-FRONTEND'] ) );

		$I->logOut();
	}

	/**
	 * Test the 'is_type' helper for the REST_REQUEST parameter.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   WPBrowser           $wp_browser     WPBrowser module powering the test.
	 * @param   FunctionalTester    $I              Codeception actor instance.
	 */
	public function test_rest_request( WPBrowser $wp_browser, FunctionalTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( '/wp-json/wp/v2/users' );

		$headers = $wp_browser->client->getInternalResponse()->getHeaders();
		$I->assertIsArray( $headers );

		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-ADMIN'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-AJAX'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-CRON'] ) );
		$I->assertEquals( '1', reset( $headers['X-DWS-REQ-TYPE-REST'] ) );
		$I->assertEquals( '0', reset( $headers['X-DWS-REQ-TYPE-FRONTEND'] ) );
	}

	// endregion
}
