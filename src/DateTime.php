<?php
/**
 * Date time
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
 * Date time
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.0.0
 */
class DateTime extends \DateTime implements \Pronamic\WordPress\DateTime\DateTimeInterface {
	use DateTimeTrait;
}
