<?php

namespace App\Catalog\Brand\Domain\Factory;

use App\Catalog\Brand\Domain\Model\Brand;

final readonly class BrandFactory
{
    public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $enabled = true,
    ): Brand {
        $brand = new Brand();

        $brand->setCode($code);
        $brand->setName($name);
        $brand->setSlug($slug);
        $brand->setDescription($description);
        $brand->setEnabled($enabled);

        return $brand;
    }
}