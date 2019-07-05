<?php

/**
 * The Metaboxes for Bookings
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The Metaboxes for Bookings
 *
 * Defines the plugin name, version, and add various metaboxes for the customer personal data and otherwise
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Metaboxes_Bookings
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
   * The array to register and deregister
   *
   * @since    1.0.0
   * @access   private
   * @var      array    $version    The array that holds which metabox to add and remove
   */
  private $iteration_box;

  /**
   * The post type
   *
   * @since    1.0.0
   * @access   private
   * @var      array    $version    The post type to assign the metaboxes to
   */
  private $post_type;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->post_type = 'bookings';
    $this->iteration_box = array(
      'register' => array(
        array(
          'id' => 'type-of-bookings',
          'title' => 'Type of Booking',
          'callback' => array($this, 'type_of_booking_html'),
          'context' => 'side',
        ),
        array(
          'id' => 'payment-types',
          'title' => 'Booking Payment Mode',
          'callback' => array($this, 'booking_mode_html'),
          'context' => 'side',
        ),
        array(
          'id' => 'booking-status_helperss',
          'title' => 'Booking Status',
          'callback' => array($this, 'booking_status_html'),
          'context' => 'side',
        ),
        array(
          'id' => 'booking-actions',
          'title' => 'Booking Actions',
          'callback' => array($this, 'booking_actions_html'),
          'context' => 'side',
        ),
        array(
          'id' => 'booking-ticket-information',
          'title' => 'Ticket Information',
          'callback' => array($this, 'booking_ticket_information_html'),
          'context' => 'side',
        ),
        array(
          'id' => 'booking-contact-information',
          'title' => 'Booking Information',
          'callback' => array($this, 'booking_information_html'),
          'context' => 'side',
        ),
      ),
      'deregister' => array(
        array(
          'id' => 'booking-actionsdiv',
          'context' => 'side'
        ),
        array(
          'id' => 'booking-typesdiv',
          'context' => 'side'
        ),
        array(
          'id' => 'booking-statusdiv',
          'context' => 'side'
        ),
        array(
          'id' => 'payment-typesdiv',
          'context' => 'side'
        ),
      ),
    );
  }

  /**
   * Register the Metabox
   *
   * @since    1.0.0
   */
  public function register()
  {
    foreach ($this->iteration_box['register'] as $box) :
      extract($box);
      add_meta_box($id, $title, $callback, $this->post_type, $context);
    endforeach;
  }

  /**
   * remove unwanted metaboxes from the post type
   *
   * @return void
   */
  public function deregister()
  {
    foreach ($this->iteration_box['deregister'] as $box) :
      extract($box);
      remove_meta_box($id, $this->post_type, $context);
    endforeach;

    return true;
  }

  /**
   * save the metaboxes fields
   *
   * @param int $post_id
   * @param object $post
   * @return void
   */
  public function save($post_id, $post)
  {
    if (!empty($_POST)) :
      $fields = array(
        'number_of_ticket',
        'select_product',
      );
      foreach ($fields as $field) :
        if (!empty($_POST[$field])) update_post_meta($post_id, $field, $_POST[$field] ?? '');
      endforeach;

      if (!empty($_POST['first_name']) && is_array($_POST['first_name'])) {

        $fields = array(
          'first_name',
          'last_name',
          'email_address',
          'confirm_email',
          'telephone_number',
          'alt_telephone_number'
        );
        $repeatable_fields = array();

        // loop through the items and convert them to a single array
        foreach ($_POST['first_name'] as $index => $value) {
          foreach ($fields as $field) {
            // $item
            $repeatable_fields[$index][$field] = $_POST[$field][$index] ?? '';
          }
        }

        // jsonify the output
        $attendee_details = wp_json_encode($repeatable_fields);
        update_post_meta($post_id, 'attendee_details', $attendee_details);
      } else {
        update_post_meta($post_id, 'attendee_details', '');
      }
    endif;
  }


  /**
   * require the booking actions html file
   *
   * @return void
   */
  public function booking_actions_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/booking-actions.php";
  }

  /**
   * require the booking status html file
   *
   * @return void
   */
  public function booking_status_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/booking-status.php";
  }

  /**
   * require the type of booking html file
   *
   * @return void
   */
  public function type_of_booking_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/type-of-booking.php";
  }

  /**
   * require the mode of booking html file
   *
   * @return void
   */
  public function booking_mode_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/booking-payment-mode.php";
  }

  /**
   * require the mode of booking html file
   *
   * @return void
   */
  public function booking_ticket_information_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/booking-ticket-information.php";
  }

  /**
   * require the mode of booking html file
   *
   * @return void
   */
  public function booking_information_html($post)
  {
    require_once plugin_dir_path(__FILE__) . "partials/metaboxes/bookings/booking-information.php";
  }
}
