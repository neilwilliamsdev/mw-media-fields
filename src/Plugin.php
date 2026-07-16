<?php

namespace NW\MediaFields;

class Plugin
{
    public static function init(): void
    {
        Assets::init();

        self::register([
            'key'        => 'gallery',
            'label'      => 'Gallery',
            'post_types' => ['page'],
        ]);

        self::register([
            'key'        => 'hero',
            'label'      => 'Hero Image',
            'post_types' => ['page'],
            'multiple'   => false,
        ]);

        error_log(print_r(Registry::all(), true));
    }

    public static function register(array $args): void
    {
        new MediaField($args);
    }
}