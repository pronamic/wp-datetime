<?php
/**
 * Date time zone
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
 * Date time zone
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.0.0
 * @psalm-immutable
 */
class DateTimeZone extends \DateTimeZone {
	/**
	 * Get default timezone.
	 *
	 * @link https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTimeZone.php
	 * @link https://github.com/WordPress/WordPress/blob/4.9.4/wp-includes/functions.php#L72-L151
	 *
	 * @return \DateTimeZone
	 */
	public static function get_default() {
		$timezone_string = \get_option( 'timezone_string' );

		if ( ! empty( $timezone_string ) ) {
			return new DateTimeZone( $timezone_string );
		}

		$gmt_offset = \get_option( 'gmt_offset' );
		$hours      = (int) $gmt_offset;
		$minutes    = \abs( ( $gmt_offset - (int) $gmt_offset ) * 60 );
		$offset     = \sprintf( '%+03d:%02d', $hours, $minutes );

		/**
		 * Offset values as timezone parameter are supported since PHP 5.5.10.
		 *
		 * @link http://php.net/manual/en/datetimezone.construct.php
		 */
		if ( \version_compare( PHP_VERSION, '5.5.10', '<' ) ) {
			$date = new DateTime( $offset );

			return $date->getTimezone();
		}

		return new \DateTimeZone( $offset );
	}

	/**
	 * Get offset.
	 *
	 * @param \DateTimeInterface $date DateTime object.
	 * @return int
	 */
	public static function get_offset( $date ) {
		$timezone_string = \get_option( 'timezone_string' );

		if ( empty( $timezone_string ) ) {
			return \intval( \floatval( \get_option( 'gmt_offset', 0 ) ) * HOUR_IN_SECONDS );
		}

		$timezone = new DateTimeZone( $timezone_string );

		return $timezone->getOffset( $date );
	}
}
