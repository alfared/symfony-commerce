<?php

namespace App\Catalog\Product\Application;

final readonly class CreateProductCommand
{
    public function __construct(
        public string $code,
        public string $name,
        public string $slug,
        public ?string $description = null,
        public bool $active = true,
    ){

    }
}
