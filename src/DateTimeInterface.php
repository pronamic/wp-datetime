<?php
/**
 * Date time interface
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 * @see       https://github.com/woocommerce/woocommerce/blob/3.3.4/includes/class-wc-datetime.php
 * @see       https://github.com/Rarst/wpdatetime/
 */

namespace Pronamic\WordPress\DateTime;

/**
 * Date time interface
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.2.0
 */
interface DateTimeInterface extends \DateTimeInterface {
	/**
	 * MySQL datetime format.
	 *
	 * @link https://dev.mysql.com/doc/en/datetime.html
	 * @link https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTime.php#L10
	 *
	 * @var string
	 */
	const MYSQL = 'Y-m-d H:i:s';

	/**
	 * Date format characters in PHP.
	 *
	 * @link https://www.php.net/manual/en/function.date.php
	 * @link https://github.com/php/php-src/blob/php-7.3.10/ext/date/php_date.c#L1128-L1288
	 * @var string[]
	 */
	const DATE_FORMAT_CHARACTERS = [
		// Day.
		'd',
		'D',
		'j',
		'l',
		'S',
		'w',
		'N',
		'z',
		// Week.
		'W',
		'o',
		// Month.
		'F',
		'm',
		'M',
		'n',
		't',
		// Year.
		'L',
		'y',
		'Y',
		// Time.
		'a',
		'A',
		'B',
		'g',
		'G',
		'h',
		'H',
		'i',
		's',
		'u',
		'v',
		// Timezone.
		'I',
		'P',
		'p',
		'O',
		'T',
		'e',
		'Z',
		// Full date/time.
		'c',
		'r',
		'U',
	];

	/**
	 * Format I18N.
	 *
	 * @link https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTimeTrait.php#L79-L104
	 * @link https://github.com/WordPress/WordPress/blob/4.9.4/wp-includes/functions.php#L72-L151
	 * @link https://developer.wordpress.org/reference/functions/apply_filters/
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n( $format = null );

	/**
	 * Create from format.
	 *
	 * @link https://www.php.net/manual/en/datetime.createfromformat.php
	 * @link https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
	 *
	 * @param string        $format   Format accepted by date().
	 * @param string        $time     String representing the time.
	 * @param \DateTimeZone $timezone A DateTimeZone object representing the desired time zone.
	 * @return self|false
	 */
	public static function create_from_format( $format, $time, \DateTimeZone $timezone = null );
}
