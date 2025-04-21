<?php

// generic block settings is passed from a panel, but if a panel is called directly this won't exist,

$generic_block_settings = get_field('generic_block_settings');

//echo print_r($generic_block_settings);

$generic_block_settings_classes = Theme\Utils::get_generic_block_settings_classes($generic_block_settings);

// Render anchor tag if filled in in CMS
if (isset($block['anchor']) && $block['anchor'] != false) {
    echo '<a name="' . $block['anchor'] . '" id="' . $block['anchor'] . '"></a>';
}
