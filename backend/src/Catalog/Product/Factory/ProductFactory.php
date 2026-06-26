<?php

namespace App\Catalog\Product\Factory;

use App\Catalog\Product\Model\Product;

final class ProductFactory implements ProductFactoryInterface
{
    public function createNew(): Product
    {
        return new Product();
    }

      public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $enabled = true
    ): Product {
        $product = $this->createNew();

        $product->setCode($code);
        $product->setName($name);
        $product->setSlug($slug);
        $product->setDescription($description);
        $product->setEnabled($enabled);

        return $product;
    }
}