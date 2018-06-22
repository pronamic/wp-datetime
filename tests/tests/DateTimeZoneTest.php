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
 * @author Remco Tolsma
 * @version 1.0
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
	 * Test get other Etc/GMT timezone.
	 *
	 * @dataProvider provider_test_get_other_gmt_timezone
	 *
	 * @param float|string $offset_in_hours
	 * @param string       $expected
	 */
	public function test_get_other_gmt_timezone( $offset_in_hours, $expected ) {
		$result = DateTimeZone::get_other_gmt_timezone( $offset_in_hours );

		$this->assertEquals( $expected, $result );
	}

	/**
	 * Provider for get other Etc/GMT timezone test.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L4613-L4746
	 *
	 * @return array
	 */
	public function provider_test_get_other_gmt_timezone() {
		return array(
			array( 15,    null ),
			array( 14,    'Etc/GMT-14' ),
			array( 13,    'Etc/GMT-13' ),
			array( 12,    'Etc/GMT-12' ),
			array( 11,    'Etc/GMT-11' ),
			array( 10,    'Etc/GMT-10' ),
			array( 9.5,   null ),
			array( 9,     'Etc/GMT-9' ),
			array( 8,     'Etc/GMT-8' ),
			array( 7,     'Etc/GMT-7' ),
			array( 6,     'Etc/GMT-6' ),
			array( 5,     'Etc/GMT-5' ),
			array( 4,     'Etc/GMT-4' ),
			array( 3,     'Etc/GMT-3' ),
			array( 2,     'Etc/GMT-2' ),
			array( 1,     'Etc/GMT-1' ),
			array( 0,     'Etc/GMT-0' ),
			array( -1,    'Etc/GMT+1' ),
			array( -2,    'Etc/GMT+2' ),
			array( -3,    'Etc/GMT+3' ),
			array( -4,    'Etc/GMT+4' ),
			array( -5,    'Etc/GMT+5' ),
			array( -6,    'Etc/GMT+6' ),
			array( -7,    'Etc/GMT+7' ),
			array( -8,    'Etc/GMT+8' ),
			array( -9,    'Etc/GMT+9' ),
			array( -10,   'Etc/GMT+10' ),
			array( -11,   'Etc/GMT+11' ),
			array( -11.5, null ),
			array( -12,   'Etc/GMT+12' ),
			array( -13,   null ),
		);
	}

	/**
	 * Test get timezone by offset.
	 *
	 * @dataProvider provider_test_get_timezone_by_offset
	 *
	 * @param float|string $offset_in_hours
	 * @param string       $expected
	 */
	public function test_get_timezone_by_offset( $offset_in_hours, $expected, $dst = true ) {
		$result = DateTimeZone::get_timezone_from_identifiers_list_by_offset( $offset_in_hours, new DateTime( '2015-05-05 12:00:00' ), $dst );

		$this->assertEquals( $expected, $result );
	}

	/**
	 * Provider for get timezone by offset test.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L4613-L4746
	 *
	 * @return array
	 */
	public function provider_test_get_timezone_by_offset() {
		return array(
			array( -12,   null ),
			array( -11.5, null ),
			array( -11,   'Pacific/Midway' ),
			array( -10.5, null ),
			array( -10,   'Pacific/Honolulu' ),
			array( -9.5,  'Pacific/Marquesas' ),
			array( -9,    'America/Adak' ),
			array( -8.5,  null ),
			array( -8,    'America/Anchorage' ),
			array( -7.5,  null ),
			array( -7,    'America/Creston' ),
			array( -6.5,  null ),
			array( -6,    'America/Belize' ),
			array( -5.5,  null ),
			array( -5,    'America/Atikokan' ),
			array( -4.5,  'America/Caracas' ),
			array( -4,    'America/Anguilla' ),
			array( -3.5,  null ),
			array( -3,    'America/Araguaina' ),
			array( -2.5,  'America/St_Johns' ),
			array( -2,    'America/Godthab' ),
			array( -1.5,  null ),
			array( -1,    'Atlantic/Cape_Verde' ),
			array( -0.5,  null ),
			array( 0,     'Africa/Abidjan' ),
			array( 0.5,   null, ),
			array( 1,     'Africa/Algiers' ),
			array( 1.5,   null ),
			array( 2,     'Africa/Blantyre' ),
			array( 2.5,   null ),
			array( 3,     'Africa/Addis_Ababa' ),
			array( 3.5,   null ),
			array( 4,     'Asia/Dubai' ),
			array( 4.5,   'Asia/Kabul' ),
			array( 5,     'Antarctica/Mawson' ),
			array( 5.5,   'Asia/Colombo' ),
			array( 5.75,  'Asia/Kathmandu' ),
			array( 6,     'Antarctica/Vostok' ),
			array( 6.5,   version_compare( PHP_VERSION, '5.5', '>' ) ? 'Asia/Yangon' : 'Asia/Rangoon' ),
			array( 7,     'Antarctica/Davis' ),
			array( 7.5,   null ),
			array( 8,     'Antarctica/Casey' ),
			array( 8.5,   null ),
			array( 8.75,  'Australia/Eucla' ),
			array( 9,     version_compare( PHP_VERSION, '5.5', '>' ) ? 'Asia/Choibalsan' : 'Asia/Dili' ),
			array( 9.5,   'Australia/Adelaide' ),
			array( 10,    'Antarctica/DumontDUrville' ),
			array( 10.5,  'Australia/Lord_Howe' ),
			array( 11,    'Antarctica/Macquarie' ),
			array( 11.5,  'Pacific/Norfolk' ),
			array( 12,    'Antarctica/McMurdo' ),
			array( 12.75, 'Pacific/Chatham' ),
			array( 13,    'Pacific/Apia' ),
			array( 13.75, null ),
			array( 14,    'Pacific/Kiritimati' ),
		);
	}
}
