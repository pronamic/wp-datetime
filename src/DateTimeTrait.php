<?php
/**
 * Date time trait
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
 * Date time trait
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.2.0
 */
trait DateTimeTrait {
	/**
	 * Slash date format characters.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/5.2/wp-includes/formatting.php#L2615-L2628
	 * @link https://www.php.net/manual/en/function.addcslashes.php
	 *
	 * @param string $value Value.
	 * @return string
	 */
	private static function slash_date_format_characters( $value ) {
		$charlist = implode( '', DateTimeInterface::DATE_FORMAT_CHARACTERS );

		// Backslash the backslash.
		$charlist .= '\\';

		$value = \addcslashes( $value, $charlist );

		return $value;
	}

	/**
	 * Translate.
	 *
	 * @since 1.0.1
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L103-L119
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/class-wp-locale.php#L116-L235
	 *
	 * @global \WP_Locale $wp_locale WordPress date and time locale object.
	 *
	 * @param string $format Format.
	 *
	 * @return string
	 */
	private function format_i18n_translate( $format ) {
		global $wp_locale;

		if ( ! $wp_locale instanceof \WP_Locale ) {
			return $format;
		}

		if ( empty( $wp_locale->month ) || empty( $wp_locale->weekday ) ) {
			return $format;
		}

		$month   = $wp_locale->get_month( $this->format( 'm' ) );
		$weekday = $wp_locale->get_weekday( \intval( $this->format( 'w' ) ) );

		$format_length = \strlen( $format );

		$format_new = '';

		for ( $i = 0; $i < $format_length; $i++ ) {
			switch ( $format[ $i ] ) {
				case 'D':
					$format_new .= self::slash_date_format_characters( $wp_locale->get_weekday_abbrev( $weekday ) );

					break;
				case 'F':
					$format_new .= self::slash_date_format_characters( $month );

					break;
				case 'l':
					$format_new .= self::slash_date_format_characters( $weekday );

					break;
				case 'M':
					$format_new .= self::slash_date_format_characters( $wp_locale->get_month_abbrev( $month ) );

					break;
				case 'a':
					$format_new .= self::slash_date_format_characters( $wp_locale->get_meridiem( $this->format( 'a' ) ) );

					break;
				case 'A':
					$format_new .= self::slash_date_format_characters( $wp_locale->get_meridiem( $this->format( 'A' ) ) );

					break;
				case '\\':
					$format_new .= $format[ $i ];

					if ( $i < $format_length ) {
						++$i;
					}

					// No break.
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
	 * @since 1.0.1
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.6/wp-includes/functions.php#L120-L136
	 * @link https://github.com/php/php-src/blob/php-7.2.7/ext/date/php_date.c#L1093-L1253
	 *
	 * @param string $format Format.
	 *
	 * @return string
	 */
	private function format_i18n_timezone( $format ) {
		$format_length = \strlen( $format );

		$format_new = '';

		for ( $i = 0; $i < $format_length; $i++ ) {
			switch ( $format[ $i ] ) {
				case 'P':
				case 'I':
				case 'O':
				case 'T':
				case 'Z':
				case 'e':
					$format_new .= self::slash_date_format_characters( $this->format( $format[ $i ] ) );

					break;
				case '\\':
					$format_new .= $format[ $i ];

					if ( $i < $format_length ) {
						++$i;
					}

					// No break.
				default:
					$format_new .= $format[ $i ];

					break;
			}
		}

		return $format_new;
	}

	/**
	 * Get WordPress timestamp.
	 *
	 * @since 1.0.1
	 *
	 * @return int
	 */
	private function get_wp_timestamp() {
		return $this->getTimestamp() + DateTimeZone::get_offset( $this );
	}

	/**
	 * Get local date for this date.
	 *
	 * @since 1.0.1
	 *
	 * @return self
	 */
	public function get_local_date() {
		$wp_timezone = DateTimeZone::get_default();

		/**
		 * PHP BUG: DateTime::setTimezone(): Can only do this for zones with ID for now.
		 * PHP version < 5.4.26
		 * PHP version > 5.5 < 5.5.10
		 *
		 * @link https://bugs.php.net/bug.php?id=45543
		 * @link https://3v4l.org/mlZX7
		 */
		if ( \version_compare( PHP_VERSION, '5.4.26', '<' ) || ( \version_compare( PHP_VERSION, '5.5', '>' ) && \version_compare( PHP_VERSION, '5.5.10', '<' ) ) ) {
			return new self( \gmdate( DateTimeInterface::MYSQL, $this->get_wp_timestamp() ), $wp_timezone );
		}

		$date = clone $this;

		$date = $date->setTimezone( $wp_timezone );

		return $date;
	}

	/**
	 * Format translate.
	 *
	 * @link https://developer.wordpress.org/reference/functions/__/
	 *
	 * @since 1.1.0
	 * @param string $format Format.
	 * @return string
	 */
	public function format_translate( $format ) {
		$format = $this->format_i18n_translate( $format );
		$format = $this->format_i18n_timezone( $format );

		return $this->format( $format );
	}

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
	public function format_i18n( $format = null ) {
		if ( \is_null( $format ) ) {
			$format = \_x( 'D j M Y \a\t H:i', 'default datetime format', 'pronamic-datetime' );

			$format = \apply_filters( 'pronamic_datetime_default_format', $format );
		}

		$date = $this->get_local_date();

		$format = $date->format_i18n_translate( $format );
		$format = $date->format_i18n_timezone( $format );

		$result = \date_i18n( $format, $date->get_wp_timestamp() );

		return $result;
	}

	/**
	 * Overrides upstream method to correct returned instance type to the inheriting one.
	 *
	 * {@inheritdoc}
	 *
	 * @param string            $format              Format.
	 * @param string            $time                String representing the time.
	 * @param DateTimeZone|null $timezone Timezone.
	 * @return self|false
	 */
	#[\ReturnTypeWillChange]
	public static function createFromFormat( // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
		$format,
		$time,
		$timezone = null
	) {
		return self::create_from_format( $format, $time, $timezone );
	}

	/**
	 * Parse a string into a new DateTime object according to the specified format.
	 *
	 * @link http://php.net/manual/en/datetime.createfromformat.php
	 * @link https://github.com/Rarst/wpdatetime/blob/0.3/src/WpDateTimeTrait.php#L56-L77
	 *
	 * @since 1.0.1
	 *
	 * @param string        $format   Format accepted by date().
	 * @param string        $time     String representing the time.
	 * @param \DateTimeZone $timezone A DateTimeZone object representing the desired time zone.
	 *
	 * @return self|false
	 */
	#[\ReturnTypeWillChange]
	public static function create_from_format( $format, $time, \DateTimeZone $timezone = null ) {
		/*
		 * In PHP 5.6 or lower it's not possible to pass in an empty (null) timezone object.
		 * This will result in a `DateTime::createFromFormat() expects parameter 3 to be DateTimeZone, null given` error.
		 */
		$created = empty( $timezone ) ?
			parent::createFromFormat( $format, $time ) :
			parent::createFromFormat( $format, $time, $timezone );

		if ( false === $created ) {
			return false;
		}

		$wp_date_time = new self( '@' . $created->getTimestamp() );

		if ( null !== $timezone ) {
			$wp_date_time = $wp_date_time->setTimezone( $timezone );
		}

		return $wp_date_time;
	}

	/**
	 * Create from interface.
	 *
	 * @link https://www.php.net/manual/en/datetime.createfrominterface.php
	 * @link https://php.watch/versions/8.0/datetime-immutable-createfrominterface
	 * @param \DateTimeInterface $value The mutable DateTime object that you want to convert to an immutable version.
	 * @return self
	 */
	public static function create_from_interface( \DateTimeInterface $value ): self {
		return new self( $value->format( 'Y-m-d H:i:s.u' ), $value->getTimezone() );
	}
}
