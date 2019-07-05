<?php

if (!current_user_can('manage_options')) {
    return;
}
?>

<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
    </h1>
    <?php
    if (isset($_GET['settings-updated'])) {
        add_settings_error('ebe_messages', 'ebe_message', __('Settings Saved', 'venues-booking-engine'), 'updated');
    }
    settings_errors('ebe_messages');

    $nav_args = array(
        'general' => 'General',
        'payment_gateways' => 'Payment Gateways',
        'notifications' => 'Notifications',
        'advanced' => 'Advanced',
    );
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    ?>
    <h2 class="nav-tab-wrapper">
        <?php foreach ($nav_args as $key => $title) { ?>
            <a href="?page=manage-settings&tab=<?php echo $key; ?>" class="nav-tab <?php echo $active_tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo $title; ?></a>
        <?php
        } ?>
    </h2>

    <form action="options.php" method="post">
        <?php
        foreach ($nav_args as $key => $title) {
            if ($active_tab == $key) {
                settings_fields('venues_booking_engine_' . $key);
                do_settings_sections('venues_booking_engine_' . $key);
            }
        }
        submit_button('Save Settings'); ?>
    </form>
</div>