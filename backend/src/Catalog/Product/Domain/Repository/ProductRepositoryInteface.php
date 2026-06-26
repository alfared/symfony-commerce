<?php

namespace App\Catalog\Product\Domain\Repository;

use App\Catalog\Product\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function findOneByCode(string $code): ?Product;

    public function save(Product $product): void;
}