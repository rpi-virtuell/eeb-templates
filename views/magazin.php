<?php

function alter_ausgabe_content($post_id, $post, $update)
{
    // Überprüfen, ob es sich um einen Auto-Save-Prozess handelt oder ob der Post-Typ nicht dem Ziel entspricht
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || $post->post_type !== 'ausgabe') {
        return;
    }

    // Berechtigungsprüfung
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    // Entfernen Sie die Action, um eine Endlosschleife zu verhindern
    remove_action('save_post', 'alter_ausgabe_content');

    $editorial = get_post_meta($post->ID, 'editorial', true);
    $kauf_link = get_post_meta($post->ID, 'kauf_link', true);

    ob_start();
    ?>
    <!-- wp:buttons -->
    <div class="wp-block-buttons"><!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo $kauf_link ?>"
                                        target="_blank" rel="noreferrer noopener">Ausgabe kaufen</a></div>
        <!-- /wp:button --></div>
    <!-- /wp:buttons -->

    <!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
        <div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:post-featured-image /--></div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"66.66%"} -->
        <div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:heading {"level":4} -->
            <h4 class="wp-block-heading">Editorial</h4>
            <!-- /wp:heading -->

            <!-- wp:paragraph -->
            <p><?php echo $editorial ?>></p>
            <!-- /wp:paragraph -->

        </div>
        <!-- /wp:column --></div>
    <!-- /wp:columns -->

    <!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
        <div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:heading -->
            <h2 class="wp-block-heading">Inhaltsverzeichnis</h2>
            <!-- /wp:heading -->

            <!-- wp:shortcode -->
            [eeb-inhaltsverzeichnis]
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            [eeb-freie-artikel-der-ausgabe]
            <!-- /wp:shortcode --></div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"33.33%"} -->
        <div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:shortcode -->
            [eeb-ansprechpartner-view]
            <!-- /wp:shortcode --></div>
        <!-- /wp:column --></div>
    <!-- /wp:columns -->
    <?php
    $new_content = ob_get_clean();
    // Aktualisieren des Beitrags
    wp_update_post(array(
        'ID' => $post_id,
        'post_content' => $new_content
    ));


    // Fügen Sie die Action wieder hinzu
    add_action('save_post', 'alter_ausgabe_content', 10, 3);
}

function display_magazin_iframe()
{
    if (get_post_type() === 'ausgabe') {
        $inhaltsverzeichnis_id = get_post_meta(get_the_ID(), 'inhaltsverzeichnis', true);
        $inhaltsverzeichnis_url = wp_get_attachment_url($inhaltsverzeichnis_id);
        if (!empty($inhaltsverzeichnis_url)) {
            ob_start();
            ?>
            <iframe src="<?php echo $inhaltsverzeichnis_url ?>" width="100%" height="500px"></iframe>

            <?php
            return ob_get_clean();
        }
    }
}

function display_current_publication()
{
    $current_magazine = get_posts(['numberposts' => 1, 'post_type' => 'ausgabe']);
    $current_magazine = reset($current_magazine);
    if (is_a($current_magazine, 'WP_Post')) {
        ob_start();
        ?>
        <h3>Blick in die aktuelle Ausgabe</h3>
        <div class="eeb-current-publication-view">
            <a href="<?php echo get_the_permalink($current_magazine->ID) ?>" class="eeb-publication-cover">
                <?php echo get_the_post_thumbnail($current_magazine->ID) ?>
            </a>
            <div class="eeb-free-article-container">
                <?php Magazin_Helper::display_free_article_carousel($current_magazine->ID); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();

    } else {
        return '';
    }
}

function display_free_articles_of_publication()
{
    if (get_post_type() === 'ausgabe') {
        ob_start();
        Magazin_Helper::display_free_article_carousel(get_the_ID(), false);
        return ob_get_clean();
    }
    return '';
}

function display_older_publications()
{
    $current_magazine = get_posts(['numberposts' => 1, 'post_type' => 'ausgabe']);
    $current_magazine = reset($current_magazine);

    $older_magazines = get_posts(
        [
            'numberposts' => -1,
            'post_type' => 'ausgabe',
            'exclude' => [$current_magazine->ID]
        ]);
    ob_start();
    Magazin_Helper::display_older_publications_carousel($older_magazines);
    return ob_get_clean();

}