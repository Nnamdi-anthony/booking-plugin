<?php

/**
 * Used to register post types to the wordpress dashboard
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * Used to register post types to the wordpress dashboard
 *
 * Defines the plugin name, version, and add new post types to the dashboard
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Post_Types
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
     * The list of post types to be registered
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $post_types    The list of post types to be registered
     */
    private $post_types;

    /**
     * used to determine if the post types will display or not
     *
     * @var bool
     * @access private
     */
    private $show_types_menu;

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
        $this->show_types_menu = false;
        $this->post_types = array(
            array(
                'slug' => 'bookings',
                'supports' => array('title'),
                'taxonomies' => array('booking-types', 'booking-status', 'booking-actions', 'payment-types'),
                'name' => 'Venues Booking',
                'title_screen' => 'Booking Code',
                'remove_buttons' => array(
                    'view', 'inline hide-if-no-js'
                ),
            ),
            array(
                'slug' => 'e-notify',
                'supports' => array('title', 'editor'),
                'taxonomies' => array('notify-status'),
                'name' => 'Email Notification',
                'title_screen' => 'Subject',
                'remove_buttons' => array(
                    'view', 'inline hide-if-no-js'
                ),
            ),
            array(
                'slug' => 's-notify',
                'supports' => array('title', 'editor'),
                'taxonomies' => array('notify-status'),
                'name' => 'SMS Notification',
                'title_screen' => 'Subject',
                'remove_buttons' => array(
                    'view', 'inline hide-if-no-js'
                ),
            ),
            array(
                'slug' => 'notify-templates',
                'supports' => array('title', 'editor'),
                'taxonomies' => array('notify-types'),
                'name' => 'Notification Templates',
                'title_screen' => 'Template Name',
                'remove_buttons' => array(
                    'view', 'inline hide-if-no-js'
                ),
            ),
        );
    }

    /**
     * Register a Post Type
     *
     * @param mixed|string $post_type the post type to register
     * @param bool $show_in_menu should the post type display in the admin menu
     * @param array $supports the default metaboxes to show
     * @param array $taxonomies the taxonomies to tie this post type to
     * @param string $post_type_name the name of the post type
     * @param string $description the description for the post type
     * @since    1.0.0
     */
    private function register($post_type, $show_in_menu = true, $supports = array('title', 'editor', 'thumbnail', 'revisions'), $taxonomies = array(), $post_type_name = "", $description = "")
    {
        $post_type_name = $post_type_name ?? str_replace("-", "_", $post_type);
        $post_type_name = is_string($taxonomies) ? $taxonomies : $post_type_name;
        $rewrite_slug = $post_type;

        $labels = array(
            'name' => _x(ucwords(str_replace("_", " ", $post_type_name)), ucwords(str_replace("_", " ", $post_type_name)), $this->plugin_name),
            'singular_name' => _x(ucwords(str_replace("_", " ", $post_type_name)), ucwords(str_replace("_", " ", $post_type_name)), $this->plugin_name),
            'menu_name' => __(ucwords(str_replace("_", " ", $post_type_name)), $this->plugin_name),
            'name_admin_bar' => __(ucwords(str_replace("_", " ", $post_type_name)), $this->plugin_name),
            'archives' => __('' . ucwords(str_replace("_", " ", $post_type_name)) . ' Archives', $this->plugin_name),
            'attributes' => __('' . ucwords(str_replace("_", " ", $post_type_name)) . ' Attributes', $this->plugin_name),
            'parent_item_colon' => __('Parent ' . ucwords(str_replace("_", " ", $post_type_name)) . ':', $this->plugin_name),
            'all_items' => __('All ' . ucwords(str_replace("_", " ", $post_type_name)) . 's', $this->plugin_name),
            'add_new_item' => __('Add New ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'add_new' => __('Add New', $this->plugin_name),
            'new_item' => __('New ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'edit_item' => __('Edit ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'update_item' => __('Update ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'view_item' => __('View ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'view_items' => __('View ' . ucwords(str_replace("_", " ", $post_type_name)) . 's', $this->plugin_name),
            'search_items' => __('Search ' . ucwords(str_replace("_", " ", $post_type_name)) . '', $this->plugin_name),
            'not_found' => __('Not found', $this->plugin_name),
            'not_found_in_trash' => __('Not found in Trash', $this->plugin_name),
            'featured_image' => __('Featured Image', $this->plugin_name),
            'set_featured_image' => __('Set featured image', $this->plugin_name),
            'remove_featured_image' => __('Remove featured image', $this->plugin_name),
            'use_featured_image' => __('Use as featured image', $this->plugin_name),
            'insert_into_item' => __('Insert into item', $this->plugin_name),
            'uploaded_to_this_item' => __('Uploaded to this item', $this->plugin_name),
            'items_list' => __('' . ucwords(str_replace("_", " ", $post_type_name)) . 's list', $this->plugin_name),
            'items_list_navigation' => __('' . ucwords(str_replace("_", " ", $post_type_name)) . 's list navigation', $this->plugin_name),
            'filter_items_list' => __('Filter items list', $this->plugin_name),
        );
        $rewrite = array(
            'slug' => $rewrite_slug,
            'with_front' => true,
            'pages' => true,
            'feeds' => true,
        );
        $args = array(
            'label' => __(ucwords($post_type), $this->plugin_name),
            'description' => __($description, $this->plugin_name),
            'labels' => $labels,
            'supports' => $supports,
            'taxonomies' => is_string($taxonomies) ? array() : $taxonomies,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => $show_in_menu,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => $show_in_menu,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => $show_in_menu,
            'publicly_queryable' => true,
            'rewrite' => $rewrite,
            'capability_type' => 'page',
            'show_in_rest' => true,
        );
        register_post_type($post_type, $args);
    }

    /**
     * adds the post types to the wordpress menu
     *
     * @return void
     * @since 1.0.0
     */
    public function init()
    {
        foreach ($this->post_types as $key => $value) :
            extract($value);
            $this->register($slug, $this->show_types_menu, $supports, $taxonomies, $name);
        endforeach;
    }

    /**
     * change the title of the current post type
     *
     * @param mixed $title
     * @return void
     */
    public function change_enter_title_here($title)
    {
        $screen = get_current_screen();

        foreach ($this->post_types as $key => $value) :
            extract($value);
            if ($slug == $screen->post_type) {
                $title = $title_screen ?? $name;
            }
        endforeach;

        return $title;
    }

    /**
     * remove the preview and quick edit from notify type post type in list view
     *
     * @param mixed $actions
     * @param mixed $post
     * @return void
     */
    public function remove_quick_edit_notify_types($actions, $post)
    {
        // output buffer the template we need to use
        ob_start();
        require plugin_dir_path(__FILE__) . "partials/post-types/notify-types/preview-notification.php";
        $template = ob_get_clean();

        foreach ($this->post_types as $i => $types) :

            // add a dying minute array to the notify types array
            if ($post->post_type == 'notify-templates') {
                $types['add_buttons'] = array(
                    'show_preview' => sprintf(
                        '<a href="#ext-%3$s" rel="modal:open">%1$s</a>
                        <div id="ext-%3$s" class="modal">
                        %2$s
                        </div>',
                        'Preview',
                        $template,
                        $post->ID
                    ),
                );
            }

            // extract the array keys to variables
            extract($types);

            // Check for your post type.
            if ($post->post_type == $slug) {

                // remove the buttons
                foreach ($remove_buttons as $button) :
                    unset($actions[$button]);
                endforeach;

                // add new buttons
                if (array_key_exists('add_buttons', $types)) :
                    $actions = array_merge(
                        $actions,
                        $add_buttons
                    );
                endif;
            }
        endforeach;

        return $actions;
    }

    /**
     * remove the edit part of menu notify-types from bulk actions dropdown
     *
     * @param mixed $actions
     * @return array
     */
    public function remove_subactions_notification_temp_post_type($actions)
    {
        unset($actions['edit']);
        return $actions;
    }
}
