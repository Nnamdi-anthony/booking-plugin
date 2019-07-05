<?php

/**
 * The form fields for the settings api for the plugin
 *
 * @link       https://github.com/nnamdi-anthony
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 */

/**
 * The form fields for the settings api for the plugin
 *
 * Defines the plugin settings common settings
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/admin
 * @author     Emeodi Anthony <emeodin@gmail.com>
 */
class Venues_Booking_Engine_Admin_Settings
{
    /**
     * Register the Metabox
     *
     * @since    1.0.0
     */
    public function register()
    {
        // register setting field
        register_setting($this->plugin_name . $this->base_name, $this->plugin_name . $this->base_name, [
            'show_in_rest' => true,
        ]);

        // loop to register the section
        foreach ($this->sections as $i => $section) :
            extract($section);

            // register section
            add_settings_section(
                $this->plugin_name . $this->base_name . '_' . strtolower(str_replace(array(" ", "-"), "_", $title)) . '_section',
                __($title, $this->plugin_name),
                function () use ($message) {
                    $html = "<h4>" . $message . " </h4>";
                    echo $html;
                },
                $this->plugin_name . $this->base_name
            );
        endforeach;

        // loop to register field
        foreach ($this->fields as $i => $field) :
            extract($field);

            // register field
            add_settings_field(
                $id,
                __(array_key_exists('title', $field) ? $title : ucwords(str_replace(array("-", "_"), ' ', $id)), $this->plugin_name), // use the id instead of the name if the name key doesnt exist
                is_array($callback) ? $callback : array($this, $callback),
                $this->plugin_name . $this->base_name,
                array_key_exists('section', $field) ? $this->plugin_name . $this->base_name . '_' . strtolower(str_replace(array(" ", "-"), "_", $field['section'])) . '_section' : '',
                [
                    'label_for' => $id,
                    'class' => !array_key_exists('class', $field) ? $id . "_class" : $class,
                ]
            );
        endforeach;
    }

    /**
     * settings field to store the anvo
     *
     * @param array $args
     * @return string|html
     */
    public function choose_page_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $options_array = array(
            'post_type' => 'page',
            'posts_per_page' => -1,
        );
        $options_array = new WP_Query($options_array);
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = "<select class='cc_select2_args' id='" . esc_attr($args['label_for']) . "' name='{$this->plugin_name}{$this->base_name}[" . esc_attr($args['label_for']) . "]'>";
        $html .= "<option> None </option>";
        if ($options_array->have_posts()) {
            while ($options_array->have_posts()) {
                $options_array->the_post();
                $html .= "<option " . selected($option, get_the_ID(), false) . " value='" . get_the_ID() . "'>" . ucwords(get_the_title()) . " </option>";
            }
        }
        $html .= "</select>";
        echo $html;
    }

    /**
     * common text field setting
     *
     * @param array $args
     * @return string|html
     */
    public function text_field_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = '<input autocomplete="off" name="' . $this->plugin_name . $this->base_name . '[' . esc_attr($args['label_for']) . ']" type="text" id="' . esc_attr($args['label_for']) . '" value="' . $option . '" class="regular-text">';
        echo $html;
    }

    /**
     * settings field to store the anvo
     *
     * @param array $args
     * @return string|html
     */
    public function app_enviroment_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $options_array = array(
            'production' => 'Live Environment',
            'development' => 'Test Environment',
        );
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = "<select id='" . esc_attr($args['label_for']) . "' name='{$this->plugin_name}{$this->base_name}[" . esc_attr($args['label_for']) . "]'>";
        $html .= "<option> None </option>";
        foreach ($options_array as $key => $val) {
            $html .= "<option " . selected($option, $key, false) . " value='" . $key . "'>" . ucwords($val) . " </option>";
        }
        $html .= "</select>";
        echo $html;
    }

    /**
     * settings field to store the yes or no
     *
     * @param array $args
     * @return string|html
     */
    public function yes_no_cb($args)
    {
        $options = get_option($this->plugin_name . $this->base_name);
        $options_array = array(
            'yes' => 'Yes',
            'no' => 'No',
        );
        $option = isset($options[$args['label_for']]) ? $options[$args['label_for']] : "";
        $html = "<select id='" . esc_attr($args['label_for']) . "' name='{$this->plugin_name}{$this->base_name}[" . esc_attr($args['label_for']) . "]'>";
        $html .= "<option> None </option>";
        foreach ($options_array as $key => $val) {
            $html .= "<option " . selected($option, $key, false) . " value='" . $key . "'>" . ucwords($val) . " </option>";
        }
        $html .= "</select>";
        echo $html;
    }
}
