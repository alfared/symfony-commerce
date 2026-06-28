<?php

namespace App\Catalog\Category\Domain\Repository;

use App\Catalog\Category\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function findAllEnabled(): array;
    public function findById(int $id): ?Category;
    public function findOneByCode(string $code): ?Category;
    public function save(Category $product): void;
}