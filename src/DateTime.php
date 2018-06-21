<?php
/**
 * Date time
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 * @see       https://github.com/woocommerce/woocommerce/blob/3.3.4/includes/class-wc-datetime.php
 * @see       https://github.com/Rarst/wpdatetime/
 */

namespace Pronamic\WordPress\DateTime;

/**
 * Date time
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class DateTime extends \DateTime {
	/**
	 * MySQL datetime foramt.
	 *
	 * @see https://dev.mysql.com/doc/en/datetime.html
	 * @see https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTime.php#L10
	 *
	 * @var string
	 */
	const MYSQL = 'Y-m-d H:i:s';

	/**
	 * Format I18N.
	 *
	 * @see https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTimeTrait.php#L79-L104
	 * @see https://github.com/WordPress/WordPress/blob/4.9.4/wp-includes/functions.php#L72-L151
	 * @see https://developer.wordpress.org/reference/functions/apply_filters/
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n( $format = null ) {
		if ( is_null( $format ) ) {
			$format = _x( 'D j M Y \a\t H:i', 'default datetime format', 'pronamic-datetime' );

			$format = apply_filters( 'pronamic_datetime_default_format', $format );
		}

		$date = clone $this;

		$date->setTimezone( DateTimeZone::get_default() );

		$result = date_i18n( $format, $date->getTimestamp() + $date->getOffset(), true );

		return $result;
	}

	/**
	 * Parse a string into a new DateTime object according to the specified format
	 *
	 * @param string       $format   Format accepted by date().
	 * @param string       $time     String representing the time.
	 * @param DateTimeZone $timezone A DateTimeZone object representing the desired time zone.
	 *
	 * @return DateTime|boolean
	 *
	 * @link http://php.net/manual/en/datetime.createfromformat.php
	 */
	public static function create_from_format( $format, $time, \DateTimeZone $timezone = null ) {
		$date = parent::createFromFormat( $format, $time, $timezone );

		return new self( '@' . $date->format( 'U' ) );
	}
}
