<?php

namespace App\Catalog\ProductVariant\Domain\Factory;

use App\Catalog\Product\Domain\Model\Product;
use App\Catalog\ProductVariant\Domain\Model\ProductVariant;

interface ProductVariantFactoryInterface
{
    public function createNew(): ProductVariant;

    public function createWithData(
        Product $product,
        string $code,
        string $sku,
        int $price,
        int $stock,
        bool $enabled = true
    ): ProductVariant;
}