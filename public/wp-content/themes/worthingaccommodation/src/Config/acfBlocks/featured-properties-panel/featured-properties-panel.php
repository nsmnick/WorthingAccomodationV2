<?php

include __DIR__ . '/../_block-generics.php';

if (!$is_preview && !$generic_block_settings['hide_panel']) {

    $heading = get_field('heading');

    if (!$heading) {
        $heading = 'Featured Properties';
    }

    $properties = \Theme\Utils::get_featured_properties(3);

    if (!empty($properties)) {
?>

        <section class="panel content content__featured-properties-panel <?php echo $generic_block_settings_classes; ?>">
            <div class="container">

                <h2 class="icon-underline"><?php echo $heading; ?></h2>

                <div class="content-container animate fade-in">
                    <?php

                    foreach ($properties as $property) {
                        echo '<div class="content-container__col">';
                            echo '<a href="' . get_the_permalink($property->ID) . '">';
                       
                                echo '<div class="property-card">';

                                    echo '<div class="property-card__image">';
                                    echo \Theme\Utils::get_image_html(get_post_thumbnail_id($property->ID));
                                    echo '</div>';

                                    echo '<div class="property-card__content">';
                                        echo '<h3>' . $property->post_title . '</h3>';
                                    echo '</div>';

                                echo '</div>';
                                
                            echo '</a>';
                        
                            echo '</div>';
                    }

                    ?>
                </div>
            </div>
        </section>

<?php }
}
?>