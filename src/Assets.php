<?php

namespace NW\MediaFields;

class Assets
{
    public static function init(): void
    {
        add_action('admin_enqueue_scripts', [self::class, 'enqueue']);
    }

    public static function enqueue(): void
    {
        wp_enqueue_media();

        wp_enqueue_script(
            'nw-media-fields',
            plugin_dir_url(dirname(__FILE__)) . 'assets/media-field.js',
            [],
            '0.1.0',
            true
        );

        wp_enqueue_style(
            'nw-media-fields',
            plugin_dir_url(dirname(__FILE__)) . 'assets/admin.css',
            [],
            '0.1.0'
        );
    }
}