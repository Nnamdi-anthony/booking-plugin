<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin
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
	 * The screen of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $screen    The current screen of this plugin.
	 */
	private $screen;

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
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Venues_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Venues_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$this->screen = get_current_screen();

		wp_enqueue_style($this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css', array(), $this->version, 'all');
		if ($this->screen->id === 'edit-notify-templates') :
			wp_enqueue_style($this->plugin_name . '-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', array(), $this->version, 'all');
		endif;
		wp_enqueue_style($this->plugin_name . '-bootstrap-grid', 'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap-grid.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/venues-booking-engine-admin.css', array($this->plugin_name . '-bootstrap-grid'), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Venues_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Venues_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$this->screen = get_current_screen();
		wp_enqueue_script($this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js', array('jquery'), $this->version, false);
		if ($this->screen->id === 'edit-notify-templates') :
			wp_enqueue_script($this->plugin_name . '-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', array('jquery'), $this->version, false);
		endif;
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/venues-booking-engine-admin.js', array('jquery'), $this->version, false);
	}
}
