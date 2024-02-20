<?php
ob_start();
?>
    <div data-prefix="organistaionen-archive">
        <div class="eeb-organisation-list">
            <?php

            $bereiche = get_terms(array('taxonomy' => 'zustaendigkeitsbereich','order'=>'DESC'));
            foreach ($bereiche

                     as $bereich) {
                ?>
                <div>
                    <h3><?php echo $bereich->name ?></h3>
                    <div class="eeb-bereich-list" id="eeb-bereich-<?php echo $bereich->slug ?> ">
                        <?php
                        while (have_posts()):
                            the_post();
                            $post_bereich = wp_get_post_terms(get_the_ID(), 'zustaendigkeitsbereich', ['fields' => 'names']);
                            if (in_array($bereich->name, $post_bereich)) {
                                ?>
                                <div class="eeb-organisation-single">
                                    <div class="eeb-organisation-image">
                                        <?php echo get_the_post_thumbnail(get_the_ID()) ?>
                                    </div>
                                    <div class="eeb-organisation-credentials">
                                        <b><?php the_title() ?></b>
                                        <br>
                                        <?php $organisation_website = get_post_meta(get_the_ID(), 'website', true) ?>
                                        <a href="<?php echo $organisation_website; ?>"  target="_blank" rel="noopener noreferrer"><?php echo $organisation_website ?></a>
                                    </div>
                                </div>
                                <?php

                            }
                        endwhile;
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
<?php
echo ob_get_clean();
?>