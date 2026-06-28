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
        $category = new Category();

        $category->setCode($code);
        $category->setName($name);
        $category->setSlug($slug);
        $category->setDescription($description);
        $category->setEnabled($enabled);

        return $category;
    }
}