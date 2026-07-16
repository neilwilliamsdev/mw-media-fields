<?php

namespace NW\MediaFields;

class MetaBoxSave
{
    public static function init(): void
    {
        add_action('save_post', [self::class, 'save']);
    }


    public static function save(int $postId): void
    {
        if (
            ! isset($_POST['nw_media_fields_nonce']) ||
            ! wp_verify_nonce(
                $_POST['nw_media_fields_nonce'],
                'nw_media_fields_save'
            )
        ) {
            return;
        }


        if (
            defined('DOING_AUTOSAVE') &&
            DOING_AUTOSAVE
        ) {
            return;
        }


        foreach (Registry::all() as $field) {

            $key = 'nw_media_' . $field->key();

            if (! isset($_POST[$key])) {
                continue;
            }


            $ids = json_decode( stripslashes($_POST[$key]), true );

            if (!is_array($ids)) {
                $ids = [];
            }

            update_post_meta( $postId, $key, array_map('intval', $ids) );

        }
    }
}