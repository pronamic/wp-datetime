<?php
/**
 * DateTime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2018 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\DateTime
 */

namespace Pronamic\WordPress\DateTime;

use WP_UnitTestCase;

/**
 * DateTimeZone Test
 *
 * @author Remco Tolsma
 * @version 1.0
 */
class DateTimeZoneTest extends WP_UnitTestCase {
	/**
	 * Test constructor.
	 *
	 * @see https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 */
	public function test_constructor() {
		$timezone = new DateTimeZone( 'UTC' );

		$this->assertInstanceOf( __NAMESPACE__ . '\DateTimeZone', $timezone );
	}
}
