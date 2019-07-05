<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       venues-booking-engine
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/public
 * @author     Venues-booking-engine <venues-booking-engine>
 */
class Venues_Booking_Engine_Public
{

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Venues_Booking_Engine_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Venues_Booking_Engine_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/venues-booking-engine-public.css', array(), $this->version, 'all');
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Venues_Booking_Engine_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Venues_Booking_Engine_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script($this->plugin_name . '-flutterwave', 'https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js', array('jquery'), $this->version, false);
    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/venues-booking-engine-public.js', array('jquery'), $this->version, false);
  }

  /**
   * register the shortcode for the cart part of the app
   */
  public function init_book_now_cart()
  {
    require_once plugin_dir_path(__FILE__) . "partials/init_book_now_cart_html.php";
  }

  /**
   * register the shortcode for the checkout page
   */
  public function init_book_now_checkout()
  {
    require_once plugin_dir_path(__FILE__) . "partials/init_book_now_checkout_html.php";
  }

  /**
   * register the shortcode for the ticket page
   */
  public function init_book_now_ticket()
  {
    require_once plugin_dir_path(__FILE__) . "partials/init_book_now_ticket_html.php";
  }

  /**
   * register the shortcode for the payment page
   */
  public function init_book_now_payment()
  {
    require_once plugin_dir_path(__FILE__) . "partials/init_book_now_payment_html.php";
  }

  /**
   * helpers function to get the iop address of a user
   * 
   * @author Emeodi anthony <anthony10@hotmai.com>
   */
  public static function get_user_ip_address()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      //ip from share internet
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      //ip pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}
