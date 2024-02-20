<?php

function display_ansprechpartner($person_ids = '')
{
    if (empty($person_ids)) {
        $persons = get_post_meta(get_the_ID(), 'person', true);
    } else {
        $persons = explode(',', reset($person_ids));
    }
    if (is_array($persons) && !empty(implode("", $persons))) {
        ob_start();

        ?>
        <div class="eeb-ansprechpartner">
            <h4>
                Ansprechpartner:innen
            </h4>
            <?php
            foreach ($persons as $person) {
                $person_post = get_post($person);
                PersonHelper::display_person_container($person_post);
            }
            ?>
        </div>
        <?php
        return ob_get_clean();

    } else {
        return '';
    }
}