<?php

get_header();

while (have_posts()) {
    the_post();

    $featured_image_id = get_post_thumbnail_id(get_the_ID());


    $gallery = get_field('gallery');
    $sleeps = get_field('sleeps');
    $wifi = get_field('wifi');
    $bed_linen = get_field('bed_linen');
    $children = get_field('children');
    $check_in = get_field('check_in');
    $check_out = get_field('check_out');
    $smoking = get_field('smoking');
    $book_now_link = get_field('book_now_link');


    $properties_location =  yoast_get_primary_term_id('properties_location', get_the_ID());
    $properties_type =  yoast_get_primary_term_id('properties_type', get_the_ID());
    $related_properties = \Theme\Utils::get_related_properties(3, get_the_ID(), $properties_location, $properties_type);


    // $category_tag = '';
    // if ($primary_term) {
    //     $category_tag = '<div class="card-tag card-tag--mb">' . $primary_term . '</div>';
    // }
?>


    <section class="content content__internal-hero-panel bgc-green">
        <div class="container">
            <div class="content-container">
                <h1 class="animate fade-in"><?php echo get_the_title(); ?></h1>
            </div>
        </div>
    </section>


    <section class=" panel content content__post-article">

        <div class="container">

            <div class="article-container">
                <div class="article-container__col1">



                    <?php
                    $slider_html = '';
                    $thumbs_html = '';

                    $photo_gallery = get_field('gallery');

                    if ($photo_gallery) {

                        foreach ($photo_gallery as $key => $image) {

                            $slider_html .= '
                                <div class="property-gallery-slider__slide">
                                    ' . \Theme\Utils::get_image_html($image) . '
                                  </div>';

                            $thumbs_html .= '<div class="property-thumbs-slider__slide">'
                                . \Theme\Utils::get_image_html($image)
                                . '</div>';
                        }

                    ?>

                        <div class="gallery-container">
                            <div class="property-gallery-slider">
                                <div class="property-gallery-slider__slides-wrapper">
                                    <?php echo $slider_html;
                                    ?>
                                </div>

                                <div class="property-gallery-slider__controls">
                                    <div class="property-gallery-slider__nav-button property-gallery-slider__nav-button--prev"></div>
                                    <div class="property-gallery-slider__nav-button property-gallery-slider__nav-button--next"></div>
                                </div>

                            </div>

                            <div thumbsSlider="" class="property-thumbs-slider">
                                <div class="property-thumbs-slider__slides-wrapper">
                                    <?php echo $thumbs_html;
                                    ?>
                                </div>
                            </div>

                        </div>
                    <?php
                    }
                    ?>


                </div>
                <div class="article-container__col2">

                    <h3>Property Information</h3>

                    <ul class="property-details">
                        <li><span>Sleeps: </span><?php echo $sleeps; ?></li>
                        <li><span>Wifi: </span><?php echo $wifi; ?></li>
                        <li><span>Check in: </span><?php echo $check_in; ?></li>
                        <li><span>Check out: </span><?php echo $check_out; ?></li>
                        <li><span>Bed linen/towels: </span><?php echo $bed_linen; ?></li>
                        <li><span>Children: </span><?php echo $children; ?></li>
                        <li><span>Smoking: </span><?php echo $smoking; ?></li>
                    </ul>

                    <ul class="property-details">
                        <li><span>Enquiries: </span> <a href="mailto:<?php echo get_field('email_address', 'options'); ?>"><?php echo get_field('email_address', 'options'); ?></a></li>
                        <li><span>Telephone: </span> <a href="tel:<?php echo get_field('phone_number', 'options'); ?>"><?php echo get_field('phone_number_display', 'options'); ?></a></li>
                    </ul>


                    <div class="cta-actions desktop-only">
                        <a target="_blank" rel="noopener noreferrer" href="<?php echo $book_now_link; ?>" class="button">BOOK NOW</a>
                        <a href="mailto:<?php echo get_field('email_address', 'options'); ?>" class="button">ENQUIRE</a>
                    </div>



                </div>
            </div>


            <div class="article-container">
                <div class="article-container__col1  animate fade-up">

                    <div class="article">
                        <div class="wysiwyg-container">
                            <?php echo the_content();
                            ?>
                        </div>
                    </div>

                    <div class="cta-actions mobile-only">
                        <a target="_blank" rel="noopener noreferrer" href="<?php echo $book_now_link; ?>" class="button">BOOK NOW</a>
                        <a href="mailto:<?php echo get_field('email_address', 'options'); ?>" class="button">ENQUIRE</a>
                    </div>

                    <div class="share-container">
                        <h3 class="label">Share this property with others</h3>
                        <?php echo \Theme\Utils::share_article(get_the_ID()); ?>
                    </div>


                </div>


                <div class="article-container__col2 animate fade-up">






                </div>

            </div>

        </div>

    </section>

    <?php
    // Render Upcoming events promo Panel Block
    // $content = '';
    // $block = acf_get_block_type('acf/featured-properties-panel');
    // $block['data']['heading'] = 'Other properties you might be interested in...';
    // $block['data']['generic_block_settings']['hide_panel'] = false;
    // $block['data']['generic_block_settings']['background_colour'] = 'back-grey';

    // echo acf_rendered_block($block, $content, false);


    ?>


    <section class="panel content content__featured-properties-panel bgc-back-grey">
        <div class="container">

            <h2 class="icon-underline">Other properties you might be interested in...</h2>

            <div class="content-container animate fade-in">
                <?php

                foreach ($related_properties as $property) {
                    echo '<div class="content-container__col">';
                    echo '<div class="property-card">';

                    echo '<div class="property-card__image">';
                    echo \Theme\Utils::get_image_html(get_post_thumbnail_id($property->ID));
                    echo '</div>';

                    echo '<div class="property-card__content">';
                    echo '<a href="' . get_the_permalink($property->ID) . '"><h3>' . $property->post_title . '</h3></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                ?>
            </div>
        </div>
    </section>

<?php



}


get_footer();
