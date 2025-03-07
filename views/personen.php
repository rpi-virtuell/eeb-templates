<?php

function display_person_view()
{
    $arbeitsbereiche = get_terms(['taxonomy' => 'arbeitsbereich', 'order' => 'DESC',]);
    $arbeitsbereich_whitelist = [
        'funktionen',
        'vertretung'
    ];
    ob_start()

    ?>

    <div class="eeb-person-view-container">

        <?php
        foreach ($arbeitsbereiche as $arbeitsbereich) {
            ?>
            <div class="eeb-term-container" id="<?php echo 'term-container-' . $arbeitsbereich->slug ?>">
                <h3><?php echo $arbeitsbereich->name ?></h3>

                <div class="eeb-person-archive">
                    <?php
                    $personen = get_posts([
                        'numberposts' => -1,
                        'post_type' => 'personen',
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'tax_query' => array(array(
                            'taxonomy' => 'arbeitsbereich',
                            'field' => 'slug',
                            'terms' => $arbeitsbereich->slug,
                        ))
                    ]);
                    foreach ($personen as $person) {
                        $show_funktion = in_array($arbeitsbereich->slug, $arbeitsbereich_whitelist);
                        PersonHelper::display_person_container($person,$show_funktion);
                    }
                    ?>
                </div>
                <?php
                if (!empty($arbeitsbereich->description)) {
                    ?>
                    <div class="eeb-term-description">
                        <span>
                            <?php
                            echo $arbeitsbereich->description;
                            ?>
                        </span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }

        ?>

    </div>
    <?php
    return ob_get_clean();

}


