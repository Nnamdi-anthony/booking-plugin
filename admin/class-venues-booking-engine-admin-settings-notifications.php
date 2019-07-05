<?php

/**
 * The notifications settings
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The notifications settings
 *
 * Defines the plugin name, version, and add various settings for notifications
 * templates and ways to send either the sms or email notifications
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Settings_Notifications extends Venues_Booking_Engine_Admin_Settings
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The ID of this plugin.
     */
    protected $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of this plugin.
     */
    protected $version;

    /**
     * The base_name of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $base_name    The base_name for this option
     */
    protected $base_name;

    /**
     * The fields for this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $fields    The fields for this option
     */
    protected $fields;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = str_replace("-", "_", $plugin_name);
        $this->version = $version;
        $this->base_name = "_notifications";
        $this->sections = array(
            array(
                'title' => 'Notification Settings',
                'message' => "Use the options below to customize the way the notification are sent",
            ),
            array(
                'title' => 'Email Template Settings',
                'message' => "Use the options below to customize the email notification templates to be sent",
            ),
            array(
                'title' => 'SMS Template Settings',
                'message' => "Use the options below to customize the sms notification templates to be sent",
            ),
        );
        $this->fields = array(
            array(
                'id' => 'notify-owners',
                'section' => 'Notification Settings',
                'callback' => 'yes_no_cb',
            ),
            array(
                'id' => 'notify-customers',
                'section' => 'Notification Settings',
                'callback' => 'yes_no_cb',
            ),
            array(
                'id' => 'owner-email-new-bookings',
                'title' => 'Owner New Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'owner-email-failed-bookings',
                'title' => 'Owner Failed Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'owner-email-cancelled-bookings',
                'title' => 'Owner Cancelled Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-email-new-bookings',
                'title' => 'Customer New Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-email-failed-bookings',
                'title' => 'Customer Failed Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-email-cancelled-bookings',
                'title' => 'Customer Cancelled Bookings',
                'section' => 'Email Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'owner-sms-new-bookings',
                'title' => 'Owner New Bookings',
                'section' => 'SMS Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'owner-sms-failed-bookings',
                'title' => 'Owner Failed Bookings',
                'section' => 'SMS Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'owner-sms-cancelled-bookings',
                'title' => 'Owner Cancelled Bookings',
                'section' => 'SMS Template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-sms-new-bookings',
                'title' => 'Customer New Bookings',
                'section' => 'SMS template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-sms-cancelled-bookings',
                'title' => 'Customer Cancelled Bookings',
                'section' => 'SMS template Settings',
                'callback' => 'choose_template_cb',
            ),
            array(
                'id' => 'customer-sms-failed-bookings',
                'title' => 'Customer Failed Bookings',
                'section' => 'SMS template Settings',
                'callback' => 'choose_template_cb',
            ),
        );
    }

    /**
     * settings field to store the anvo
     *
     * @param array $args
     * @return string|html
     */
    public function choose_template_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $options_array = array(
            'post_type' => 'notify-templates',
            'posts_per_page' => -1,
        );
        $options_array = new WP_Query($options_array);
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = "<select id='" . esc_attr($args['label_for']) . "' name='{$this->plugin_name}{$this->base_name}[" . esc_attr($args['label_for']) . "]'>";
        $html .= "<option> None </option>";
        if ($options_array->have_posts()) {
            while ($options_array->have_posts()) {
                $options_array->the_post();
                $html .= "<option " . selected($option, get_the_ID(), false) . " value='" . get_the_ID() . "'>" . ucwords(get_the_title()) . " </option>";
            }
        }
        $html .= "</select>";
        echo $html;
    }
}
