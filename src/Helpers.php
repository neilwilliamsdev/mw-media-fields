<?php

namespace NW\MediaFields;

class Helpers
{

    public static function media(string $key, ?int $postId = null)
    {
        if (!$postId) {
            $postId = get_the_ID();
        }


        $ids = get_post_meta(
            $postId,
            'nw_media_' . $key,
            true
        );


        if (!is_array($ids) || empty($ids)) {
            return null;
        }


        $field = Registry::get($key);


        if ($field && !$field->multiple()) {

            return self::image($ids[0]);

        }


        return array_map(
            [self::class, 'image'],
            $ids
        );

    }


    private static function image(int $id): array
    {

        $image = wp_get_attachment_image_src(
            $id,
            'large'
        );


        return [
            'id' => $id,

            'url' => $image[0] ?? '',

            'width' => $image[1] ?? 0,

            'height' => $image[2] ?? 0,

            'alt' => get_post_meta(
                $id,
                '_wp_attachment_image_alt',
                true
            ),

            'srcset' => wp_get_attachment_image_srcset(
                $id,
                'large'
            ),

            'sizes' => wp_get_attachment_image_sizes(
                $id,
                'large'
            ),

        ];

    }

}