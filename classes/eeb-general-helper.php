<?php

class Eeb_General_Helper
{
    static $post_fix_post_type_whitelist = [
        'news',
        'events'
    ];

    static function display_logo_postfix()
    {
        if (in_array(get_post_type(), Eeb_General_Helper::$post_fix_post_type_whitelist)) {
            ob_start();
            ?>
            <div class="eeb-logo-postfix"
                 style='background-image: url("<?php echo EEB_TEMPLATE_PLUGIN_URL . '/assets/svg/logo-postfix.svg' ?>")'></div>
            <?php
            echo ob_get_clean();
        }
    }

    static function display_magazin_button()
    {
        $current_magazine = get_post(395);
        if (is_a($current_magazine, 'WP_Post')) {
            ob_start();
            ?>
            <a href="<?php echo get_post_permalink($current_magazine->ID) ?>"
               class="eeb-magazin-button button <?php echo get_the_ID() === $current_magazine->ID ? 'button-active' : '' ?>">
                forum erwachsenenbildung
            </a>
            <?php
            echo ob_get_clean();
        }
    }


    static function forward_to_zoom_link()
    {
        $zoom_link = get_field('eeb_zoom_link', 'option');
        if (!empty($zoom_link)) {

            wp_redirect($zoom_link);
            exit;

        } else {
            return '';
        }
    }

    static function display_thumbnail_fallback()
    {

        //TODO This probably can be refactored with the carousel logic
        $thumbnail = get_the_post_thumbnail();
        if (empty($thumbnail)) {
            $color_pallet = [
                ['background' => '#5e7fa7', 'font' => '#fff'],
//                ['background' => '#84b0da', 'font' => '#00365f'],
//                ['background' => '#ced1dd', 'font' => '#00365f'],
                ['background' => '#704e8d', 'font' => '#fff'],
                ['background' => '#707400', 'font' => '#fff'],
                ['background' => '#f4e72f', 'font' => '#00365f'],
            ];
            $color = rand(0, count($color_pallet)-1);
            $link = get_the_permalink(get_the_ID());
            $fill_text = get_post_meta(get_the_ID(), 'bild_text', true);
            ob_start();
            ?>
            <a href="<?php echo $link ?>">
                <div class="eeb-default-thumbnail"
                     style="background-color: <?php echo $color_pallet[$color]['background'] ?>; color: <?php echo $color_pallet[$color]['font'] ?>">
                    <span><?php echo $fill_text ?></span>
                </div>
            </a>
            <?php
            return ob_get_clean();
        }
        return '';
    }


}