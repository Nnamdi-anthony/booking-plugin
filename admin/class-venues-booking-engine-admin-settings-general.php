<?php

/**
 * The general settings
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The general settings
 *
 * Defines the plugin name, version, and add various settings for configuring the application
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Settings_General extends Venues_Booking_Engine_Admin_Settings
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
        $this->base_name = "_general";
        $this->sections = array(
            array(
                'title' => 'General Settings',
                'message' => "Use the platform to set the  default post type, default price meta key minimum price meta key, e.t.c",
            ),
        );
        $this->fields = array(
            array(
                'id' => 'default_post_type',
                'section' => 'General Settings',
                'callback' => array($this, 'choose_page_cb'),
            ),
            array(
                'id' => 'default_price_key',
                'title' => 'Price Meta Key',
                'section' => 'General Settings',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'sale_price_key',
                'title' => 'Sale Price Meta Key',
                'section' => 'General Settings',
                'callback' => array($this, 'text_field_cb'),
            ),
            array(
                'id' => 'currency',
                'title' => 'Default Currency',
                'section' => 'General Settings',
                'callback' => array($this, 'text_field_cb'),
            ),
        );
    }

    /**
     * settings field to store the anvo
     *
     * @param array $args
     * @return string|html
     */
    public function choose_page_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $options_array = get_post_types();
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = "<select class='cc_select2_args' id='" . esc_attr($args['label_for']) . "' name='{$this->plugin_name}{$this->base_name}[" . esc_attr($args['label_for']) . "]'>";
        $html .= "<option> None </option>";
        foreach ($options_array as $key => $val) {
            $html .= "<option " . selected($option, $key, false) . " value='" . $key . "'>" . ucwords($val) . " </option>";
        }
        $html .= "</select>";
        echo $html;
    }
}
