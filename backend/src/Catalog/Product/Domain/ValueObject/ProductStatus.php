<?php

namespace App\Catalog\Product\Domain\ValueObject;

enum ProductStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Archived = 'archived';

    public function isSellable(): bool
    {
        return $this === self::Active;
    }
}