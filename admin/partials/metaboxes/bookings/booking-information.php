<?php
$attendees = get_post_meta($post->ID, 'attendee_details', true);
$attendees = json_decode($attendees);
ob_start();
require plugin_dir_path(__FILE__) . "person-form.php";
$template = ob_get_clean();
?>
<div id="repeater-wrapper">
    <div class="container">
        <div class="row">
            <div class="mr-auto col-auto">
                <a href="#" class="button button-default my-3" data-repeater data-template="<?php echo esc_attr($template); ?>">Add Attendee</a>
            </div>
        </div>
    </div>

    <div class="container" id="repeater-wrapper-inside">
        <?php
        if (is_array($attendees)) {
            foreach ($attendees as $index => $field) {
                require plugin_dir_path(__FILE__) . "person-form.php";
            }
        } else {
            require plugin_dir_path(__FILE__) . "person-form.php";
        }
        ?>
    </div>
</div>