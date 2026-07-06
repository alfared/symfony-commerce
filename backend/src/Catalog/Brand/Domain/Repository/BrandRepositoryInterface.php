<?php

namespace App\Catalog\Brand\Domain\Repository;

use App\Catalog\Brand\Domain\Model\Brand;

interface BrandRepositoryInterface
{
    /**
     * @return Brand[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Brand;

    public function findOneByCode(string $code): ?Brand;

    public function save(Brand $brand): void;
}