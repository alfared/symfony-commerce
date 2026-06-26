<?php

namespace App\Catalog\ProductVariant\Application;

final readonly class CreateProductVariantCommand
{
    public function __construct(
        public int $productId,
        public string $code,
        public string $sku,
        public int $price,
        public int $stock,
        public bool $enabled = true,
    ) {
    }
}