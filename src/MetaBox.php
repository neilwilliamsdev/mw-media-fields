<?php

namespace NW\MediaFields;

class MetaBox
{
    public static function init(): void
    {
        add_action('add_meta_boxes', [self::class, 'register']);
    }

    public static function register(): void
    {
        foreach (Registry::all() as $field) {

            foreach ($field->postTypes() as $postType) {

                add_meta_box(
                    'nw_media_' . $field->key(),
                    $field->label(),
                    [self::class, 'render'],
                    $postType,
                    'normal',
                    'default',
                    [
                        'field' => $field,
                    ]
                );

            }
        }
    }

    public static function render($post, $args): void

    {
        $field = $args['args']['field'];

        $name = 'nw_media_' . $field->key();

        ?>

        <div class="nw-media-field">

            <div class="nw-media-preview"></div>

            <input 
                type="hidden"
                class="nw-media-input"
                name="<?php echo esc_attr($name); ?>"
                value=""
            >

            <button 
                type="button"
                class="button nw-media-select"
                data-multiple="<?php echo $field->multiple() ? 'true' : 'false'; ?>"
            >
                Select Media
            </button>

        </div>

        <?php
    }
}