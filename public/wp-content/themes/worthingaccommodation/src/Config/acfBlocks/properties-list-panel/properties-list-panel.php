<?php

include __DIR__ . '/../_block-generics.php';


if (!$is_preview && !$generic_block_settings['hide_panel']) {

    $category_id = 0;
    $category = '';
    $location = get_field('location');
    if ($location && $location != 'all') {
        $category = get_term_by('slug', $location, 'properties_location');

        if ($category) {
            $category_id  = $category->term_id;
            $category = $category->name;
        }
    }

    $config_data = [
        'defaultCategoryID' => $category_id,
        'defaultCategory' => $category
    ];

?>

    <section class="panel content content__properties-list-panel animate fade-in <?php echo $generic_block_settings_classes; ?>">
        <div class="container">
            <div id="vue-app" data-app="properties-search" data-config="<?php echo htmlspecialchars(json_encode($config_data)); ?>"></div>
        </div>
    </section>

<?php
}
?>