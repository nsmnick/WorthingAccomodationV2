<?php
include __DIR__ . '/../_block-generics.php';


if (!$is_preview && !$generic_block_settings['hide_panel']) {

    $meta_heading = get_field('meta_heading');
    $heading = get_field('heading');
    $description = get_field('description');
    $faq_items = get_field(
        'faq_items'
    );
    $faq_html = '';

?>

    <section class="panel content content__faq-panel  <?php echo $generic_block_settings_classes; ?>">


        <div class="container">


            <h2 class="icon-underline"><?php echo $heading; ?></h2>


            <?php

            $accordion_items_html = '';
            foreach ($faq_items as $accordion_item) {
                $accordion_items_html .= "
                    <details>
                        <summary class=\"accordion-title\">
                            <div class=\"accordion-title__col1\">
                                <h3>{$accordion_item['faq_title']}</h3>
                            </div>
                            <div class=\"accordion-title__col2\">
                                <div class=\"accordion-icon\">
                                    <div class=\"accordion-icon__left\"></div>
                                    <div class=\"accordion-icon__right\"></div>
                                </div>
                            </div>
                        </summary>
                        <div class=\"accordion__content post-content content\">
                            {$accordion_item['faq_content']}
                        </div>
                    </details>";
            }
            ?>

            <div class="content-container">
                <div class="accordion">
                    <?= $accordion_items_html ?>
                </div>
            </div>




        </div>
    </section>

<?php
}
?>