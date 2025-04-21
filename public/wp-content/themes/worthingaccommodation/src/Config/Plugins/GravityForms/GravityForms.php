<?php

namespace Theme\Config\Plugins\GravityForms;

class GravityForms
{
    public static function init(): void
    {
        add_filter('gform_required_legend', [self::class, 'requiredLegendText'], 10, 2);
    }

    public static function requiredLegendText($legend, $form): string
    {
        return '<span>*</span> required fields';
    }
}
