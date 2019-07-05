<?php

/**
 * Provide a cart
 *
 * This file is used to markup the cart user interface, thereby allowing the user to update the quantity of ticket he
 * or she is purchasing. It also may end up having some dynamism on how many tickets needs to be profilled.
 *
 * @link       venues-booking-engine
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/public/partials
 */

if (!empty($_GET['eid'])) {
    extract($_GET);

    $id = $eid;
    $default_post_type = get_option("venues_booking_engine_general")['default_post_type'];
    $default_price_key = get_option("venues_booking_engine_general")['default_price_key'];
    $default_sale_price_key = get_option("venues_booking_engine_general")['sale_price_key'];
    $checkout_page = get_option('venues_booking_engine_advanced')['book-now-checkout'];
    $currency = get_option("venues_booking_engine_general")['currency'];
    $checkout_page_url = get_page_link($checkout_page);

    $args = array(
        'post_type' => $default_post_type,
        'p' => $id,
    );
    $auery = new WP_Query($args);
    $data = array();

    if ($auery->have_posts()) :
        while ($auery->have_posts()) : $auery->the_post();
            $data['summary'] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'featured_image' => get_the_post_thumbnail_url(),
                'price' => get_post_meta(get_the_ID(), $default_price_key, true) ?? 0,
                'sale_price' => get_post_meta(get_the_ID(), $default_sale_price_key, true) ?? 0,
            );
        endwhile;
        wp_reset_postdata();
        $data['extras'] = get_post($id);
    endif;
    $client_ip = Venues_Booking_Engine_Public::get_user_ip_address();
    $hshed_ip = password_hash($client_ip, PASSWORD_BCRYPT);
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section id="ebe-cart-collector">
    <div class="row">
        <div class="heading-primary">
            <h2>Choose Your Ticket Type</h2>
        </div>
    </div>

    <form action="<?php echo $checkout_page_url; ?>" method="get">
        <input type="hidden" name="p" value="<?php echo $data['summary']['price']; ?>"> <!-- price -->
        <input type="hidden" name="sp" value="<?php echo $data['summary']['sale_price']; ?>"> <!-- sale price -->
        <input type="hidden" name="id" value="<?php echo $data['summary']['id']; ?>"> <!-- current id of post type -->
        <input type="hidden" name="client_id" value="<?php echo $hshed_ip; ?>">
        <section class="row">
            <table class="table table-hover custom-table">
                <thead>
                    <td></td>
                    <td>
                        Name
                    </td>
                    <td>
                        Ticket Type
                    </td>
                    <td>
                        Price
                    </td>
                    <td>
                        Quantity
                    </td>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input checked type="checkbox" name="ticket_choice[]" id="ticket_choice_1" value="<?php echo $eid; ?>">
                        </td>
                        <td>
                            <label for="ticket_choice_1"><?php echo $data['summary']['title']; ?></label>
                        </td>
                        <td>
                            Basic
                        </td>
                        <td>
                            <?php
                            $price = $data['summary']['price'] > 0 && !is_array($data['summary']['price']) ? $data['summary']['price'] : 'Free';
                            $sale_price = $data['summary']['sale_price'];
                            if (!empty($price) && $price > $sale_price && !is_array($price)) {
                                echo "<small><del>{$currency}{$price}</del></small>";
                            } else {
                                echo "<span class='cseess-urrency'>{$currency}</span> <span class='bold-text sessy-price'>{$price}</span>";
                            }
                            if (!empty($sale_price) && !is_array($sale_price)) echo " <div>
                                <span class='cseess-urrency'>{$currency}</span><span class='sessy-price'>{$sale_price}</span>
                            </div>";
                            ?>
                        </td>
                        <td>
                            <input type="number" min="0" value="0" name="quantity[]" id="quantity_1" class="min-witty">
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="row">
            <div class="col-md-4">
                <h3>Total: <span class="total_price_cart">Free</span></h3>
            </div>
            <div class="pull-right">
                <a href="<?php echo $data['summary']['link']; ?>" class="button">Back to Site</a>
                <button type="submit" class="button cart-btn-cheesz">Checkout <i class="fa fa-right-arrow"></i></button>
            </div>
        </section>
    </form>
</section>