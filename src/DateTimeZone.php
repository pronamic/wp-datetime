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
	 * Get offset.
	 */
	public static function get_offset( $date ) {
		$timezone_string = get_option( 'timezone_string' );

		if ( empty( $timezone_string ) ) {
			return floatval( get_option( 'gmt_offset', 0 ) ) * HOUR_IN_SECONDS;
		}

		$timezone = new DateTimeZone( $timezone_string );

		return $timezone->getOffset( $date );
	}

	/**
	 * Get 'other' Etc/GMT timezone by the specified offset in hours.
	 *
	 * @link http://php.net/manual/en/timezones.others.php
	 *
	 * @param float $offset Timezone offset in hours.
	 * @return string|null
	 */
	public static function get_other_gmt_timezone( $offset_in_hours ) {
		if ( fmod( $offset_in_hours, 1 ) !== 0.0 ) {
			return;
		}

		if ( $offset_in_hours < -12 || $offset_in_hours > 14 ) {
			return;
		}

		$sign = ( $offset_in_hours < 0 ) ? '+' : '-';

		return 'Etc/GMT' . $sign . intval( abs( $offset_in_hours ) );
	}

	/**
	 * Get timezone by the specified offset in hours.
	 *
	 * @param float    $offset_in_hours Timezone offset in hours.
	 * @param DateTime $date            Date.
	 * @return string|null
	 */
	public static function get_timezone_from_identifiers_list_by_offset( $offset_in_hours, $date = null ) {
		$date = ( null === $date ) ? new DateTime() : $date;

		$identifiers = DateTimeZone::listIdentifiers();

		$offset_in_seconds = intval( $offset_in_hours * HOUR_IN_SECONDS );

		foreach ( $identifiers as $identifier ) {
			$timezone = new DateTimeZone( $identifier );

			if ( $timezone->getOffset( $date ) === $offset_in_seconds ) {
				return $identifier;
			}
		}
	}

	/**
	 * Get timezone from abbreviations list by the specified offset in hours.
	 *
	 * @param float $offset_in_hours Timezone offset in hours.
	 * @return string|null
	 */
	public static function get_timezone_from_abbreviations_list_by_offset( $offset_in_hours ) {
		$abbreviations = DateTimeZone::listAbbreviations();

		$offset_in_seconds = intval( $offset_in_hours * HOUR_IN_SECONDS );

		foreach ( $abbreviations as $abbreviation => $timezones ) {
			foreach ( $timezones as $timezone ) {
				if ( $timezone['offset'] === $offset_in_seconds ) {
					return $timezone['timezone_id'];
				}
			}
		}
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
