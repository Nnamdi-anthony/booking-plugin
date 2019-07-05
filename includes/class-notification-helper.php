<?php

/**
 * The file that defines the notifications helpers
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area for sending notifications using sms or email
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 */

/**
 * the notifications helpers.
 *
 * This is used to define methods for sending notifications using sms or email
 *
 * @since      1.0.0
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/includes
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Notification_Helper
{
    public static function send_email($to, $subject, $message, $attachments = array())
    {
        $sender_display_name = !empty(get_option('venues_booking_engine_advanced')['email_sender_display_name']) ? get_option('venues_booking_engine_advanced')['email_sender_display_name'] : 'gidievents';
        $sender_mail = !empty(get_option('venues_booking_engine_advanced')['email_sender_email']) ? get_option('venues_booking_engine_advanced')['email_sender_email'] : 'info@gidievents.com';
        // headers
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = "From: {$sender_display_name}<{$sender_mail}>";
        $headers[] = "Return-Path: {$sender_mail}";
        $headers[] = "MIME-Version: 1.0";

        $mail_contents = wpautop($message);
        $title = $subject;
        $receiver_mail = $to;

        $status_mail = wp_mail($receiver_mail, $title, $mail_contents, $headers, $attachments);
        if ($status_mail) {
            return true;
        }

        return false;
    }

    /**
     * used to send sms to users
     */
    public static function send_sms($to, $message)
    {
        $api_token = !empty(get_option('venues_booking_engine_advanced')['sms_gateway_api_key']) ? get_option('venues_booking_engine_advanced')['sms_gateway_api_key'] : "9MEYPz9RvGpepOuZKwWHem2Foj6qZvjNInUJ30jPPgqlGVmjbGVeeB4fCOR9";
        $from = !empty(get_option('venues_booking_engine_advanced')['sms_gateway_sender_name']) ? get_option('venues_booking_engine_advanced')['sms_gateway_sender_name'] : 'gidievents';
        $message = rawurlencode($message);
        $endpoint = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=$api_token&from=$from&to=$to&body=$message";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $res = json_decode($response);
        curl_close($curl);

        if ($err) {
            return $err;
        }

        return $res;
    }

    /**
     * get the notificatino template using the id and the template type
     *
     * @param int|string $template_id - the id or slug for the notification template
     * @param string $type - the type of template to return | sms | email
     * @return string|array
     */
    public static function get_notification_template($template_id, $type = "")
    { }

    /**
     * save the notification
     *
     * @param string|int $to - the reciever email or phone number
     * @param string $message - the message to the reciever
     * @param string $status - the status of the notification
     * @param string $type - the type of notification
     * @param string $subject - the subject of the notification
     * @return bool
     */
    public static function save_notification($to, $message, $status, $type = "email", $subject = "")
    { }

    /**
     * get all the notification templates
     *
     * @param string $type - the type of template you want to filter | sms | email
     * @return array
     */
    public static function get_notification_templates($type = "")
    { }

    /**
     * parse the notification template
     *
     * @param string|int $message
     * @param array $replaced_with
     * @return string
     */
    public static function parse_notification_template($message, $replaced_with = array())
    { }
}
