<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Activator
{

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public static function activate()
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

    $desired_options = array(
      'app_environment' => 'development',
      'sender_display_name' => 'Emeodi anthony',
      'sender_email' => 'info@email.com',
    );
    foreach ($pages_arrg as $index => $page) :
      // Create homepage
      $zpage = array(
        'post_type'    => 'page',
        'post_title'    => $page['title'],
        'post_content'  => $page['content'],
        'post_name' => $page['id'],
        'post_status'   => 'publish',
      );
      // Insert the post into the database
      $page_id =  wp_insert_post($zpage);
      $desired_options[$page['id']] = $page_id;
    endforeach;
    // set this page as homepage
    $current_options = get_option('venues_booking_engine_advanced', array());
    $merged_options = wp_parse_args($current_options, $desired_options);
    update_option('venues_booking_engine_advanced', $merged_options);
  }
}
