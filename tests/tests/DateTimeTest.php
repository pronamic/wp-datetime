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
 * DateTime Test
 *
 * @author Remco Tolsma
 * @version 1.0
 */
class DateTimeTest extends WP_UnitTestCase {
	/**
	 * Test constructor.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 */
	public function test_constructor() {
		$date = new DateTime( 'now', new DateTimeZone( 'UTC' ) );

		$this->assertInstanceOf( __NAMESPACE__ . '\DateTime', $date );
	}

	/**
	 * @dataProvider provider_test_format_i18n
	 */
	public function test_format_i18n( $wp_timezone, $wp_gmt_offset, $expected_i18n, $date_string, $date_timezone ) {
		update_option( 'timezone_string', $wp_timezone );
		update_option( 'gmt_offset', $wp_gmt_offset );

		$date = new DateTime( $date_string, new DateTimeZone( $date_timezone ) );

		$this->assertEquals( $expected_i18n, $date->format_i18n( 'Y-m-d H:i:s P T e' ) );
	}

	/**
	 * Provider for the format i18n test.
	 *
	 * @return array
	 */
	public function provider_test_format_i18n() {
		return array(
			array( 'UTC',              null,  '2015-05-05 13:00:00 +00:00 UTC UTC',               '2015-05-05 15:00:00', 'Europe/Amsterdam' ),
			array( 'Europe/Amsterdam', null,  '2015-05-05 15:00:00 +02:00 CEST Europe/Amsterdam', '2015-05-05 13:00:00', 'UTC'              ),
			array( null,               2,     '2015-05-05 15:00:00 +02:00 GMT+0200 +02:00',       '2015-05-05 13:00:00', 'UTC'              ),
			array( null,               12.75, '2015-05-06 01:45:00 +12:45 GMT+1245 +12:45',       '2015-05-05 13:00:00', 'UTC'              ),
			array( 'UTC',              null,  '2016-03-11 10:00:00 +00:00 UTC UTC',               '2016-03-11 11:00:00', 'Europe/Amsterdam' ),
			array( 'UTC',              null,  '2016-04-11 09:00:00 +00:00 UTC UTC',               '2016-04-11 11:00:00', 'Europe/Amsterdam' ),
			array( 'Europe/Amsterdam', null,  '2016-03-11 11:00:00 +01:00 CET Europe/Amsterdam',  '2016-03-11 10:00:00', 'UTC' ),
			array( 'Europe/Amsterdam', null,  '2016-04-11 11:00:00 +02:00 CEST Europe/Amsterdam', '2016-04-11 09:00:00', 'UTC' ),
			array( null,               2,     '2016-03-11 12:00:00 +02:00 GMT+0200 +02:00',       '2016-03-11 10:00:00', 'UTC' ),
			array( null,               2,     '2016-04-11 11:00:00 +02:00 GMT+0200 +02:00',       '2016-04-11 09:00:00', 'UTC' ),
		);
	}
}
