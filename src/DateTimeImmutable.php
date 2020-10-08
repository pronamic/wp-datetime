<?php
/**
 * Date time immutable
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 * @see       https://github.com/woocommerce/woocommerce/blob/3.3.4/includes/class-wc-datetime.php
 * @see       https://github.com/Rarst/wpdatetime/
 */

namespace Pronamic\WordPress\DateTime;

/**
 * Date time immutable
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.2.0
 */
class DateTimeImmutable extends \DateTimeImmutable implements DateTimeInterface {
	use DateTimeTrait;

	/**
	 * Overrides upstream method to correct returned instance type to the inheriting one.
	 *
	 * {@inheritdoc}
	 *
	 * @param \DateTime $object Object.
	 * @return self
	 */
	public static function createFromMutable( $object ) {
		return self::create_from_mutable( $object );
	}

	/**
	 * Create from mutable.
	 *
	 * @link https://www.php.net/manual/en/datetimeimmutable.createfrommutable.php
	 * @param \DateTime $object The mutable DateTime object that you want to convert to an immutable version.
	 * @return self
	 */
	public static function create_from_mutable( \DateTime $object ) {
		$instance = new self( '@' . $object->getTimestamp() );

		return $instance->setTimezone( $object->getTimezone() );
	}
}
