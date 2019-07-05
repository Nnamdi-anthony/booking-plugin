<?php

/**
 * The Metaboxes for Email Notifications
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The Metaboxes for Email Notifications
 *
 * Defines the plugin name, version, and add various metaboxes for the email notifications to the customer
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Metaboxes_Email_Notifications
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
        $this->post_type = 'e-notify';
        $this->iteration_box = array(
            'register' => array(
                array(
                    'id' => 'contact-information',
                    'title' => 'Contact Information',
                    'callback' => array($this, 'contact_information_html'),
                    'context' => 'side',
                    'priority' => 'low',
                ),
                array(
                    'id' => 'notification-status',
                    'title' => 'Notification Status',
                    'callback' => array(
                        new Venues_Booking_Engine_Admin_Metaboxes_SMS_Notifications($this->plugin_name, $this->version),
                        'notification_status_html'
                    ),
                    'context' => 'side',
                    'priority' => 'high',
                ),
            ),
            'deregister' => array(
                array(
                    'id' => 'notify-statusdiv',
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
            add_meta_box($id, $title, $callback, $this->post_type, $context, $priority);
        endforeach;
    }

    /**
     * remove unwanted metaboxes from the post type
     *
     * @return void
     */
    public function deregister()
    {
        foreach ($this->iteration_box['deregister'] as $box) :
            extract($box);
            remove_meta_box($id, $this->post_type, $context);
        endforeach;

        return true;
    }

    /**
     * save the metaboxes fields
     *
     * @param int $post_id
     * @param object $post
     * @return void
     */
    public function save($post_id, $post)
    {
        if (!empty($_POST) && $_POST['post_type'] == $this->post_type) :
            $fields = array(
                'receiver_address' => '',
                'date_sent' => date('d-m-Y'),
                'time_sent' => date('h:i:sa'),
            );
            foreach ($fields as $field => $value) :
                if (!empty($_POST[$field]) && empty($value)) update_post_meta($post->ID, $field, $_POST[$field] ?? '');
                if (!empty($value)) update_post_meta($post->ID, $field, $value);
            endforeach;

            // set a default action
            wp_set_object_terms($post_id, 'not-initiated', 'notify-status');

            $mail_contents = wpautop($post->post_content);
            $title = $post->post_title;
            $receiver_mail = get_post_meta($post_id, 'receiver_address', true);

            // $status_mail = wp_mail($receiver_mail, $title, $mail_contents, $headers);
            $status_mail = Notification_Helper::send_email($receiver_mail, $title, $mail_contents);
            if ($status_mail) {
                wp_set_object_terms($post_id, 'sent-successfully', 'notify-status');
            } else {
                wp_set_object_terms($post_id, 'not-initiated', 'notify-status');
                if (!empty($_POST)) wp_set_object_terms($post_id, 'failed', 'notify-status');
            }
        endif;
    }

    /**
     * house the fields
     * 
     * @param object $post
     */
    public function contact_information_html($post)
    {
        require_once plugin_dir_path(__FILE__) . "partials/metaboxes/email-notifications/index.php";
    }
}
