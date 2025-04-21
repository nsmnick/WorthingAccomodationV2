<?php

namespace Theme\Config\Plugins\ACFPro;

class ACFPro
{
    public static function init()
    {
        add_filter('acf/init', [self::class, 'addOptionsPages']);
        add_filter('acf/settings/load_json', [self::class, 'pluginAcfSettingsLoadJson']);
        // add_filter('acf/settings/save_json', [self::class, 'pluginAcfSettingsSaveJson']);
    }

    public static function addOptionsPages()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme Settings',
                'menu_title' => 'Theme Settings',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => true
            ]);

            acf_add_options_sub_page([
                'page_title' => 'Theme Settings',
                'menu_title' => 'General',
                'parent_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => true
            ]);

            acf_add_options_sub_page([
                'page_title' => 'Theme Header Settings',
                'menu_title' => 'Header',
                'parent_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => true
            ]);

            acf_add_options_sub_page([
                'page_title' => 'Theme Footer Settings',
                'menu_title' => 'Footer',
                'parent_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => true
            ]);
        }
    }

    public static function pluginAcfSettingsLoadJson($paths)
    {
        unset($paths[0]);
        $paths[] = __DIR__ . '/config';
        return $paths;
    }

    public static function pluginAcfSettingsSaveJson($path)
    {
        $path = __DIR__ . '/config';
        return $path;
    }
}
