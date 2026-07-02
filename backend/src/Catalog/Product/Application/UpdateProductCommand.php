<?php

namespace App\Catalog\Product\Application;

final readonly class UpdateProductCommand
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $slug,
        public ?string $description = null,
        public bool $active = true,
    ) {

    }
}