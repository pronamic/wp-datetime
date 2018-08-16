<?php
/**
 * DateTime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 */

namespace Pronamic\WordPress\DateTime;

use WP_UnitTestCase;

/**
 * DateTimeZone Test
 *
 * @author  Remco Tolsma
 * @version 1.0.1
 * @since   1.0.0
 */
class DateTimeZoneTest extends WP_UnitTestCase {
	/**
	 * Test constructor.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 */
	public function test_constructor() {
		$timezone = new DateTimeZone( 'UTC' );

		$this->assertInstanceOf( __NAMESPACE__ . '\DateTimeZone', $timezone );
	}

	/**
	 * @dataProvider provider_test_get_default
	 */
	public function test_get_default( $wp_timezone, $wp_gmt_offset, $expected ) {
		update_option( 'timezone_string', $wp_timezone );
		update_option( 'gmt_offset', $wp_gmt_offset );

		$timezone = DateTimeZone::get_default();

		$this->assertEquals( $expected, $timezone->getName() );
	}

	/**
	 * Provider for the format i18n test.
	 *
	 * @return array
	 */
	public function provider_test_get_default() {
		return array(
			array( 'UTC',              null,  'UTC' ),
			array( 'Europe/Amsterdam', null,  'Europe/Amsterdam' ),
			array( null,               2,     '+02:00' ),
			array( null,               12.75, '+12:45' ),
		);
	}
}
