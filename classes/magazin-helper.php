<?php

class Magazin_Helper
{


    static function display_free_article_carousel($ausgabe_id, $display_carousel = true)
    {

        $args = [
            'post_type' => 'freiartikel',
            'meta_query' => array(
                array(
                    'key' => 'aus_ausgabe',
                    'value' => $ausgabe_id,
                )
            )
        ];
        $articles = get_posts($args);
        if (is_array($articles)) {
            $color_pallet = [
                ['background' => '#5e7fa7', 'font' => '#fff'],
                ['background' => '#84b0da', 'font' => '#00365f'],
                ['background' => '#ced1dd', 'font' => '#00365f'],
                ['background' => '#704e8d', 'font' => '#fff'],
                ['background' => '#707400', 'font' => '#fff'],
                ['background' => '#f4e72f', 'font' => '#00365f'],
            ];

            if ($display_carousel) {
                ?>

                <div>
                    <div class="carousel">
                        <ul class="slides">
                            <?php
                            $i = 0;
                            foreach ($articles as $article) {
                                $i++;
                                ?>
                                <input type="radio" name="radio-buttons"
                                       id="img-<?php echo $i ?>" <?php echo $i == 1 ? 'checked' : '' ?> />
                                <li class="slide-container">
                                    <?php
                                    $link = get_post_meta($article->ID, 'waxmann_link', true);
                                    ?>
                                    <a href="<?php echo $link ?>"target="_blank" rel="noopener noreferrer" class="slide-image">
                                        <?php $color = rand(0, 5) ?>
                                        <div class="carousel-content-container"
                                             style="background-color: <?php echo $color_pallet[$color]['background'] ?>; color: <?php echo $color_pallet[$color]['font'] ?>">
                                            <span><?php echo get_post_meta($article->ID, 'author', true) ?></span><br>
                                            <span><?php echo $article->post_title ?></span>
                                        </div>
                                    </a>
                                    <div class="carousel-controls">
                                        <label for="img-<?php echo $i == 1 ? sizeof($articles) : $i - 1 ?>"
                                               class="prev-slide">
                                            <span>&lsaquo; ZURÜCK <?php ?></span>
                                        </label>
                                        <label for="img-<?php echo $i == sizeof($articles) ? 1 : $i + 1 ?>"
                                               class="next-slide">
                                            <span>VOR &rsaquo;</span>
                                        </label>
                                    </div>
                                </li>

                                <?php
                            }
                            ?>
                            <div class="carousel-dots">

                                <?php
                                $i = 0;
                                foreach ($articles as $article) {
                                    $i++;
                                    ?>
                                    <label for="img-<?php echo $i ?>" class="carousel-dot"
                                           id="img-dot-<?php echo $i ?>"></label>

                                    <?php
                                }
                                ?>
                            </div>
                        </ul>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <div class="eeb-article-grid">
                    <?php
                    foreach ($articles as $article) {
                        if (is_a($article, 'WP_Post')) {
                            $link = get_post_meta($article->ID, 'waxmann_link', true);
                            ?>
                            <div class="eeb-single-article">
                                <?php $color = rand(0, 5) ?>
                                <?php
                                $author = get_post_meta($article->ID, 'author', true);

                                    ?>

                                    <a href="<?php echo $link ?>"><h5
                                                class="eeb-article-headline"><?php echo $author ?></h5></a>
                                    <a href="<?php echo $link ?>">
                                        <div class="eeb-article-default-thumbnail"
                                             style="background-color: <?php echo $color_pallet[$color]['background'] ?>; color: <?php echo $color_pallet[$color]['font'] ?>">
                                            <span><?php echo $article->post_title ?></span>
                                        </div>
                                    </a>

                                    <?php
                                if (!empty($article->post_excerpt)) {
                                    ?>
                                    <div class="eeb-article-excerpt"><?php echo substr($article->post_excerpt, 0 , 200) . ' (...)' ?></div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }
        }

    }


}