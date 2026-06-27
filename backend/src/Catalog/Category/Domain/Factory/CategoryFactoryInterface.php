<?php

namespace App\Catalog\Category\Domain\Factory;

use App\Catalog\Category\Domain\Model\Category;

interface CategoryFactoryInterface
{
    public function createNew(): Category;

    public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $enabled = true
    ): Category;
}