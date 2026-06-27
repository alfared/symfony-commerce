<?php

namespace App\Catalog\Product\Domain\Factory;

use App\Catalog\Product\Domain\Model\Product;

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
        bool $active = true
    ): Product {
        $product = $this->createNew();

        $product->setCode($code);
        $product->setName($name);
        $product->setSlug($slug);
        $product->setDescription($description);
        $product->setActive($active);

        return $product;
    }
}