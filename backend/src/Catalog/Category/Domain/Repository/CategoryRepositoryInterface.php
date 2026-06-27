<?php

namespace App\Catalog\Category\Domain\Repository;

use App\Catalog\Category\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    public function findOneByCode(string $code): ?Category;
    public function save(Category $product): void;
}