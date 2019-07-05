<?php

/**
 * Used to register taxonomies to the wordpress dashboard
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * Used to register taxonomies to the wordpress dashboard
 *
 * Defines the plugin name, version, and add new taxonomies to the dashboard
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Taxonomies
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
     * The taxonomies of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $taxonomies    The taxonomies for this plugin.
     */
    private $taxonomies;

    /**
     * The option to show taxonomies
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $taxonomies    The option to show taxonomies for this plugin.
     */
    private $show_in_menu;

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
        $this->taxonomies = array(
            array(
                'slug' => 'notify-types',
                'terms' => array('Email', 'SMS'),
                'post_types' => array('notify-templates'),
                'name' => 'Notificiation Type Categories',
            ),
            array(
                'slug' => 'booking-types',
                'terms' => array('Guest', 'Customer'),
                'post_types' => array('bookings'),
                'name' => 'Booking Types',
            ),
            array(
                'slug' => 'booking-status',
                'terms' => array('Pending Payment', 'Processing', 'On Hold', 'Completed', 'Cancelled', 'Refunded', 'Failed'),
                'post_types' => array('bookings'),
                'name' => 'Booking Statuses',
            ),
            array(
                'slug' => 'booking-actions',
                'terms' => array('Email Invoice Details to Customer', 'Resend New Order Notifications'),
                'post_types' => array('bookings'),
                'name' => 'Booking Actions',
            ),
            array(
                'slug' => 'notify-status',
                'terms' => array('Sent Successfully', 'Pending', 'Processing', 'Failed', 'Initiated', 'Not Initiated'),
                'post_types' => array('e-notify', 's-notify'),
                'name' => 'Notification Status',
            ),
            array(
                'slug' => 'payment-types',
                'terms' => array('Free', 'Paid'),
                'post_types' => array('bookings'),
                'name' => 'Payment Types',
            ),
        );
        $this->show_in_menu = true;
    }

    /**
     * Register the custom taxonomies
     *
     * @since    1.0.0
     */
    public function register($taxonomy, $show_in_menu = true, $post_types = array(), $taxonomy_name = "")
    {
        $labels = array(
            'name' => _x(ucwords(str_replace("_", " ", $taxonomy_name)), ucwords(str_replace("_", " ", $taxonomy_name)), $this->plugin_name),
            'singular_name' => _x(ucwords(str_replace("_", " ", $taxonomy_name)), ucwords(str_replace("_", " ", $taxonomy_name)), $this->plugin_name),
            'menu_name' => __(ucwords(str_replace("_", " ", $taxonomy_name)), $this->plugin_name),
            'all_items' => __('All ' . ucwords(str_replace("_", " ", $taxonomy_name)), $this->plugin_name),
            'parent_item' => __('Parent ' . ucwords(str_replace("_", " ", $taxonomy_name)) . '', $this->plugin_name),
            'parent_item_colon' => __('Parent ' . ucwords(str_replace("_", " ", $taxonomy_name)) . ':', $this->plugin_name),
            'new_item_name' => __('New ' . ucwords(str_replace("_", " ", $taxonomy_name)) . ' Name', $this->plugin_name),
            'add_new_item' => __('Add New ' . ucwords(str_replace("_", " ", $taxonomy_name)) . '', $this->plugin_name),
            'edit_item' => __('Edit ' . ucwords(str_replace("_", " ", $taxonomy_name)) . '', $this->plugin_name),
            'update_item' => __('Update ' . ucwords(str_replace("_", " ", $taxonomy_name)) . '', $this->plugin_name),
            'view_item' => __('View ' . ucwords(str_replace("_", " ", $taxonomy_name)) . '', $this->plugin_name),
            'separate_items_with_commas' => __('Separate items with commas', $this->plugin_name),
            'add_or_remove_items' => __('Add or remove items', $this->plugin_name),
            'choose_from_most_used' => __('Choose from the most used', $this->plugin_name),
            'popular_items' => __('Popular Categories', $this->plugin_name),
            'search_items' => __('Search Categories', $this->plugin_name),
            'not_found' => __('Not Found', $this->plugin_name),
            'no_terms' => __('No items', $this->plugin_name),
            'items_list' => __('Categories list', $this->plugin_name),
            'items_list_navigation' => __('Categories list navigation', $this->plugin_name),
        );
        $rewrite = array(
            'slug' => $taxonomy,
            'with_front' => true,
            'hierarchical' => true,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'rewrite' => $rewrite,
            'show_in_rest' => true,
        );
        register_taxonomy($taxonomy, $post_types, $args);
    }

    /**
     * adds the custom taxonomy to the wordpress dashboard
     *
     * @return void
     */
    public function init()
    {
        // insert the defaul tersm for notification types
        foreach ($this->taxonomies as $index => $taxonomy) {
            extract($taxonomy);
            $this->register($slug, $this->show_in_menu, $post_types, $name);
        }
    }

    /**
     * insert default terms for the custom taxonomies
     *
     * @return void
     */
    public function insert_default_tax_terms()
    {
        // insert the defaul tersm for notification types
        foreach ($this->taxonomies as $index => $taxonomy) {
            extract($taxonomy);
            foreach ($terms as $term) :
                $tax_id = wp_insert_term($term, $slug);
            endforeach;
        }
    }
}
