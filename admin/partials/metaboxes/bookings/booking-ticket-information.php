<div class="container">
    <div class="row">
        <div class="col-auto">

            <h3 class="price-stated my-3">
                Ticket Price: 0
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            $name = "number_of_ticket";
            $title = "Number of Ticket";
            echo "<p> 
                <label for='{$name}'>{$title}:</label>
                <input type='text' name='{$name}' id='{$name}' class='widefat' value='" . get_post_meta($post->ID, $name, true) . "'>
            </p>"; ?>
        </div>
        <div class="col">
            <?php
            $post_type = get_option('venues_booking_engine_general')['default_post_type'] ?? "product";
            $name = "select_product";
            $title = "Select Resource";
            $qargs = array(
                "post_type" => $post_type,
                'posts_per_page' => -1,
            );
            $query = new WP_Query($qargs);
            $option = get_post_meta($post->ID, $name, true);

            // html proper
            $html = "<p> <label for='{$name}'>{$title}:</label>";
            $html .= "<select class='cc_select2_args' id='" . esc_attr($name) . "' name='{$name}' class='widefat'>";
            $html .= "<option> None </option>";
            while ($query->have_posts()) {
                $query->the_post();
                $html .= "<option " . selected($option, get_the_ID(), false) . " value='" . get_the_ID() . "'>" . ucwords(get_the_title()) . " </option>";
            }
            $html .= "</select></p>";
            echo $html;
            ?>
        </div>
    </div>
</div>