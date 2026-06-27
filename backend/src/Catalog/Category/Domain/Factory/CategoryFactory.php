<?php

namespace App\Catalog\Category\Domain\Factory;

use App\Catalog\Category\Domain\Model\Category;

final class CategoryFactory implements CategoryFactoryInterface
{
    public function createNew(): Category
    {
        return new Category();
    }

    public function createWithData(
       string $code,
       string $name,
       string $slug,
       ?string $description = null,
       bool $enabled = true
    ): Category {
    }
}