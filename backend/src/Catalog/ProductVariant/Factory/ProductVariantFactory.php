<?php

namespace App\Catalog\ProductVariant\Factory;

use App\Catalog\Product\Model\Product;
use App\Catalog\ProductVariant\Model\ProductVariant;

final class ProductVariantFactory implements ProductVariantFactoryInterface
{
    public function createNew(): ProductVariant
    {
        return new ProductVariant();
    }

    public function createWithData(
        Product $product,
        string $code,
        string $sku,
        int $price,
        int $stock,
        bool $enabled = true
    ): ProductVariant {
        $variant = $this->createNew();

        $product->setCode($code);
        $product->setName($name);
        $product->setSlug($slug);
        $product->setDescription($description);
        $product->setEnabled($enabled);

        $variant->setProduct($product);
        return $variant;
    }
}