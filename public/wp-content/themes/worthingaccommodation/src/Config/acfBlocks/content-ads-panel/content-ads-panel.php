<?php
include __DIR__ . '/../_block-generics.php';

if (!$is_preview && !$generic_block_settings['hide_panel']) {
    $content = get_field('content');
    $selected_properties = get_field('popular_properties');
    $properties = \Theme\Utils::get_featured_properties(6, $selected_properties);

?>

    <section class="panel content content__content-ads-panel <?php echo $generic_block_settings_classes; ?>">

        <div class="container">

            <div class="content-container">
                <div class="content-container__col1">
                    <div class="wysiwyg-container animate fade-in">
                        <?php echo $content; ?>
                    </div>
                </div>
                <div class="content-container__col2">

                    <div class="popular-accommodation-heading">
                        <h3>Popular Accommodation</h3>
                    </div>

                    <div class="popular-accommodation">

                        <?php foreach ($properties as $property) {

                            echo '<a href="' . get_the_permalink($property->ID) . '">';
                            echo '<div class="popular-accommodation__row">';

                            echo '<div class="popular-accommodation__row__col1">';
                            echo '<img src="' . get_the_post_thumbnail_url($property->ID, 'small') . '"/>';
                            echo '</div>';

                            echo '<div class="popular-accommodation__row__col2">';
                            echo $property->post_title;
                            echo '</div>';

                            echo '</div>';
                            echo '</a>';
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
}
?>