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

        // Add nonce field for security
        wp_nonce_field('nw_media_fields_save', 'nw_media_fields_nonce');

        // Get the field object from the args
        $field = $args['args']['field'];

        // Get the name and value for the input field
        $name = 'nw_media_' . $field->key();

        // Get the current value from post meta
        $value = get_post_meta( $post->ID, 'nw_media_' . $field->key(), true );

        // If the value is not an array, initialize it as an empty array
        if (!is_array($value)) {
            $value = [];
        }

        ?>

        <div class="nw-media-field">

            <div class="nw-media-preview">

                <?php foreach ($value as $id): ?>

                    <?php if ($id): ?>

                        <?php echo wp_get_attachment_image($id, 'thumbnail'); ?>

                    <?php endif; ?>

                <?php endforeach; ?>
                
            </div>

            <input 
                type="hidden"
                class="nw-media-input"
                name="<?php echo esc_attr($name); ?>"
                value="<?php echo esc_attr(json_encode($value)); ?>"
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