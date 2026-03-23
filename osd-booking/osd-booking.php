<?php
/**
 * Plugin Name:       OSD Booking
 * Plugin URI:        https://github.com/technicalosd/osd-booking-plugin
 * Description:       OSD Booking system for WordPress.
 * Version:           1.0.0
 * Author:            TechnicalOSD
 * Author URI:        https://github.com/technicalosd
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       osd-booking
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'OSD_BOOKING_VERSION', '1.0.0' );
define( 'OSD_BOOKING_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'OSD_BOOKING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once OSD_BOOKING_PLUGIN_DIR . 'includes/class-osd-booking-activator.php';
require_once OSD_BOOKING_PLUGIN_DIR . 'includes/class-osd-booking-deactivator.php';
require_once OSD_BOOKING_PLUGIN_DIR . 'includes/class-osd-booking.php';
require_once OSD_BOOKING_PLUGIN_DIR . 'shortcodes/osd-login-button.php';
require_once OSD_BOOKING_PLUGIN_DIR . 'shortcodes/osd-search-box.php';

register_activation_hook( __FILE__, array( 'OSD_Booking_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'OSD_Booking_Deactivator', 'deactivate' ) );

$plugin = new OSD_Booking();
$plugin->run();