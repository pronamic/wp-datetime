<?php
/**
 * Date time zone
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
 * Date time zone
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class DateTimeZone extends \DateTimeZone {
	/**
	 * Get default timezone.
	 *
	 * @see https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTimeZone.php
	 * @see https://github.com/WordPress/WordPress/blob/4.9.4/wp-includes/functions.php#L72-L151
	 *
	 * @return DateTimeZone
	 */
	public static function get_default() {
		$timezone_string = get_option( 'timezone_string' );

		/**
		 * Offset values as timezone parameter are supported since PHP 5.5.10,
		 * use 'GMT' timezone string instead as default.
		 *
		 * @link http://php.net/manual/en/datetimezone.construct.php
		 */
		if ( empty( $timezone_string ) && version_compare( PHP_VERSION, '5.5.10', '<' ) ) {
			$timezone_string = 'GMT';
		}

		if ( ! empty( $timezone_string ) ) {
			return new DateTimeZone( $timezone_string );
		}

		$offset  = get_option( 'gmt_offset' );
		$hours   = (int) $offset;
		$minutes = abs( ( $offset - (int) $offset ) * 60 );
		$offset  = sprintf( '%+03d:%02d', $hours, $minutes );

		return new DateTimeZone( $offset );
	}
}
