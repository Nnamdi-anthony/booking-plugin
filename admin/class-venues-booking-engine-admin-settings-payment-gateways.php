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
 * Defines the plugin name, version, and add various options to add more ways to pay for the resources
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Settings_Payment_Gateways extends Venues_Booking_Engine_Admin_Settings
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
        $this->base_name = "_payment_gateways";
        $this->sections = array(
            array(
                'title' => 'Payment Settings',
                'message' => "For Developers to use and customize the application behaviour",
            ),
        );
        $this->fields = array(
            array(
                'id' => 'payment_gateway_environment',
                'section' => 'Payment Settings',
                'callback' => array($this, 'app_enviroment_cb'),
            ),
            array(
                'id' => 'payment_gateway_api_key',
                'title' => 'API Key',
                'section' => 'Payment Settings',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'payment_use_woocommerce',
                'title' => 'Use WC Payment Methods',
                'section' => 'Payment Settings',
                'callback' => array($this, 'yes_no_cb'),
            ),
        );
    }
}
