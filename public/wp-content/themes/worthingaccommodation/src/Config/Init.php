<?php

namespace Theme\Config;

class Init
{
    public array $assets_map;

    public function __construct()
    {
        $this->assets_map = $this->getAssetsMap();

        add_action('after_setup_theme', [$this, 'themeSupports']);

        // Menus
        add_filter('init', [$this, 'registerNavMenus']);


        // Set gallery defaults.
        add_filter('media_view_settings', [$this, 'galleryDefaults']);

        // Frontend scripts.
        add_filter('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        add_filter('wp_enqueue_scripts', [$this, 'enqueueScripts']);

        // Admin styles.
        add_action('login_enqueue_scripts', [$this, 'enqueueLoginStyles']);
        add_filter('login_headerurl', [$this, 'customLoginLogoUrl']);

        // Post excerpt settings.
        add_filter('excerpt_length', [$this, 'excerptLength'], 999);
        add_filter('excerpt_more', [$this, 'excerptMore'], 999);

        // Check for staging environment.
        add_action('login_body_class', [$this, 'addEnvironmentClass']);
        add_filter('body_class', [$this, 'addEnvironmentClass']);

        // Editor Interface Tidyup
        add_action('admin_head', [$this, 'tidy_up_WP_interface']);
        add_action('admin_init', [$this, 'disable_autosave']);

        // Editor styles
        add_filter('mce_buttons_2', [$this, 'add_style_select_buttons']);
        add_action('admin_init', [$this, 'admin_add_editor_styles']);
        add_filter('tiny_mce_before_init', [$this, 'my_custom_editor_styles']);
        add_action('enqueue_block_editor_assets', [$this, 'add_block_editor_styles']);
        add_editor_style(get_theme_file_uri('/editor-custom-formats.css'));

        add_filter('manage_events_posts_columns', [$this, 'add_acf_columns']);
        add_action('manage_events_posts_custom_column', [$this, 'events_custom_column'], 10, 2);
    }

    private function getAssetsMap()
    {
        $assets_map_path = get_stylesheet_directory() . '/dist/.vite/manifest.json';

        if (file_exists($assets_map_path)) {
            return json_decode(file_get_contents($assets_map_path), true);
        }

        return [];
    }

    public function themeSupports()
    {
        add_theme_support('html5', ['gallery', 'caption']);
        add_theme_support('post-thumbnails');
    }



    public function registerNavMenus()
    {
        register_nav_menu('primary-menu', 'Primary Menu');
        register_nav_menu('secondary-menu', 'Secondary Menu');
        register_nav_menu('footer-menu', 'Footer Menu');
    }


    public function galleryDefaults($settings)
    {
        $settings['galleryDefaults']['columns'] = 2;
        $settings['galleryDefaults']['link'] = 'none';
        $settings['galleryDefaults']['size'] = 'full';

        return $settings;
    }

    public function enqueueScripts()
    {
        // wp_enqueue_script('jquery');

        if (!$this->isViteHMRAvailable()) {
            if (array_key_exists('assets/index.js', $this->assets_map)) {
                wp_enqueue_script(
                    'custom-script',
                    get_stylesheet_directory_uri() . '/dist/' . $this->assets_map['assets/index.js']["file"],
                    [],
                    null,
                    []
                );
                $this->loadJSScriptAsESModule('custom-script');
            }
        } else {
            $theme_path = parse_url(get_stylesheet_directory_uri(), PHP_URL_PATH);

            wp_enqueue_script(
                'vite-client',
                $this->getViteDevServerAddress() . $theme_path . '/dist/@vite/client',
                [],
                null,
                []
            );
            $this->loadJSScriptAsESModule('vite-client');

            wp_enqueue_script(
                'vite-script',
                $this->getViteDevServerAddress() . $theme_path . '/dist/assets/index.js',
                [],
                null,
                []
            );
            $this->loadJSScriptAsESModule('vite-script');
        }
    }

    public function enqueueStyles()
    {
        if (
            !$this->isViteHMRAvailable() &&
            array_key_exists('assets/index.js', $this->assets_map) &&
            array_key_exists('css', $this->assets_map['assets/index.js'])
        ) {
            foreach ($this->assets_map['assets/index.js']["css"] as $style_path) {
                wp_enqueue_style(
                    'core',
                    get_stylesheet_directory_uri() . '/dist/' . $style_path,
                    [],
                    false,
                    'all'
                );
            }
        }
    }

    public function enqueueLoginStyles()
    {
        if (
            array_key_exists('assets/login.js', $this->assets_map) &&
            array_key_exists('css', $this->assets_map['assets/login.js'])
        ) {
            foreach ($this->assets_map['assets/login.js']["css"] as $style_path) {
                wp_enqueue_style(
                    'admin-styles',
                    get_stylesheet_directory_uri() . '/dist/' . $style_path,
                    [],
                    false,
                    'all'
                );
            }
        }
    }

    public function customLoginLogoUrl()
    {
        return site_url();
    }

    public function excerptLength()
    {
        return 20;
    }

    public function excerptMore()
    {
        return '&hellip;';
    }

    public function addEnvironmentClass($classes = '')
    {
        $environment = wp_get_environment_type();

        if ($environment !== 'production') {
            $classes[] = 'env-' . $environment;
        }

        return $classes;
    }

    public function loadJSScriptAsESModule($script_handle)
    {
        add_filter(
            'script_loader_tag',
            function ($tag, $handle, $src) use ($script_handle) {
                if ($script_handle === $handle) {
                    return sprintf(
                        '<script type="module" src="%s"></script>',
                        esc_url($src)
                    );
                }
                return $tag;
            },
            10,
            3
        );
    }

    public function getViteDevServerAddress()
    {
        if (defined('VITE_DEV_SERVER_URL')) {
            return VITE_DEV_SERVER_URL;
        }

        return '';
    }

    public function isViteHMRAvailable()
    {
        return !empty($this->getViteDevServerAddress()) &&
            defined('WP_ENVIRONMENT_TYPE') &&
            WP_ENVIRONMENT_TYPE === 'local';
    }



    // Editor Interface Tidy Up


    public function add_style_select_buttons($buttons)
    {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    public function admin_add_editor_styles()
    {
        add_editor_style('editor-custom-style-v3.css');
    }


    //add custom styles to the WordPress editor
    public function my_custom_editor_styles($init_array)
    {

        $style_formats = array(
            // These are the custom styles
            array(
                'title' => 'Introduction Paragraph',
                'block' => 'span',
                'classes' => 'introduction-paragraph',
                'wrapper' => true,
            ),
            array(
                'title' => 'Highlight',
                'block' => 'span',
                'classes' => 'highlight',
                'wrapper' => false,
            ),
            array(
                'title' => 'External Link',
                'block' => 'span',
                'classes' => 'external-link',
                'wrapper' => false,
            ),
        );
        // Insert the array, JSON ENCODED, into 'style_formats'
        $init_array['style_formats'] = json_encode($style_formats);

        return $init_array;
    }


    public function add_block_editor_styles()
    {
        wp_enqueue_style('legit-editor-styles', get_theme_file_uri('/editor-custom-formats.css'), false, '2.3', 'all');
    }



    // Overridden styles to hide preview button in top navigation and tidy up interface elements
    public function tidy_up_WP_interface()
    {
        echo '<style type="text/css">
        .editor-preview-dropdown {
            display: none !important;
        }
        .mce-content-body {
            border: solid 1px #ccc !important;
            min-height: 300px;
            padding: 10px; 
        }

        #poststuff .postbox-container {
            width: 93%;
            margin: 0 auto;
            border: solid 1px #ccc;
            float: unset;           
        }

        :root :where(.editor-styles-wrapper)::after {
           content: "";
            display: block;
            height: 0px !important;
        }

        </style>
    ';

        if (function_exists('wpseo_init')) {
            echo '<style>.wpseo-metabox-content,.wpseo-meta-section,.wpseo-meta-section-react,.postbox,.wp-block,.acf-postbox {max-width: 95%;margin: 40px auto;}</style>';
        }
    }



    // Disable autosave
    public function disable_autosave()
    {
        wp_deregister_script('autosave');
    }


    public function add_acf_columns($columns)
    {
        return array_merge($columns, array(
            'event_date' => __('Event Date')
        ));
    }

    public function events_custom_column($column, $post_id)
    {
        if ($column == 'event_date') {
            echo get_post_meta($post_id, 'display_date', true);
        }
    }
}
