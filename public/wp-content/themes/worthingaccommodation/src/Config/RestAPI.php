<?php

namespace Theme\Config;

use VarRepresentation\Node\Object_;

class RestAPI
{
    public static function init()
    {
        add_filter('rest_api_init', [self::class, 'registerCustomRestFields']);

        add_filter('rest_prepare_post', [self::class, 'trimHeading'], 10, 3);
        add_filter('rest_prepare_post', [self::class, 'removeTitleHTMLEntities'], 10, 3);

        add_filter('rest_properties_collection_params', [self::class, 'filter_add_rest_orderby_params'], 10, 1);
        add_filter('rest_properties_query', [self::class, 'theme_rest_api_properties_queryX'], 10, 2);
    }


    public static function filter_add_rest_orderby_params($params)
    {
        $params['orderby']['enum'][] = 'menu_order';

        return $params;
    }

    /**
     * Filter custom post type by meta data 
     *
     */
    public static function theme_rest_api_properties_queryX($args, $request)
    {

        $meta_array = array();

        $params = $request->get_params();

        if (isset($params['properties_guests'])) {

            $meta_array[] =  array(
                'key' => 'sleeps',
                'value' => $params['properties_guests'],
                'compare' => '>=',
                'type' => 'numeric'
            );
            $meta_array[] =  array(
                'key' => 'sleeps',
                'value' => 0,
                'compare' => '!=',
                'type' => 'numeric'
            );
        }

        $args['meta_query'] = $meta_array;


        return $args;
    }



    public static function registerCustomRestFields()
    {
        $post_type_fields = [
            'properties' => [
                'custom_fields' => [self::class, 'getPostFields'],
            ]
        ];

        foreach ($post_type_fields as $post_type => $fields) {
            foreach ($fields as $field_name => $function) {
                register_rest_field(
                    $post_type,
                    $field_name,
                    [
                        'get_callback' => $function,
                        'update_callback' => null,
                        'schema' => null
                    ]
                );
            }
        }
    }

    public static function getFeaturedImageSrc(array $object): string|false
    {
        return get_the_post_thumbnail_url($object['id'], 'medium');
    }

    public static function getFeaturedImageSrcset(array $object): string|false
    {
        $image_id = get_post_thumbnail_id($object['id']);
        return ($image_id ? wp_get_attachment_image_srcset($image_id, 'medium') : false);
    }

    public static function getFeaturedImageAlt(array $object): string|false
    {
        $image_id = get_post_thumbnail_id($object['id']);
        return get_post_meta($image_id, '_wp_attachment_image_alt', true);
    }

    public static function getImageFields(array $object): array
    {
        return [
            'featured_image_src' => self::getFeaturedImageSrc($object),
            'featured_image_srcset' => self::getFeaturedImageSrcset($object),
            'featured_image_alt' => self::getFeaturedImageAlt($object),
        ];
    }

    public static function getCustomExcerpt(array $object): array
    {
        return [
            'excerpt' => \Theme\Utils::getExcerpt($object['id'])
        ];
    }

    public static function getPostCategory(array $object): array
    {
        return [
            'post_category' => \Theme\Utils::get_post_primary_term_name('category', $object['id'])
        ];
    }

    public static function getPostLink(array $object): array
    {

        $external_link =  get_post_meta($object['id'], 'external_url_link', true);

        $post_link_type = 'internal';
        if ($external_link) {
            $url = $external_link;
            $post_link_type = 'external';
        } else {
            $url = get_the_permalink($object['id']);
        }

        return [
            'post_link' => $url,
            'post_link_type' => $post_link_type,
        ];
    }

    // Events Fields

    public static function getPostFields(array $object): array
    {
        $fields = [];

        return array_merge(
            $fields,
            self::getImageFields($object),
            self::getCustomExcerpt($object),
            self::getPostCategory($object),
            self::getPostLink($object),
        );
    }

    public static function removeTitleHTMLEntities($response, $post)
    {
        if (isset($post)) {
            $response->data['title']['rendered'] = html_entity_decode(
                $response->data['title']['rendered']
            );
        }
        return $response;
    }

    public static function trimHeading($response, $post)
    {
        if (isset($post)) {
            $response->data['title']['rendered'] = \Theme\Utils::getTrimmedHeading($response->data['title']['rendered']);
        }
        return $response;
    }
}
