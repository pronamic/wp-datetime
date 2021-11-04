<?php
/**
 * Date time
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
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
 * @version 1.2.0
 * @since   1.0.0
 */
class DateTime extends \DateTime implements DateTimeInterface {
	use DateTimeTrait;

	/**
	 * Overrides upstream method to correct returned instance type to the inheriting one.
	 *
	 * {@inheritdoc}
	 *
	 * @param \DateTimeImmutable $object Object.
	 * @return self
	 */
	public static function createFromImmutable( $object ) {
		return self::create_from_interface( $object );
	}

	/**
	 * Overrides upstream method to correct returned instance type to the inheriting one.
	 *
	 * {@inheritdoc}
	 *
	 * @param \DateTime $object Object.
	 * @return self
	 */
	public static function createFromInterface( \DateTimeInterface $object ) {
		return self::create_from_interface( $object );
	}

	/**
	 * Create from interface.
	 *
	 * @link https://www.php.net/manual/en/datetime.createfrominterface.php
	 * @link https://php.watch/versions/8.0/datetime-immutable-createfrominterface
	 * @param \DateTimeInterface $object The mutable DateTime object that you want to convert to an immutable version.
	 * @return self
	 */
	public static function create_from_interface( \DateTimeInterface $object ) {
		return new self( $object->format('Y-m-d H:i:s.u'), $object->getTimezone() );
	}
}
