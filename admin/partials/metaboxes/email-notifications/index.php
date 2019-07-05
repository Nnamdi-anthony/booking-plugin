
<?php
$fields = array(
    array(
        'name' => 'receiver_address',
        'title' => 'Email Address',
    ),
    array(
        'name' => 'date_sent',
        'title' => 'Date Sent',
    ),
    array(
        'name' => 'time_sent',
        'title' => 'Time Sent',
    ),
);
if (!empty($fields)) :
    foreach ($fields as $key => $field) :
        extract($field);
        echo "<p> 
                <label for='{$name}'>{$title}</label>
                <br>
                <input type='text' name='{$name}' id='{$name}' class='widefat' value='" . get_post_meta($post->ID, $name, true) . "'>
            </p>";
    endforeach;
endif;
?>