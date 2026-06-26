<?php

namespace App\Catalog\Product\Factory;

use App\Catalog\Product\Model\Product;

interface ProductFactoryInterface
{
    public function createNew(): Product;

    public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $enabled = true
    ): Product;
}