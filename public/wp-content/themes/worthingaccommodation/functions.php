<?php

define('THEMEROOT', get_stylesheet_directory_uri());

require __DIR__ . "/src/Autoloader.php";

\Theme\Autoloader::register();

use Theme\Config\Init;
use Theme\Config\Lockdown;

use Theme\Config\Plugins\ACFPro\ACFPro;
use Theme\Config\Plugins\GravityForms\GravityForms;

use Theme\Config\ACFBlocks;
use Theme\Config\CustomPosts;
use Theme\Config\RestAPI;


// Initialise theme config.
new Init();
Lockdown::init();

// Custom Posts
CustomPosts::init();

// ACF Block.
ACFBlocks::init();

// Rest API config.
RestAPI::init();

// Initialise plugins config.
ACFPro::init();
GravityForms::init();


function get_primary_term_name($taxo, $post_id)
{
    $wpseo_primary_term = new WPSEO_Primary_Term($taxo, $post_id);
    $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
    return $wpseo_primary_term = get_term($wpseo_primary_term);
}
