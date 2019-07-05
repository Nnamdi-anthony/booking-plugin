<?php

class Venues_Booking_Engine_Helpers
{
  public static function generate_booking_code()
  {
    $current_site_id = get_current_blog_id();
    $current_year_month = date("ym");

    $query = array(
      "post_type" => str_replace("-", "_", self::$plugin_name . "_booking"),
      "posts_per_page" => -1,
    );
    $q = new WP_Query($query);
    $count_old_bookings = $q->post_count;
    $unique_code = str_pad($count_old_bookings + 1, 6, '0', STR_PAD_LEFT);

    return "GF" . $current_site_id . $current_year_month . $unique_code;
  }
}
