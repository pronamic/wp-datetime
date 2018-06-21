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

		if ( ! empty( $timezone_string ) ) {
			return new DateTimeZone( $timezone_string );
		}

		$gmt_offset = get_option( 'gmt_offset' );
		$hours      = (int) $gmt_offset;
		$minutes    = abs( ( $gmt_offset - (int) $gmt_offset ) * 60 );
		$offset     = sprintf( '%+03d:%02d', $hours, $minutes );

		/**
		 * Offset values as timezone parameter are supported since PHP 5.5.10,
		 * use 'GMT' timezone string instead as default.
		 *
		 * @link http://php.net/manual/en/datetimezone.construct.php
		 */
		if ( version_compare( PHP_VERSION, '5.5.10', '<' ) ) {
			$offset = self::transform_offset_to_timezone( $gmt_offset );
		}

		return new DateTimeZone( $offset );
	}

	/**
	 * Transform offset to timezone.
	 *
	 * @param int|string $gmt_offset GMT offset.
	 *
	 * @return string
	 */
	private static function transform_offset_to_timezone( $gmt_offset ) {
		// Ignore minutes in offsets.
		$dot_position = strrpos( $gmt_offset, '.' );

		if ( false !== $dot_position ) {
			$gmt_offset = substr( $gmt_offset, 0, $dot_position );
		}

		// Set timezone.
		if ( empty( $gmt_offset ) ) {
			return 'GMT';
		}

		if ( $gmt_offset < 0 ) {
			// Need to reverse +/- signs (http://php.net/manual/en/timezones.others.php).
			return 'Etc/GMT+' . substr( $gmt_offset, 1 );
		}

		return 'Etc/GMT-' . $gmt_offset;
	}
}
