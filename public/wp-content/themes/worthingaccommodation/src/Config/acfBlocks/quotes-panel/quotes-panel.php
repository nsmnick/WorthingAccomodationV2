<?php
include __DIR__ . '/../_block-generics.php';

if (!$is_preview) {

    $quotes = get_field('quotes');

?>
    <?php if ($quotes) { ?>
        <section class="panel content content__quotes-panel <?php echo $generic_block_settings_classes; ?>">


            <div class="container">

                <h2 class="icon-underline">Previous guests comments</h2>

                <?php
                $slider_html = '';

                foreach ($quotes as $quote) {

                    $quote_content = get_post_meta($quote, 'quote', true);
                    $quote_by = get_post_meta($quote, 'quote_by', true);
                    $organisation = get_post_meta($quote, 'organisation', true);
                    $location = get_post_meta($quote, 'location', true);

                    $slider_html .= '<div class="quotes-slider__slide">';
                    $slider_html .= '<div class="slide-content">'
                        . '<div class="quote-marks"></div>'
                        . '<div class="quote">'
                        . $quote_content
                        . '</div>'
                        . '<div class="quote_by">'
                        . $quote_by
                        . '</div>'
                        . '<div class="quote_org">'
                        . $organisation
                        . '</div>'
                        . '<div class="quote_loc">'
                        . $location
                        . '</div>'
                        . '</div>'
                        . '</div>';
                }
                ?>

                <div class="quotes-slider animate fade-in">
                    <div class="quotes-slider__slides">
                        <?php echo $slider_html; ?>
                    </div>

                    <div class="quotes-slider__pagination  animate fade-in"></div>
                </div>

                <div class="button-center-container mt-60">
                    <a href="/testimonials/" class="button">Read more testimonials</a>
                </div>

            </div>
        </section>

    <?php } ?>

<?php
}
?>