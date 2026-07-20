<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Domain\Factory;

use App\Catalog\Manufacturer\Domain\Model\Manufacturer;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerName;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;

final readonly class ManufacturerFactory
{
    public function create(
        string $code,
        string $name,
        string $slug
    ): Manufacturer {
        return Manufacturer::create(
            code: new ManufacturerCode($code),
            name: new ManufacturerName($name),
            slug: new ManufacturerSlug($slug),
        );
    }
}