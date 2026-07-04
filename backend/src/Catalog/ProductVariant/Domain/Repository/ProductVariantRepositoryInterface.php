<?php

namespace App\Catalog\ProductVariant\Domain\Repository;

use App\Catalog\ProductVariant\Domain\Model\ProductVariant;

interface ProductVariantRepositoryInterface
{
    /**
     * @return ProductVariant[]
     */
    public function findAll(): array;

    public function findById(int $id): ?ProductVariant;

    public function findOneByCode(string $code): ?ProductVariant;

    public function save(ProductVariant $variant): void;

}