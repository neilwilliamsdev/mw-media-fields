<?php

namespace NW\MediaFields;

class MediaField
{
    protected string $key;
    protected string $label;
    protected array $postTypes;
    protected bool $multiple;

    public function __construct(array $args)
    {
        $this->key       = $args['key'];
        $this->label     = $args['label'];
        $this->postTypes = $args['post_types'] ?? ['post'];
        $this->multiple  = $args['multiple'] ?? true;

        Registry::register($this);
    }

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function postTypes(): array
    {
        return $this->postTypes;
    }

    public function multiple(): bool
    {
        return $this->multiple;
    }
}