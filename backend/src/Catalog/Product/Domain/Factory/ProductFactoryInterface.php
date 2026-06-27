<?php

namespace App\Catalog\Product\Domain\Factory;

use App\Catalog\Product\Domain\Model\Product;

interface ProductFactoryInterface
{
    public function createNew(): Product;

    public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $active = true
    ): Product;
}