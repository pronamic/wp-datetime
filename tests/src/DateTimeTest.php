<?php
/**
 * DateTime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 */

namespace Pronamic\WordPress\DateTime;

use WP_UnitTestCase;

/**
 * DateTime Test
 *
 * @author  Remco Tolsma
 * @version 1.0.2
 * @since   1.0.0
 */
class DateTimeTest extends WP_UnitTestCase {
	/**
	 * Test constructor.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 */
	public function test_constructor() {
		$date = new DateTime( 'now', new DateTimeZone( 'UTC' ) );

		$this->assertInstanceOf( __NAMESPACE__ . '\DateTime', $date );
	}

	/**
	 * Test format i18n.
	 *
	 * @dataProvider provider_test_format_i18n
	 */
	public function test_format_i18n( $locale, $wp_timezone, $wp_gmt_offset, $expected_i18n, $date_string, $date_timezone ) {
		switch_to_locale( $locale );

		update_option( 'timezone_string', $wp_timezone );
		update_option( 'gmt_offset', $wp_gmt_offset );

		$date = new DateTime( $date_string, new DateTimeZone( $date_timezone ) );

		$this->assertEquals( $expected_i18n, $date->format_i18n( 'Y-m-d F H:i:s P T e' ) );
	}

	/**
	 * Provider for the format i18n test.
	 *
	 * @return array
	 */
	public function provider_test_format_i18n() {
		return array(
			// Dutch.
			array( 'nl_NL', 'UTC', null, '2015-05-05 mei 13:00:00 +00:00 UTC UTC', '2015-05-05 15:00:00', 'Europe/Amsterdam' ),
			array( 'nl_NL', 'Europe/Amsterdam', null, '2015-05-05 mei 15:00:00 +02:00 CEST Europe/Amsterdam', '2015-05-05 13:00:00', 'UTC' ),
			array( 'nl_NL', null, 2, '2015-05-05 mei 15:00:00 +02:00 GMT+0200 +02:00', '2015-05-05 13:00:00', 'UTC' ),
			array( 'nl_NL', null, 12.75, '2015-05-06 mei 01:45:00 +12:45 GMT+1245 +12:45', '2015-05-05 13:00:00', 'UTC' ),
			array( 'nl_NL', 'UTC', null, '2016-03-11 maart 10:00:00 +00:00 UTC UTC', '2016-03-11 11:00:00', 'Europe/Amsterdam' ),
			array( 'nl_NL', 'UTC', null, '2016-04-11 april 09:00:00 +00:00 UTC UTC', '2016-04-11 11:00:00', 'Europe/Amsterdam' ),
			array( 'nl_NL', 'Europe/Amsterdam', null, '2016-03-11 maart 11:00:00 +01:00 CET Europe/Amsterdam', '2016-03-11 10:00:00', 'UTC' ),
			array( 'nl_NL', 'Europe/Amsterdam', null, '2016-04-11 april 11:00:00 +02:00 CEST Europe/Amsterdam', '2016-04-11 09:00:00', 'UTC' ),
			array( 'nl_NL', null, 2, '2016-03-11 maart 12:00:00 +02:00 GMT+0200 +02:00', '2016-03-11 10:00:00', 'UTC' ),
			array( 'nl_NL', null, 2, '2016-04-11 april 11:00:00 +02:00 GMT+0200 +02:00', '2016-04-11 09:00:00', 'UTC' ),
			// English.
			array( 'en_US', 'UTC', null, '2015-05-05 May 13:00:00 +00:00 UTC UTC', '2015-05-05 15:00:00', 'Europe/Amsterdam' ),
			// French.
			array( 'fr_FR', 'UTC', null, '2015-05-05 mai 13:00:00 +00:00 UTC UTC', '2015-05-05 15:00:00', 'Europe/Amsterdam' ),
		);
	}

	/**
	 * Test create from format.
	 *
	 * @dataProvider provider_create_from_format
	 */
	public function test_create_from_format( $format, $time, $timezone, $expected ) {
		$date = DateTime::create_from_format( $format, $time, $timezone );

		$this->assertEquals( $expected, $date->format( DATE_W3C ) );
	}

	/**
	 * Provider create from format.
	 *
	 * @return array
	 */
	public function provider_create_from_format() {
		return array(
			array( 'j-M-Y H:i:s', '15-Feb-2009 10:00:00', null, '2009-02-15T10:00:00+00:00' ),
			array( 'j-M-Y H:i:s', '15-Feb-2009 10:00:00', new DateTimeZone( 'Europe/Amsterdam' ), '2009-02-15T10:00:00+01:00' ),
			array( 'j-M-Y H:i:s', '15-Feb-2009 10:00:00', new DateTimeZone( 'America/Regina' ), '2009-02-15T10:00:00-06:00' ),
		);
	}

	/**
	 * Test format 'F' in 'ja' locale.
	 *
	 * @link https://core.trac.wordpress.org/ticket/48319
	 */
	public function test_format_month_locale_ja() {
		\switch_to_locale( 'ja' );

		$this->assertEquals( '10月', \date_i18n( 'F', \strtotime( '2019-10-16 00:00:00' ) ) );
		$this->assertEquals( 'F', \date_i18n( '\F', \strtotime( '2019-10-16 00:00:00' ) ) );

		$date = new DateTime( '2019-10-16 00:00:00' );

		$this->assertEquals( '10月', $date->format_i18n( 'F' ) );
		$this->assertEquals( 'F', $date->format_i18n( '\F' ) );
	}

	/**
	 * Test format that starts with a number.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/formatting.php#L2615-L2628
	 */
	public function test_format_with_number_at_start() {
		\switch_to_locale( 'en_US' );

		$date = new DateTime( '2019-10-16 00:00:00' );

		$this->assertEquals( '0 2019 October', $date->format_i18n( '0 Y F' ) );
		$this->assertEquals( '0 2019 October', \date_i18n( '0 Y F', \strtotime( '2019-10-16 00:00:00' ) ) );
	}

	/**
	 * Test format that starts with a number in 'ja' locale.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/formatting.php#L2615-L2628
	 */
	public function test_format_with_number_at_start_2() {
		\switch_to_locale( 'ja' );

		$date = new DateTime( '2019-10-16 00:00:00' );

		$this->assertEquals( '0 2019 10月', $date->format_i18n( '0 Y F' ) );	
		$this->assertEquals( '0 2019 10月', \date_i18n( '0 Y F', \strtotime( '2019-10-16 00:00:00' ) ) );
	}

	/**
	 * Test date format characters in translation.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/gettext/
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/class-wp-locale.php
	 */
	public function test_date_format_characters_in_translation() {
		global $wp_locale;

		\switch_to_locale( 'en_US' );

		$month_translation = 'dDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrU';

		$wp_locale->month['10'] = $month_translation;
		$wp_locale->month_abbrev[ $month_translation ] = $month_translation;

		$string = '2019-10-16 00:00:00';

		$date = new DateTime( $string );

		$this->assertEquals( 'dDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrU', $date->format_i18n( 'F' ) );	
		$this->assertEquals( 'dDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrU', \date_i18n( 'F', \strtotime( $string ) ) );
	}

	/**
	 * Test UTF-8 characters in translation.
	 *
	 * @link https://www.utf8-chartable.de/unicode-utf8-table.pl
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/class-wp-locale.php
	 */
	public function test_utf8_characters_in_translation() {
		global $wp_locale;

		\switch_to_locale( 'en_US' );

		$month_translation = 'ⒶⒷⒸdDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrUⓍⓎⓏ';

		$wp_locale->month['10'] = $month_translation;
		$wp_locale->month_abbrev[ $month_translation ] = $month_translation;

		$string = '2019-10-16 00:00:00';

		$date = new DateTime( $string );

		$this->assertEquals( '123 ⒶⒷⒸdDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrUⓍⓎⓏ 2019', $date->format_i18n( '123 F Y' ) );
		$this->assertEquals( '123 ⒶⒷⒸdDjlSwNzWoFmMntLyYaABgGhHisuvIPOTeZcrUⓍⓎⓏ 2019', \date_i18n( '123 F Y', \strtotime( $string ) ) );
	}

	/**
	 * Test backslashes in translation.
	 *
	 * @link https://www.utf8-chartable.de/unicode-utf8-table.pl
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/class-wp-locale.php
	 */
	public function test_backslashes_in_translation() {
		global $wp_locale;

		\switch_to_locale( 'en_US' );

		$month_translation = 'ABCD \ 1234';

		$wp_locale->month['10'] = $month_translation;
		$wp_locale->month_abbrev[ $month_translation ] = $month_translation;

		$string = '2019-10-16 00:00:00';

		$date = new DateTime( $string );

		$this->assertEquals( '123 - ABCD \ 1234 - 2019', $date->format_i18n( '123 - F - Y' ) );	
		$this->assertEquals( '123 - ABCD \ 1234 - 2019', \date_i18n( '123 - F - Y', \strtotime( $string ) ) );
	}

	/**
	 * Test backslash at end in translation.
	 *
	 * @link https://www.utf8-chartable.de/unicode-utf8-table.pl
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/class-wp-locale.php
	 */
	public function test_backslash_at_end_in_translation() {
		global $wp_locale;

		\switch_to_locale( 'en_US' );

		$month_translation = 'ABCD 1234 \\';

		$wp_locale->month['10'] = $month_translation;
		$wp_locale->month_abbrev[ $month_translation ] = $month_translation;

		$string = '2019-10-16 00:00:00';

		$date = new DateTime( $string );

		$this->assertEquals( '123 - ABCD 1234 \ - 2019', $date->format_i18n( '123 - F - Y' ) );	
		$this->assertEquals( '123 - ABCD 1234 \ - 2019', \date_i18n( '123 - F - Y', \strtotime( $string ) ) );
	}
}
