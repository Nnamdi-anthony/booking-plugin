<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine
{

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Venues_Booking_Engine_Loader $loader Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $plugin_name The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $version The current version of the plugin.
   */
  protected $version;

  /**
   * The ebe_post_menus of this plugin.
   *
   * @since    1.0.0
   * @access   public
   * @var      string $ebe_post_menus The ebe_post_menus of this plugin.
   */
  public $ebe_post_menus;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct()
  {
    if (defined('VENUES_BOOKING_ENGINE_VERSION')) {
      $this->version = VENUES_BOOKING_ENGINE_VERSION;
    } else {
      $this->version = '1.0.0';
    }
    $this->plugin_name = 'venues-booking-engine';
    $this->ebe_post_menus = array(
      array(
        'name' => 'Bookings & Tickets',
        'post_type' => 'bookings'
      ),
      array(
        'name' => 'Email Notifications',
        'post_type' => 'e-notify'
      ),
      array(
        'name' => 'SMS Notifications',
        'post_type' => 's-notify'
      ),
      array(
        'name' => 'Notifications Templates',
        'post_type' => 'notify-templates'
      ),
    );

    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Venues_Booking_Engine_Loader. Orchestrates the hooks of the plugin.
   * - Venues_Booking_Engine_i18n. Defines internationalization functionality.
   * - Venues_Booking_Engine_Admin. Defines all hooks for the admin area.
   * - Venues_Booking_Engine_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies()
  {
    // ref the loader
    $this->loader = new Venues_Booking_Engine_Loader();
  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the Venues_Booking_Engine_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale()
  {

    $plugin_i18n = new Venues_Booking_Engine_i18n();

    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks()
  {

    $plugin_admin = new Venues_Booking_Engine_Admin($this->get_plugin_name(), $this->get_version());
    $post_types = new Venues_Booking_Engine_Admin_Post_Types($this->get_plugin_name(), $this->get_version());
    $menu = new Venues_Booking_Engine_Admin_Menus($this->get_plugin_name(), $this->get_version());
    $taxonomies = new Venues_Booking_Engine_Admin_Taxonomies($this->get_plugin_name(), $this->get_version());
    $settings_general = new Venues_Booking_Engine_Admin_Settings_General($this->get_plugin_name(), $this->get_version());
    $settings_advanced = new Venues_Booking_Engine_Admin_Settings_Advanced($this->get_plugin_name(), $this->get_version());
    $settings_notifications = new Venues_Booking_Engine_Admin_Settings_Notifications($this->get_plugin_name(), $this->get_version());
    $settings_payments = new Venues_Booking_Engine_Admin_Settings_Payment_Gateways($this->get_plugin_name(), $this->get_version());
    $metaboxes = array(
      new Venues_Booking_Engine_Admin_Metaboxes_Bookings($this->get_plugin_name(), $this->get_version()),
      new Venues_Booking_Engine_Admin_Metaboxes_Notifications_Templates($this->get_plugin_name(), $this->get_version()),
      new Venues_Booking_Engine_Admin_Metaboxes_Email_Notifications($this->get_plugin_name(), $this->get_version()),
      new Venues_Booking_Engine_Admin_Metaboxes_SMS_Notifications($this->get_plugin_name(), $this->get_version()),
    );

    // enqueue admin sdripts and styles
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles'); // enqueue css files for the lugin
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts'); // enqueue javascript files for the plugin

    // post types and taxonomies
    $this->loader->add_action('init', $post_types, 'init'); // register the post types for the plugin
    $this->loader->add_action('init', $taxonomies, 'init'); // register the taxonomies for the plugin
    $this->loader->add_action('init', $taxonomies, 'insert_default_tax_terms'); // insert default tax terms for the plugin
    $this->loader->add_filter('enter_title_here', $post_types, 'change_enter_title_here'); // customize the title text
    $this->loader->add_filter('post_row_actions', $post_types, 'remove_quick_edit_notify_types', 10, 2); // customize the quick edit actions
    if (is_array($this->ebe_post_menus)) :
      foreach ($this->ebe_post_menus as $in => $post_ty) :
        extract($post_ty);
        $this->loader->add_filter('bulk_actions-edit-' . $post_ty['post_type'], $post_types, 'remove_subactions_notification_temp_post_type'); // remove certain buttons on list view
      endforeach;
    endif;

    // custom admin menus
    $this->loader->add_action('admin_menu', $menu, 'register');
    $this->loader->add_action('admin_menu', $menu, 'deregister');
    $this->loader->add_action('admin_head', $menu, 'set_menu_state');
    $this->loader->add_filter("plugin_action_links", $menu, 'register_plugin_menus', 10, 5);

    //metaboxes registrations
    foreach ($metaboxes as $class) :
      $this->loader->add_action('admin_head', $class, 'deregister');
      $this->loader->add_action('add_meta_boxes', $class, 'register');
      $this->loader->add_action('save_post', $class, 'save', 10, 2);
    endforeach;

    // settings
    $this->loader->add_action('admin_init', $settings_general, 'register');
    $this->loader->add_action('admin_init', $settings_advanced, 'register');
    $this->loader->add_action('admin_init', $settings_notifications, 'register');
    $this->loader->add_action('admin_init', $settings_payments, 'register');
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks()
  {

    $plugin_public = new Venues_Booking_Engine_Public($this->get_plugin_name(), $this->get_version());

    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    // adding of shortcodes to the application
    add_shortcode('init_book_now_cart', array($plugin_public, 'init_book_now_cart'));
    add_shortcode('init_book_now_checkout', array($plugin_public, 'init_book_now_checkout'));
    add_shortcode('init_book_now_ticket', array($plugin_public, 'init_book_now_ticket'));
    add_shortcode('init_book_now_payment', array($plugin_public, 'init_book_now_payment'));
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run()
  {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @return    string    The name of the plugin.
   * @since     1.0.0
   */
  public function get_plugin_name()
  {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @return    Venues_Booking_Engine_Loader    Orchestrates the hooks of the plugin.
   * @since     1.0.0
   */
  public function get_loader()
  {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @return    string    The version number of the plugin.
   * @since     1.0.0
   */
  public function get_version()
  {
    return $this->version;
  }
}
