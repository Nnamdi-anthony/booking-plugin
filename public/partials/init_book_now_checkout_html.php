<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       venues-booking-engine
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/public/partials
 */

// make sure to kill the page ithe current ip doesnt match what was sent from the cart
$ip = Venues_Booking_Engine_Public::get_user_ip_address();
if (!password_verify($ip, $_GET['client_id'])) {
  wp_die('sorry no access allowed');
}
$id = $_GET['id'];
$cart_page = get_page_link(get_option('venues_booking_engine_advanced')['book-now-cart']);
$payment_page = get_page_link(get_option('venues_booking_engine_advanced')['book-now-payment']);
$tickrt_page = get_page_link(get_option('venues_booking_engine_advanced')['book-now-ticket']);
$default_post_type = get_option("venues_booking_engine_general")['default_post_type'];
$currency = get_option("venues_booking_engine_general")['currency'];
$quantity = $_GET['quantity'];
$total_qty = 0;
$fields = array(
  array(
    'first_name' => 'text',
    'last_name' => 'text'
  ),
  array(
    'email_address' => 'email',
    'telephone_number' => 'text',
    'alt_telephone_number' => 'text'
  )
);
// calc the total quantity of tickets
for ($i = 0; $i < count($quantity); $i++) {
  $total_qty += $quantity[$i];
}
$is_single_ticket = true; // to be set on later when multiticketing is not allowed for certain venues
$desired_price = isset($_GET['sp']) && !empty($_GET['sp']) && $_GET['sp'] > $_GET['p'] ? $_GET['sp'] : $_GET['p'];

$args = array(
  'p' => $id,
  'post_type' => $default_post_type,
);
$otall = $desired_price * $total_qty;
$next_url = $otall > 0 ? $tickrt_page : $payment_page;
$query = new WP_Query($args);
if ($query->have_posts()) :
  $insert_data = array(
    'post_type' => 'bookings',
    'post_name' => Venues_Booking_Engine_Helpers::generate_booking_code(),
    'meta_input' => array(
      'number_of_ticket' => $total_qty,
      'select_product' => $default_post_type,
    ),
  );
  $booking_id = wp_insert_post($insert_data); // create the booking id and save it
  wp_set_object_terms($booking_id, 'guest', 'booking-types');
  wp_set_object_terms($booking_id, 'on-hold', 'booking-status');
  if ($otall > 0) wp_set_object_terms($booking_id, 'paid', 'payment-types');
  if ($otall <= 0) wp_set_object_terms($booking_id, 'free', 'payment-types');
  while ($query->have_posts()) : $query->the_post();
    ?>

    <!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <form action="<?php echo $next_url; ?>" method="post">
      <section class="row">
        <div class="col-md-8">
          <h2>
            <strong>
              <?php the_title(); ?>
            </strong>
          </h2>
          <h4 class="event-organizer-name"><?php echo get_post_meta(get_the_ID(), 'listing_branding_name', true); ?></h4>
          <h5 class="event-organizer-time-line"><?php echo date("l, F j, Y", strtotime(get_post_meta(get_the_ID(), 'listing_event_date', true))); ?> at <?php echo date("h:ia", strtotime(get_post_meta(get_the_ID(), 'listing_event_time', true))); ?> - <?php echo date("l, F j, Y", strtotime(get_post_meta(get_the_ID(), 'listing_event_date_end', true))); ?> at <?php echo date("h:ia", strtotime(get_post_meta(get_the_ID(), 'listing_event_time_end', true))); ?></h5>
          <h5 class="event-orgaizer-address"><?php echo get_post_meta(get_the_ID(), 'listing_contact_address', true); ?> </h5>
        </div>
        <div class="col-md-4">
          <div class="event-post-image">
            <?php the_post_thumbnail(); ?>
          </div>
        </div>
      </section>
      <section class="row" style="margin-top:10px;">
        <div class="col-md-8">
          <div class="evu-card">
            <div class="evu-card-title">
              <h5>Summary</h5>
            </div>
            <div class="evu-card-content">
              <div class="row">
                <div class="col-md-6">
                  <h4>Ticket Type</h4>
                  <p>
                    Basic
                  </p>
                </div>
                <div class="col-md-6 text-center">
                  <h4>Quantity</h4>
                  <p>
                    <?php echo $total_qty; ?>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <h4>Base Price</h4>
                  <p>
                    <?php echo $currency . $desired_price; ?>
                  </p>
                </div>
                <div class="col-md-6 text-center">
                  <h4>Total</h4>
                  <p>
                    <?php
                    if ($otall > 0) {
                      echo $currency . $otall;
                    } else {
                      echo "Free";
                    } ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="evu-card">
            <div class="evu-card-title">
              <h5>Registration Information</h5>
            </div>
            <div class="evu-card-content">
              <?php
              ob_start(); ?>
              <div class="row stay-wrong-boi">
                <?php foreach ($fields as $name => $type) : ?>
                  <?php if (is_array($type)) :
                    $cols_div = count($type);
                    $cols_div = 12 / $cols_div;
                    ?>
                    <div class="new-rwo">
                      <?php foreach ($type as $new_name => $new_type) : ?>
                        <div class="col-md-<?php echo $cols_div; ?>">
                          <label for="<?php echo $new_name; ?>"><?php echo str_replace("_", " ", $new_name); ?></label>
                          <input type="<?php echo $new_type; ?>" name="<?php echo $new_name; ?>[]" id="<?php echo $new_name; ?>" class="form-control">
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php else : ?>
                    <div class="col-md-12">
                      <label for="<?php echo $type; ?>"><?php echo str_replace("_", " ", $type); ?></label>
                      <input type="<?php echo $type; ?>" name="<?php echo $type; ?>[]" id="<?php echo $type; ?>" class="form-control">
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <?php $compiled_fields = ob_get_clean();
              if (!$is_single_ticket) :
                for ($i = 0; $i < $total_qty; $i++) :
                  $count += 1;
                  echo "<div class='row'>
                                    <div class='col-md-12'>
                                        <h3 class='no-heading-style'>#{$count} Attendee</h3>
                                    </div>
                                </div>";
                  echo $compiled_fields;
                endfor;
              else :
                $count += 1;
                echo "<div class='row'>
                                    <div class='col-md-12'>
                                        <h3 class='no-heading-style'>#{$count} Attendee</h3>
                                    </div>
                                </div>";
                echo $compiled_fields;

              endif;
              ?>
              <div class="row text-right">
                <div class="col-md-12">
                  <button type="submit" class="button" style="margin-top: 30px;">Submit</button>
                  <!-- <button type="button" onClick="payWithRave()">Pay Now</button>

                                                                            <script>
                                            const API_publicKey = "FLWPUBK-cba53ee1341aba1ec03fcee26568ae0d-X";

                                            function payWithRave() {
                                                var x = getpaidSetup({
                                                    PBFPubKey: API_publicKey,
                                                    customer_email: "user@example.com",
                                                    amount: 2000,
                                                    customer_phone: "234099940409",
                                                    currency: "NGN",
                                                    txref: "rave-123456",
                                                    meta: [{
                                                        metaname: "flightID",
                                                        metavalue: "AP1234"
                                                    }],
                                                    onclose: function() {},
                                                    callback: function(response) {
                                                        var txref = response.tx.txRef; // collect txRef returned and pass to a 					server page to complete status check.
                                                        console.log("This is the response returned after a charge", response);
                                                        if (
                                                            response.tx.chargeResponseCode == "00" ||
                                                            response.tx.chargeResponseCode == "0"
                                                        ) {
                                                            // redirect to a success page
                                                        } else {
                                                            // redirect to a failure page.
                                                        }

                                                        x.close(); // use this to close the modal immediately after payment.
                                                    }
                                                });
                                            }
                                        </script> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="evu-card">
            <div class="evu-card-title">
              <h5>Event Details</h5>
            </div>
            <div class="evu-card-content">
              <div class="event-details-mainnee">
                <?php the_content(); ?>
              </div>
              <div class="event-when">
                <h5 class="event-organizer-time-line"><?php echo date("l, F j, Y", strtotime(get_post_meta(get_the_ID(), 'listing_event_date', true))); ?> at <?php echo date("h:ia", strtotime(get_post_meta(get_the_ID(), 'listing_event_time', true))); ?> - <?php echo date("l, F j, Y", strtotime(get_post_meta(get_the_ID(), 'listing_event_date_end', true))); ?> at <?php echo date("h:ia", strtotime(get_post_meta(get_the_ID(), 'listing_event_time_end', true))); ?></h5>
              </div>
            </div>
          </div>
          <div class="evu-card">
            <div class="evu-card-title">
              <h5>Organizer Information</h5>
            </div>
            <div class="evu-card-content">
              <h3 class="event-organizer-name"><?php echo get_post_meta(get_the_ID(), 'listing_branding_name', true); ?></h3>
              <p class="event-organizer-name">Website: <?php echo get_post_meta(get_the_ID(), 'listing_contact_website', true); ?></p>
              <p class="event-organizer-name">Address: <?php echo get_post_meta(get_the_ID(), 'listing_contact_address', true); ?></p>
              <p class="event-organizer-name">Phone: <?php echo get_post_meta(get_the_ID(), 'listing_contact_phone', true); ?></p>
            </div>
          </div>
        </div>
      </section>
    </form>

  <?php endwhile;
  wp_reset_postdata(); ?>
<?php else : ?>
  <?php wp_die('sorry access is restricted'); ?>
<?php endif; ?>