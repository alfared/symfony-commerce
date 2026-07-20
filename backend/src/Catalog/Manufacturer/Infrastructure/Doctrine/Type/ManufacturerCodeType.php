<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Doctrine\Type;

use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Shared\Infrastructure\Doctrine\Type\CodeType;

final class ManufacturerCodeType extends CodeType
{
    public const NAME = 'manufacturer_code';

    protected function valueObjectClass(): string
    {
        return ManufacturerCode::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}