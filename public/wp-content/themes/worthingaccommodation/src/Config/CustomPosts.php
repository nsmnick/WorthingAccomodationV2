<?php

namespace Theme\Config;

class CustomPosts
{
    public static function init()
    {

        // Custom Post Types
        add_filter('init', [self::class, 'registerPostTypes']);
        add_filter('init', [self::class, 'registerTaxonomies']);
    }


    // Custom Post Types

    public static function registerPostTypes()
    {
        register_post_type(
            'properties',
            [
                'labels' => [
                    'name'                  => _x('Properties', 'Post type general name', 'worthingaccommodation'),
                    'singular_name'         => _x('Property', 'Post type singular name', 'worthingaccommodation'),
                    'menu_name'             => _x('Properties', 'Admin Menu text', 'worthingaccommodation'),
                    'name_admin_bar'        => _x('Properties', 'Add New on Toolbar', 'worthingaccommodation'),
                    'add_new'               => __('Add New', 'worthingaccommodation'),
                    'add_new_item'          => __('Add New Property', 'worthingaccommodation'),
                    'new_item'              => __('New Property', 'worthingaccommodation'),
                    'edit_item'             => __('Edit Property', 'worthingaccommodation'),
                    'view_item'             => __('View Properties', 'worthingaccommodation'),
                    'all_items'             => __('All Properties', 'worthingaccommodation'),
                    'search_items'          => __('Search Properties', 'worthingaccommodation'),
                    'parent_item_colon'     => __('Parent Property:', 'worthingaccommodation'),
                    'not_found'             => __('No Properties found.', 'worthingaccommodation'),
                    'not_found_in_trash'    => __('No events found in Trash.', 'worthingaccommodation'),
                ],
                'public' => true,
                'has_archive' => false,
                'show_in_rest' => true,
                'query_var' => true,
                'rewrite' => [
                    'slug' => __('properties'),
                    'with_front' => false
                ],
                'supports' => ['title', 'thumbnail', 'excerpt', 'editor'],
                'menu_icon' => 'dashicons-calendar-alt',
            ]
        );

        register_post_type(
            'quotes',
            [
                'labels' => [
                    'name'                  => _x('Quotes', 'Post type general name', 'worthingaccommodation'),
                    'singular_name'         => _x('Quote', 'Post type singular name', 'worthingaccommodation'),
                    'menu_name'             => _x('Quotes', 'Admin Menu text', 'worthingaccommodation'),
                    'name_admin_bar'        => _x('Quotes', 'Add New on Toolbar', 'worthingaccommodation'),
                    'add_new'               => __('Add New', 'worthingaccommodation'),
                    'add_new_item'          => __('Add New Quote', 'worthingaccommodation'),
                    'new_item'              => __('New Quote', 'worthingaccommodation'),
                    'edit_item'             => __('Edit Quote', 'worthingaccommodation'),
                    'view_item'             => __('View quotes', 'worthingaccommodation'),
                    'all_items'             => __('All quotes', 'worthingaccommodation'),
                    'search_items'          => __('Search quotes', 'worthingaccommodation'),
                    'parent_item_colon'     => __('Parent Quote:', 'worthingaccommodation'),
                    'not_found'             => __('No quotes found.', 'worthingaccommodation'),
                    'not_found_in_trash'    => __('No events found in Trash.', 'worthingaccommodation'),
                ],
                'public' => true,
                'has_archive' => false,
                'show_in_rest' => true,
                'query_var' => true,
                'rewrite' => [
                    'slug' => __('quote'),
                    'with_front' => false
                ],
                'supports' => ['title'],
                'menu_icon' => 'dashicons-calendar-alt',
            ]
        );
    }

    public static function registerTaxonomies()
    {


        register_taxonomy(
            'properties_location',
            'properties',
            [
                'hierarchical' => true,
                'labels' => [
                    'name' => _x('Location', 'taxonomy general name', 'worthingaccommodation'),
                    'singular_name' => _x('Propery Sleeps', 'taxonomy singular name', 'worthingaccommodation'),
                    'search_items' =>  __('Search Location', 'worthingaccommodation'),
                    'popular_items' => __('Popular Location', 'worthingaccommodation'),
                    'all_items' => __('All Location', 'worthingaccommodation'),
                    'parent_item' => null,
                    'parent_item_colon' => null,
                    'edit_item' => __('Edit Propery Sleeps', 'worthingaccommodation'),
                    'update_item' => __('Update Propery Sleeps', 'worthingaccommodation'),
                    'add_new_item' => __('Add New Propery Sleeps', 'worthingaccommodation'),
                    'new_item_name' => __('New Propery Sleeps', 'worthingaccommodation'),
                    'separate_items_with_commas' => __('Separate Location with commas', 'worthingaccommodation'),
                    'add_or_remove_items' => __('Add or remove Location', 'worthingaccommodation'),
                    'choose_from_most_used' => __('Choose from the most used Propery Sleeps', 'worthingaccommodation'),
                    'menu_name' => __('Location', 'worthingaccommodation')
                ],
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'show_in_rest' => true
            ]
        );


        register_taxonomy(
            'properties_type',
            'properties',
            [
                'hierarchical' => true,
                'labels' => [
                    'name' => _x('Property Types', 'taxonomy general name', 'worthingaccommodation'),
                    'singular_name' => _x('Property Type', 'taxonomy singular name', 'worthingaccommodation'),
                    'search_items' =>  __('Search Type', 'worthingaccommodation'),
                    'popular_items' => __('Popular Type', 'worthingaccommodation'),
                    'all_items' => __('All Type', 'worthingaccommodation'),
                    'parent_item' => null,
                    'parent_item_colon' => null,
                    'edit_item' => __('Edit Propery Types', 'worthingaccommodation'),
                    'update_item' => __('Update Propery Types', 'worthingaccommodation'),
                    'add_new_item' => __('Add New Propery Types', 'worthingaccommodation'),
                    'new_item_name' => __('New Propery Types', 'worthingaccommodation'),
                    'separate_items_with_commas' => __('Separate Type with commas', 'worthingaccommodation'),
                    'add_or_remove_items' => __('Add or remove Type', 'worthingaccommodation'),
                    'choose_from_most_used' => __('Choose from the most used Propery Types', 'worthingaccommodation'),
                    'menu_name' => __('Type', 'worthingaccommodation')
                ],
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'show_in_rest' => true
            ]
        );
    }
}
