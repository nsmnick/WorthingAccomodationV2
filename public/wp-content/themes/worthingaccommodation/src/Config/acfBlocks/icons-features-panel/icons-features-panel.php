<?php

include __DIR__ . '/../_block-generics.php';

if (!$is_preview && !$generic_block_settings['hide_panel']) {

    $features = get_field('features');

    if (!empty($features)) {
?>

        <section class="panel content content__icons-features-panel <?php echo $generic_block_settings_classes; ?>">
            <div class="container">

                <div class="content-container animate fade-in">
                    <?php

                    foreach ($features as $feature) {
                        echo '<div class="content-container__col">';
                        echo '<div class="feature-card">';

                        echo '<div class="feature-card__icon animate fade-up">';
                        echo '<img src="' . $feature['icon'] . '"/>';
                        echo '</div>';

                        echo '<div class="feature-card__content">';
                        echo '<h2>' . $feature['heading'] . '</h2>';
                        echo '<p>' . $feature['summary'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    ?>
                </div>
            </div>
        </section>

<?php }
}
?>