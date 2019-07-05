<?php

/**
 * The admin-specific menu functionality of the plugin.
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The admin-specific menu functionality of the plugin.
 *
 * Defines the plugin name, version, and registers 
 * new admin specific menus to the wordpress dashboard
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Menus
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
     * The post_menus of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $post_menus    The post_menus of this plugin.
     */
    private $post_menus;

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
        $this->post_menus = array(
            array(
                'name' => 'All Bookings',
                'post_type' =>  'bookings'
            ),
            array(
                'name' => 'Email Notifications',
                'post_type' =>  'e-notify'
            ),
            array(
                'name' => 'SMS Notifications',
                'post_type' =>  's-notify'
            ),
            array(
                'name' => 'Notifications Templates',
                'post_type' =>  'notify-templates'
            ),
        );
    }

    /**
     * Register the Bookings Post Type
     *
     * @since    1.0.0
     */
    public function register()
    {
        add_menu_page('Bookings', 'Bookings', 'manage_options', $this->plugin_name, null, 'dashicons-dashboard', 5);
        foreach ($this->post_menus as $in => $post_ty) :
            extract($post_ty);
            add_submenu_page($this->plugin_name, $name, $name, 'manage_options', 'edit.php?post_type=' . $post_type, null);
        endforeach;
        add_submenu_page($this->plugin_name, 'Booking Settings', 'Booking Settings', 'manage_options', 'manage-settings', array($this, 'show_settings_html'));
    }

    /**
     * menus to remove from
     *
     * @return void
     */
    public function deregister()
    {
        // remove_menu_page('edit.php');
        remove_submenu_page($this->plugin_name, $this->plugin_name);
        // remove_menu_page('edit-comments.php');
    }

    /**
     * register menus under plugin name
     *
     * @param array $actions
     * @param string $plugin_file
     * @return array
     */
    public function register_plugin_menus($actions, $plugin_file)
    {
        static $plugin;

        if (!isset($plugin)) {
            $plugin = plugin_basename(dirname(dirname(__FILE__)) . "/{$this->plugin_name}.php");
        }

        if ($plugin == $plugin_file) {

            $settings = array('settings' => '<a href="admin.php?page=manage-settings">' . __('Settings', 'venues-booking-engine') . '</a>');
            $actions = array_merge($settings, $actions);
        }

        return $actions;
    }

    public function show_settings_html()
    {
        require_once plugin_dir_path(__FILE__) . "partials/settings/index.php";
    }

    /**
     * Set active menu for post type color
     *
     * @hook parent_file
     * @access public
     * @return void
     */
    public function set_menu_state()
    {
        global $parent_file, $submenu_file, $post_type, $taxonomy;

        // echo $submenu_file;

        foreach ($this->post_menus as $in => $type) :
            switch ($post_type) {
                case $type['post_type']:
                    $parent_file = $this->plugin_name; // WPCS: override ok.
                    break;
            }
        endforeach;
    }
}
