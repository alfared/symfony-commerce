<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Doctrine\Type;

use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerId;
use App\Shared\Infrastructure\Doctrine\Type\IdentifierType;

final class ManufacturerIdType extends IdentifierType
{
    public const NAME = 'manufacturer_id';

    protected function valueObjectClass(): string
    {
        return ManufacturerId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
