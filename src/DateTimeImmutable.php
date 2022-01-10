<?php
/**
 * Date time immutable
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
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
}
