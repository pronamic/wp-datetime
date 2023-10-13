<?php
/**
 * DateTime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 */

namespace Pronamic\WordPress\DateTime;

use PHPUnit\Framework\TestCase;

/**
 * DateTimeZone Test
 *
 * @author  Remco Tolsma
 * @version 1.0.1
 * @since   1.0.0
 */
class DateTimeZoneTest extends TestCase {
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
	 * @param string|null $wp_timezone   WordPress timezone.
	 * @param float|null  $wp_gmt_offset WordPress GMT offset.
	 * @param string      $expected      Expected timezone.
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
	public static function provider_test_get_default() {
		return [
			[ 'UTC', null, 'UTC' ],
			[ 'Europe/Amsterdam', null, 'Europe/Amsterdam' ],
			[ null, 2, '+02:00' ],
			[ null, 12.75, '+12:45' ],
		];
	}

	/**
	 * WordPress stores offset in hours, `DateTimeZone::getOffset` will return in seconds.
	 *
	 * @dataProvider provider_test_offsets
	 * @param float $wp_offset  WordPress offset.
	 * @param int   $php_offset PHP offset.
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
	public static function provider_test_offsets() {
		return [
			[ 12.75, 45900 ],
			[ 12.751, 45903 ],
			[ 12.758, 45928 ],
			[ -12.75, -45900 ],
			[ -12.751, -45903 ],
			[ -12.758, -45928 ],
		];
	}
}
