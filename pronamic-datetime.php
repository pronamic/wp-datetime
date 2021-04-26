<?php
/**
 * Plugin Name: Pronamic DateTime
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-datetime/
 * Description: WordPress DateTime library.
 *
 * Version: 1.2.0
 * Requires at least: 4.7
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: pronamic-datetime
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 * GitHub URI: https://github.com/pronamic/wp-datetime
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

/**
 * Pronamic DateTime load plugin text domain.
 */
function pronamic_datetime_load_plugin_textdomain() {
	load_plugin_textdomain( 'pronamic-datetime', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'pronamic_datetime_load_plugin_textdomain' );
