<?php

include __DIR__ . '/../_block-generics.php';
//return;
if (!$is_preview) {

    $images = get_field('images');

    $slides_html = '';

    if ($images) {
        foreach ($images as $slide) {

            $background_image = $slide['background_image'];

            $slides_html .= '<div class="image-slider__slide">';

            $slides_html .= '<div class="image">';
            $slides_html .= \Theme\Utils::get_image_html($background_image);
            $slides_html .= '</div>';

            $slides_html .= '<div class="content">';
            $slides_html .= '<h1>' . $slide['meta_heading'] . '</h1>';
            $slides_html .= '<h2>' . $slide['heading'] . '</h2>';
            $slides_html .= '</div>';

            $slides_html .= '</div>';
        }
    }
?>

    <section class="content content__hero-slider-panel <?php echo $generic_block_settings_classes; ?>">

        <div class="image-slider animate fade-in">
            <div class="image-slider__slides-wrapper">
                <div class="image-slider__slides">
                    <?php echo $slides_html; ?>
                </div>
            </div>
        </div>

    </section>
<?php } ?>