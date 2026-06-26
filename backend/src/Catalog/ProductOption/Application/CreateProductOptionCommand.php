<?php

namespace App\Catalog\ProductOption\Application;

final readonly class CreateProductOptionCommand
{
    public function __construct(
        public string $code,
        public string $name,
    ) {
    }
}