<?php

namespace Theme;

class Utils
{
    public static function debug(mixed $variable): void
    {
        echo '<pre>' . print_r($variable, true) . '</pre>';
    }

    public static function getTemplateName(): string
    {
        global $template;
        return basename($template);
    }

    public static function getExcerpt($postID)
    {
        $excerpt = get_the_excerpt($postID);

        if (has_excerpt($postID)) {
            $excerpt = wp_trim_words($excerpt, apply_filters("excerpt_length", 30));
        }

        return $excerpt;
    }

    public static function getTrimmedHeading($heading)
    {

        if ($heading) {
            $heading =  wp_trim_words($heading, 16);
        }

        return $heading;
    }

    public static function get_image_html($image_id, $sizes = 1): string
    {
        if ($image_id === 0) {
            return '';
        }

        switch ($sizes) {
            case 3:
                $sizes = '(max-width: 480px) 100vw, (max-width: 1024px) 50vw, 33.33vw';
                break;
            case 2:
                $sizes = '(max-width: 480px) 100vw, 50vw';
                break;
            default:
                $sizes = '100vw';
        }

        $image_src = wp_get_attachment_image_url($image_id, 'full');
        $image_srcset = wp_get_attachment_image_srcset($image_id, 'full');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        return <<<IMAGE
            <img src="{$image_src}" srcset="{$image_srcset}" sizes="{$sizes}" alt="{$image_alt}">
        IMAGE;
    }



    public static function get_generic_block_settings_classes($generic_block_settings)
    {

        // echo 'BEFORE:<br/>';
        // echo print_r($generic_block_settings);
        // echo '<br/>';

        $top_padding = (isset($generic_block_settings['top_padding']) ? $generic_block_settings['top_padding'] : '');
        $bottom_padding = (isset($generic_block_settings['bottom_padding']) ? $generic_block_settings['bottom_padding'] : '');

        $background_colour = (isset($generic_block_settings['background_colour']) ? $generic_block_settings['background_colour'] : '');

        $generic_block_class = '';
        $generic_block_class .= ($top_padding == "default" ? '' : ' tp-' . $top_padding);
        $generic_block_class .= ($bottom_padding == "default" ? '' : ' bp-' . $bottom_padding);

        $custom_class = (isset($generic_block_settings['custom_class']) ? $generic_block_settings['custom_class'] : '');

        if ($custom_class != '')
            $generic_block_class .= ' ' . $custom_class . ' ';

        if ($background_colour)
            $generic_block_class .= ' bgc-' . $background_colour . ' ';

        //$generic_block_class .= ($z_index != "" ? '' : 'inset');

        // echo 'AFTER:<br/>';
        // echo $generic_block_class;
        // echo '<br/>';


        return $generic_block_class;
    }



    public static function get_link_url($link_url, $link_page)
    {
        // echo 'lurl:' . $link_url . '<br/>';
        // echo 'link_page:' . $link_page . '<br/>';
        if ($link_page) {
            return $link_page;
        } else {
            return $link_url;
        }
    }


    public static function get_quotes($total_quotes = 99)
    {
        $args = [
            'post_type' => 'quotes',
            'posts_per_page' => $total_quotes,
            'post_status' => 'publish',
            'order' => 'menu_order',
            'orderby' => 'asc'
        ];

        $quotes = get_posts($args);

        return $quotes;
    }

    public static function get_related_properties($total_posts = 3, $current_property, $properties_location, $properties_type)
    {


        $args = [
            'post_type' => 'properties',
            'posts_per_page' => $total_posts,
            'post_status' => 'publish',
            'post__not_in' => array($current_property),
            'tax_query' => array(
                array(
                    'taxonomy' => 'properties_location',
                    'field' => 'term_id',
                    'terms' => $properties_location
                )
            )
        ];

        //echo print_r($args);
        $posts  = get_posts($args);
        //echo print_r($posts);
        return $posts;
    }

    public static function get_featured_properties($total_posts = 3, $selected_properties = [])
    {

        $featured_posts = [];
        $latest_posts = [];

        if ($selected_properties) {
            $args = [
                'post_type' => 'properties',
                'post_status' => 'publish',
                'post__in' => $selected_properties,
                'order' => 'menu_order',
                'orderby' => 'asc'
            ];

            $featured_posts = get_posts($args);
        }


        if (count($featured_posts) < $total_posts) {
            $required_posts = $total_posts - count($featured_posts);

            $args = [
                'post_type' => 'properties',
                'posts_per_page' => $required_posts,
                'post_status' => 'publish',
                'post__not_in' => $selected_properties,
            ];

            $latest_posts =  get_posts($args);
        }

        $posts = array_merge($featured_posts, $latest_posts);

        return $posts;
    }

    public static function get_post_primary_term_name($taxo, $post_id)
    {
        $primary_term = get_primary_term_name($taxo, $post_id);

        $category = '';
        if (!$primary_term->errors) {
            $category = $primary_term->name;
        }

        return $category;
    }


    public static function  share_article($article_id)
    {

        $title = get_the_title($article_id);
        $short_url = get_the_permalink($article_id);
        $url = get_the_permalink($article_id);

        $twitter_params =
            '?text=' . urlencode($title) . '+-' .
            '&amp;url=' . urlencode($short_url) .
            '&amp;counturl=' . urlencode($url) .
            '';

        $twitter_link = "https://twitter.com/share" . $twitter_params . "";
        $linkedIn_link = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($url);
        $facebook_link = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url);
        $whatsapp_link = "https://api.whatsapp.com/send/?text=" . urlencode($url);
        $email_link = "mailto:?subject=I wanted you to see this website page&amp;body=Check out this site " . urlencode($url) . ".";

        echo '<div class="share-container">'

            . '<ul class="socials">'
            . '<li class="socials__item">'
            . '<a class="socials__item__link socials__item__link--linkedin" href="javascript:void(0)" onclick="window.open(\'' . $linkedIn_link . '\', \'sharer\', \'toolbar=0, status=0, width=626, height=436\');return false;" title="Linkedin" aria-label="LinkedIn"><span>LinkedIn</span></a>'
            . '</li>'
            . '<li class="socials__item"><a class="socials__item__link socials__item__link--x" href="javascript:void(0)" onclick="window.open(\'' . $twitter_link . '\', \'sharer\', \'toolbar=0, status=0, width=626, height=436\');return false;" title="X" aria-label="X"><span>X</span></a>'
            . '</li>'
            . '<li class="socials__item"><a class="socials__item__link socials__item__link--whatsapp" href="javascript:void(0)" onclick="window.open(\'' . $whatsapp_link . '\', \'sharer\', \'toolbar=0, status=0, width=626, height=436\');return false;" title="WhatsApp" aria-label="WhatsApp"><span>WhatsApp</span></a>'
            . '</li>'
            . '<li class="socials__item"><a class="socials__item__link socials__item__link--email" href="' . $email_link . '"></a>'
            . '</li>'
            . '<li class="socials__item"><a class="socials__item__link socials__item__link--copylink" href="javascript:void(0)" onclick="CopyToClipboard(window.location.href);" title="Copy Link" aria-label="Copy Link"></a>'
            . '</li>'
            . '</ul>';



        echo '</div>';
    }
}
