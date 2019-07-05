<?php
$fields = array(
    'first_name',
    'last_name',
    'email_address',
    'confirm_email',
    'telephone_number',
    'alt_telephone_number'
);
?>

<div class="row repeater-wrapper" style="border-top:1px solid #ccc;padding-top: 20px;margin-top:10px;padding-bottom:10px;">
    <div class="col-12">
        <div class="row">
            <div class="col">
                <h1># Attendee</h1>
            </div>
            <div class="col-auto mr-auto">
                <a href="#" class="button button-default" data-repeater-delete>Delete Attendee</a>
            </div>
        </div>
    </div>
    <?php
    if (!empty($fields)) :
        foreach ($fields as $field) :
            $option = !empty($attendees) ? $attendees[$index]->$field : '';
            echo "<div class='col-6'>
                <div class='repeated-field'>
                    <p> 
                            <label for='{$field}'>" . ucwords(str_replace('_', ' ', $field)) . "</label>
                            <br>
                            <input type='text' name='{$field}[]' id='{$field}' class='widefat' value='" . $option . "'>
                        </p>
                </div>
            </div>";
        endforeach;
    endif;
    ?>
    <hr>
</div>