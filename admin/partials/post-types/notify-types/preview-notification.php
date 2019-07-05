<?php
$linked_tax        = wp_get_post_terms($post->ID, 'notify-types');
$notification_type = !empty($linked_tax) ? $linked_tax[0]->slug : "default";
$content = get_the_content();
$find    = array("{{fullname}}", "{{email}}", "{{phone_number}}", "{{ticket_id}}", "{{ticket_name}}");
$replace = array(
    "John Smith",
    "abc@example.com",
    "08091234567",
    "COM-221-21234",
    "TRAVEL TO LAND OF CODITES, Englinde"
);
$content = str_replace($find, $replace, $content);
if ($notification_type == 'email') {
    $content = wpautop($content);
}

echo $content;
