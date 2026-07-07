<?php

namespace App\Catalog\Category\Application;

final readonly class UpdateCategoryCommand
{
    public function __construct(
        public int $id,
        public ?string $code = null,
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?bool $enabled = null,
    ){

    }
}