<?php

namespace App\Agent\Shared\Dto;

final readonly class CategoryDto
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $slug,
        public ?string $description,
        public bool $enabled,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}