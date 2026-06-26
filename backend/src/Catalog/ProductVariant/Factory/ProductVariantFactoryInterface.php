<?php

namespace App\Catalog\ProductVariant\Factory;

use App\Catalog\Product\Model\Product;
use App\Catalog\ProductVariant\Model\ProductVariant;

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