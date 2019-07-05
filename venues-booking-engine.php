<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/nnamdi-anthony
 * @since             1.0.0
 * @package           Venues_Booking_Engine
 *
 * @wordpress-plugin
 * Plugin Name:       Venues Booking Engine
 * Plugin URI:        https://gidievents.com/venues
 * Description:       This is this venues booking engine plugin for the venues subsite
 * Version:           1.0.0
 * Author:            Emeodi Nnamdi
 * Author URI:        https://github.com/nnamdi-anthony
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       venues-booking-engine
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('VENUES_BOOKING_ENGINE_VERSION', '1');

/**
 * require the composer autoloader
 */
require_once plugin_dir_path(__FILE__) . "vendor/autoload.php";

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-events-booking-engine-activator.php
 */
function activate_venues_booking_engine()
{
  Venues_Booking_Engine_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-events-booking-engine-deactivator.php
 */
function deactivate_venues_booking_engine()
{
  Venues_Booking_Engine_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_venues_booking_engine');
register_deactivation_hook(__FILE__, 'deactivate_venues_booking_engine');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_venues_booking_engine()
{

  $plugin = new Venues_Booking_Engine();
  $plugin->run();
}
run_venues_booking_engine();
