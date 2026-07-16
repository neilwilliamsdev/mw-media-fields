<?php

namespace NW\MediaFields;

class Registry
{
    protected static array $fields = [];

    public static function register(MediaField $field): void
    
    {
        if (isset(self::$fields[$field->key()])) {
            return;
        }

        self::$fields[$field->key()] = $field;
    }

    public static function all(): array
    {
        return self::$fields;
    }

    public static function get(string $key): ?MediaField
    {
        return self::$fields[$key] ?? null;
    }
}