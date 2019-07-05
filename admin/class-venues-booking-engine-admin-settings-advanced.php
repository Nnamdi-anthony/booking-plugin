<?php

/**
 * The advanced settings for the plugin
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The advanced settings for the plugin
 *
 * Defines the plugin name, version, and adds various advanced settings
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Settings_Advanced extends Venues_Booking_Engine_Admin_Settings
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
        $this->base_name = "_advanced";
        $this->sections = array(
            array(
                'title' => 'Application Page Settings',
                'message' => "For Developers to use and customize the application behaviour",
            ),
            array(
                'title' => 'SMS API Keys and Configurations',
                'message' => "Set sms gateway api keys, and sender name. This settings is used to configure bulksmsnigeria.com",
            ),
            array(
                'title' => 'Email Configurations',
                'message' => "Set up the email configurations for outbound emails",
            ),
        );
        $this->fields = array(
            array(
                'id' => 'book-now-cart',
                'title' => 'Cart Page',
                'section' => 'Application Page Settings',
                'callback' => array($this, 'choose_page_cb'),
            ),
            array(
                'id' => 'book-now-checkout',
                'title' => 'Checkout Page',
                'section' => 'Application Page Settings',
                'callback' => array($this, 'choose_page_cb'),
            ),
            array(
                'id' => 'book-now-payment',
                'title' => 'Payment Page',
                'section' => 'Application Page Settings',
                'callback' => array($this, 'choose_page_cb'),
            ),
            array(
                'id' => 'book-now-ticket',
                'title' => 'Ticket Page',
                'section' => 'Application Page Settings',
                'callback' => array($this, 'choose_page_cb'),
            ),
            array(
                'id' => 'sms_gateway_api_key',
                'title' => 'SMS Gateway API Key',
                'section' => 'SMS API Keys and Configurations',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'sms_gateway_sender_name',
                'title' => 'SMS Sender Name',
                'section' => 'SMS API Keys and Configurations',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'email_sender_email',
                'title' => 'Email Sender',
                'section' => 'Email Configurations',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'email_sender_display_name',
                'title' => 'Email Sender Display Name',
                'section' => 'Email Configurations',
                'callback' => array($this, 'text_field_cb'),
            ),
        );
    }
}
