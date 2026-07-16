<?php

use NW\MediaFields\Helpers;


function nw_media(string $key, ?int $postId = null)
{
    return Helpers::media($key, $postId);
}