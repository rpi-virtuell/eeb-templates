<?php

class PersonHelperClass
{

    static function display_person_container(WP_Post $person, $show_funktion = false)
    {
        ?>
        <div class="eeb-single-person">
            <div class="eeb-single-person-image">
                <?php
                echo get_the_post_thumbnail($person->ID)
                ?>
            </div>
            <div class="eeb-single-person-credentials">
                <?php
                $person_vertretung = get_post_meta($person->ID, 'vertretungsfunktion', true);
                if (!empty($person_vertretung) && $show_funktion) {
                    ?><b> <?php echo $person_vertretung ?></b><?php
                    ?>
                    <br>
                    <?php
                }
                ?>
                <strong><?php echo $person->post_title; ?></strong><br>
                <?php
                if ($person_funktion = get_post_meta($person->ID, 'funktion', true)) {
                    echo $person_funktion;
                    ?>
                    <br>
                    <?php
                }
                if ($person_organisation = get_post_meta($person->ID, 'organisation', true)) {
                    echo $person_organisation;
                    ?><br>

                    <?php
                }

                if ($person_email = get_post_meta($person->ID, 'email', true)) {
                    ?>
                    <a
                    href="mailto:<?php echo $person_email ?>"><?php echo $person_email; ?></a><?php

                    ?><br>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }


}