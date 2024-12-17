<?php
/**
 * Plugin Name: Pronamic DateTime
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-datetime/
 * Description: WordPress DateTime library.
 *
 * Version: 2.1.8
 * Requires at least: 4.7
 * Requires PHP: 7.4
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
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pronamic DateTime load plugin text domain.
 */
function pronamic_datetime_load_plugin_textdomain() {
	load_plugin_textdomain( 'pronamic-datetime', false, basename( __DIR__ ) . '/languages' );
}

add_action( 'init', 'pronamic_datetime_load_plugin_textdomain' );
