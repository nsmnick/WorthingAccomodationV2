<?php

namespace Theme\Config;

class ACFBlocks
{
    public static function init()
    {
        // Remove block directory
        remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
        add_action('init', [self::class, 'register_acf_blocks']);
        add_filter('allowed_block_types_all', [self::class, 'set_allowed_block_types'], 10, 2);
        add_action('init', [self::class, 'create_post_default_template']);
        add_action('after_setup_theme', [self::class, 'remove_theme_patterns']);
    }


    // // Register Custom Blocks
    public static function register_acf_blocks()
    {
        register_block_type(__DIR__ . '/acfBlocks/content-ads-panel');
        register_block_type(__DIR__ . '/acfBlocks/faq-panel');
        register_block_type(__DIR__ . '/acfBlocks/featured-properties-panel');
        register_block_type(__DIR__ . '/acfBlocks/hero-slider-panel');
        register_block_type(__DIR__ . '/acfBlocks/icons-features-panel');
        register_block_type(__DIR__ . '/acfBlocks/internal-hero-panel');
        register_block_type(__DIR__ . '/acfBlocks/properties-list-panel');
        register_block_type(__DIR__ . '/acfBlocks/quotes-ads-panel');
        register_block_type(__DIR__ . '/acfBlocks/quotes-panel');
        register_block_type(__DIR__ . '/acfBlocks/simple-text-panel');
    }


    // Remove WP default blocks and allocate which blocks can be used by pages and posts be default
    public static function set_allowed_block_types($block_editor_context, $editor_context)
    {
        if (!empty($editor_context->post)) {
            if ('post' === $editor_context->post->post_type) {
                return array(
                    'core/freeform'
                );
            }

            if ('events' === $editor_context->post->post_type) {
                return array(
                    'core/freeform'
                );
            }

            if ('page' === $editor_context->post->post_type) {
                return array(
                    'acf/hero-slider-panel',
                    'acf/simple-text-panel',
                    'acf/featured-properties-panel',
                    'acf/icons-features-panel',
                    'acf/quotes-panel',
                    'acf/properties-list-panel',
                    'acf/internal-hero-panel',
                    'acf/content-ads-panel',
                    'acf/quotes-ads-panel',
                    'acf/faq-panel',


                );
            }
        }
        return $block_editor_context;
    }


    // Create a specific predefined block template for a post. By default a post always has a classic editor to start with. This is locked by default,
    // however, If we want to allow more custom panels for post then we could unlock this and let users build up panels as they wish.
    public static function create_post_default_template()
    {
        $post_type_object = get_post_type_object('post');
        $post_type_object->template_lock = 'all';
        $post_type_object->template = array(
            array('core/freeform'),
        );

        $post_type_object = get_post_type_object('properties');
        $post_type_object->template_lock = 'all';
        $post_type_object->template = array(
            array('core/freeform'),
        );
    }


    // Remove core patterns from interface
    public static function remove_theme_patterns()
    {
        remove_theme_support('core-block-patterns');
    }
}
