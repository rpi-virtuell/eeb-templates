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
            <a href="<?php  echo get_post_permalink($current_magazine->ID)?>" class="eeb-magazin-button button <?php echo get_the_ID() === $current_magazine->ID ? 'button-active' : '' ?>">
                MAGAZIN
            </a>
            <?php
            echo ob_get_clean();
        }
    }



}