<?php

namespace App\Catalog\ProductOption\Application;

final readonly class CreateProductOptionValueCommand
{
    public function __construct(
        public int $optionId,
        public string $code,
        public string $value,
    ){

    }
}