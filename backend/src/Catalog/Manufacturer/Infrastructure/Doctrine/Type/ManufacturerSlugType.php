<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Doctrine\Type;

use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;
use App\Shared\Infrastructure\Doctrine\Type\SlugType;

final class ManufacturerSlugType extends SlugType
{
    public const NAME = 'manufacturer_slug';

    protected function valueObjectClass(): string
    {
        return ManufacturerSlug::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}