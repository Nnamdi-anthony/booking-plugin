<?php
//Set up the taxonomy object and get terms
$taxonomy = 'notify-types';

//The name of the form
$name = 'tax_input[' . $taxonomy . '][0]';

//Get all the terms for this taxonomy
$terms     = get_terms($taxonomy, array('hide_empty' => 0));
$postterms = get_the_terms($post->ID, $taxonomy);
$current   = ($postterms ? array_pop($postterms) : false);
$current   = ($current ? $current->term_id : 0);

?>
<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy ?> categorychecklist form-no-clear">
    <?php foreach ($terms as $term) {
        $id = $taxonomy . '-' . $term->term_id;
        echo "<li id='$id'><label class='selectit'>";
        echo "<input type='radio' id='in-$id' name='{$name}'" . checked($current, $term->term_id, false) . "value='$term->term_id' required/>$term->name<br />";
        echo "</label></li>";
    }
    ?>
</ul>