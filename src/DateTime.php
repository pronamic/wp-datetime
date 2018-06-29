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
	 * Translate.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L103-L119
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/class-wp-locale.php#L116-L235
	 *
	 * @param string $foramt Format.
	 *
	 * @return string
	 */
	private function format_i18n_translate( $format ) {
		global $wp_locale;

		if ( empty( $wp_locale->month ) || empty( $wp_locale->weekday ) ) {
			return $format;
		}

		$month   = $wp_locale->get_month( $this->format( 'm' ) );
		$weekday = $wp_locale->get_weekday( $this->format( 'w' ) );

		$format_length = strlen( $format );

		$format_new = '';

		for ( $i = 0; $i < $format_length; $i++ ) {
			switch ( $format[ $i ] ) {
				case 'D':
					$format_new .= backslashit( $wp_locale->get_weekday_abbrev( $weekday ) );

					break;
				case 'F':
					$format_new .= backslashit( $month );

					break;
				case 'l':
					$format_new .= backslashit( $weekday );

					break;
				case 'M':
					$format_new .= backslashit( $wp_locale->get_month_abbrev( $month ) );

					break;
				case 'a':
					$format_new .= backslashit( $wp_locale->get_meridiem( $this->format( 'a' ) ) );

					break;
				case 'A':
					$format_new .= backslashit( $wp_locale->get_meridiem( $this->format( 'A' ) ) );

					break;
				case '\\':
					$format_new .= $format[ $i ];

					if ( $i < $format_length ) {
						$i++;
					}

					// no break
				default:
					$format_new .= $format[ $i ];

					break;
			}
		}

		return $format_new;
	}

	/**
	 * Format I18N timezone.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L120-L136
	 * @link https://github.com/php/php-src/blob/php-7.2.7/ext/date/php_date.c#L1093-L1253
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	private function format_i18n_timezone( $format ) {
		$format_length = strlen( $format );

		$format_new = '';

		for ( $i = 0; $i < $format_length; $i++ ) {
			switch ( $format[ $i ] ) {
				case 'P':
				case 'I':
				case 'O':
				case 'T':
				case 'Z':
				case 'e':
					$format_new .= backslashit( $this->format( $format[ $i ] ) );

					break;
				case '\\':
					$format_new .= $format[ $i ];

					if ( $i < $format_length ) {
						$i++;
					}

					// no break
				default:
					$format_new .= $format[ $i ];

					break;
			}
		}

		return $format_new;
	}

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

		$format = $date->format_i18n_translate( $format );
		$format = $date->format_i18n_timezone( $format );

		$result = date_i18n( $format, $date->getTimestamp() + DateTimeZone::get_offset( $date ) );

		return $result;
	}

	/**
	 * Parse a string into a new DateTime object according to the specified format
	 *
	 * @param string        $format   Format accepted by date().
	 * @param string        $time     String representing the time.
	 * @param \DateTimeZone $timezone A DateTimeZone object representing the desired time zone.
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
