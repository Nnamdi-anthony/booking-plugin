<?php

/**
 * The Metaboxes for Notifications Types
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The Metaboxes for Notifications Types
 *
 * Defines the plugin name, version, and add various metaboxes for notifications types
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Metaboxes_Notifications_Templates
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
        $this->post_type = 'notify-templates';
        $this->iteration_box = array(
            'register' => array(
                array(
                    'id' => 'notify-types-choice',
                    'title' => 'Template Types',
                    'callback' => array($this, 'notifications_types_html'),
                    'context' => 'side',
                ),
                array(
                    'id' => 'notify-types-referrals',
                    'title' => 'Template Placeholders',
                    'callback' => array(
                        $this,
                        'template_placeholders_html'
                    ),
                    'context' => 'side',
                ),
            ),
            'deregister' => array(
                array(
                    'id' => 'notify-typesdiv',
                    'context' => 'side'
                )
            )
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
     * Deregister the Metabox
     *
     * @since    1.0.0
     */
    public function deregister()
    {
        foreach ($this->iteration_box['deregister'] as $box) :
            extract($box);
            remove_meta_box($id, $this->post_type, $context);
        endforeach;
    }

    /**
     * save the Metabox fields
     *
     * @param int $post_id the id of the currently saved post
     * @param object $post the post object for the current postobje
     * @since    1.0.0
     */
    public function save($post_id, $post)
    { }

    /**
     * used to display the notifications types
     *
     * @param object $post
     * @return void
     */
    public function notifications_types_html($post)
    {
        require_once plugin_dir_path(__FILE__) . "partials/metaboxes/notification-types/notification-types.php";
    }

    /**
     * used to display the template placeholders types
     *
     * @param object $post
     * @return void
     */
    public function template_placeholders_html($post)
    {
        require_once plugin_dir_path(__FILE__) . "partials/metaboxes/notification-types/template-placeholders.php";
    }
}
