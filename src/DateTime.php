<?php
/**
 * Date time
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
		return self::create_from_immutable( $object );
	}

	/**
	 * Create from immutable.
	 *
	 * @link https://www.php.net/manual/en/datetimeimmutable.createfrommutable.php
	 * @param \DateTimeImmutable $object The immutable DateTimeImmutable object that needs to be converted to a mutable version.
	 * @return self
	 */
	public static function create_from_immutable( \DateTimeImmutable $object ) {
		$instance = new self( '@' . $object->getTimestamp() );

		return $instance->setTimezone( $object->getTimezone() );
	}
}
