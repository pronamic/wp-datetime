<?php
/**
 * DateTime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 */

namespace Pronamic\WordPress\DateTime;

/**
 * DateTimeZone Test
 *
 * @author  Remco Tolsma
 * @version 1.0.1
 * @since   1.0.0
 */
class DateTimeZoneTest extends \WP_UnitTestCase {
	/**
	 * Test constructor.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 */
	public function test_constructor() {
		$timezone = new DateTimeZone( 'UTC' );

		$this->assertInstanceOf( __NAMESPACE__ . '\DateTimeZone', $timezone );
	}

	/**
	 * Test get default timezone.
	 *
	 * @dataProvider provider_test_get_default
	 */
	public function test_get_default( $wp_timezone, $wp_gmt_offset, $expected ) {
		\update_option( 'timezone_string', $wp_timezone );
		\update_option( 'gmt_offset', $wp_gmt_offset );

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
			array( 'UTC', null, 'UTC' ),
			array( 'Europe/Amsterdam', null, 'Europe/Amsterdam' ),
			array( null, 2, '+02:00' ),
			array( null, 12.75, '+12:45' ),
		);
	}

	/**
	 * WordPress stores offset in hours, `DateTimeZone::getOffset` will return in seconds.
	 *
	 * @dataProvider provider_test_offsets
	 */
	public function test_offsets( $wp_offset, $php_offset ) {
		\update_option( 'timezone_string', null );
		\update_option( 'gmt_offset', $wp_offset );

		$date = new \DateTime( '2015-05-05 00:00:00', new DateTimeZone( 'UTC' ) );

		$this->assertEquals( $php_offset, DateTimeZone::get_offset( $date ) );
	}

	/**
	 * Provider for the format i18n test.
	 *
	 * @return array
	 */
	public function provider_test_offsets() {
		return array(
			array( 12.75, 45900 ),
			array( 12.751, 45903 ),
			array( 12.758, 45928 ),
			array( -12.75, -45900 ),
			array( -12.751, -45903 ),
			array( -12.758, -45928 ),
		);
	}
}
