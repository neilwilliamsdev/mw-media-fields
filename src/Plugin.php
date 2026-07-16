<?php

namespace NW\MediaFields;

class Plugin
{
    public static function init(): void
    {
        Assets::init();
        MetaBox::init();
        MetaBoxSave::init();

        self::register([
            'key'        => 'gallery',
            'label'      => 'Gallery',
            'post_types' => ['page'],
            'multiple'   => true,
        ]);

        self::register([
            'key'        => 'hero',
            'label'      => 'Hero Image',
            'post_types' => ['page'],
            'multiple'   => true,
        ]);

    }

    public static function register(array $args): void
    {
        new MediaField($args);
    }
}