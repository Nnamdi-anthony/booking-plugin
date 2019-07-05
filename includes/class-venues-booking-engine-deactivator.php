<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Deactivator
{

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public static function deactivate()
  {
    $pages_arrg = array(
      array(
        'id' => 'book-now-cart',
        'title' => 'Book Now Cart',
        'content' => "[init_book_now_cart]"
      ),
      array(
        'id' => 'book-now-checkout',
        'title' => 'Book Now Checkout',
        'content' => "[init_book_now_checkout]"
      ),
      array(
        'id' => 'book-now-ticket',
        'title' => 'Book Now Ticket',
        'content' => "[init_book_now_ticket]"
      ),
      array(
        'id' => 'book-now-payment',
        'title' => 'Book Now Payment',
        'content' => "[init_book_now_payment]"
      ),
    );

    foreach ($pages_arrg as $index => $page) :
      $homepage_id = get_option('venues_booking_engine_advanced')[$page['id']];
      wp_delete_post($homepage_id);

      delete_option('venues_booking_engine_advanced')[$page['id']];
    endforeach;
  }
}
